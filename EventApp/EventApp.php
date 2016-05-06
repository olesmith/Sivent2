<?php

include_once("../Accessor.php");

Accessor_Create
(
   array
   (
      "Unit" => array
      (
         "Type" => "Hash",
      ),
      "Event" => array
      (
         "Type" => "Hash",
      ),
      "Events" => array
      (
         "Type" => "HashList",
      ),
   )
);

include_once("../MySql2/UniqueCols.php");
include_once("../Application/DBDataObj.php");
include_once("Modules/Common.php");
include_once("../Application/Application.php");

include_once("MyApp/CGIVars.php");
include_once("MyApp/Accessors.php");
include_once("MyApp/Access.php");
include_once("MyApp/Menues.php");


class EventApp extends MyEventAppMenues
{
    use _accessor_;

    var $EventGroup="Inscriptions";
    
    var $Unit2MailInfo=array
    (
       "Auth","Secure","Port","Host","User","Password",
       "FromEmail","FromName","ReplyTo","BCCEmail",
    );
    
    var $Event2MailInfo=array
    (
       "Auth","Secure","Port","Host","User","Password",
       "FromEmail","FromName","ReplyTo","BCCEmail",
    );
    
    var $Pertains=1; //Questionary: 1, Asssessment: 2
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
       )
    );

    
    var $Sigma="&Sigma;";
    var $Mu="&mu;";
    var $Percent="%";

    var $SqlVars=array();

    var $UserProfiles=array
    (
       "Friends"
    );
    var $AppProfiles=array
    (
       //Order in Profiles menu
       "SiPos" => array
       (
          "Public",
          "Coordinator",
          "Friend",
          "Admin",
       ),
    );

    var $Sponsors=FALSE;

    
    var $Event=array();
    var $Unit=array();
    var $Units=array();
    //var $UnitsObject=NULL;

    var $PreTextMethod="";

    //*
    //* function EventApp, Parameter list: $args=array()
    //*
    //* EventApp constructor, main object.
    //*

    function EventApp($args=array())
    {
        $unit=$this->GetGETint("Unit");

        $args[ "SessionsTable" ]=$unit."__Sessions";
        $args[ "SavePath" ]="?Unit=".$unit."&Action=Start";

        parent::Application($args);
    }

    //*
    //* function PreInitSession, Parameter list: $hash=array()
    //*
    //* Called by session initializer.
    //*

    function PreInitSession($hash=array())
    {
    }

    //*
    //* function PreInterfaceMenu, Parameter list: 
    //*
    //* Called by modules TInterface menu (via ApplicationObj), before printing anything.
    //* Displays App and Unit info.
    //*

    function PreInterfaceMenu()
    {
        echo
            $this->AppInfo();
    }
    
    //*
    //* sub MyApp_Titles, Parameter list:
    //*
    //* Returns titles to use in interface top center cell, when no unit specified.
    //*
    //*

    function MyApp_Titles()
    {
        return array
        (
           $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationName"),
           $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationTitle").
           ", Ver. ".
           $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationVersion"),
           $this->A
           (
              $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationURL"),
              $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationURL"),
              array
              (
                 "CLASS" => 'applicationlink',
              )
           )
        );
    }
    
    //*
    //* sub MyApp_Interface_Icon_Get, Parameter list: $n
    //* 
    //* Returns left ($n=1) resp. right ($n=2) icons. 
    //*

    function MyApp_Interface_Icon_Get($n)
    {
        $unit=$this->Unit();
        if (!empty($unit))
        {
            $args=array
            (
               "ModuleName" => "Units",
               "Action" => "Download",
               "Unit" => $unit[ "ID" ],
               "Data" => "HtmlIcon".$n,
            );
            $icon="?".$this->CGI_Hash2URI($args);

            return $icon;    
        }
        
        return parent::MyApp_Interface_Icon_Get($n);
    }
    
    //*
    //* sub MyApp_Interface_Titles, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Interface_Titles()
    {
        $this->UnitsObj()->Sql_Table_Structure_Update();
        $unit=$this->Unit();
        if (empty($unit))
        {
            return $this->MyApp_Titles();
        }

        return array
        (
           $unit[ "Name" ],
           $unit[ "Title" ],
           $unit[ "Address" ],
           
           $unit[ "Area" ].", ".
           $unit[ "City" ]."-".
           $this->UnitsObj()->MyMod_Data_Fields_Show("State",$unit).
           ", CEP: ".
           $unit[ "ZIP" ],
           
           $unit[ "Url" ]." - ".
           $unit[ "Phone" ]." - ".
           $unit[ "Email" ],
        );
    }
   

    //*
    //* sub DetectEventGET, Parameter list:
    //*
    //* Reads Event - if possible.
    //*
    //*

    function DetectEventGET()
    {
       if (isset($_GET[ "Event" ]))
        {
            return "Event";
        }
        elseif (
                  isset($_GET[ "ModuleName" ])
                  && 
                  $_GET[ "ModuleName" ]=="Events"
                  && 
                  isset($_GET[ "ID" ])
               )
        {
            return "ID";
        }

        return "";
    }

    
    //*
    //* sub InitTInterfaceTitles, Parameter list:
    //*
    //* Overrides Application::InitTInterfaceTitles.
    //*
    //*

    function InitTInterfaceTitles()
    {
        parent::InitTInterfaceTitles();
        array_splice($this->TInterfaceTitles,1,0,$this->CompanyHash[ "Title" ]);
    }

    //*
    //* function InitApplication, Parameter list: 
    //*
    //* Application initializer.
    //*

    function InitApplication()
    {
        $this->Layout=array
        (
           "Font"      => "",
           "White"     => "#FFFFFF",
           "Black"     => "#000000",
           "Light"     => "#555555",//"#dcf7fa",
           "LightDark" => "#90a1a3",
           "DarkLight" => "#90a1a3",
           "Dark"      => "#464e4f",

           "Light"     => "#33ccff",
           "Dark"      => "#3333ff",
           "DarkLight" => "#3333ff",
           "LightDark" => "#3399ff",

           "Blue"       => "#33ccff",
           "DarkBlue"   => "#3366ff",
           "LightBlue"  => "#CEECF5",

           "LightGrey" => "#F2F2F2",
           "Grey"      => "#CCCCCC",
           "DarkGrey"  => "#333333",//848484",

           "Yellow"     => "#F5BCA9",
           "Orange"     => "#FAEBD7",
           "Red"     => "#FF6347 ",
        );

        parent::InitApplication();
    }

    //*
    //* function AppInfo, Parameter list: 
    //*
    //* Creates application info table: Unit and Event, if defined.
    //*

    function AppInfo()
    {
        $table=$this->UnitsObj()->MyMod_Item_Table
        (
           0,
           $this->Unit(),
           array(array("Title","Url","Email"))
        );

        array_unshift
        (
           $table,
           array($this->H(3,$this->Unit("Title")))
        );

        $event=$this->Event();
        if (!empty($event))
        {
            $table=array_merge
            (
               $table,
               array($this->H(3,$this->GetRealNameKey($event,"Title"))),
               $this->EventsObj()->MyMod_Item_Table
               (
                  0,
                  $event,
                  array
                  (
                     array
                     (
                        "Name","Date","Announcement"
                     ),
                     array
                     (
                        "StartDate","EndDate","EditDate",
                     )
                  )
               )
            );            
        }

        return 
            $this->FrameIt
            (
                $this->H(1,$this->HtmlSetupHash[ "ApplicationName" ]).
                $this->Html_Table
                (
                   "",
                   $table
                ).
                ""
            ).
            $this->BR();
    }

    //*
    //* function HandleFriend, Parameter list: 
    //*
    //* Friend handler, listing open inscriptions and history.
    //*

    function HandleFriend()
    {
        $this->InscriptionsObj()->Actions();
        
        echo
            $this->H(1,$this->EventsObj()->MyMod_Language_Message("Events_Handle_Candidate_Title")).
            $this->EventsObj()->OpenEventsHtmlTable().
            $this->EventsObj()->FriendEventsHtmlTable($this->LoginData());
        
        exit();
    }

     //*
    //* function MailInfo, Parameter list: 
    //*
    //* Returns mail info, that is, content of $this->MailInfo.
    //* Supposed to be overwritten by and ApplicationObj.
    //*

    function MailInfo()
    {
        $mailinfo=parent::MailInfo();
        $unit=$this->Unit();
        if (!empty($unit))
        {
            foreach ($this->Unit2MailInfo as $key)
            {
                if (
                      !empty($unit[ $key ])
                      &&
                      $mailinfo[ $key ]!=$unit[ $key ]
                   )
                {
                    $mailinfo[ $key ]=$unit[ $key ];
                }
            }

            $event=$this->Event();
            if (!empty($event))
            {
                foreach ($this->Event2MailInfo as $key)
                {
                    if (
                          !empty($event[ $key ])
                          &&
                          $mailinfo[ $key ]!=$event[ $key ]
                       )
                    {
                        $mailinfo[ $key ]=$event[ $key ];
                    }
                }
            }
        }

        return $mailinfo;
    }

    //*
    //* function ApplicationWindowTitle, Parameter list: 
    //*
    //* Overrides title maker, including Unit title.
    //*

    function ApplicationWindowTitle()
    {
        return
            $this->Unit("Name").
            "::".
            parent::ApplicationWindowTitle().
            "";
            
    }

}

?>