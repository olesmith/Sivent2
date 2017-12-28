<?php

include_once("Fields/Access.php");
include_once("Fields/Is.php");
include_once("Fields/Show.php");
include_once("Fields/Edit.php");
include_once("Fields/File.php");
include_once("Fields/Text.php");
include_once("Fields/Test.php");
include_once("Fields/Color.php");
include_once("Fields/Barcode.php");
include_once("Fields/Module.php");
include_once("Fields/Enums.php");
include_once("Fields/Derived.php");
include_once("Fields/Sql.php");
include_once("Fields/Crypt.php");

trait MyMod_Data_Fields
{
    use 
        MyMod_Data_Fields_Access,
        MyMod_Data_Fields_Is,
        MyMod_Data_Fields_Show,
        MyMod_Data_Fields_Edit,
        MyMod_Data_Fields_File,
        MyMod_Data_Fields_Text,
        MyMod_Data_Fields_Test,
        MyMod_Data_Fields_Color,
        MyMod_Data_Fields_Barcode,
        MyMod_Data_Fields_Module,
        MyMod_Data_Fields_Enums,
        MyMod_Data_Fields_Derived,
        MyMod_Data_Fields_Crypt,
        MyMod_Data_Fields_Sql;

    //*
    //* function MyMod_Data_Field, Parameter list: $edit,$item,$data,$plural=FALSE,$tabindex="",$rdata=""
    //*
    //* Generates data field.
    //*

    function MyMod_Data_Field($edit,$item,$data,$plural=FALSE,$tabindex="",$rdata="")
    {
        $access=$this->MyMod_Data_Access($data,$item);
        
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }

        if ($this->ItemData($data,"Type")=="TEXT")
        {
            return "";
        }
        
        if (!empty($this->ItemData[ $data ][ "Info" ]))
        {
            return $this->MyMod_Data_Field_Info($data);
        }

        $field="";
        if ($edit==1 && $access==2 && isset($this->ItemData[ $data ]))
        {
            if (empty($tabindex) && !empty($this->ItemData[ $data ][ "TabIndex" ]))
            {
                $tabindex-$this->ItemData[ $data ][ "TabIndex" ];
            }
            
            $field=$this->MyMod_Data_Fields_Edit
            (
               $data,
               $item,
               $value,
               $tabindex,
               $plural,
               TRUE,
               TRUE,
               $rdata
            );
        }
        elseif ($access>0)
        {
            $field=$this->MyMod_Data_Fields_Show($data,$item,$plural);
        }
        elseif (method_exists($this,$data))
        {
            $field=$this->$data($edit,$item,$data);
        }
        else
        {
            $field="Forbidden ".$data." #1";
        }


        if (!empty($this->ItemData[ $data ][ "Comment_Method" ]))
        {
            $method=$this->ItemData[ $data ][ "Comment_Method" ];
            if (method_exists($this,$method))
            {
                
                $field=$field.
                    $this->$method
                    (
                        $this->Min($edit,$access-1),
                        $data,
                        $item,
                        $field
                    );
            }
            else
            {
                var_dump("Invalid method: ".$method);
            }
        }
        
        return $field;
    }
    
    //*
    //* function MyMod_Data_Fields, Parameter list: $edit,$item,$data,$plural=FALSE,$tabindex="",$rdata=""
    //*
    //* Generates data field.
    //*

    function MyMod_Data_Fields($edit,$item,$datas,$plural=FALSE,$tabindex="",$rdatas="")
    {
        if (!is_array($datas))  { $datas=array($datas); }
        if (!is_array($rdatas)) { $rdatas=array($rdatas); }
        
        $cells=array();
        foreach ($datas as $data)
        {
            $rdata=array_shift($rdatas);
            $cell=$this->MyMod_Data_Field($edit,$item,$data,$plural,$tabindex,$rdata);

            array_push
            (
               $cells,
               $cell
            );
        }

        return join($this->BR(),$cells);
    }

    //*
    //* function MyMod_Data_Field_CGIName, Parameter list: $data
    //*
    //* Detects $data CGIName from ItemData. 
    //*

    function MyMod_Data_Field_CGIName($data,$plural,$prepost="")
    {
        $rdata=$data;
        if (!empty($this->ItemData[ $data ][ "CGIName" ]) && !$plural)
        {
            $rdata=$this->ItemData[ $data ][ "CGIName" ];
        }

        if ($plural)      { $rdata=$item[ "ID" ]."_".$rdata; }
        elseif ($prepost) { $rdata=$prepost.$rdata; }

        return $rdata;
    }


    //*
    //* function MyMod_Data_Fields_Method, Parameter list: $item,$data
    //*
    //* Returns name of field method to apply - or NULL.
    //*

    function MyMod_Data_Fields_Method($item,$data)
    {
        $fieldmethod=NULL;
        if (!empty($this->ItemData[ $data ][ "FieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "FieldMethod" ];
        }

        if (!empty($this->ItemData[ $data ][ "EditFieldMethod" ]))
        {
            $fieldmethod=$this->ItemData[ $data ][ "EditFieldMethod" ];
        }

        if ($fieldmethod!="" && !method_exists($this,$fieldmethod))
        {
            $this->DoDie("Invalid FieldMethod",$data, $fieldmethod,"Args: \$edit,\$item,\$data");
        }

        return $fieldmethod;
    }
    
    //*
    //* function MyMod_Data_Field_Logo, Parameter list: $item,$data
    //*
    //* Creates file data entry, as a logo field.
    //*

    function MyMod_Data_Field_Logo($item,$data,$height="",$width="")
    {
        $access=$this->MyMod_Data_Access($data,$item);

        if ($access<1) { return "Not allowed"; }

        $img="";
        if (!empty($item[ $data ]))
        {
            $icon=$item[ $data ];
            $args=array
            (
               "Unit" => $this->Unit("ID"),
               "Event" => $this->Event("ID"),
               "ModuleName" => $this->ModuleName,
               "Action" => "Download",
               "Data" => $data,
            );
            

            $href="?".$this->CGI_Hash2URI($args);
            if (!empty($item[ "HtmlLogoHeight" ])) { $height=$item[ "HtmlLogoHeight" ]; }
            if (!empty($item[ "HtmlLogoWidth" ]))  { $width=$item[ "HtmlLogoWidth" ]; }

            $img=$this->Img($href,$this->ModuleName." logo",$height,$width);
        }

        return $img;
    }
}

?>