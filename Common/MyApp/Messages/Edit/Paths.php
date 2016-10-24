<?php


trait MyApp_Messages_Edit_Paths
{
    //*
    //* function MyApp_Messages_Edit_Paths, Parameter list: $edit,$paths
    //*
    //* Handles message $paths editing.
    //*

    function MyApp_Messages_Edit_Paths($edit,$paths)
    {
        $table=array();
        foreach ($this->FixedFiles as $file => $keys)
        {
            $table=array_merge($table,$this->MyApp_Messages_Edit_Title_Rows("",$file));
            $table=array_merge
            (
               $table,
               $this->MyApp_Messages_Edit_File($edit,"",$file,$keys)
            );
         }

        
        foreach ($paths as $path)
        {
            $table=
                array_merge
                (
                   $table,
                   $this->MyApp_Messages_Edit_Path($edit,$path)
                );
        }
        
        return
            $this->H(1,"System Messages").
            $this->Html_Table("",$table).
            "";
    }

    //*
    //* function MyApp_Messages_Edit_Path, Parameter list: $path
    //*
    //* Handles message dir, $path, editing.
    //*

    function MyApp_Messages_Edit_Path($edit,$path)
    {
        $tables=array();
        foreach ($this->MyApp_Messages_Dir_Files_Get($path) as $file)
        {
            array_push
            (
               $tables,
               $this->MyApp_Messages_Edit_File($edit,$path,$file)
            );
        }

        $rtable=array();
        $rtable=array_merge($rtable,$this->MyApp_Messages_Edit_Title_Rows($path,$file));
        foreach ($tables as $table)
        {
            $rpath=$path;
            for ($n=0;$n<count($table);$n++)
            {
                array_unshift($table[ $n ],$rpath);
                array_push($rtable,$table[ $n ]);
                $rpath="";
            }
        }
        
        return $rtable;
    }
}

?>