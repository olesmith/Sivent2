<?php

include_once("../EventApp/MyUnits.php");

class Units extends MyUnits
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Units($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name");
        $this->Sort=array("Name");
        $this->IDGETVar="Unit";
        $this->UploadFilesHidden=FALSE;
        $this->SqlWhere=array("ID" => $this->ApplicationObj()->Unit("ID"));
   }
    
    //*
    //* function MyMod_Messages_Files, Parameter list: 
    //*
    //* Returns list of module messaged files.
    //*

    function MyMod_Messages_Files()
    {
        return 
            array_merge
            (
               array
               (
                  "System/Units/LeftMenu.php",
               ),
               parent::MyMod_Messages_Files()
            );
    }
}

?>