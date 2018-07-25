<?php

class App_Handle extends App_Has
{
    //*
    //* function MyApp_Handle_Start, Parameter list: $echo=TRUE
    //*
    //* Overrides Application::MyApp_Handle_Start.
    //*

    function MyApp_Handle_Start($echo=TRUE)
    {
        if ($this->GetCGIVarValue("Action")=="Start")
        {
            $this->ResetCookieVars();
        }

        $this->EventsObj()->ItemData();
        $this->EventsObj()->ItemDataGroups();
        $this->EventsObj()->Actions();

        $profile=$this->Profile();
        if (preg_match('/^(Friend)$/',$profile))
        {
            $this->HandleFriend();
        }
        elseif (preg_match('/^(Coordinator|Admin)$/',$profile))
        {
            $this->HandleCoordinator();
        }
        elseif (preg_match('/^(Public)$/',$profile))
        {
            $this->HandlePublic();
        }
        else
        {
            $this->EventsObj()->ShowEvents();
        }
        
        exit();
    }

   
    //*
    //* function HandleCoordinator, Parameter list: 
    //*
    //* Handle coord entry.
    //*

    function HandleCoordinator()
    {
        $event=$this->Event("ID");
        if (!empty($event))
        {
            $args=$this->CGI_URI2Hash();
            $args[ "ModuleName" ]="Events";
            $args[ "Action" ]="Config";
            $this->CGI_Redirect($args);
            exit();
        }
        
        $this->MyApp_Interface_Head();

        echo
            $this->H(1,$this->MyLanguage_GetMessage("Events_Table_Title")).
            $this->EventsObj()->MyMod_Items_Group_Table_Html
            (
               0,
               $this->GetCoordinatorEvents()
            ).
            "";
    }

    //*
    //* function HandleFriend, Parameter list: 
    //*
    //* Handle friend entry
    //*

    function HandleFriend()
    {
        $event=$this->Event("ID");
        if (!empty($event))
        {
            $args=$this->CGI_URI2Hash();
            $args[ "ModuleName" ]="Inscriptions";
            $args[ "Action" ]="Inscribe";
            $this->CGI_Redirect($args);
            exit();
        }
        
        $this->MyApp_Interface_Head();

        $this->FriendsObj()->Sql_Table_Structure_Update();
        $this->CertificatesObj()->Sql_Table_Structure_Update();
        $friend=$this->LoginData();
        
        $event=$this->Event();
        if (!empty($event))
        {
            if ($this->Friend_Inscribed_Is($event,$friend))
            {
                $this->InscriptionsObj()->HandleInscribe();
                exit();
            }
            else
            {
                $this->InscriptionsObj()->HandleInscribe();
                exit();
            }
        }
        
        $this->FriendsObj()->Friend_Events_Handle($friend);
    }

    //*
    //* function HandlePublic, Parameter list: 
    //*
    //* Handle public action Start·
    //*

    function HandlePublic()
    {
        $this->MyApp_Interface_Head();

        $this->MyApp_Login_Form();

        $this->EventsObj()->ShowEvents();
    }

}
