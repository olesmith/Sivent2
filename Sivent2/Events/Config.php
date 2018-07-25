<?php

include_once("Config/Groups.php");
include_once("Config/Group.php");
include_once("Config/Modules.php");
include_once("Config/Module.php");
include_once("Config/Menu.php");
include_once("Config/Event.php");

class Events_Config extends Events_Statistics
{
    use
        Events_Config_Groups,
        Events_Config_Group,
        Events_Config_Modules,
        Events_Config_Module,
        Events_Config_Menu,
        Events_Config_Event;
    
    var $Event_Config_Path="System/Events";
    var $Event_Config_File="Config.Messages.php";
    var $Event_Config=array();
    
    var $Event_Config_SGroup="Common";
    var $Event_Config_Group="";
    var $Event_Config_Group_CGI_Key="Group";
    
    #Key in Config.Messages
    var $Event_Config_Groups_Key="Groups";
    
    //*
    //* Event configurations setup file name.
    //*

    function Event_Config_File()
    {
        return join("/",array($this->Event_Config_Path,$this->Event_Config_File));
    }
    
    //*
    //* Event configurations setup file name.
    //*

    function Event_Config_Read()
    {
        if (empty($this->Event_Config))
        {
            $this->Event_Config=$this->ReadPHPArray($this->Event_Config_File());
            $groups=$this->Dir_Files($this->Event_Config_Path."/Config",'\.php$');
            $this->Event_Config_Group=$this->Event_Config[ "Config_Group_Default" ];
            
        }
    }
    
    //*
    //* Event configurations setup file, hash accessor method.
    //*
    //* May specify until 3 level of keys. Reads once only.
    //*

    function Event_Config($key1="",$key2="",$key3="")
    {
        $this->Event_Config_Read();

        if (empty($key1)) { return $this->Event_Config; }
        if (empty($key2)) { return $this->Event_Config[ $key1 ]; }
        if (empty($key3)) { return $this->Event_Config[ $key1 ][ $key2 ]; }
        
        return $this->Event_Config[ $key1 ][ $key2 ][ $key3 ];
    }
    
    
    //*
    //* Event configuration handler.
    //*

    function Event_Config_Handle()
    {
        $event=$this->Event();
        $edit=1;


        echo
            $this->Htmls_Text
            (
                $this->Event_Config_Event_Form($edit,$event)
            );
    }

   
     
    
    //*
    //* Generates a configuration cell.
    //*

    
    function Event_Config_Cell($group,$text,$class)
    {
        return
            $this->Htmls_SPAN
            (
                $this->GetRealNameKey($text),
                array("CLASS" => 'config '.$class)
            );
    }
    
    //*
    //* Generates one configuration Group rows of cells.
    //*
    
    function Event_Config_Cell_Rows($group,$text,$class)
    {
        return
            array
            (
                array
                (
                    $this->Event_Config_Cell($group,$text,$class),
                    ""
                ),
            );
    }
    
    
}

?>