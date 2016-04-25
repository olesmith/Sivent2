<?php

include_once("../Accessor.php");


include_once("../EventApp/EventApp.php");

include_once("App/Handle.php");


//For modules.


class Sivent2 extends AppHandle
{
    var $IDGETVar="";
    var $Pertains=1; //Questionary: 1, 
    var $PertainsSetup=array
    (
       1 => array
       (
          "Title" => "Questinário",
          "Title_UK" => "Questionary",
          
          "Object_Accessor" => "InscriptionsObj",
          
          "Data_Action" => "Datas",
          "Data_Form_Title" => "Dados dos Questionários",
          "Data_Form_Title_UK" => "Questionary Data",
          
          "Group_Action" => "GroupDatas",
          "Groups_Form_Title" => "Grupos dos Questionários",
          "Groups_Form_Title_UK" => "Questionary Data Groups",
          
          "Table_Method" => "ShowInscriptionQuest",
       ),
    );

    
    var $AppProfiles=array
    (
       //Order in Profiles menu
       "Sivent2" => array
       (
          "Public",
          "Coordinator",
          "Friend",
          "Admin",
       ),
    );
    
    var $UserProfiles=array
    (
       "Friend",
    );

    var $MyApp_Latex_Filters=array
    (
       "Unit"  => "Unit",
       "Event" => "Event",
    );

    //*
    //* function Sivent2, Parameter list: $args=array()
    //*
    //* Sivent2 constructor, main object.
    //*

    function Sivent2($args=array())
    {
        $unit=$this->GetGETint("Unit");

        $args[ "SessionsTable" ]=$unit."__Sessions";
        $args[ "SavePath" ]="?Unit=".$unit."&Action=Start";
        
        parent::Application($args);
   }
    
    //*
    //* function MyApp_Interface_LeftMenu, Parameter list:
    //*
    //* Overrides parent, calling it and adding sponsor table.
    //*

    function MyApp_Interface_LeftMenu()
    {
        $this->SponsorsObj()->Sql_Table_Structure_Update();
        
        return
            parent::MyApp_Interface_LeftMenu().
            $this->SponsorsObj()->ShowSponsors(1).
            "";
    }

        //*
    //* function MyApp_Interface_Tail_Center(), Parameter list:
    //*
    //* Overrides parent, calling it and adding sponsor table.
    //*

    function MyApp_Interface_Tail_Center()
    {
       return
            $this->SponsorsObj()->ShowSponsors(2).
            parent::MyApp_Interface_Tail_Center().
            "";
    }
    
    //*
    //* sub MyApp_Interface_Status, Parameter list: 
    //*
    //* Overrides parent, calling it and adding sponsor table.
    //*

    function MyApp_Interface_Messages_Status()
    {
        return
            parent::MyApp_Interface_Messages_Status().
            $this->SponsorsObj()->ShowSponsors(3).
            "";
     }
    
     //*
    //* function MyApp_Init, Parameter list: 
    //*
    //* Overrided function. Calls parent, then checks for event access.
    //*

    function MyApp_Login_SetData($logindata)
    {
        parent::MyApp_Login_SetData($logindata);
        $this->CheckEventAccess();
     }

    
}

$application=new Sivent2
(
   array
   (
      "AppName" => "SiVent2",
      "PublicAllow" => TRUE,
      "SessionsTable" => "Sessions",
      "MayCreateSessionTable" => TRUE,

      "Mail" => TRUE,
      "Logging" => TRUE,
      "Authentication" => TRUE,
      "DB" => TRUE,

      "ActionPaths" => array("System"),
      "ActionFiles" => array("Actions.php"),
      
      "MessageDirs" => array
      (
         "../Common",
         "../MySql2",
         "../Application",
         "../EventApp/System",
         "System",
      ),
      "MessageFiles" => array
      (
         "../Common/Messages/MyTime.php",
      ),

      "AppLoadModules" => array
      (
         "Units",
      ),

      "LogGETVars" => array
      (
         "Unit"
      ),

      "LogPOSTVars" => array
      (
         "Edit","EditList","Save","Update","Generate","Transfer",
      ),

      "ValidProfiles" => array
      (
          "Public",
          "Coordinator",
          "Friend",
          "Admin",
      ),
      "CGIVars" => "Sivent2_CGIVars_Get",
   )
);

$application->MyApp_Run(array());

?>