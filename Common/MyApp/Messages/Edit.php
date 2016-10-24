<?php

include_once("Edit/Paths.php");
include_once("Edit/Files.php");
include_once("Edit/Hashes.php");
include_once("Edit/Keys.php");
include_once("Edit/Language.php");

trait MyApp_Messages_Edit
{
    use
        MyApp_Messages_Edit_Paths,
        MyApp_Messages_Edit_Files,
        MyApp_Messages_Edit_Hashes,
        MyApp_Messages_Edit_Keys,
        MyApp_Messages_Edit_Language;
    
    var $FixedFiles=
        array
        (
           "../MySql2/Actions/Actions.php" => array("Name","Title","ShortName"),
           "System/Modules.php" => array("ItemName","ItemsName"),
           "System/Profiles.php" => array("Name","PName"),
           "System/LeftMenu.php" => array("Name","Title"),
        );
    
    //*
    //* function MyApp_Messages_Edit_Handle, Parameter list: 
    //*
    //* Handles message editing
    //*

    function MyApp_Messages_Edit_Handle()
    {
        $this->MyApp_Interface_Head();

        $edit=1;
        echo
            $this->MyApp_Messages_Edit_Modules_Menu().
            $this->MyApp_Messages_Edit($edit);
    }
        
    //*
    //* function MyApp_Messages_Edit, Parameter list: $edit
    //*
    //* Handles message editing
    //*

    function MyApp_Messages_Edit($edit)
    {
        $module=$this->CGI_GET("Module");

        $html="";
        if (empty($module))
        {
            $paths=$this->MessageDirs;
            array_unshift($paths,"System/LeftMenu");

            $html=
                $this->MyApp_Messages_Edit_Paths($edit,$paths);
        }
        else
        {
            $html=
                $this->MyApp_Messages_Edit_Module($edit,$module);
        }

        return $html;
    }
        
    //*
    //* function MyApp_Messages_Edit_Module, Parameter list: $edit,$module
    //*
    //* Runs module message editing.
    //*

    function MyApp_Messages_Edit_Module($edit,$module)
    {
        $module=$this->MyApp_Module_GetObject($module);

        return $module->MyMod_Messages_Edit($edit);
    }
    
    //*
    //* function MyApp_Messages_Edit_Modules_Menu, Parameter list: 
    //*
    //* Handles message editing
    //*

    function MyApp_Messages_Edit_Modules_Menu()
    {
        $modules=$this->MyApp_Modules_Get();

        $args=$this->CGI_URI2Hash();
        unset($args[ "File" ]);
        
        $hrefs=array();
        foreach ($modules as $module)
        {
            $args[ "Module" ]=$module;
            array_push
            (
               $hrefs,
               $this->Href
               (
                  "?".$this->CGI_Hash2URI($args),
                  $module
               )
            );
        }
        
        return
            $this->Center
            (
               $this->B("Modules: ").
               $this->HRefMenu("",$hrefs).
               ""
            );
    }
    
    //*
    //* function MyApp_Messages_Edit_Titles, Parameter list: $path
    //*
    //* Handles message $file editing.
    //*

    function MyApp_Messages_Edit_Title_Rows($path)
    {
        return
            array
            (
               $this->Html_Table_Head_Row
               (
                  array("Path","File","Writeable","Nº Keys")
               )
            );
    }

    //*
    //* function MyApp_Messages_Edit_Title_Row, Parameter list: $path,$file
    //*
    //* Handles message $file editing.
    //*

    function MyApp_Messages_Edit_File_Title_Row($path,$file)
    {
        return array(array("Message","Key","Lang","Value"));
    }

    
}

?>