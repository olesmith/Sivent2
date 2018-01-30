<?php


include_once("Items/Read.php"); 
include_once("Items/Ors.php"); 
include_once("Items/Row.php"); 
include_once("Items/Table.php"); 
include_once("Items/Menu.php"); 
include_once("Items/Group.php"); 
include_once("Items/Post.php"); 
include_once("Items/Search.php"); 
include_once("Items/PHP.php"); 
include_once("Items/Print.php"); 
include_once("Items/Latex.php"); 
include_once("Items/Update.php"); 

trait MyMod_Items
{
    use
        MyMod_Items_Read,
        MyMod_Items_Table,
        MyMod_Items_Menu,
        MyMod_Items_Group,
        MyMod_Items_Post,
        MyMod_Items_Row,
        MyMod_Items_Ors,
        MyMod_Items_Search,
        MyMod_Items_PHP,
        MyMod_Items_Print,
        MyMod_Items_Latex,
        MyMod_Items_Update;
        
    //*
    //* function GetRealWhereClause, Parameter list: $where="",$data=""
    //*
    //* Returns the real where clause, that is $this->SqlWhere properly
    //* prepended.
    //*

    function MyMod_Items_Where_Clause_Real($where="",$data="")
    {
        if (is_array($where)) { $wheres=$where; }
        else                  { $wheres=$this->SqlClause2Hash($where); }

        $rwheres=$this->SqlWhere;
        if (!is_array($this->SqlWhere))
        {
            $rwheres=$this->SqlClause2Hash($this->SqlWhere);
        }

        foreach ($rwheres as $key => $value)
        {
            $wheres[ $key ]=$value;
        }

        $where=$this->Sql_Where_From_Hash($wheres);

        if ($this->LoginType!="Public")
        {
            $where=preg_replace('/#Login/',$this->LoginData[ "ID" ],$where);
        }

        return $where;
    }

}

?>