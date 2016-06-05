<?php

trait Sql_Insert
{
    //*
    //* function Sql_Insert_Item_Query, Parameter list: $item,$table=""
    //*
    //* Genertates query inserting item into $table.
    //* 

    function Sql_Insert_Item_Query($item,$table="",$nocheckcols=FALSE)
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        $query1="";
        $query2="";
        foreach ($item as $data => $value)
        {
            if (!is_array($value) && !empty($value))
            {
                if ($nocheckcols || $this->Sql_Table_Field_Exists($data,$table))
                {
                    $query1.=$this->Sql_Table_Column_Name_Qualify($data).", ";
                    $query2.="'".$value."', ";
                }
            }
        }

        $query1=preg_replace('/,\s$/',"",$query1);
        $query2=preg_replace('/,\s$/',"",$query2);

        return
            "INSERT INTO ".
            $this->Sql_Table_Name_Qualify($table).
            " (".
            $query1.
            ") VALUES (".
            $query2.
            ")";
    }
    
    //*
    //* function Sql_Insert_NextID, Parameter list: 
    //*
    //* Returns next ID: max+1.
    //* 
    //* 

    function Sql_Insert_NextID($table)
    {
        $ids=$this->Sql_Select_Unique_Col_Values("ID",array(),"",$table);

        $max=0;
        foreach ($ids as $id) { if ($id>$max) { $max=$id; } }

        return $max+1;
    }
    
    //*
    //* function Sql_Insert_LastID, Parameter list: $result,$table
    //*
    //* Adds $item (assoc array) to DB table $table
    //* 
    //* 

    function Sql_Insert_LastID($result,$table)
    {
        $type=$this->DB_Dialect();
        
        $id=0;
        if ($type=="mysql")
        {
            $id=$this->DB_Method_Call("Insert_LastID",$result);
        }
        elseif ($type=="pgsql")
        {
            $query="SELECT max(\"ID\") FROM ".$this->Sql_Table_Name_Qualify($table);
            $result=$this->DB_Query($query);
            $result=$this->DB_Fetch_Assoc($result);
            if (!empty($result[ 'max' ])) $id=$result[ 'max' ];
        }

        return $id;
    }
    
    //*
    //* function Sql_Insert_Item, Parameter list: &$item,$table="",$nocheckcols=FALSE
    //*
    //* Adds $item (assoc array) to DB table $table
    //* 
    //* 

    function Sql_Insert_Item(&$item,$table="",$nocheckcols=FALSE)
    {
        $this->LastSqlInsert=$this->Sql_Insert_Item_Query($item,$table,$nocheckcols);
        $item[ "ID" ]=$this->Sql_Insert_NextID($table);

        $result=$this->DB_Query($this->LastSqlInsert);

         //$item[ "ID" ]=$this->Sql_Insert_LastID($result,$table);

        return $result;
    }
    
    //*
    //* function Sql_Insert_Unique, Parameter list: $where,&$item,$table="",$nocheckcols=FALSE
    //*
    //* Adds $item (assoc array) to DB table $table
    //* 
    //* 

    function Sql_Insert_Unique($where,&$item,$table="",$nocheckcols=FALSE)
    {
        $ritem=$this->Sql_Select_Hash
        (
           $where,
           TRUE,
           array("ID"),
           $table
        );

       
        if (empty($ritem))
        {
            if ($table!="__Table__")
            {
                foreach (array("ATime","CTime","MTime") as $key)
                {
                    $item[ $key ]=time();
                }
            }

            $this->Sql_Insert_Item($item,$table,$nocheckcols);

            return TRUE;
        }
       
        return FALSE;
    }
}
?>