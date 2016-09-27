<?php

include_once("../Base/CGI.php");
include_once("Profile.php");
include_once("Actions.php");
include_once("MySql.php");
include_once("Access.php");
include_once("DataPrint.php");
include_once("Data.php");
include_once("HashesData.php");
include_once("DataSGroups.php");
include_once("DataGroups.php");
include_once("Enums.php");
include_once("SubItems.php");
include_once("Fields.php");
include_once("Item.php");
include_once("Items.php");
include_once("Search.php");
include_once("Sort.php");
include_once("Import.php");
include_once("Export.php");
include_once("Menues.php");
include_once("Handle.php");
include_once("Language.php");

include_once("../Common/MyApp.php");


class Table extends TableLanguage
{
    use MyMod;

    //*
    //* Variables of Table class:

    var $Handle=FALSE;
    var $ApplicationObj=NULL;
    var $ReadOnly=FALSE;
    var $SubModules=array();
    var $ModuleLevel=0;
    var $SetupData=array();
    var $GlobalData=array();
    var $Action="Search";
    var $NoHandle=0;
    var $NoRedirect=0;
    var $ListMessage=NULL;
    var $PreTextMethod=NULL;
    var $Level=0;
    var $LoginID=0;
    var $SplitVars=array();
    //var $HtmlStatusMessages=array();
    var $HtmlStatus=array();
    var $DefaultAction="Search";
    var $AddSearchVarsToDataList=FALSE;

    
    var $IDGETVar=FALSE;
    var $IDWhereVar="ID";

    var $NAdded=0;
    var $NUpdated=0;

    //*
    //* function Table, Parameter list: 
    //*
    //* Table constructor.
    //*

    function Table($hash=array())
    {
        $this->InitBase($hash);
    }


    //*
    //* function AddOrUpdate, Parameter list: $table,$where,&$item,$namekey="ID",$readdatas=array()
    //*
    //* Test whether $item should be added or updated:
    //* If $this->SelectUniqueHash() returns an empty set, adds -
    //* Otherwise updates.
    //* 

    function AddOrUpdate($table,$where,&$item,$namekey="ID",$readdatas=array())
    {
        $res=parent::AddOrUpdate($table,$where,$item,$namekey,$readdatas);

        if ($res==1)
        {
            $msg="Added Item: ".$item[ $namekey ]." to ".$this->SqlTableName($table);
            $this->NAdded++;
        }
        elseif ($res==2)
        {
            $msg="Updated Item: ".$item[ $namekey ]." in ".$this->SqlTableName($table);
            $this->NUpdated++;
        }
        else
        {
            $msg="ERROR Item: ".$item[ $namekey ]." in ".$this->SqlTableName($table);
        }

        return $msg;

    }

    //*
    //* function FilterItemNames, Parameter list: $value
    //*
    //* Filters
    //* over #ItemName and #ItemsName
    //*

    function FilterItemNames($value)
    {
        foreach (array_reverse($this->LanguageKeys()) as $lang)
        {
            foreach (array("ItemName","ItemsName") as $key)
            {
                $acc=$key.$lang;
                if (!is_array($value))
                {
                    if (property_exists ($this,$acc))
                    {
                        $value=preg_replace('/#'.$acc.'/',$this->$acc,$value);
                    }
                }
            }
        }
        
        return $value;
    }

    //*
    //* function GetRealNameKey, Parameter list: $hash,$key="Name"
    //*
    //* Calls base method of same name, and filters
    //* over #ItemName and #ItemsName
    //*

    function GetRealNameKey($hash,$key="Name")
    {
        $value=parent::GetRealNameKey($hash,$key);
        
        return $this->FilterItemNames($value);
    }

    //*
    //* function ApplicationWindowTitle, Parameter list: 
    //*
    //* Returns module specific part of the application window title. 
    //* Supposed to be overwritten!
    //*

    function ApplicationWindowTitle()
    {
        $title=$this->ItemsName;
        if (!empty($this->Action) && !empty($this->Actions[ $this->Action ]))
        {
            $title.=" ".$this->Actions[ $this->Action ][ "Name" ];
        }

        return $title."-&gt;";
    }


    //*
    //* function VerifyPRN, Parameter list: $item
    //*
    //* Verifies brasilian PRN, rejects if invalid. Used as TriggerFunction for PRN.
    //*

    function VerifyPRN($item,$data,$newvalue)
    {
        $prn=preg_replace('/[\.-]/',"",$newvalue);

        $regexs=array();
        for ($n=1;$n<=9;$n++)
        {
            $regex="";
            for ($m=1;$m<=11;$m++) { $regex.=$n; }

            array_push($regexs,$regex);
        }

        if (
              strlen($prn)!=11
              ||
              preg_match('/('.join("|",$regexs).')/',$prn)
           )
        {
            echo $this->H(4,"CPF: '".$prn."' inválido: 11 Dígitos!!");
            return $item;
        }
        else
        { 
            if (!$this->TestPRN($prn))
            {
           
                echo $this->H(4,"CPF: '".$prn."' inválido!");

                return $item;
            }

            $item[ "PRN" ]=$prn;
            return $item;
        }
    }


    //*
    //* function StartForm, Parameter list: $action="",$method="post",$enctype=0,$options=array(),$suppresscgis=array()
    //*
    //* Starts form with ModuleName GET variable set.
    //*

