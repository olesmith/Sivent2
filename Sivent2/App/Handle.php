<?php

class App_Handle extends App_Has
{
    //*
    //* function HandleShowUnits, Parameter list: 
    //*
    //* Displays Units in DB.
    //*

    function HandleShowUnits()
    {
        $this->MyApp_Interface_Head();

        echo
            $this->UnitsObj()->ShowUnits(0);
    }
    
    //*
    //* function HandleStart, Parameter list: 
    //*
    //* Overrides Application::HandleStart.
    //*

    function HandleStart()
    {
        if ($this->GetCGIVarValue("Action")=="Start")
        {
            $this->ResetCookieVars();
        }

        $this->EventsObj()->ItemData();
        $this->EventsObj()->ItemDataGroups();
        $this->EventsObj()->Actions();

        $this->MyApp_Interface_Head();

        if ($this->Profile=="Friend")
        {
            $this->HandleFriend();
        }
        elseif ($this->Profile=="Coordinator")
        {
            $this->HandleCoordinator();
        }
        elseif ($this->Profile=="Public")
        {
            $this->HandlePublic();
        }
        else
        {
            $this->EventsObj()->ShowEvents();
        }
    }

   
    //*
    //* function HandleCoordinator, Parameter list: 
    //*
    //* Handle coord entry.
    //*

    function HandleCoordinator()
    {
        echo
            $this->H(1,$this->MyLanguage_GetMessage("Events_Table_Title")).
            $this->Html_Table
            (
               "",
               $this->EventsObj()->ItemsTableDataGroup
               (
                  "",
                  0,
                  "",
                  $this->GetCoordinatorEvents()
               )
            ).
            "";

        exit();
    }

    //*
    //* function HandleFriend, Parameter list: 
    //*
    //* Handle friend entry
    //*

    function HandleFriend()
    {
        $this->FriendsObj()->Friend_Events_Table();
    }

    //*
    //* function HandlePublic, Parameter list: 
    //*
    //* Handle public action Start·
    //*

    function HandlePublic()
    {
        $this->MyApp_Login_Form();
        
        $this->EventsObj()->ShowEvents();
    }

}
