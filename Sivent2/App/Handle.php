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
        
        exit();
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
        $this->MyApp_Login_Form();

        $this->EventsObj()->ShowEvents();
    }

}
