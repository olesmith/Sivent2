<?php

class MyEventAppMenues extends MyEventAppAccess
{
    //*
    //* function  HtmlUnitMenu, Parameter list: 
    //*
    //* Generates Unit menu.
    //*

    function HtmlUnitMenu()
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
                $submenu=array();
                foreach (array("System/Units/LeftMenu.php","../EventApp/System/Units/LeftMenu.php") as $file)
                {
                    if (file_exists($file))
                    {
                        $submenu=$this->ReadPHPArray($file,$submenu);
                        break;
                    }
                }

                array_push
                (
                   $links,
                   "&nbsp;".$this->MyApp_Interface_LeftMenu_Bullet("-").
                   $unit[ "Name" ].
                   $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List($submenu,$unit).
                   join("",$this->HtmlEventsMenu())
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
           array("ID","Name"),
           FALSE,
           "Name"
        );

        $links=array();
        foreach ($events as $event)
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
