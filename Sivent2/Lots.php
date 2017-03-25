<?php

include_once("Lots/Access.php");


class Lots extends Lots_Access
{
    var $ValuesData=array();
    var $ValueVars=array();

    var $Lots=array();
    var $Lot=array();
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Lots($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array();
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("LimitDate");
        
        $this->Coordinator_Type=8;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Lots",$table);
    }


    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->Coordinator_Type=8;

        $this->PostProcessUnitData();
        $this->PostProcessEventData();

        $this->TypesObj()->ItemData();
        $this->TypesObj()->Types_Read();

        $this->ValuesData=$this->ReadPHPArray("System/Lots/Data.PerTypes.php");

        $this->ValuesVars=array();

        $forceupdate=FALSE;
        foreach ($this->TypesObj()->Types as $type)
        {
            $typename=$this->GetRealNameKey($type,"Name");
            foreach ($this->ValuesData as $data => $datadef)
            {
                $key=$data."_".$type[ "ID" ];

                if (!$this->Sql_Table_Field_Exists($key))
                {
                    $forceupdate=TRUE;
               }

                $this->ItemData[ $key ]=$datadef;
                foreach (array_keys($datadef) as $rdata)
                {
                    if (is_string($this->ItemData[ $key ][ $rdata ]))
                    {
                        $this->ItemData[ $key ][ $rdata ]=
                            preg_replace
                            (
                                '/#Name/',
                                $typename,
                                $this->ItemData[ $key ][ $rdata ]
                            );
                    }
                }

                array_push($this->ValuesVars,$key);
            }
        }

        if ($forceupdate)
        {
            $this->Sql_Table_Structure_Update_Force=TRUE;
            $this->Sql_Table_Structure_Update();
        }
    }

    
    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemDataGroups()
    {
        $groups=array("Basic");
        foreach ($groups as $group)
        {
            $this->ItemDataGroups[ $group ][ "Data" ]=
                array_merge
                (
                    $this->ItemDataGroups[ $group ][ "Data" ],
                    $this->ValuesVars
                );
        }
        $sgroups=array("Basic");
        foreach ($sgroups as $group)
        {
            $this->ItemDataSGroups[ $group ][ "Data" ]=
                array_merge
                (
                    $this->ItemDataSGroups[ $group ][ "Data" ],
                    $this->ValuesVars
                );
        }
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
        if ($module!="Lots")
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
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->Item_Existence_Message();
        if ($res)
        {
            $res=$this->LotsObj()->Item_Existence_Message("Types");
        }

        return $res;
    }

    
    //*
    //* function Lots_Value_Update, Parameter list: $item,$data,$newvalue
    //*
    //* Updates lots value. Subst , for .
    //*

    function Lots_Value_Update($item,$data,$newvalue)
    {
        if (preg_match('/^\d+[.,]?\d*$/',$newvalue))
        {
            $newvalue=preg_replace('/,$/',".",$newvalue);
            $newvalue=sprintf("%.02f",$newvalue);
            
            $item[ $data ]=$newvalue;
        }
        
        return $item;
    }

    //*
    //* function Lots_Read, Parameter list: $item,$data,$newvalue
    //*
    //* Reads event lots, if necessary.
    //*

    function Lots_Read()
    {
        if (empty($this->Lots))
        {
            $this->Lots=$this->Sql_Select_Hashes($this->UnitEventWhere());
        }
    }
    
    //*
    //* function Lot_Current_Get, Parameter list: $item,$data,$newvalue
    //*
    //* Returns current lot, according to tdays date.
    //*

    function Lot_Current_Get()
    {
        $today=$this->MyTime_2Sort();
        
        $this->Lots_Read();
        if (empty($this->Lot))
        {
            $rlots=array();
            foreach ($this->Lots as $lot)
            {
                if ($lot[ "LimitDate" ]>=$today)
                {
                    $rlots[ $lot[ "LimitDate" ] ]=$lot;
                }
            }

            $this->Lot=array();
            if (!empty($rlots))
            {
                $dates=array_keys($rlots);
                sort($dates);
                $date=array_shift($dates);
    
                $this->Lot=$rlots[ $date ];
            }
        }

        return $this->Lot;
    }

    //*
    //* function Lot, Parameter list: $id=0
    //*
    //* Return lot with ID $id.
    //*

    function Lot($lotid=0)
    {
        if (empty($lotid)) { return $this->Lot_Current_Get(); }

        $rlot=array();
        foreach ($this->Lots as $lot)
        {
            if ($lot[ "ID" ]==$lotid)
            {
                $rlot=$lot;
                break;
            }
        }

        return $rlot;
    }

    

    
    //*
    //* function Lot_Default_Type_Get, Parameter list: $item,$data,$newvalue
    //*
    //* Returns default type for current lot: most expensive.
    //*

    function Lot_Default_Type_Get($lot=array())
    {
        if (empty($lot)) { $lot=$this->Lot_Current_Get(); }

        $keys=array_keys($lot);
        $keys=preg_grep('/^Value_\d+$/',$keys);
        
        $maxval=0.0;
        $maxkey="";
        foreach ($keys as $key)
        {
            if ($maxval<$lot[ $key ])
            {
                $maxval=$lot[ $key ];
                $maxkey=$key;
            }
                
        }

        $type=0;
        if ($maxval>0.0)
        {
            $type=preg_replace('/^Value_/',"",$maxkey);
            $type=intval($type);
        }

        return $type;
    }

    
}

?>