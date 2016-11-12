<?php

class MyEventApp_Menues_Friend extends MyEventApp_Menues_Event
{
    //*
    //* function  HtmlFriendMenuFile, Parameter list: 
    //*
    //* Returns friend menu def file name.
    //*

    function HtmlFriendMenuFile()
    {
        return "System/Friends/LeftMenu.php";
    }
    //*
    //* function  HtmlFriendMenuDef, Parameter list: 
    //*
    //* Returns friend menu def as read from system file. May be overridden.
    //*

    function HtmlFriendMenuDef()
    {
        return $this->ReadPHPArray($this->HtmlFriendMenuFile());
    }
    
    //*
    //* function  HtmlFriendMenu, Parameter list: $event,$friend
    //*
    //* Prints menu of $friend.
    //*

    function HtmlFriendEventMenu($event,$friend)
    {
        if (preg_match('/^Public$/',$this->Profile())) { return ""; }
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        $menufile=$this->HtmlFriendMenuFile();
        if (!file_exists($menufile)) { return ""; }
        
        return
            "&nbsp;".$this->MyApp_Interface_LeftMenu_Bullet("-").
            $this->InscriptionsObj()->MyMod_ItemName().
            $this->MyApp_Interface_LeftMenu_Generate_SubMenu_List
            (
                $this->HtmlFriendMenuDef(),
                $friend
            ).
            "";
    }
}
