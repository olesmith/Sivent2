<?php


class TimeFields extends SubItems
{
    //*
    //* Variables of Fields class:
    //*
    var $StartYear=1900;
    var $EndYear=2020;
    var $TimeVars=array("CTime","MTime","ATime");


    //*
    //* Writes value of time to $timetype column for $item.
    //*

    function SetItemTime($timetype,$item,$mtime=0)
    {
        if (!empty($item[ "ID" ]))
        {
            if ($mtime==0) { $mtime=time(); }

            $item[ $timetype ]=$mtime;
 
            $this->MySqlSetItemValue($this->SqlTableName(),"ID",$item[ "ID" ],$timetype,$mtime);
        }

        return $item;
    }

    //*
    //* Checks if item has time var set (CTime,MTime and ATime).
    //*

    function SetItemTimes($item)
    {
        $firsttime=time();
        foreach ($this->TimeVars as $timetype)
        {
            if (!isset($item[ $timetype ]) || $item[ $timetype ]==0)
            {    
                $item=$this->SetItemTime($timetype,$item,$firsttime);
            }
        }

        return $item;
    }

    //*
    //* Creates show field based on data definition (type, size, etc.).
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function CreateDateShowField($data,$item,$value="")
    {
        $date=0;
        $mon=0;
        $year=0;

        if (empty($value))
        {
            if ($this->ItemData[ $data ][ "Default" ]=='today')
            {
                $value=$this->TimeStamp2DateSort();
            }
            else { return "-"; }
        }

        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/',$value,$matches))
        {
            $year=$matches[1];
            $mon=$matches[2];
            $date=$matches[3];
        }

        return sprintf("%02d",$date)."/".sprintf("%02d",$mon)."/".$year;
    }

    //*
    //* Creates show field based on hour definition (type, size, etc.).
    //* Should ONLY be called by MakeDataField, who checks access
    //*

    function CreateHourShowField($data,$item,$value="")
    {
        $hour=0;
        $min=0;
        if (preg_match('/[:\.]/',$value,$matches))
        {
            $matches=preg_split('/[:\.]/',$value);
            $hour=$matches[0];
            $min=$matches[1];
        }
        elseif (preg_match('/^(\d\d?)(\d\d)$/',$value,$matches))
        {
            $hour=$matches[1];
            $min=$matches[2];
        }
        elseif (preg_match('/^(\d\d?)$/',$value,$matches))
        {
            $hour=$matches[1];
            $min=0;
        }

        return sprintf("%02d",$hour).":".sprintf("%02d",$min);
    }

    //*
    //* Create a composed Day Month Year select field.
    //*

    function CreateDateField($data,$item,$value="",$searchfield=FALSE,$rdata="")
    {
        if (empty($rdata)) { $rdata=$data; }
        
        $date=0;
        $mon=0;
        $year=0;

        /* //fix */
        /* $tmpdata=$data; */
        /* if (!empty($item[ "ID" ])) */
        /* { */
        /*     $tmpdata=preg_replace('/^'.$item[ "ID" ].'_/',"",$data); */
        /* } */
        
        /* if (empty($value) && $this->ItemData[ $data ][ "Default" ]=="today") */
        /* { */
        /*     $value=$this->TimeStamp2DateSort(); */
        /* } */

        if (preg_match('/^(\d\d\d\d)(\d\d)(\d\d)$/',$value,$matches))
        {
            $year=$matches[1];
            $mon =sprintf("%02d",$matches[2]);
            $date=sprintf("%02d",$matches[3]);

            $value=$date."/".$mon."/".$year;
        }

        $prekey=$rdata;
        $postkey="";
        if ($searchfield)
        {
            $prekey=$this->ModuleName."_".$data;
            $postkey="_Search";
        }

        if ($value==0 || $value=="0") { $value=""; }

        $size=10;
        if (!empty($this->ItemData[ $data ][ "Size" ])) { $size=$this->ItemData[ $data ][ "Size" ]; }


        $field=$this->MakeInput($prekey.$postkey,$value,$size);

        return $field;
    }

    //*
    //* Create a composed Hour Minute field.
    //*

    function CreateHourField($data,$item,$value="",$searchfield=FALSE)
    {
        if (empty($value))
        {
            $value=$item[ $value ];
        }
        $value=preg_replace(':',"",$value);
        $value=preg_replace('(\d\d)(\d\d)','$1:.$2',$value);

        return
            $this->MyMod_Data_Fields_Edit($data,$value);
    }

    //*
    //* Create a composed Hour Minute select field.
    //*

    function CreateHourSelectFields($data,$item,$value="",$searchfield=FALSE)
    {
        $hours=array();
        $hourids=array();
        for ($n=0;$n<24;$n++)
        {
            array_push($hours,sprintf("%02d",$n));
            array_push($hourids,$n);
        }

        $minutes=array();
        $minuteids=array();
        for ($n=0;$n<60;$n++)
        {
            array_push($minutes,sprintf("%02d",$n));
            array_push($minuteids,$n);
        }

        $hour=-1;
        $min=-1;
        $value=preg_replace('/:/',"",$value);
        if (preg_match('/^(\d\d)(\d\d)$/',$value,$matches))
        {
            $hour=sprintf("%d",$matches[1]);
            $min=sprintf("%d",$matches[2]);
        }
        if ($hour==-1 && !$searchfield)
        {
            $hour=$this->CurrentHour();
        }

        if ($min==-1 && !$searchfield)
        {
            $min=$this->CurrentMinute();
        }

        $prekey=$data;
        $postkey="";
        if ($searchfield)
        {
            $prekey=$this->ModuleName."_".$data;
            $postkey="_Search";
        }

        $field=
            $this->MakeSelectField($prekey."Hour".$postkey ,$hourids,$hours,$hour).
            $this->MakeSelectField($prekey."Min".$postkey ,$minuteids,$minutes,$min);

        if (!empty($value))
        {
            $field.=$this->MakeHidden($prekey.$postkey,$value);
        }
        else
        {
            $field.=$this->MakeHidden($prekey.$postkey,sprintf("%02d",$hour).sprintf("%02d",$min));
        }

        return $field;
    }
}

?>