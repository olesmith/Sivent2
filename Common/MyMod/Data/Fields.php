<?php

include_once("Fields/Access.php");
include_once("Fields/Is.php");
include_once("Fields/Show.php");
include_once("Fields/Edit.php");
include_once("Fields/File.php");
include_once("Fields/Text.php");
include_once("Fields/Module.php");
include_once("Fields/Enums.php");
include_once("Fields/Derived.php");
include_once("Fields/Sql.php");

trait MyMod_Data_Fields
{
    use 
        MyMod_Data_Fields_Access,
        MyMod_Data_Fields_Is,
        MyMod_Data_Fields_Show,
        MyMod_Data_Fields_Edit,
        MyMod_Data_Fields_File,
        MyMod_Data_Fields_Text,
        MyMod_Data_Fields_Module,
        MyMod_Data_Fields_Enums,
        MyMod_Data_Fields_Derived,
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

        if ($edit==1 && $access==2 && isset($this->ItemData[ $data ]))
        {
            return $this->MyMod_Data_Fields_Edit
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
            return $this->MyMod_Data_Fields_Show($data,$item,$plural);
        }
        elseif (method_exists($this,$data))
        {
            return $this->$data($edit,$item,$data);
        }
        else
        {
            return "Forbidden ".$data." #1";
        }
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
            $this->DoDie("Invalid FieldMethod",$data, $fieldmethod);
        }

        return $fieldmethod;
    }
}

?>