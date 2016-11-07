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
    //* function  HtmlEventsWhere, Parameter list: 
    //*
    //* Returns menu def as read from system file. May be overridden.
    //*

    function HtmlEventsWhere()
    {
        return
            array
            (
               "Unit" => $this->Unit("ID"),
            );
    }
    
     //*
    //* function  HtmlEventsWhere, Parameter list: 
    //*
    //* Returns menu def as read from system file. May be overridden.
    //*

    function HtmlEventsData()
    {
        return array("ID","Unit","Name","Date","Initials");
    }
    
    //*
    //* function  HtmlEventsMenu, Parameter list: 
    //*
    //* Prints menu of Events.
    //*

    function HtmlEventsMenu()
    {
        $args=$this->ScriptQueryHash();
        unset($args[ "Type" ]);
 
        $uid=$this->Unit("ID");
        if (!empty($uid)) { $args[ "Unit" ]=$uid; }

        $args[ "ModuleName" ]="";
        $args[ "Action" ]="Search";
 
        $currenteventid=$this->GetCGIVarValue("Event");
        $events=$this->EventsObj()->SelectHashesFromTable
        (
           "",
           $this->HtmlEventsWhere(),
           $this->HtmlEventsData(),
           FALSE,
           "CTime,ID"
        );

        array_reverse($events);

        $links=array();
        foreach (array_reverse($events) as $event)
        {
            $eventid=$event[ "ID" ];

            $link="";
            if ($eventid!=$currenteventid)
            {
               $link=
                   $this->HtmlEventMenu($event,$args);
            }
            else
            {
                $name=$event[ "Name" ];
                if (!empty($event[ "Initials" ])) { $name=$event[ "Initials" ]; }
                
                $link=
                    "&nbsp;".$this->MyApp_Interface_LeftMenu_Bullet("-").
                    $name.
                    $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
                    (
                       $this->HtmlEventsMenuDef(),
                       $event
                     );
            }

            $link=preg_replace('/#Event/',$event[ "ID" ],$link);
            $link=preg_replace('/#Unit/',$args[ "Unit" ],$link);
            
            array_push($links,$link.$this->BR());
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
        $args[ "Unit" ]=$event[ "Unit" ];
        $args[ "Event" ]=$event[ "ID" ];
        unset($args[ "Type" ]);
 

        $args[ "Action" ]="Show";
        if (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $args[ "Action" ]="Edit";
            $args[ "ModuleName" ]="Events";
        }
        elseif (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $args[ "Action" ]="Inscription";
            $args[ "ModuleName" ]="Inscriptions";
        }
        
        $args[ "ID" ]=$event[ "ID" ];

        $name=$event[ "Name" ];
        if (!empty($event[ "Initials" ])) { $name=$event[ "Initials" ]; }
        
        return 
            $this->MyApp_Interface_LeftMenu_Bullet("+").
            $this->HtmlTags
            (
               "A",
               $name,
               array
               (
                  "HREF" => "?".$this->Hash2Query($args)."#Top",
                  "TITLE" => $event[ "Name" ],
               )
             );
    }
}
