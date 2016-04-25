<?php

trait MyMod_Language
{
    
    //*
    //* function MyMod_Language_Read, Parameter list: 
    //*
    //* Module language initializer.
    //* Reads System/$module/Messages.php, if exists.
    //*

    function MyMod_Language_Read()
    {
        if (!empty($this->Messages)) { return; }
        
        $file=
            $this->ApplicationObj()->MyApp_Setup_Path().
            "/Messages/".
            $this->ModuleName.
            ".php";

        if (file_exists($file))
        {
            $this->Messages=$this->ReadPHPArray($file);
        }
    }
    
    //*
    //* function MyMod_Language_Message, Parameter list: $key,$skey="Name",$filter=array()
    //*
    //* Module language initializer.
    //* Reads System/$module/Messages.php, if exists.
    //*

    function MyMod_Language_Message($key,$skey="Name",$filter=array())
    {
        if (empty($this->Messages))
        {
            $this->MyMod_Language_Read();
        }
        
        $msg=$this->Messages($key,$skey);
        if (!empty($filter))
        {
            $msg=$this->FilterHash($msg,$filter);
        }

        return $msg;
    }
}

?>