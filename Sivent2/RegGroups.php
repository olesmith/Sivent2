<?php

include_once("RegGroups/Access.php");



class RegGroups extends RegGroupsAccess
{    
    var $Friend_SGroups_Default=
        array
        (
            "Basic"
        );
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function RegGroups($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Title");
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Name");

        $this->CellMethods[ "RegGroup_Info_Field" ]=True;
        $this->Coordinator_Type=5;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("RegGroups",$table);
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
        if ($module!="RegGroups")
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



    #########################################

    //*
    //* function RegGroups_Friend_SGroups_Get, Parameter list: 
    //*
    //* Returns friend accessible sgroups.
    //*

    function RegGroups_Friend_SGroups_Get()
    {
        if (empty($this->Friend_SGroups))
        {
            $this->FriendsObj()->ItemDataSGroups();

            $this->Friend_SGroups=
                $this->FriendsObj()->MyMod_Access_HashesAccess
                (
                    $this->FriendsObj()->ItemDataSGroups,
                    1,
                    "Friend"
                );
        }
        
        return $this->Friend_SGroups;
    }

    //*
    //* function RegGroup_Key_Field, Parameter list:
    //*
    //* Generate key field as select.
    //*

    function RegGroup_Key_Field($data,$item,$edit)
    {
        if ($edit!=1) { return $item[ $data ]; }
        
        $values=$this->RegGroups_Friend_SGroups_Get();

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
    //* function RegGroup_Data_Get, Parameter list:
    //*
    //* Returns data in $sgroup;
    //*

    function RegGroup_Data_Get($item)
    {
        $datas=array();
        if (is_array($item) && !empty($item[ "GroupKey" ])) 
        {
            $sgroup=$item[ "GroupKey" ];
            if (!empty($sgroup) && !empty($this->FriendsObj()->ItemDataSGroups[ $sgroup ]))
            {
                $datas=$this->FriendsObj()->ItemDataSGroups[ $sgroup ][ "Data" ];
            }
        }
        
        return $datas;
    }
    //*
    //* function RegGroup_Info_Field, Parameter list:
    //*
    //* Generate key field as select.
    //*

    function RegGroup_Info_Field($edit,$item,$data)
    {
        $datas=$this->RegGroup_Data_Get($item);
        if (empty($datas)) { return ""; }
        
        foreach (array_keys($datas) as $id)
        {
            if (empty($this->FriendsObj()->ItemData[ $datas[ $id ] ]))
            {
                $datas[ $id ].="*";
            }

            $dataitem=$this->RegDatasObj()->RegDatas_Friend_Data_Read($datas[ $id ]);
            if (empty($dataitem) || $dataitem[ "Active" ]!=2)
            {
                $datas[ $id ]="(".$datas[ $id ].")";
            }
        }
        return join(", ",$datas);
    }
    

    //*
    //* function RegGroup_Datas_Activate, Parameter list:
    //*
    //* Active sgroup datas.
    //*

    function RegGroup_Datas_Activate($item,$data,$newvalue)
    {
        $this->RegDatasObj()->Sql_Table_Create_Query();

        #Skew, since active is a checkbutton
        if (!empty($newvalue)) { $newvalue=2; }
        else                   { $newvalue=1; }

        if ($item[ $data ]!=$newvalue)
        {
            $item[ $data ]=$newvalue;

            if ($newvalue==2)
            {
                foreach ($this->RegGroup_Data_Get($item) as $data)
                {
                    $this->RegDatasObj()->RegDatas_Friend_Data_Activate($data);
                }
            }
        }

        return $item;
    }
    

    //*
    //* function RegGroups_SGroup_Where, Parameter list: $sgroup
    //*
    //* Gets where clause for fetching $sgroup item.
    //*

    function RegGroups_SGroup_Where($sgroup)
    {
        $where=$this->UnitEventWhere();
        $where[ "GroupKey" ]=$sgroup;

        return $where;
    }
    
    //*
    //* function RegGroups_SGroup_Read, Parameter list: $sgroup
    //*
    //* Gets where clause for fetching $sgroup item.
    //*

    function RegGroups_SGroup_Read($sgroup)
    {
        return $this->Sql_Select_Hash
        (
            $this->RegGroups_SGroup_Where($sgroup)
        );
    }
    
    //*
    //* function RegGroups_SGroup_Add, Parameter list: $sgroup
    //*
    //* Makes sure $sgroup is added.
    //*

    function RegGroups_SGroup_Add($sgroup)
    {
        $item=$this->RegGroups_SGroup_Read($sgroup);
        $added=False;
        if (empty($item))
        {
            $item=$this->RegGroups_SGroup_Where($sgroup);
            $item[ "GroupKey" ]=$sgroup;
            $item[ "Active" ]=1;
            if (preg_grep('/^'.$sgroup.'$/',$this->Friend_SGroups_Default))
            {
                $item[ "Active" ]=2;
                $datas=$this->RegGroup_Data_Get($item);
                foreach (array_keys($datas) as $id)
                {
                    $this->RegDatasObj()->RegDatas_Friend_Data_Activate($datas[ $id ]);
                }
            }
            
            $this->ApplicationObj()->AddHtmlStatusMessage("Group '".$sgroup."' added: ".$item[ "Active" ]);

            $this->Sql_Insert_Item($item);
            $added=True;
        }

        return $added;
    }

    
    //*
    //* function RegGroups_SGroups_Add, Parameter list: 
    //*
    //* Makes sure all sgroups are added.
    //*

    function RegGroups_SGroups_Add()
    {
        $this->Sql_Table_Structure_Update();
        $this->RegDatasObj()->RegDatas_Friend_Datas_Add();
        
        $added=0;
        foreach ($this->RegGroups_Friend_SGroups_Get() as $sgroup)
        {
            if ($this->RegGroups_SGroup_Add($sgroup)) { $added++; }
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
        $this->RegGroups_SGroups_Add();
                
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