    function StartForm($href="",$method="post",$enctype=0,$options=array(),$suppresscgis=array())
    {
        $matches=preg_split('/\?/',$href);
        $script="";
        $argstring="";

        if (isset($matches[0])) { $script=$matches[0]; }
        if (isset($matches[1])) { $argstring=$matches[1]; }

        $rargs=array();
        $rargs[ "ModuleName" ]=$this->ModuleName;

        $args=$this->Query2Hash($argstring,$rargs);

        if (!empty($href) && !preg_match('/\?/',$href))
        {            
            $args[ "Action" ]=$href;
        }
        
        return parent::StartForm("?".$this->Hash2Query($args),$method,$enctype,$options,$suppresscgis);
    }

    //*
    //* function Href, Parameter list: $href,$name="",$title="",$target="",$class="",$noqueryargs=0,$options=array(),$anchor=""
    //*
    //* Creates HREF with ModuleName GET variable set.
    //*

    function Href($href,$name="",$title="",$target="",$class="",$noqueryargs=0,$options=array(),$anchor="")
    {
        $matches=preg_split('/\?/',$href);
        $script="";
        $argstring="";
        if (count($matches)>0) { $script=$matches[0]; }
        if (count($matches)>1) { $argstring=$matches[1]; }

        $rargs=array();
        //$rargs[ "ModuleName" ]=$this->ModuleName;
        $args=$this->Query2Hash($argstring,$rargs);

        return parent::Href
        (
           $script."?".$this->Hash2Query($args),
           $name,$title,$target,$class,$noqueryargs,$options,$anchor
        );
    }


    //*
    //* function InitTable, Parameter list: $hash=array()
    //*
    //* Table initiailizer. Pt. does nothing.
    //*

    function InitTable($hash=array())
    {
    }

    //*
    //* function InitializeSetup, Parameter list: $module="",$file="Setup.php",$path="Setup",$globalfile="Globals.php",$globalpath=""
    //*
    //* Initializes setup. Reads SetupData, GlobalData, Item Data and Item Groups.
    //* Finally, initializes Modules.
    //*

    function InitializeSetup($module="",$file="Setup.php",$path="Setup",$globalfile="Globals.php",$globalpath="")
    {
        if ($globalpath=="") { $globalpath=$path; }

        $this->ReadSetupData($module,$file,$path);
        $this->ReadGlobalData($globalfile,$globalpath);
        $this->ReadItemDatasAndGroups($module);
        $this->InitModules($module);
    }

    //*
    //* function ReadSetupData, Parameter list: $module="",$file="Setup.php",$path="Setup"
    //*
    //* Reads setup data from $path/$file, then calls InitBase on this->SetupData[ "Vars" ]
    //* and $this->SetupData[ "Vars_".$module ].
    //*

    function ReadSetupData($module="",$file="Setup.php",$path="Setup")
    {
        $rfile=$path."/".$file;
        $this->SetupData=$this->ReadPHPArray($rfile);;
        $this->InitBase($this->SetupData[ "Vars" ]);
        $this->InitBase($this->SetupData[ "Vars_".$module ]);
    }


    //*
    //* function ReadGlobalData, Parameter list: $file="Globals.php",$path="Setup"
    //*
    //* Reads globals data from $path."/".$file, and then InitBase on $this->GlobalData.
    //*

   function ReadGlobalData($file="Globals.php",$path="Setup")
    {
        $rfile=$path."/".$file;
        $this->GlobalData=$this->ReadPHPArray($rfile);
        $this->InitBase($this->GlobalData);
    }

    //*
    //* function ReadItemDatasAndGroups, Parameter list: $module=""
    //*
    //* Reads Item Data, Groups and SGroups
    //*

    function ReadItemDatasAndGroups($module="")
    {
        if ($module=="") { $module=$this->ModuleName; }

         if (is_file($module."/Datas.php"))
        {
            $this->ItemData=$this->ReadPHPArray($module."/Datas.php",$this->ItemData);
        }

        if (is_file($module."/Groups.php"))
        {

            $this->ItemDataGroups=$this->ReadPHPArray($module."/Groups.php",$this->ItemDataGroups);
        }


        if (is_file($modulename."/Groups.Common.php"))
        {
            $this->ItemDataGroupsCommon=$this->ReadPHPArray($modulename."/Groups.Common.php");
        }

        if (is_file($module."/SGroups.php"))
        {
            $this->ItemDataSGroups=$this->ReadPHPArray($module."/SGroups.php");
        }
        if (is_file($modulename."/SGroups.Common.php"))
        {
            $this->ItemDataSGroupsCommon=$this->ReadPHPArray($modulename."/SGroups.Common.php");
        }
    }

    //*
    //* function InitModules, Parameter list: $module=""
    //*
    //* Reads Latex and Search data from $module."/Latex.Data.php" resp. $module."/Search.Data.php".
    //* Then calls Init on these, and sets $this->LeftMenu.
    //*

    function InitModules($module="")
    {
        if ($module=="") { $module=$this->ModuleName; }

        $inithash=array
        (
            "Latex"  => $module."/Latex.Data.php",
            "Search" => $module."/Search.Data.php",
         );

        foreach ($this->SetupData[ "Hashes" ] as $name => $def)
        {
            $inithash[ $name ]=$def;
        }

        $this->Init($inithash);
        $this->LeftMenu=$this->SetupData[ "Tables" ];
    }




  /* function PrintDocHeads() */
  /* { */
  /*     $this->ApplicationObj->MyApp_Interface_Head(); */
  /* } */


  function PrintDocHeadsAndInterfaceMenu($plural=FALSE)
  {
      $this->ApplicationObj()->MyApp_Interface_Head();
      $this->MyMod_HorMenu_Echo($plural);
  }
}

?>