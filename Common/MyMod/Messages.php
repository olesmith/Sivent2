<?php

trait MyMod_Messages
{
    //*
    //* function MyMod_Messages_Files, Parameter list: 
    //*
    //* Returns list of module messaged files.
    //*

    function MyMod_Messages_Files()
    {
        return 
            array_merge
            (
               $this->MyMod_Data_Files_Get(),
               $this->MyActions_GetFiles(),
               $this->MyMod_Data_Groups_Files_GetFiles(FALSE),
               $this->MyMod_Data_Groups_Files_GetFiles(TRUE)
            );
    }
    
    //*
    //* function MyMod_Messages_Edit, Parameter list: $edit
    //*
    //* Handles message editing
    //*

    function MyMod_Messages_Edit($edit)
    {        
        $table=$this->ApplicationObj()->MyApp_Messages_Edit_Title_Rows("");
        
        foreach ($this->MyMod_Messages_Files() as $file)
        {
            $rtable=
               $this->ApplicationObj()->MyApp_Messages_Edit_File
               (
                  $edit,
                  "",
                  $file,
                  array("Name","Title","ShortName")
                );
            
            $path=dirname($file);
            foreach (array_keys($rtable) as $n)
            {
                array_unshift($rtable[ $n ],$path);
                //$path="";
            }

            $table=array_merge($table,$rtable);
        }

         return
            $this->H(1,"System Messages").
            $this->H(2,"Module: ".$this->ModuleName).
            $this->Html_Table("",$table).
            "";
    }
        
}

?>