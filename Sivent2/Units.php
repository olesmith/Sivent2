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
   }
}

?>