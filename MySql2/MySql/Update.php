<?php


class MySqlUpdate extends MySqlInsert
{
    //*
    //* function MySqlTouchItem, Parameter list: $table,$where,$noecho=FALSE
    //*
    //* Touches an item - ie, updates ATime.
    //*
    //* 

    function MySqlTouchItem($table,$id,$noecho=FALSE)
    {
        $this->MySqlSetItemsValue($table,"ID",$id,"ATime",time());
    }

    //*
    //* function MySqlAlterTouchItem, Parameter list: $table,$where,$noecho=FALSE
    //*
    //* Touches an item - ie, updates ATime.
    //*
    //* 

    function MySqlAlterTouchItem($table,$id,$noecho=FALSE)
    {
        $this->MySqlSetItemsValue($table,"ID",$id,"MTime",time());
    }


    //*
    //* function MySqlShouldUpdateItem, Parameter list: $table,$item,$where
    //*
    //* Tests if $item (assoc array) needs updating in table $table.
    //* 
    //* 

    function MySqlShouldUpdateItem($table,$item,$where,$data=array())
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if ($table=="") { $table=$this->SqlTableName($table); }

        if (count($data)==0) { $data=array_keys($item); }

        $olditem=$this->SelectUniqueHash($table,$where);

        $nchanges=0;
        foreach ($data as $key)
        {
            $value=$item[ $key ];
            if ($value!=$olditem[ $key ]) { $nchanges++; }
        }

