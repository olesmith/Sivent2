<?php

trait Sql_Update
{
    //*
    //* function Sql_Update_Item_Query, Parameter list: $item,$where,$datas=array(),$table=""
    //*
    //* Updates $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Update_Item_Query($item,$where,$datas=array(),$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($datas)) { $datas=array_keys($item); }
        //if (empty($table)) { $table=$this->SqlTableName($table); }

        $olditem=$this->Sql_Select_Hash($where,$datas,FALSE,$table);

        $query="";
        
        $nchanges=0;
        foreach ($datas as $key)
        {
            $value=$item[ $key ];
            $value=preg_replace('/\'/',"''",$value);
            
            if ($value!=$olditem[ $key ])
            {
                $query.=
                    $this->Sql_Table_Column_Name_Qualify($key).
                    "=".
                    $this->Sql_Table_Column_Value_Qualify($value).
                    ", ";
                $nchanges++;
            }
        }

        if ($nchanges>0)
        {
            $query=preg_replace('/,\s$/',"",$query);
            $query="UPDATE ".
                $this->Sql_Table_Name_Qualify($table).
                " SET ".
                $query.
                " WHERE ".
                $where;
        }

        return $query;
    }
    //*
    //* function Sql_Update_Item, Parameter list: $item,$where,$datas=array(),$table=""
    //*
    //* Updates $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Update_Item($item,$where,$datas=array(),$table="")
    {
        $query=$this->Sql_Update_Item_Query($item,$where,$datas,$table);
        if (!empty($query))
        {
            return $this->DB_Query($query);
        }
        else
        {
            return -1;
        }
    }

    //*
    //* function Sql_Update_Item_Value_Set_Query, Parameter list: $id,$var,$value,$idvar="ID",$table=""
    //*
    //* Sets value of var $var of item with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function Sql_Update_Item_Value_Set_Query($id,$var,$value,$idvar="ID",$table="")
    {
        //if (empty($table)) { $table=$this->SqlTableName($table); }
        
        $value=preg_replace("/'/","''",$value);
        return
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".
            $this->Sql_Table_Column_Name_Qualify($var).
            "='".$value."'".
            " WHERE ".
            $this->Sql_Table_Column_Name_Qualify($idvar).
            "='".$id."'";
    }
    
    
    //*
    //* function Sql_Update_Item_Value_Set, Parameter list: $id,$var,$value,$idvar="ID",$table=""
    //*
    //* Sets value of var $var of item with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function Sql_Update_Item_Value_Set($id,$var,$value,$idvar="ID",$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        $query=$this->Sql_Update_Item_Value_Set_Query($id,$var,$value,$idvar,$table);

        return $this->DB_Query($query);
    }
    
    //*
    //* function Sql_Update_Items_Value_Set, Parameter list: $idvar,$id,$var,$value,$table=""
    //*
    //* Sets value of var $var of multiple items with key $idvar $id in table $table. 
    //* Returns value set.
    //* 

    function Sql_Update_Items_Value_Set($idvar,$id,$var,$value,$table="")
    {
        $value=preg_replace("/'/","''",$value);
        $query=
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".
            $this->Sql_Table_Column_Name_Qualify($var).
            "=".
            $this->Sql_Table_Column_Value_Qualify($value).
            " WHERE ".
            $this->Sql_Table_Column_Name_Qualify($idvar).
            "=".
            $this->Sql_Table_Column_Value_Qualify($id);

        $this->DB_Query($query);

        return $value;
    }
    //*
    //* function Sql_Update_Item_Values_Set_Query, Parameter list: $vars,$item,$table=""
    //*
    //* Returns update query.
    //* 

    function Sql_Update_Item_Values_Set_Query($vars,$item,$table="")
    {
        //if (empty($table)) { $table=$this->SqlTableName($table); }

        $sets=array();
        foreach ($vars as $vid => $var)
        {
            $value=preg_replace("/'/","''",$item[ $var ]);
            array_push
            (
               $sets,
               $this->Sql_Table_Column_Name_Qualify($var).
               "=".
               $this->Sql_Table_Column_Value_Qualify($value)
            );
        }
    
        return
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".
            join(", ",$sets)." ".
            "WHERE ".
            $this->Sql_Table_Column_Name_Qualify("ID").
            "=".
            $this->Sql_Table_Column_Value_Qualify($item[ "ID" ]);
    }
    
     //*
    //* function Sql_Update_Item_Values_Set, Parameter list: $vars,$item,$table=""
    //*
    //* Returns values of var $vars of item with key $idvar $id in table $table. 
    //* 

    function Sql_Update_Item_Values_Set($vars,$item,$table="")
    {
        if (empty($vars)) { return; }

        $query=$this->Sql_Update_Item_Values_Set_Query($vars,$item,$table);
        
        $this->DB_Query($query);
    }
    
    //*
    //* function Sql_Update_Where_Query, Parameter list: $item,$where
    //*
    //* Generrates UPDATE, SET $item WHERE $where.
    //* 

    function Sql_Update_Where_Query($item,$where,$datas=array(),$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($datas)) { $datas=array_keys($item); }
        
        $sets=array();
        foreach ($datas as $vid => $var)
        {
            $value=preg_replace("/'/","''",$item[ $var ]);
            array_push
            (
               $sets,
               $this->Sql_Table_Column_Name_Qualify($var).
               "=".
               $this->Sql_Table_Column_Value_Qualify($value)
            );
        }
    
        return
            "UPDATE ".
            $this->Sql_Table_Name_Qualify($table).
            " SET ".join(", ",$sets).
            " WHERE ".$where;
    }
    
    //*
    //* function Sql_Update_Where, Parameter list: $item,$where
    //*
    //* Updates $item with $datas, according to $where.
    //* 

    function Sql_Update_Where($item,$where,$datas=array(),$table="")
    {
        $naffected=$this->DB_Exec($this->Sql_Update_Where_Query($item,$where,$datas,$table));

        return $naffected;
    }

    
    //*
    //* function Sql_Update_Where, Parameter list: $item,$where
    //*
    //* Updates $item with $datas, according to $where - if $item unique, according to $where!"
    //* 

    function Sql_Update_Where_Unique($item,$where,$datas=array(),$table="")
    {
        $hash=$this->SelectUniqueHash($table,$uniquewhere);
        if (empty($hash) || empty($hash[ "ID" ])) { return FALSE; }
        
        return $this->Sql_Update_Where($item,$where,$datas,$table);
    }        


}
?>