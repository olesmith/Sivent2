<?php

trait MyMod_Handle_Info
{
    //*
    //* function MyMod_Handle_Info_Tables, Parameter list: 
    //*
    //* Generates module with sql tables info.
    //*

    function MyMod_Handle_Info_Tables()
    {
        $sqltables=$this->Sql_Table_Names('_'.$this->ModuleName.'$');
        sort($sqltables);
        
        $table=array();
        $n=1;
        $nitems=0;
        foreach ($sqltables as $sqltable)
        {
            $mtime=$this->Sql_Select_Hash_Value($sqltable,"Time","Name",FALSE,"__Table__");
            $nitem=$this->Sql_Select_NHashes("",$sqltable);
            $nitems+=$nitem;
            $row=
                array
                (
                   $this->B($n++).":",
                   $sqltable,
                   $this->TimeStamp2Text($mtime),
                   $this->Sql_Select_NHashes("",$sqltable),
                );

            array_push($table,$row);
        }

        array_push($table,array(),array("","",$this->B($this->ApplicationObj()->Sigma.":"),$nitems));
        return
            $this->H(2,"SQL Tables").
            $this->Html_Table
            (
               array("No.","SQL Table","Last Struct. Update","No. Items"),
               $table
            );
    }
    
    //*
    //* function MyMod_Handle_Info_Menu, Parameter list: 
    //*
    //* Generates with sql tables info.
    //*

    function MyMod_Handle_Info_Menu()
    {
        $hash=
            array
            (
               "Data" => "Item Data",
               "Actions" => "Actions",
               "Groups" => "Data Groups",
               "SGroups" => "Data SGroups",
               "HorMenu" => "Horisontal Menus",
            );
        
        $args=$this->CGI_URI2Hash();
        $hrefs=array();
        foreach ($hash as $type => $name) 
        {
            $args[ "Type" ]=$type;
            $href="?".$this->CGI_Hash2URI($args);
            $href=$this->Href($href,$name,"","","",FALSE,array(),"HorMenu");
            array_push($hrefs,$href);
        }

        return
            $this->BR().
            $this->Center("[ ".join(" | ",$hrefs)." ]").
            $this->BR().
            "";
    }
    
    //*
    //* function MyMod_Handle_Info, Parameter list: 
    //*
    //* Handles module object info.
    //*

    function MyMod_Handle_Info()
    {
        $table=
            array
            (
               array
               (
                  $this->B("Module:"),
                  $this->ModuleName,
                  $this->B("File:"),
                  $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ "SqlFile" ],
               ),
               array
               (
                  $this->B("SqlClass:"),
                  $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ "SqlClass" ],
                  $this->B("SqlFile:"),
                  $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ "SqlFile" ],
               ),
                array
               (
                  $this->B("SqlFilter:"),
                  $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ "SqlFilter" ],
                  $this->B("SqlDerivedData:"),
                  $this->ApplicationObj()->SubModulesVars[ $this->ModuleName ][ "SqlDerivedData" ],
               ),
               array
               (
                  $this->B("Item Name:"),
                  $this->ItemName,
                  $this->B("Item Name (UK):"),
                  $this->ItemName_UK,
               ),
               array
               (
                  $this->B("Items Name:"),
                  $this->ItemsName,
                  $this->B("Items Name (UK):"),
                  $this->ItemsName_UK,
               ),
               array
               (
                  $this->B("Item Namer:"),
                  $this->ItemsNamer,
                  $this->B("Item Namer (UK):"),
                  $this->ItemsNamer_UK,
               ),
            );

        
        echo
            $this->H(1,"Module Info").
            $this->Html_Table("",$table).
            $this->MyMod_Handle_Info_Tables().
            $this->MyMod_Handle_Info_Menu().
            "";

        $type=$this->CGI_GET("Type");
        if (empty($type)) $type="Data";

        if ($type=="Data")
        {
            echo $this->MyMod_Data_Info();
        }
        elseif ($type=="Actions")
        {
            echo $this->MyMod_Actions_Info();
        }
        elseif ($type=="Groups")
        {
            echo $this->MyMod_Data_Groups_Info();
        }
        elseif ($type=="SGroups")
        {
            echo $this->MyMod_Data_Groups_Info(TRUE);
        }        
        elseif ($type=="HorMenu")
        {
            echo $this->MyMod_HorMenu_Info(TRUE);
        }        
    }
}

?>