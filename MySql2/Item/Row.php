<?php

class ItemRow extends ItemEdits
{

    //*
    //* Creates item table, calling ItemTableRow for each var.
    //*

    function ItemTableRowCellTitle($edit,$data)
    {
        $title=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyTitle);
        
        if (empty($title)) { $title=$this->ItemTableRowCellName($edit,$data); }
        
        if (
              $this->ItemData[ $data ][ "Compulsory" ]
              &&
              $this->LoginType!="Public"
              &&
              $edit==1
              &&
              empty($item[ $data ])
            )
        {
            $title.=
                " - ".
                $this->GetMessage($this->ItemDataMessages,"CompulsoryFieldTag")."!";
        }

        return $title;
    }
    

    //*
    //* Creates item table, calling ItemTableRow for each var.
    //*

    function ItemTableRowCellName($edit,$data)
    {
            $name=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyName);
            if (
                  preg_match('/^([^_]+)_(.+)/',$data,$matches)
                  &&
                  isset($this->ItemData[ $matches[1] ])
                  &&
                  !empty($this->ItemData[ $matches[1] ][ "SqlObject" ])
                )
            {
                $object=$this->ItemData[ $matches[1] ][ "SqlObject" ];

                if (isset($this->$object->ItemData[ $matches[2] ]))
                {
                    $name=$this->GetRealNameKey($this->$object->ItemData[ $matches[2] ],"Name");
                }
            }
            elseif ($this->LoginType=="Admin" && $this->ItemData[ $data ][ "NamerLink" ]) 
            {
                if ($item[ $data ]!="" && $item[ $data ]>0)
                {
                    $name="<A TARGET='_item'";
                    if ($this->ItemData[ $data ][ "NamerText" ])
                    {
                        $name.=" TITLE='".$this->ItemData[ $data ][ "NamerText" ]."'";
                    }
                    $name.=
                        " HREF='".
                        $this->ItemData[ $data ][ "NamerLink" ]."=".
                        $item[ $data ]."'>".$this->ItemData[ $data ][ "Name" ]."</A>";

                    $name=preg_replace('/#LoginType/',$this->LoginType,$name);
                }
            }
            elseif (isset($this->ItemDerivedData[ $data ][ "LongName" ]))
            {
                $name=$this->GetRealNameKey($this->ItemDerivedData[ $data ],"LongName");
            }
            elseif (isset($this->ItemDerivedData[ $data ][ "Name" ]))
            { 
                $name=$this->GetRealNameKey($this->ItemDerivedData[ $data ],"Name");
            }
            elseif ($this->ItemData[ $data ][ "LongName" ])
            {
                $name=$this->GetRealNameKey($this->ItemData[ $data ],"LongName");
            }

            return $name.":";
    }
    


    //*
    //* function ItemTableRow, Parameter list: $edit,$item,$data,&$compulsories=0,&$row=array(),$plural=FALSE,$precgikey=""
    //*
    //* Creates ItemTableRow.
    //*

    function ItemTableRow($edit,$item,$data,&$compulsories=0,&$row=array(),$plural=FALSE,$precgikey="")
    {
        $dagger=$this->SPAN("*",array("CLASS" => "errors"));
        $access=$this->MyMod_Data_Access($data,$item);

        $rdata="";
        if ($plural) { $rdata=$item[ "ID" ]."_".$data; }
        if ($precgikey) { $rdata=$precgikey.$rdata; }
            
        if ($access>=1)
        {
            $value="";
            if ($access==1)
            {
                $value=$this->MyMod_Data_Fields_Show($data,$item);
            }
            else
            {
                $value=$this->MyMod_Data_Fields($edit,$item,$data,$plural,"",$rdata);
            }

            if (!$this->LatexMode() && isset($item[ $data."_Message" ]) && $item[ $data."_Message" ]!="" && $this->LoginType!="Public")
            {
                $value.="<FONT CLASS='errors'>".$item[ $data."_Message" ]."</FONT>";
            }

            $action=$this->MyActions_Detect();
            $add="";
            if (
                $this->ItemData[ $data ][ "Compulsory" ] &&
                $edit==1
               )
            {
                $add=$dagger;
                $compulsories++;
            }

            if (
                $access==2
                &&
                $this->ItemData[ $data ][ "Sql" ]=="INT"
                &&
                $this->ItemData[ $data ][ "IsDate" ]
                &&
                (
                    empty($item[ $data ])
                    ||
                    !preg_match('/^\d{8}$/',$item[ $data ])
                )
               )
            {
                $value.=" DD/MM/YYYY";
            }

            array_push
            (
               $row,
               $this->DecorateDataTitle
               (
                  $this->ItemTableRowCellName($edit,$data),
                  $this->ItemTableRowCellTitle($edit,$data),
                  TRUE
               ).
               $add,
               
               $this->Span($value,array("CLASS" => 'data'))
            );
        }

        return $row;
    }
}
?>