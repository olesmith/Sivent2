<?php

include_once("MyCertificates/Code.php");
include_once("MyCertificates/Verify.php");
include_once("MyCertificates/Latex.php");
include_once("MyCertificates/Read.php");
include_once("MyCertificates/Generate.php");
include_once("MyCertificates/Handle.php");

class MyCertificates extends MyCertificates_Handle
{
    var $UnitDatas=array("Event","Friend");
    var $EventDatas=
        array
        (
            "Inscription",
        );
    
    var $Certificate_NTypes=2;
    var $Certificate_Data=
        array
        (
            1 => "Inscription",
        );
            
    
    var $Code_Data=array
    (
       "Unit" => "%02d",
       "Event" => "%03d",
       "Friend" => "%06d",
       "ID" => "%06d",       
    );
    
    //*
    //* function MyCertificates, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function MyCertificates($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=
            array
            (
                "Unit","Event","Name","Code","Type","Friend",
                "Inscription",
            );
        $this->Sort=array("Name");
        $this->IncludeAllDefault=TRUE;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlUnitTableName("Certificates",$table);
    }
    
     
    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Certificates")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        $this->Certificate_Name_PostProcess($item,$updatedatas);
        $this->Certificate_Code_PostProcess($item,$updatedatas);
        
        $this->Certificate_Verify($item,$updatedatas);
        
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
    
    //*
    //* function Certificate_Name_PostProcess, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses certificate name.
    //*

    function Certificate_Name_PostProcess(&$item,&$updatedatas)
    {
        $names=array();
        if (!empty($item[ "Friend" ]))
        {
            array_push($names,$this->FriendsObj()->Sql_Select_Hash_Value($item[ "Friend" ],"Name"));
        }
        
        $key=$this->Type2Key($item);
        $namekey=$this->Type2NameKey($item);
        $obj=$key."sObj";
       
        if ($item[ "Type" ]>1 && !empty($item[ $key ]))
        {
            $sqltable=$this->ApplicationObj()->SubModulesVars[ $key."s" ][ "SqlTable" ];
            $sqltable=$this->FilterHash($sqltable,$item);
            
            array_push
            (
               $names,
               $name=$this->$obj()->Sql_Select_Hash_Value
               (
                  $item[ $key ],
                  $namekey,
                  "ID",TRUE,
                  $sqltable
               )
            );
        }

        $name=join(", ",$names);
        if ($item[ "Name" ]!=$name)
        {
            $item[ "Name" ]=$name;
            array_push($updatedatas,"Name");
        }
    }    
}

?>