        if ($nchanges>0)
        {
            return $nchanges;
        }
        else
        {
            return -1;
        }
    }



    //*
    //* function MySqlUpdateItem, Parameter list: $table,$item,$where,$datas=array()
    //*
    //* Updates $item (assoc array) to DB table $table, if needed.
    //* 
    //* 

    function MySqlUpdateItem($table,$item,$where,$datas=array())
    {
        return $this->Sql_Update_Item($item,$where,$datas,$table);
    }

    //*
    //* function MySqlSetItemValue, Parameter list: $table,$idvar,$id,$var
    //*
    //* Sets value of var $var of item with key $idvar $id in table $table. 
    //* Returns value set. Should limit to ID
    //* 

    function MySqlSetItemValue($table,$idvar,$id,$var,$value)
    {
        return $this->Sql_Update_Item_Value_Set($id,$var,$value,$idvar,$table);
    }


    //*
    //* function MySqlSetItemsValue, Parameter list: $table,$idvar,$id,$var,$value
    //*
    //* Sets value of var $var of multiple items with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function MySqlSetItemsValue($table,$idvar,$id,$var,$value)
    {
        return $this->Sql_Update_Items_Value_Set($idvar,$id,$value,$table);
    }

    //*
    //* function MySqlSetItemValues, Parameter list: $table,$idvar,$id,$vars,$item
    //*
    //* Returns values of var $vars of item with key $idvar $id in table $table. 
    //* Returns values set.
    //* 

    function MySqlSetItemValues($table,$vars,$item)
    {
        return $this->Sql_Update_Item_Values_Set($vars,$item,$table);
    }

    //*
    //* function MySqlSetItemValuesWhere, Parameter list: $table,$idvar,$id,$vars,$item
    //*
    //* Returns values of var $vars of item with key $idvar $id in table $table. 
    //* Returns values set.
    //* 

    function MySqlSetItemValuesWhere($table,$where,$vars,$item)
    {
        return $this->Sql_Update_Where($item,$where,$vars,$table);
    }


    /* //\* */
    /* //\* function UpdateQuery, Parameter list: $table,$set,$where */
    /* //\* */
    /* //\* Runs a set .. where query on entire table. */
    /* //\*  */

    /* function UpdateQuery($table,$set,$where) */
    /* { */
    /*     if ($table=="") { $table=$this->SqlTableName($table); } */

    /*     $sets=array(); */
    /*     foreach ($set as $var => $value) */
    /*     { */
    /*         array_push($sets,$var."='".$value."'"); */
    /*     } */

    /*     if (is_array($where)) { $where=$this->Hash2SqlWhere($where); } */

    
    /*     $query= */
    /*         "UPDATE `".$table."` ". */
    /*         "SET ".join(", ",$sets)." ". */
    /*         "WHERE ".$where; */

    /*     $this->QueryDB($query); */
    /* } */

    //*
    //* function AddOrUpdate, Parameter list: $table,$where,&$item,$namekey="ID"
    //*
    //* Test whether $item should be added or updated:
    //* If $this->SelectUniqueHash() returns an empty set, adds -
    //* Otherwise updates.
    //* 

    function AddOrUpdate($table,$where,&$item,$namekey="ID",$readdatas=array())
    {
        if ($table=="") { $table=$this->SqlTableName($table); }

        $ritem=$this->SelectUniqueHash
        (
           $table,
           $where,
           TRUE,
           array("ID")
        );

        if (!empty($ritem))
        {
            //Retrieve ID and update
            $item[ "ID" ]=$ritem[ "ID" ];
            /* foreach (array("ATime","MTime") as $key) */
            /* { */
            /*     $item[ $key ]=time(); */
            /* } */

            foreach ($readdatas as $key)
            {
                if (!isset($item[ $key ]))
                {
                    $item[ $key ]="";
                }
            }

            $this->MySqlUpdateItem
            (
               $table,
               $item,
               "ID='".$item[ "ID" ]."'"
            );

            return 2;
        }
        else
        {
            foreach (array("ATime","CTime","MTime") as $key)
            {
                $item[ $key ]=time();
            }

            $res=$this->MySqlInsertItem($table,$item);

            return 1;
        }

        return -1;
    }

    //*
    //* function DataNeedUpdate, Parameter list: $newvalue,$data,&$item,&$updatedata
    //*
    //* Test whether $newvalue differrs from $item[ $data ] 
    //* (or the latter does not exists), if so, updates $item[ $data ]
    //* and appends $data to $updatedata
    //* 

    function DataNeedUpdate($newvalue,$data,&$item,&$updatedata)
    {
        if (empty($item[ $data ]) || $newvalue!=$item[ $data ])
        {
            $item[ $data ]=$newvalue;
            array_push($updatedata,$data);
        }
    }

    //*
    //* function DatasNeedUpdate, Parameter list: $newvalues,&$item,&$updatedata,$update=TRUE
    //*
    //* Test whether $newvalue differrs from $item[ $data ] 
    //* (or the latter does not exists), if so, updates $item[ $data ]
    //* and appends $data to $updatedata
    //* 

    function DatasNeedUpdate($newvalues,&$item,$update=TRUE)
    {
        $updatedata=array();
        foreach ($newvalues as $data => $newvalue)
        {
            $this->DataNeedUpdate($newvalue,$data,$item,$updatedata);
        }

        if ($update && count($updatedata)>0)
        {
            $this->MySqlSetItemValues("",$updatedata,$item);
        }
    }

    //*
    //* function UpdateUniqueItem, Parameter list: $table,$uniquewhere,$vars,$item
    //*
    //* Checks if item is unique - and if so, updates $vars columns for this $item.
    //* 

    function UpdateUniqueItem($table,$uniquewhere,$vars,$item)
    {
        if (empty($vars)) { return; }
        if ($table=="") { $table=$this->SqlTableName($table); }

        $hash=$this->SelectUniqueHash($table,$uniquewhere);
        if (empty($hash) || empty($hash[ "ID" ])) { return FALSE; }
        $uniquewhere[ "ID" ]=$hash[ "ID" ];

        $sets=array();
        foreach ($vars as $vid => $var)
        {
            $value=preg_replace("/'/","''",$item[ $var ]);
            array_push($sets,$var."='".$value."'");
        }
    
        $query=
            "UPDATE `".$table."` ".
            "SET ".join(", ",$sets)." ".
            "WHERE ".$this->Hash2SqlWhere($uniquewhere);

        $this->QueryDB($query);
    }
 

    //*
    //* function MySqlSetItemValueWhere, Parameter list: $table,$where,$var,$value
    //*
    //* Sets value of var $var of item with key $idvar $id in table $table. 
    //* Returns value set. Should limit to ID
    //* 

    function MySqlSetItemValueWhere($table,$where,$var,$value)
    {
        if ($table=="") { $table=$this->SqlTableName($table); }
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $value=preg_replace("/'/","''",$value);
        $query="UPDATE `".$table."` SET ".$var."='".$value."' WHERE ".$where;

        $this->QueryDB($query);

        return $value;
    }
    //*
    //* function SetAndUpdateDataValue, Parameter list: 
    //*
    //* Sets and updates data value
    //*

    function SetAndUpdateDataValue($table="",&$item,$data,$value,$idkey="ID")
    {
        $item[ $data ]=$value;
        $this->MySqlSetItemValue
        (
           "",
           $idkey,
           $item[ $idkey ],
           $data,
           $value
        );
    }
    //*
    //* function MySqlSetFieldWhere, Parameter list: $table,$where,$set
    //*
    //* Executes Update $table SET $set where $where
    //* 

    function MySqlSetFieldWhere($table,$where,$set)
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($table)) { $table=$this->SqlTableName($table); }

        $query="UPDATE `".$table."` SET ".$set." WHERE ".$where;

        return $this->QueryDB($query);
    }
}

?>