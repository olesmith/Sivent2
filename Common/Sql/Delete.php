<?php

trait Sql_Delete
{
    var $Sql_Delete_Log=FALSE;
    
    //*
    //* function Sql_Delete_Item_Query, Parameter list: $id,$var="ID",$table=""
    //*
    //* Deletes $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Delete_Item_Query($id,$var="ID",$table="")
    {
        if (is_array($id)) { $id=$id[ $var ]; }

        $id=intval($id);
        if (!empty($id) && $id>0)
        {
            return
                "DELETE FROM ".
                $this->Sql_Table_Name_Qualify($table).
                " WHERE ".
                $this->Sql_Table_Column_Name_Qualify($var).
                "='".$id."'";
        }

        return "";
    }

    
    //*
    //* function Sql_Delete_Item, Parameter list: $id,$var="ID",$table=""
    //*
    //* Deletes $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Delete_Item($id,$var="ID",$table="",$logging=TRUE)
    {
        if (is_array($id)) { $id=$id[ $var ]; }

        $id=intval($id);
        if (!empty($id) && $id>0 && $this->Sql_Table_Exists($table))
        {
            $query=$this->Sql_Delete_Item_Query($id,$var,$table);

            $res=$this->QueryDB($query);
            if ($this->Sql_Delete_Log)
            {
                $this->Sql_Log_Query($query,$res);
            }
            
            return $res;
        }

        return 0;
    }

    
    //*
    //* function Sql_Delete_Items_Query, Parameter list: $id,$var="ID",$table=""
    //*
    //* Deletes $multiple items, according to $where.
    //* 

    function Sql_Delete_Items_Query($where,$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        
        return
            "DELETE FROM ".
            $this->Sql_Table_Name_Qualify($table).
            " WHERE ".
            $where;
    }

    //*
    //* function Sql_Delete_Items Parameter list: $where,$table=""
    //*
    //* Deletes $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Delete_Items($where,$table="")
    {
        if (empty($where))
        {
            $this->Warn("Covardly refusing to delete with empty where clause: ",$where);
        }

        $res=FALSE;
        if ($this->Sql_Table_Exists($table))
        {
            $query=$this->Sql_Delete_Items_Query($where,$table);
            
            $res=$this->QueryDB($query);
            if ($this->Sql_Delete_Log)
            {
                $this->Sql_Log_Query($query,$res);
            }
        }
        
        return $res;            
    }

    //*
    //* function Sql_Delete_Items_ByID_Query Parameter list: $where,$table=""
    //*
    //* Deletes $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Delete_Items_ByID_Query($ids,$table="")
    {
        $where[ "ID" ]=$ids;
        
        return $this->Sql_Delete_Items_Query($where,$table);
    }
    
    //*
    //* function Sql_Delete_Items_ByID Parameter list: $where,$table=""
    //*
    //* Deletes $item (assoc array) to DB table $table, if needed.
    //* 

    function Sql_Delete_Items_ByID($ids,$table="")
    {
        $query=$this->Sql_Delete_Items_ByID_Query($ids,$table);
        
        $result=$this->DB_Query($query);
        
        return $result;
    }
    
}
?>