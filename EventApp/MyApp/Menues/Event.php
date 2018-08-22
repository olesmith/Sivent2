<?php

class MyEventApp_Menues_Event extends MyEventApp_Menues_Unit
{
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
    //* function  HtmlEventsSubMenu, Parameter list: $event
    //*
    //* Prints submenu menu for $event.
    //*

    function HtmlEventsSubMenu($event)
    {
        $name=$event[ "Name" ];
        if (!empty($event[ "Initials" ])) { $name=$event[ "Initials" ]; }

        return
            array
            (
                // $this->MyApp_Interface_LeftMenu_Bullet("-").
                $name,
                $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
                (
                    $this->HtmlEventsMenuDef(),
                    $event
                ),
                $this->HtmlFriendEventMenu($event,$this->LoginData())
            ); 
    }
    
    //*
    //* function  HtmlEventsMenu, Parameter list: 
    //*
    //* Prints menu of Events.
    //*

    function HtmlEventsMenu()
    {
        $args=$this->CGI_Script_Query_Hash();
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
               $link=$this->HtmlEventMenu($event,$args);
            }
            else
            {
                $name=$event[ "Name" ];
                if (!empty($event[ "Initials" ])) { $name=$event[ "Initials" ]; }
                
                $link=$this->HtmlEventsSubMenu($event);
            }
            
            array_push
            (
                $links,
                $link
            );
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
            $args[ "Action" ]="Config";
            $args[ "ModuleName" ]="Events";
        }
        elseif (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $args[ "ModuleName" ]="Inscriptions";
            if ($this->Friend_Inscribed_Is($this->LoginData()))
            {
                $args[ "Action" ]="Inscription";
                $args[ "ModuleName" ]="Inscriptions";
            }
            else
            {
                $args[ "Action" ]="Inscribe";
                $args[ "ModuleName" ]="Inscriptions";
            }
        }

        $name=$event[ "Name" ];
        if (!empty($event[ "Initials" ])) { $name=$event[ "Initials" ]; }

        return
            array_merge
            (
                array
                (
                    // $this->MyApp_Interface_LeftMenu_Bullet("+"),
                ),
                $this->Htmls_HRef
                (
                    "?".$this->CGI_Hash2Query($args),
                    $name,
                    $event[ "Name" ],
                    'leftmenulinks'
                )
            );
    }
}
