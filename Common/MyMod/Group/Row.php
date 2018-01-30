<?php

trait MyMod_Group_Row
{
    //*
    //* function MyMod_Group_Row_Item, Parameter list: ($edit,$item,$nn,$datas,$even=TRUE)
    //*
    //* Generate group row, as list.
    //* Specific class may override MyMod_Group_Rows_Item (returns matrix) or
    //* MyMod_Group_Row_Item, return list.
    //* 
    
    function MyMod_Group_Row_Item($edit,$item,$nn,$datas,$even=TRUE)
    {
        //Test if we have individual access to Edit $item
        if (!$this->MyAction_Allowed("Edit",$item))
        {
            $edit=0;
        }
 
        $item[ "_RID_" ]="";
        if (isset($item[ "ID" ])) { $item[ "_RID_" ]=sprintf("%03d",$item[ "ID" ]); }
        $nn=sprintf("%03d",$nn);

        $tabindex=1;
        $row=array();
        foreach ($datas as $data)
        {
            if (empty($data))
            {
                $value="&nbsp;";
            }
            elseif ($data=="No")
            {
                $value=$this->B($nn);
            }
            elseif (preg_match('/newline\((\d+)\)/',$data,$matches))
            {
                array_push($tbl,$row);
                
                $row=array($this->MultiCell("",$matches[1]));
                continue;
            }
            elseif (preg_match('/^text\_/',$data))
            {
                $value=preg_replace('/^text\_/',"",$data);
                $value=$this->Span($value,array("CLASS" => 'Bold Right'));
            }
            elseif (preg_match('/newline\((\d*)\)\((\d*)\)/',$data,$matches))
            {
                $preempties=0;
                if (isset($matches[1])) { $preempties=$matches[1]; }
                
                $postempties=0;
                if (isset($matches[2])) { $postempties=$matches[2]; }
                for ($n=1;$n<=$postempties;$n++)
                {
                    array_push($row,"");
                }

                array_push($tbl,$row);

                $row=array();
                for ($n=1;$n<=$preempties;$n++)
                {
                    array_push($row,"");
                }
                $value="";
            }
            elseif (!isset($this->ItemData[ $data ]) && isset($this->Actions[ $data ]))
            {
                if ($even)
                {
                    $this->Actions[ $data ][ "Icon" ]=
                        preg_replace
                        (
                           '/_light./',
                           "_dark.",
                           $this->Actions[ $data ][ "Icon" ]
                        );
                }
                else
                {
                    $this->Actions[ $data ][ "Icon" ]=
                        preg_replace
                        (
                           '/_dark./',
                           "_light.",
                           $this->Actions[ $data ][ "Icon" ]
                        );
                }

                $value=$this->MyActions_Entry($data,$item);
                if (!empty($this->Actions[ $data ][ "Icon" ]))
                {
                    $value=$this->Center($value);
                }
            }
            elseif (
                    preg_match('/\S+\_\S+/',$data)
                    &&
                    empty($this->ItemData[ $data ])
                    &&
                    isset($item[ $data ])
                   )
            {
                 $value=$item[ $data ];
            }
            elseif (!empty($this->ItemData[ $data ]))
            {
                $value=$this->MyMod_Data_Fields($edit,$item,$data,TRUE,$tabindex);//TRUE for plural
                
                if (empty($value)) { $value="&nbsp;"; }
            }
            elseif (method_exists($this,$data))
            {
                $value=$this->Span($this->$data($item,$edit),array("CLASS" => 'data'));
            }
            else
            {
                $value=$this->MakeField($edit,$item,$data,TRUE,$tabindex);//TRUE for plural
                
                if (!preg_match('/\S/',$value)) { $value="&nbsp;"; }
            }

            if (
                $edit==1
                &&
                $this->Profile!="Public"
                &&
                isset($item[ $data."_Message" ])
                &&
                $item[ $data."_Message" ]!=""
               )
            {
                $value.=$this->Font($item[ $data."_Message" ],array("CLASS" => 'errors'));
            }

            $value=$this->MyMod_Group_Cell_Align($data,$value);
           
            array_push($row,$value);

            $tabindex++;
        }

        if (count($row)>0 && isset($item[ "ID" ]) && !$this->LatexMode)
        {
            if (!is_array($row[0]))
            {
                $row[0].=$this->HtmlTags("A","",array("NAME" => "#".$this->ModuleName."_".$item[ "ID" ]));
            }
        }

        return $row;
    }
}

?>