<?php


include_once("Interface/Head.php");
include_once("Interface/Doc.php");
include_once("Interface/Messages.php");
include_once("Interface/Tail.php");
include_once("Interface/Titles.php");
include_once("Interface/Icons.php");
include_once("Interface/LeftMenu.php");
include_once("Interface/CSS.php");


trait MyApp_Interface
{
    use
        MyApp_Interface_Head,
        MyApp_Interface_Doc,
        MyApp_Interface_Messages,
        MyApp_Interface_Tail,
        MyApp_Interface_Titles,
        MyApp_Interface_Icons,
        MyApp_Interface_LeftMenu,
        MyApp_Interface_CSS;

    //*
    //* function MyApp_Interface_Init, Parameter list: 
    //*
    //* Initializes applicatiion interface.
    //*

    function MyApp_Interface_Init()
    {
        if ($this->HtmlSetupHash[ "CharSet" ]=="")
        {
            $this->HtmlSetupHash[ "CharSet"  ]="utf-8";
        }
        if ($this->HtmlSetupHash[ "WindowTitle" ]=="")
        {
            $this->HtmlSetupHash[ "WindowTitle"  ]="Yes I am a Mother Nature Son...)";
        }
        if ($this->HtmlSetupHash[ "DocTitle" ]=="")
        {
            $this->HtmlSetupHash[ "DocTitle"  ]="Please give me a title (HtmlSetupHash->DocTitle)";
        }
        if ($this->HtmlSetupHash[ "Author" ]=="")
        {
            $this->HtmlSetupHash[ "Author"  ]="Prof. Dr. Ole Peter Smith, IME, UFG, ole'at'mat'dot'ufg'dot'br";
        }

        $this->ApplicationName=$this->HtmlSetupHash[ "ApplicationName"  ];
    }
}

?>