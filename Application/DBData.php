<?php

include_once("DBData/Access.php");
include_once("DBData/Pertains.php");
include_once("DBData/Cells.php");
include_once("DBData/Quest.php");
include_once("DBData/Update.php");
include_once("DBData/Form.php");

class DBData extends DBDataForm
{
    //*
    //* function Datas, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function DBData($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("SortOrder","Name","SqlKey");
        $this->Sort=array("DataGroup","SortOrder","Name");

    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlEventTableName("DBData",$table);
    }

    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return join("/",array("..","Application","System","DBData","Profiles.php"));
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_push($this->ItemDataPaths,"../Application/System/DBData");
        array_push($this->ItemDataGroupPaths,"../Application/System/DBData");
        $this->Sql_Table_Column_Rename("Candidate","Friend");
    }
    
    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreActions()
    {
        array_push($this->ActionPaths,"../Application/System/DBData");
    }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $pertainsnames=array();
        foreach ($this->ApplicationObj()->PertainsSetup as $pertains => $def)
        {
            array_push($pertainsnames,$this->GetRealNameKey($def,"Title"));         
        }

        $this->ItemData[ "Pertains" ][ "Values" ]=$pertainsnames;
    }
    

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }


        $updatedatas=array();
        if (empty($item[ "SqlDef" ]) && !empty($item[ "Type" ]))
        {
            $item[ "SqlDef" ]=
                $this->ItemData[ "Type" ][ "SQLDefault" ][ $item[ "Type" ]-1 ];
            array_push($updatedatas,"SqlDef");
        }

        if (empty($item[ "SortOrder" ]) && !empty($item[ "ID" ]))
        {
            $item[ "SortOrder" ]=$item[ "ID" ];
            array_push($updatedatas,"SortOrder");
        }

        foreach (array("UK") as $lang)
        {
            $data="SValues";
            $rdata=$data."_".$lang;
            
            if (empty($item[ $rdata ]) && !empty($item[ $data ]))
            {
                $item[ $rdata ]=$item[ $data ];
                array_push($updatedatas,$rdata);
            }
        }

        foreach (array("Text","Text_UK") as $data)
        {
            $rdata=preg_replace('/^Text/',"Title",$data);
            if (empty($item[ $rdata ]) && !empty($item[ $data ]))
            {
                $item[ $rdata ]=$item[ $data ];
                array_push($updatedatas,$rdata);
            }
        }



        if (count($updatedatas)>0)
        {
            $this->MySqlSetItemValues("",$updatedatas,$item);
        }

        return $item;
    }

    
    //*
    //* function Edit_Default_Field, Parameter list: $item
    //*
    //* Creates sutiable default spec field.
    //*

    function Edit_Default_Field($data,$item,$edit=0,$rdata="")
    {
        if ($item[ "SqlDef" ]=="ENUM")
        {
            $valuenames=$this->GetRealNameKey($item,"SValues");
            $valuenames=preg_split('/\s*,\s*/',$valuenames);
            $values=array();

            $n=1;
            foreach ($valuenames as $valuename)
            {
                array_push($values,$n++);
            }
            array_unshift($values,0);
            array_unshift($valuenames,"");
            
            $value=$this->MakeSelectField($rdata,$values,$valuenames,$item[ $data ]);
            return $value;
        }

        return
            $this->MyMod_Data_Fields_Edit
            (
                $data,$item,$value="",$tabindex="",$plural=FALSE,$links=TRUE,
                $callmethod=FALSE,
                $rdata
            );
    }
    
}

?>