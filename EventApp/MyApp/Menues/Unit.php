<?php

class MyEventApp_Menues_Unit extends MyEventApp_Overrides
{
    //*
    //* function  MyEvent_App_Menues_Unit_Paths, Parameter list: 
    //*
    //* Returns paths to menus paths. Optionally overwritten.
    //*

    function MyEvent_App_Menues_Unit_Paths()
    {
        return array("../EventApp/System/Units","System/Units");
    }
    
    //*
    //* function  MyEvent_App_Menues_Sys_Paths, Parameter list: 
    //*
    //* Returns paths to menus files. Optionally overwritten.
    //*

    function MyEvent_App_Menues_Sys_Files()
    {
        return array("LeftMenu.php");
    }
    
    //*
    //* function  MyEvent_App_Menues_Unit_Files, Parameter list: 
    //*
    //* Generates Unit menu.
    //*

    function MyEvent_App_Menues_Unit_Files()
    {
        $files=array();
        foreach ($this->MyEvent_App_Menues_Unit_Paths() as $path)
        {
            foreach ($this->MyEvent_App_Menues_Sys_Files() as $file)
            {
                $rfile=$path."/".$file;
                if (file_exists($rfile))
                {
                    array_push($files,$rfile);
                }
            }
        }

        return $files;
    }

    //*
    //* function  MyEvent_App_Menues_Unit_Menues, Parameter list: 
    //*
    //* Generates Unit menu.
    //*

    function MyEvent_App_Menues_Unit_Menues($unit)
    {
        $title=$unit[ "Name" ];

        $menu="";
        foreach ($this->MyEvent_App_Menues_Unit_Files() as $file)
        {
            $submenu=$this->ReadPHPArray($file);
            if (!empty($submenu))
            {
                $menu.=
                    "&nbsp;".$this->MyApp_Interface_LeftMenu_Bullet("-").
                    $title.
                    $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List($submenu,$unit).
                    "";
                $title="";
            }
                
        }

        return preg_replace('/#Unit/',$unit[ "ID" ],$menu);
    }
    
    //*
    //* function  MyEvent_App_Menues_Unit_Menu, Parameter list: 
    //*
    //* Generates Unit menu.
    //*

    function MyEvent_App_Menues_Unit_Menu($unit)
    {
        return
            $this->MyEvent_App_Menues_Unit_Menues($unit).
            "";
    }
    
    //*
    //* function  HtmlUnitMenu, Parameter list: 
    //*
    //* Generates Unit menu.
    //*

    function HtmlUnitMenu($menufile="LeftMenu.php")
    {
        $args=$this->ScriptQueryHash();
        if ($this->Unit) { $args[ "Unit" ]=$this->Unit[ "ID" ]; }
        $args[ "ModuleName" ]="";
        $args[ "Action" ]="Search";

        unset($args[ "Type" ]);
 
        $currentunitid=$this->GetCGIVarValue("Unit");
        $units=$this->UnitsObj()->SelectHashesFromTable
        (
           "",
           array("ID" => $currentunitid),
           array("ID","Name"),
           FALSE,
           "Name"
        );

        $links=array();
        foreach ($units as $unit)
        {
            $unitid=$unit[ "ID" ];
            if ($unitid!=$currentunitid)
            {
                $rargs=$args;
                $rargs[ "Unit" ]=$unitid;
                array_push
                (
                   $links,
                   $this->MyApp_Interface_LeftMenu_Bullet("+").
                   $this->HtmlTags
                   (
                      "A",
                      $unit[ "Name" ],
                      array
                      (
                         "HREF" => "?".$this->Hash2Query($rargs),
                         "TITLE" => "Ano de ".$unit[ "Name" ],
                      )
                   )
                );
            }
            else
            {
                array_push
                (
                   $links,
                   $this->MyEvent_App_Menues_Unit_Menu($unit)
                );
           }
        }      

        return $links;
    }
}
