<?php

include_once("../EventApp/MyPermissions.php");
include_once("Permissions/Access.php");

class Permissions extends Permissions_Access
{
    //*
    //* function Permissions, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Permissions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->Sort=array("Name");
        $this->NonGetVars=array("Event","CreateTable");
    }


    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Permissions")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
}

?>