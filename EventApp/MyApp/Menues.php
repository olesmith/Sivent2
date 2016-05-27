<?php

class MyEventAppMenues extends MyEventAppAccess
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

        return $menu;
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
            join("",$this->HtmlEventsMenu()).
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


     //*
    //* function  HtmlEventsMenuDef, Parameter list: 
    //*
    //* Returns menu def as read from system file. May be overridden.
    //*

    function HtmlEventsMenuDef()
    {
        return $this->ReadPHPArray("../EventApp/System/Events/LeftMenu.php");
    }
    
    //*
    //* function  HtmlEventsMenu, Parameter list: 
    //*
    //* Prints menu of Events.
    //*

    function HtmlEventsMenu()
    {
        $args=$this->ScriptQueryHash();
        if ($this->Unit) { $args[ "Unit" ]=$this->Unit[ "ID" ]; }

        $args[ "ModuleName" ]="";
        $args[ "Action" ]="Search";
 
        $currenteventid=$this->GetCGIVarValue("Event");
        $events=$this->EventsObj()->SelectHashesFromTable
        (
           "",
           array("Unit" => $args[ "Unit" ]),
           array("ID","Name","Date"),
           FALSE,
           "Date,ID"
        );

        $links=array();
        foreach (array_reverse($events) as $event)
        {
            $eventid=$event[ "ID" ];
            if ($eventid!=$currenteventid)
            {
                array_push
                (
                   $links,
                   $this->HtmlEventMenu($event,$args).
                   $this->BR()
                );
            }
            else
            {
                array_push
                (
                   $links,
                   "&nbsp;".$this->MyApp_Interface_LeftMenu_Bullet("-").
                   $event[ "Name" ].
                   $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
                   (
                      $this->HtmlEventsMenuDef(),
                      $event
                   ).
                   $this->BR()
                );
            }
        }      

        return $links;
    }


    //*
    //* function  HtmlEventMenu, Parameter list: $event
    //*
    //* Prints menulist of $event.
    //*

    function HtmlEventMenu($event,$args)
    {
        $args[ "Event" ]=$event[ "ID" ];
        $args[ "ModuleName" ]="Events";

        $args[ "Action" ]="Show";
        if (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $args[ "Action" ]="Edit";
        }
        
        $args[ "ID" ]=$event[ "ID" ];

        return 
            $this->MyApp_Interface_LeftMenu_Bullet("+").
            $this->HtmlTags
            (
               "A",
               $event[ "Name" ],
               array
               (
                  "HREF" => "?".$this->Hash2Query($args),
                  "TITLE" => $event[ "Name" ],
               )
             );
    }
}
