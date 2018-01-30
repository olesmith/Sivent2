<?php


trait Sql_Table_Index
{
    //*
    //* function Sql_Table_Index_Table_Name, Parameter list:
    //*
    //* Name of tables Index table.
    //*

    function Sql_Table_Index_Table_Name()
    {
        return "__Index__";
    }
    
     //*
    //* function Sql_Table_Index_Data, Parameter list:
    //*
    //* Data defs of tables Index table.
    //*

    function Sql_Table_Index_Data()
    {
        return 
            array
            (
              "ID" => array
               (
                  "Name"   => "ID",
                  "Sql"    => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "Module" => array
               (
                  "Name"   => "Module",
                  "Sql"    => "VARCHAR(256)",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
               ),
               "Sql_Table" => array
               (
                  "Name"   => "SQL Table",
                  "Sql"    => "VARCHAR(256)",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
               ),
               "Item" => array
               (
                  "Name"   => "Item ID",
                  "Sql"    => "INT",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
                  "TimeType"  => TRUE,
               ),
               "Name" => array
               (
                  "Name"   => "Item Name",
                  "Sql"    => "VARCHAR(256)",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
                  "TimeType"  => TRUE,
               ),
               "CTime" => array
               (
                  "Name"   => "First Seen",
                  "Sql"    => "INT",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
                  "TimeType"  => TRUE,
               ),
               "MTime" => array
               (
                  "Name"   => "Modified",
                  "Sql"    => "INT",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
                  "TimeType"  => TRUE,
               ),
               "ATime" => array
               (
                  "Name"   => "Last Seen",
                  "Sql"    => "INT",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
                  "TimeType"  => TRUE,
               ),
            );
     }
    
    //*
    //* function Sql_Table_Index_Table_Create, Parameter list:
    //*
    //* Creates session table, if non existent.
    //*

    function Sql_Table_Index_Table_Create()
    {
        $stable=$this->Sql_Table_Index_Table_Name();
        if (!$this->Sql_Table_Exists($stable))
        {
            $this->Sql_Table_Create($stable);

            //Success?
            if (!$this->Sql_Table_Exists($stable))
            {
                die("Unable to create SQL tables info table: ".$stable);
            }

            $datas=$this->Sql_Table_Index_Data();
            unset($datas[ "ID" ]);

            $this->Sql_Table_Fields_Add_List(array_keys($datas),$datas,$stable);
        }

        return $stable;
    }

    //*
    //* function Sql_Table_Index_Unique_Where, Parameter list: $table
    //*
    //* Returns unique where clause on index sql table
    //*

    function Sql_Table_Index_Unique_Where($sqltable,$item)
    {
        return
            array
            (
                "Sql_Table"    => $sqltable,
                "Module" => $this->ModuleName,
                "Item"   => $item[ "ID" ],
            );
    }
    
    //*
    //* function Sql_Table_Index_New_Entry, Parameter list: $table
    //*
    //* Returns new entry as hash.
    //*

    function Sql_Table_Index_New_Entry($item_table,$item)
    {
        $hash=$this->Sql_Table_Index_Unique_Where($item_table,$item);
        
        $hash[ "CTime" ]=$hash[ "MTime" ]=$hash[ "ATime" ]=time();
        $hash[ "Name" ]=$this->MyMod_Item_Name_Get($item);
        
        return $hash;
    }
    
    //*
    //* function Sql_Table_Index_Item_Stamp, Parameter list: $table
    //*
    //* Stamps $item in Index table.
    //*

    function Sql_Table_Index_Item_Stamp($item_table,$item)
    {
        $this->Sql_Table_Index_Table_Create();

        
        $where=$this->Sql_Table_Index_Unique_Where($item_table,$item);

        $hash=$this->Sql_Select_Hash
        (
           $where,
           array("ID","Name"),
           TRUE,
           $this->Sql_Table_Index_Table_Name()
        );

        if (empty($hash))
        {
            $hash=$this->Sql_Table_Index_New_Entry($item_table,$item);
            $this->Sql_Insert_Item
            (
                $hash,
                $this->Sql_Table_Index_Table_Name()
            );
            
            return $hash;
        }
        else
        {
            $updatedatas=array("ATime");

            $hash[ "ATime" ]=time();
            $name=$this->MyMod_Item_Name_Get($item);
            if ($hash[ "Name" ]!=$name)
            {
                $hash[ "Name" ]=$name;
                array_push($updatedatas,"MTime","Name");
            }
                

            $this->Sql_Update_Item_Values_Set
            (
                $updatedatas,
                $hash,
                $this->Sql_Table_Index_Table_Name()
            );
        }
        

        return $hash;
    }
    
    //*
    //* function Sql_Table_Index_Set, Parameter list: $table,$item
    //*
    //* Creates unique entry in Index db.
    //*

    function Sql_Table_Index_Set($item)
    {        
        $item_table=$this->SqlTableName();
        
        $this->Sql_Table_Index_Item_Stamp($item_table,$item);

        return $item;
    }
}
?>