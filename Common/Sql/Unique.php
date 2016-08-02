<?php

trait Sql_Unique
{
    //*
    //* function Sql_UniqueItem__Update, Parameter list: $where,&$item,$table="",$nocheckcols=FALSE
    //*
    //* Makes sure $item exists in SQL $table, according to $where. If not creates it.
    //* If $item exists, updates it.
    //* 

    function Sql_Unique_Item_Update($where,&$item,$table="",$nocheckcols=FALSE)
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
        }
        else
        {
            $this->Sql_Update_Item($item,$where,array(),$table);
        }

        return $item;
    }

    //*
    //* function Sql_Unique_Item_AddOrUpdate, Parameter list: $table,$where,&$item,$namekey="ID"
    //*
    //* Adds $item according to whether exists with $where.
    //* If $item already exists, updates.
    //* 

    function Sql_Unique_Item_AddOrUpdate($where,&$item,$namekey="ID",$readdatas=array(),$table="")
    {
        if ($table=="") { $table=$this->SqlTableName($table); }

        $ritem=$this->Sql_Select_Hash
        (
           $where,
           array("ID"),
           TRUE,
           $table
        );

        if (!empty($ritem))
        {
            //Retrieve ID and update
            $item[ "ID" ]=$ritem[ "ID" ];
            foreach ($readdatas as $key)
            {
                if (!isset($item[ $key ]))
                {
                    $item[ $key ]="";
                }
            }

            $this->Sql_Update_Item
            (
               $item,
               array("ID" => $item[ "ID" ]),
               array(),
               $table
            );

            print "update<BR>";
            return 2;
        }
        else
        {
            foreach (array("ATime","CTime","MTime") as $key)
            {
                $item[ $key ]=time();
            }

            $res=$this->Sql_Insert_Item($item,$table);

            print "insert<BR>";
            return 1;
        }

        return -1;
    }

}
?>