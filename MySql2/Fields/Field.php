<?php

class FieldFields extends ShowFields
{
    //*
    //* Variables of Fields class:
    //*

    //*
    //* Returns comment to add to field
    //*

    function FieldComment($data,$edit=0)
    {
        if (
            !$this->NoFieldComments
            &&
            !isset($this->ItemData[ $data ][ "NoComment" ])
           )
        {
            $comment=$this->GetRealNameKey($this->ItemData[ $data ],"Comment");
            if ($comment!="")
            {
                return $comment;
            }
            
            $comment=$this->GetRealNameKey($this->ItemData[ $data ],"EditComment");
            if ($edit==1 && $comment!="")
            {
                return $comment;
            }
        }

        return "";
    }


    //*
    //* Creates input field based on data definition (type, size, etc.).
    //*

    function MakeDataValue($data,$item,$value="")
    {
        if ($this->ItemData[ $data ][ "Sql" ]=="TEXT")
        {
            $value=preg_replace("/\n/","<BR>\n",$value);
            $value=preg_replace("/ /","&nbsp;",$value);
        }
        elseif ($this->ItemData[ $data ][ "Sql" ]=="ENUM")
        {
            $value=$this->GetEnumValue($data,$item);
        }
        elseif ($this->ItemData[ $data ][ "SqlDerivedData" ])
        {
            $value=$item[ $data."_Name" ];
        }
        elseif ($this->ItemData[ $data ][ "Link" ])
        {
            $link=$this->ItemData[ $data ][ "LinkRef" ];
            $name=$this->ItemData[ $data ][ "LinkName" ];
            $link=$this->FilterHash($link,$item);
            $value="<A HREF='".$link."'>".$name."</A>";
        }

        //Defalut here?

        return $value;
    }

    
    //*
    //* Generates non-edit input value, showing field value as text. 
    //*

    function MakeField($edit,$item,$data,$plural=FALSE,$tabindex="",$rdata="")
    {
        return $this->MyMod_Data_Fields($edit,$item,$data,$plural,$tabindex,$rdata);
    }


    //*
    //* function PrependInputNameTag, Parameter list: $inputhtml,$prepend,$n=1
    //*
    //* Prepends $prepend to first occorrence of Name='...' in $inputhtml.
    //*

    function PrependInputNameTag($inputhtml,$prepend,$nmax=1)
    {
       $inputhtml=preg_replace  //Prepend $prepend to input Name=
        (
           '/NAME="/i',
           "NAME=\"".$prepend,
           $inputhtml,
           $nmax
        );

        return preg_replace  //Prepend $prepend to input Name=
        (
           '/NAME=\'/i',
           "NAME='".$prepend,
           $inputhtml,
           $nmax
        );
    }
}

?>