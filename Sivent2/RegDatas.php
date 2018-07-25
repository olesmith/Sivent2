<?php

include_once("RegDatas/Access.php");



class RegDatas extends RegDatasAccess
{
    var $Friend_Datas_Default=
        array
        (
            "Name",
            "Email",
            "Institution",
            "Department",
            "Titulation",
            "Cell"
        );
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function RegDatas($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Title");
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name");

        $this->Coordinator_Type=5;

        $this->Sort=array("ID");
        $this->NItemsPerPage=20;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("RegDatas",$table);
    }
    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->PostProcessUnitData();
        $this->PostProcessEventData();
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
        $module=$this->GetGET("ModuleName");
        if ($module!="RegDatas")
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

    //*
    //* function RegData_Friend_Datas_Get, Parameter list: 
    //*
    //* Returns friend accessible datas.
    //*

    function RegDatas_Friend_Datas_Get()
    {
        if (empty($this->Friend_Datas))
        {
            $this->FriendsObj()->ItemData();

            $this->Friend_Datas=
                $this->FriendsObj()->MyMod_Access_HashesAccess
                (
                    $this->FriendsObj()->ItemData,
                    array(1,2),
                    "Friend"
                );
        }

        
        return $this->Friend_Datas;
    }
    //*
    //* function RegData_Key_Field, Parameter list:
    //*
    //* Generate key field as select.
    //*

    function RegData_Key_Field($data,$item,$edit)
    {
        if ($edit!=1) { return $item[ $data ]; }
        
        $values=$this->RegData_Datas_Get();

        return
            $this->MakeSelectField
            (
                $item[ "ID" ]."_".$data,
                $values,
                $values,
                $item[ $data ]
            );
    }

    
    //*
    //* function RegDatas_Friend_Data_Activate, Parameter list: $data
    //*
    //* Sets $data item to Active=2.
    //*

    function RegDatas_Friend_Data_Activate($data)
    {
        $where=$this->RegDatas_Friend_Data_Where($data);
                
        $item=$this->Sql_Select_Hash($where,array("ID","Active"));
        if (!empty($item))
        {
            if ($item[ "Active" ]!=2)
            {
                $this->Sql_Update_Item_Value_Set($item[ "ID" ],"Active",2);
                $this->ApplicationObj()->AddHtmlStatusMessage("Data ".$data." activated");
            }
        }

    }
    
    //*
    //* function RegDatas_Friend_Data_Where, Parameter list: $data
    //*
    //* Gets where clause for fetching $data item.
    //*

    function RegDatas_Friend_Data_Where($data)
    {
        $where=$this->UnitEventWhere();
        $where[ "DataKey" ]=$data;

        return $where;
    }
    
    //*
    //* function RegDatas_Friend_Data_Read, Parameter list: $data
    //*
    //* Gets where clause for fetching $data item.
    //*

    function RegDatas_Friend_Data_Read($data)
    {
        return $this->Sql_Select_Hash
        (
            $this->RegDatas_Friend_Data_Where($data)
        );
    }
    
     //*
    //* function RegDatas_Friend_Data_Add, Parameter list: $sgroup
    //*
    //* Makes sure $data is added.
    //*

    function RegDatas_Friend_Data_Add($data)
    {
        $this->Sql_Table_Structure_Update();
        $item=$this->RegDatas_Friend_Data_Read($data);

        $added=False;
        if (empty($item))
        {
            $item=$this->RegDatas_Friend_Data_Where($data);
            
            $item[ "DataKey" ]=$data;
            $item[ "Active" ]=1;
            if (preg_grep('/^'.$data.'$/',$this->Friend_Datas_Default))
            {
                $item[ "Active" ]=2;
            }

            $this->ApplicationObj()->AddHtmlStatusMessage
            (
                "Data '".$item[ "DataKey" ]."' added: ".$item[ "Active" ]
            );
            $this->Sql_Insert_Item($item);
            $added=True;
        }

        return $added;
    }

    //*
    //* function RegData_Friend_Datas_Add, Parameter list: 
    //*
    //* Makes sure all sgroups are added.
    //*

    function RegDatas_Friend_Datas_Add()
    {
        $added=0;
        foreach ($this->RegDatas_Friend_Datas_Get() as $data)
        {
            if ($this->RegDatas_Friend_Data_Add($data)) { $added++; }
        }
        
        return $added;
    }

    
    //*
    //* function MyMod_Handle_Search, Parameter list:
    //*
    //* Override Handle Search
    //*

    function MyMod_Handle_Search($where = '', $searchvarstable = true, $edit = 0, $group = '', $omitvars = array(), $action = '', $module = '', $savebuttonname = '', $resetbottonname = '')
    {
        $this->RegDatas_Friend_Datas_Add();
        $this->NoPaging=True;
        parent::MyMod_Handle_Search
        (
            $where,
            $searchvarstable,
            $edit,
            $group,
            $omitvars,
            $action,
            $module,
            $savebuttonname,
            $resetbottonname
        );
    }

}

?>