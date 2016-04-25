<?php


trait Sql_Table_Info
{
    //*
    //* function Sql_Tables_Info_Name, Parameter list:
    //*
    //* Name of tables info table.
    //*

    function Sql_Tables_Info_Name()
    {
        return "__Table__";
    }
    
     //*
    //* function Sql_Tables_Info_Data, Parameter list:
    //*
    //* Data defs of tables info table.
    //*

    function Sql_Tables_Info_Data()
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
               "Name" => array
               (
                  "Name"   => "Nome",
                  "Sql"    => "VARCHAR(256)",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
               ),
               "Time" => array
               (
                  "Name"   => "Última Atualização da Estrutura",
                  "Sql"    => "INT",
                  "Public" => 1,
                  "Person" => 1,
                  "Admin"  => 1,
                  "TimeType"  => TRUE,
               ),
            );
     }
    
    //*
    //* function Sql_Table_Info_Create, Parameter list:
    //*
    //* Creates session table, if non existent.
    //*

    function Sql_Tables_Info_Create()
    {
        $stable=$this->Sql_Tables_Info_Name();
        if (!$this->Sql_Table_Exists($stable))
        {
            $this->Sql_Table_Create($stable);

            //Success?
            if (!$this->Sql_Table_Exists($stable))
            {
                die("Unable to create SQL tables info table: ".$stable);
            }

            $datas=$this->Sql_Tables_Info_Data();
            unset($datas[ "ID" ]);
            
            $this->Sql_Table_Fields_Add_List(array_keys($datas),$datas,$stable);
        }

        return $stable;
    }

    //*
    //* function Sql_Table_Info_Get, Parameter list: $table
    //*
    //* Returns table info entry, adds if nonexistent.
    //*

    function Sql_Tables_Info_Get($table)
    {
        $this->Sql_Tables_Info_Create();

        if (empty($table)) { $table=$this->SqlTableName($table); }
        if (empty($table)) { return; }
        
        $where[ "Name" ]=$table;

        $hash=$this->Sql_Select_Hash
        (
           array("Name" => $table),
           array(),
           TRUE,
           $this->Sql_Tables_Info_Name()
        );

        if (empty($hash))
        {
            $where[ "Time" ]=time();
            $this->Sql_Tables_Info_Set($table,$where);
        }

        return $hash;
    }
    
    //*
    //* function Sql_Table_Info_Set, Parameter list: $table,$hash
    //*
    //* Updates table info entry, with values in $hash.
    //*

    function Sql_Tables_Info_Set($table,$hash)
    {
        if (empty($hash[ "Time" ])) { $hash[ "Time" ]=time(); }
        
        if (empty($table)) { $table=$this->SqlTableName($table); }
        if (empty($table)) { return; }
        
        $stable=$this->Sql_Tables_Info_Create();

        $where[ "Name" ]=$table;
        $hash[ "Name" ]=$table;

        if (!empty($hash[ "Name" ]))
        {
            $this->Sql_Insert_Unique($where,$hash,$this->Sql_Tables_Info_Name(),TRUE);
            $this->Sql_Update_Item($hash,$where,array("Time"),$this->Sql_Tables_Info_Name());
        }

        return $hash;
    }
}
?>