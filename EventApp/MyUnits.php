<?php

include_once("MyUnits/Access.php");
include_once("MyUnits/Mails.php");
include_once("MyUnits/MailsTypes.php");

class MyUnits extends MyUnitsMailsTypes
{
    var $MailsPath="../EventApp/System/Units/Emails";
    
    var $MailTypes=array
    (
       "Register",
       "Confirm","Confirm_Resend",
       "Password_Reset",
       //"Password_Changed",
       "Email_Change","Email_Changed",
       "Email_Created",
    );
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function MyUnits($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name");
        $this->Sort=array("Name");
        $this->IDGETVar="Unit";
        $this->UploadFilesHidden=FALSE;
   }

    //*
    //* function MyMod_Setup_ProfilesDataFile, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_ProfilesDataFile()
    {
        return "../EventApp/System/Units/Profiles.php";
    }
    
    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
        array_push($this->ActionPaths,"../EventApp/System/Units");
    }

    //*
    //* function PostActions, Parameter list:
    //*
    //* 
    //*

    function PostActions()
    {
    }
    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
        array_push($this->ItemDataGroupFiles,"Groups.Mail.php");
        array_push($this->ItemDataSGroupFiles,"SGroups.Mail.php");
        array_unshift($this->ItemDataGroupPaths,"../EventApp/System/Units");
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
        $this->AddMails2ItemGroups
        (
           "../EventApp/System/Units/Groups.Mails.php",
           "../EventApp/System/Units/SGroups.Mails.php"
        );
        
        $this->AddMailTypes2ItemGroups
        (
           "../EventApp/System/Units/Emails/Groups.php",
           "../EventApp/System/Units/Emails/SGroups.php"
        );
    }

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_push($this->ItemDataFiles,"Data.Mail.php");
        array_push($this->ItemDataPaths,"../EventApp/System/Units");
    }
    
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->ItemData[ "State" ][ "Values" ]=$this->ApplicationObj->States_Short;
        $this->ItemData[ "State" ][ "Default" ]=9;//GO...

        $this->AddMails2ItemData("../EventApp/System/Units/Data.Mails.php");
        $this->AddMailTypes2ItemData("../EventApp/System/Units/Emails/Data.php");
    }


    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        $this->Actions[ "Show" ][ "HrefArgs" ]=
            preg_replace('/ID=/',"Unit=",$this->Actions[ "Show" ][ "HrefArgs" ]);
        $this->Actions[ "Edit" ][ "HrefArgs" ]=
            preg_replace('/ID=/',"Unit=",$this->Actions[ "Edit" ][ "HrefArgs" ]);
    }

    //*
    //* function MailInfo2Unit, Parameter list: &$item
    //*
    //* Takes undefined keys $this->ApplicationObj()->Unit2MailInfo
    //* in $item, from $this->ApplicationObj()->MailInfo.
    //*

    function MailInfo2Unit(&$item)
    {
        $updatedatas=$this->MyHash_Keys_Take
        (
           $this->ApplicationObj()->MailInfo,
           $this->ApplicationObj()->Unit2MailInfo,
           $item
        );
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }

        return count($updatedatas);
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->CGI_GET("ModuleName");
        if ($module!="Units")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $this->MailInfo2Unit($item);

        return $item;
    }


    //*
    //* function CGI2Unit, Parameter list:
    //*
    //* Reads Unit according to GET Unit value,
    //* reads into $this->ApplicationObj->Unit.
    //*

    function CGI2Unit()
    {
        $unit=$this->GetGET("Unit");
        if (empty($unit) || !preg_match('/^\d+$/',$unit))
        {
            die("Invalid unit: ".$unit);
        }

        $this->ApplicationObj->Unit=$this->SelectUniqueHash
        (
           "",
           array("ID" => $unit)
        );
    }

    //*
    //* function NoOfAnnouncements, Parameter list: $unit=array()
    //*
    //* Returns No of announcements at $unit. Empty $unit returns title.
    //*

    function NoOfAnnouncements($unit=array())
    {
        if (empty($unit)) { return "Editais"; }

        return $this->FormatInt
        (
           $this->AnnouncementsObj()->MySqlNEntries
           (
              "",
              array("Unit" => $unit[ "ID" ])
           )
        );
    }
    //*
    //* function NoOfOpenAnnouncements, Parameter list: $unit=array()
    //*
    //* Returns No of announcements at $unit. Empty $unit returns title.
    //*

    function NoOfOpenAnnouncements($unit=array())
    {
        if (empty($unit)) { return "Editais em Aberta"; }

        $today=$this-> TimeStamp2DateSort();

        return $this->FormatInt
        (
           $this->AnnouncementsObj()->MySqlNEntries
           (
              "",
              "Unit='".$unit[ "ID" ]."'".
              " AND ".
              "InscriptionStart<='".$today."'".
              " AND ".
              "InscriptionEnd>='".$today."'"
           )
        );
    }

    //*
    //* function NoOfVacancies, Parameter list: $unit=array(),$edit=0
    //*
    //* Returns no of vacancies avaliable for $unitid. Empty $unit returns title.
    //*

    function NoOfVacancies($unit=array(),$edit=0)
    {
        if (empty($unit)) { return "Vagas Remuneradas"; }

        $data="Vacancies";

        return $this->FormatInt
        (
            $this->Name
            (
               $unit[ "ID" ],
               "Vacancies"
            )
        );
    }
 
    //*
    //* function NoOfMonitors, Parameter list: $unit=array()
    //*
    //* Returns no of monitors allocated by unit. Empty $unit returns title.
    //*

    function NoOfMonitors($unit=array())
    {
        if (empty($unit)) { return "Monitores"; }

        return $this->FormatInt
        (
           $this->MonitorsObj()->MySqlNEntries
           (
              "",
              array
              (
                 "Unit"          => $unit[ "ID" ],
                 "__Inscription" => "Inscription>'0'",
                 "Status"        => 1,
                 //"Accept"        => 1,
              )
           )
        );
    }

     //*
    //* function NoOfVolunteers, Parameter list: $unit=array()
    //*
    //* Returns no of voluntarios allocated by $unitid. Empty $unit returns title.
    //*

    function NoOfScholarships($unit=array())
    {
        if (empty($unit)) { return "Bolsas"; }

        return $this->FormatInt
        (
         $this->MonitorsObj()->MySqlNEntries
           (
              "",
              array
              (
                 "Unit" => $unit[ "ID" ],
                 "Type" => 1,
              )
           )
        );
    }
     //*
    //* function NoOfVolunteers, Parameter list: $unit=array()
    //*
    //* Returns no of voluntarios allocated by $unitid. Empty $unit returns title.
    //*

    function NoOfVolunteers($unit=array())
    {
        if (empty($unit)) { return "Voluntários"; }

        return $this->FormatInt
        (
           $this->MonitorsObj()->MySqlNEntries
           (
              "",
              array
              (
                 "Unit" => $unit[ "ID" ],
                 "Type" => 2,
              )
           )
        );
    }
 
   //*
    //* function ShowUnits, Parameter list: $edit
    //*
    //* Lists active units.
    //*

    function ShowUnits($edit)
    {
        return 
            $this->H
            (
               3,
               "Entidades, ".
               $this->GetRealNameKey($this->ApplicationObj()->HtmlSetupHash,"ApplicationName")
            ).
            $this->Html_Table
            (
                "",
                $this->ItemsTableDataGroup("",$edit,"Basic")
             );
    }

    //*
    //* function HandleAnnouncements, Parameter list:
    //*
    //* Listas announcements for unit read.
    //*

    function HandleAnnouncements()
    {
        echo
            $this->AnnouncementsObj()->HandleAnnouncements
            (
               array(),
               $this->Unit("ID")
            );
    }


    //*
    //* function HandleLocations, Parameter list:
    //*
    //* Lists locations for unit read.
    //*

    function HandleLocations()
    {
        echo
            $this->LocationsObj()->UnitLocationsHtmlTable($this->ApplicationObj->Unit);
    }

    //*
    //* function HandleDisciplines, Parameter list:
    //*
    //* Lists disciplines for unit read.
    //*

    function HandleDisciplines()
    {
        echo
            $this->DisciplinesObj()->UnitDisciplinesHtmlTable($this->ApplicationObj->Unit);
    }

    //*
    //* function HandleMonitors, Parameter list:
    //*
    //* Lists monitors for unit read.
    //*

    function HandleMonitors()
    {
        echo
            $this->MonitorsObj()->UnitMonitorsHtmlTable($this->ApplicationObj->Unit);
    }

    //*
    //* function HandleEditUnit, Parameter list: $item
    //*
    //* Handles unit edit for coordinator.
    //*

    function HandleEditUnit()
    {
        if ($this->ApplicationObj->Profile=="Coordinator")
        {
            $unitid=$this->ApplicationObj->LoginData[ "Unit" ];
            $this->ItemHash=$this->SelectUniqueHash
            (
               "",
               array("ID" => $unitid)
            );
        }

        if ($this->CheckEditAccess($this->ItemHash))
        {
            $this->HandleEdit();
        }
        else { die("No access!"); }
    }

    //*
    //* function Name, Parameter list: $id,$key=""
    //*
    //* Creates properly formatted Announcement name.
    //*

    function Name($id,$key="Name")
    {
        if (is_array($id)) { $id=$id[ "ID" ]; }

        return $this->MySqlItemValue("","ID",$id,$key);
    }

    //*
    //* function VacanciesGranted, Parameter list: $unitid=0
    //*
    //* Returns noof vacancies avaliable for $unitid.
    //*

    function VacanciesGranted($unitid=0)
    {
        if (empty($unitid)) { return "Vagas"; }
        return 
            $this->Name
            (
               $unitid,
               "Vacancies"
            );
    }

    //*
    //* function VacanciesDistributed, Parameter list: $unitid=0
    //*
    //* Returns noof vacancies distributed for $unitid.
    //* We only count Type => 1 distributions (remunerado).
    //*

    function VacanciesDistributed($unitid=0)
    {
        if (empty($unitid)) { return "Vagas Distribuídas"; }
        return 
            $this->InscriptionsObj()->MySqlNEntries
            (
               "",
               array
               (
                  "Unit"      => $unitid,
                  "Selection" => 2,
                  "Type"     => 1,
               )
            );
    }

    //*
    //* function NoofDisciplines, Parameter list: $unitid=0
    //*
    //* Returns noof disciplines  for $unitid.
    //*

    function NoofDisciplines($unitid=0)
    {
        if (empty($unitid)) { return "Disciplinas"; }
        return 
            $this->DisciplinesObj()->MySqlNEntries
            (
               "",
               array
               (
                  "Unit"      => $unitid,
               )
            );
    }

    //*
    //* function VacanciesAvaliable, Parameter list: $unitid=0
    //*
    //* Returns noof vacancies avaliable for distribution for $unitid.
    //*

    function VacanciesAvaliable($unitid=0)
    {
        if (empty($unitid)) { return "Vagas Disp."; }
        return 
            $this->VacanciesGranted($unitid)
            -
            $this->VacanciesDistributed($unitid);
    }

    //*
    //* function VacanciesInfo, Parameter list: $unitid
    //*
    //* Returns Vacancies info for $unitid.
    //*

    function VacanciesInfo($unitid)
    {
        $pname=$this->PeriodsObj()->Name($this->Period("ID"));

        $granted=$this->VacanciesGranted($unitid);
        $distributed=$this->VacanciesDistributed($unitid);

        $disp=$granted-$distributed;

        $info="";
        if (!empty($unitid))
        {
            $info=$this->H
            (
               4,
               $this->Name($unitid,"Name").
               ", Vagas: ".
               $granted." Disponibilizadas, ".
               $distributed." Distribuidos, ". 
               $disp." Disponíveis."
            );
        }

        return $info;
    }


    //*
    //* function CoordinatorSelect, Parameter list: $data,$item,$edit
    //*
    //* Creates  select field. If Unit is set, restrict to unit city.
    //*

    function CoordinatorSelect($data,$item,$edit)
    {
        return $this->ApplicationObj->CoordinatorSelect($data,$item,$edit);
    }

    //*
    //* function CampusSelect, Parameter list: $data,$unit,$edit,$rdata=""
    //*
    //* Creates campus select field. If Unit is set, restrict to unit city.
    //*

    function CampusSelect($data,$unit,$edit,$rdata="")
    {
        $cell="";
        if (!empty($unit[ "ID" ]))
        {
            $cell=$this->CampiiObj()->MakeSelectFieldWithWhere
            (
               $edit,
               $data,
               array(),
               array("ID","Title","Name"),
               "#Name - #Title",
               "Name",
               $unit,
               $rdata
            );
        }

        return $cell;
    }

}

?>