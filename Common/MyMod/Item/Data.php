<?php



trait MyMod_Item_Data
{
    //*
    //* Creates item data cell.
    //*

    function MyMod_Item_Data_Cell($edit,$item,$data,$plural=FALSE,$rdata="")
    {
        $dagger=$this->SPAN("*",array("CLASS" => "errors"));
        if ($edit==0)
        {
            $ldata=$this->MyLanguage_GetLanguagedKey($data);
            if ($ldata!=$data && !empty($item[ $ldata ]))
            {
                $data=$ldata;
            }
        }
        
        $value=$this->MyMod_Data_Fields($edit,$item,$data,$plural,$tabindex="",$rdata);
        if ($edit==1 && $this->MyMod_Data_Field_Is_Date($data))
        {
            $value.=" DD/MM/YYYY";
        }
        
        if (
              isset($item[ $data."_Message" ])
              && $item[ $data."_Message" ]!=""
              && $this->LoginType!="Public"
           )
        {
            $value.=
                $this->Span($value,array("CLASS" => 'errors')).
                $item[ $data."_Message" ];
        }


        return $value=$this->Span($value,array("CLASS" => 'data'));
    }
   
    //*
    //* Creates item table title cell
    //*

    function MyMod_Item_Data_Cell_Title($data,$addcolon=FALSE,$options=array(),$addmsg=TRUE)
    {
        if (empty($this->ItemData[ $data ])) { return ""; }
        
        $dagger=$this->SPAN("*",array("CLASS" => "errors"));

        $name=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyName);
        $title=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyTitle);
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
        elseif ($this->ItemData[ $data ][ "LongName" ])
        {
            $name=
                $this->GetRealNameKey($this->ItemData[ $data ],"LongName");
        }

        if (empty($title)) { $title=$name; }
        if ($addcolon)     { $name.=":"; }
        
        $add="";
        if ($addmsg && $this->MyMod_Data_Field_Compulsory($data))
        {
            $add=$dagger;
            if (
                   $this->LoginType!="Public"
                   &&
                   empty($item[ $data ])
                )
             {
                 $title.=
                     " - ".
                     $this->GetMessage($this->ItemDataMessages,"CompulsoryFieldTag").
                     "!";
             }
        }
        
        $options[ "TITLE" ]=$title;
        return $this->Span($name,$options).$add;
    }

    
    //*
    //* function MyMod_Item_Data_Set, Parameter list: &$item,$data,$value
    //*
    //* Make sure Item $data has been set.
    //*

    function MyMod_Item_Data_Set(&$item,$data,$value)
    {
        $rdata="";
        if (empty($item[ $data ]) || $item[ $data ]!=$value)
        {
            $item[ $data ]=$value;
            $rdata=$data;
        }

        return $rdata;
    }
}

?>