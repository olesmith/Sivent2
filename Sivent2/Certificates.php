<?php

include_once("Certificates/Access.php");
include_once("Certificates/Validate.php");
include_once("Certificates/Latex.php");
include_once("Certificates/Generate.php");
include_once("Certificates/Mail.php");
include_once("Certificates/Code.php");


class Certificates extends Certificates_Code
{
    var $Code_Data=array
    (
       "Unit" => "%02d",
       "Event" => "%03d",
       "Friend" => "%06d",
       "ID" => "%06d",       
    );
    
    //*
    //* function Certificates, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Certificates($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Unit","Event","Name","Code","Type","Friend","Inscription","Submission","Collaborator","Caravaneer");
        $this->Sort=array("Name");
        $this->IncludeAllDefault=TRUE;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlUnitTableName("Certificates",$table);
    }
    
    //*
    //* function Type2Key, Parameter list: $item
    //*
    //* Returns certificate type key of certificate $item.
    //*

    function Type2Key($item)
    {
        $type2key=array
        (
           1 => "Inscription",
           2 => "Caravaneer",
           3 => "Collaborator",
           4 => "Submission",
        );
        
        $key="";
        if (isset($type2key[ $item[ "Type" ] ])) { $key=$type2key[ $item[ "Type" ] ]; }
        
        return $key;
    }
    
    //*
    //* function Type2NameKey, Parameter list: $item
    //*
    //* Returns certificate type key of certificate $item.
    //*

    function Type2NameKey($item)
    {
        $type2key=array
        (
           1 => "Name",
           2 => "Name",
           3 => "Name",
           4 => "Title",
        );
        
        $key="";
        if (isset($type2key[ $item[ "Type" ] ])) { $key=$type2key[ $item[ "Type" ] ]; }
        
        return $key;
    }
    
     //*
    //* function Type2LatexKey, Parameter list: $item
    //*
    //* Returns certificate key in $this->Event containing latex for the certificate.
    //*

    function Type2LatexKey($item)
    {
        $type2key=array
        (
           1 => "Certificates_Latex",
           2 => "Certificates_Caravaneers_Latex",
           3 => "Certificates_Collaborations_Latex",
           4 => "Certificates_Submissions_Latex",
        );
        
        $key="";
        if (isset($type2key[ $item[ "Type" ] ])) { $key=$type2key[ $item[ "Type" ] ]; }
        
        return $key;
    }
    
    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Certificates")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        $this->Certificate_Name_PostProcess($item,$updatedatas);
        $this->Certificate_Code_PostProcess($item,$updatedatas);
        
 
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }
    
    //*
    //* function Certificate_Name_PostProcess, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses certificate name.
    //*

    function Certificate_Name_PostProcess(&$item,&$updatedatas)
    {
        $names=array();
        if (!empty($item[ "Friend" ]))
        {
            array_push($names,$this->FriendsObj()->Sql_Select_Hash_Value($item[ "Friend" ],"Name"));
        }
        
        $key=$this->Type2Key($item);
        $namekey=$this->Type2NameKey($item);
        $obj=$key."sObj";
       
        if ($item[ "Type" ]>1 && !empty($item[ $key ]))
        {
            $sqltable=$this->ApplicationObj()->SubModulesVars[ $key."s" ][ "SqlTable" ];
            $sqltable=$this->FilterHash($sqltable,$item);
            
            array_push
            (
               $names,
               $name=$this->$obj()->Sql_Select_Hash_Value
               (
                  $item[ $key ],
                  $namekey,
                  "ID",TRUE,
                  $sqltable
               )
            );
        }

        $name=join(", ",$names);
        if ($item[ "Name" ]!=$name)
        {
            $item[ "Name" ]=$name;
            array_push($updatedatas,"Name");
        }
    }

    
    //*
    //* function Certificates_Friend_Table, Parameter list: $datas,$friend
    //*
    //* Creates Friend certificates table.
    //*

    function Certificates_Friend_Table($datas,$friend)
    {
        $certs=
            $this->Sql_Select_Hashes
            (
               array("Friend" => $friend[ "ID" ]),
               array(),
               "Type,Name"
            );

        if (empty($certs)) { return ""; }


        $table=array();
        $n=1;
        foreach ($this->MyHash_HashesList_Key($certs,"Event") as $eventid => $eventcerts)
        {
            $event=$this->EventsObj()->Sql_Select_Hash(array("ID" => $eventid),array("ID","Name","Certificates","Certificates_Published"));

            if (!$this->EventsObj()->Event_Certificates_Published($event)) { continue; }
            $first=array($this->GetRealNameKey($event,"Name"));
            
            foreach ($eventcerts as $eventcert)
            {
                array_push
                (
                   $table,
                   array_merge
                   (
                      $first,
                      $this->MyMod_Items_Table_Row(0,$n++,$eventcert,$datas)
                   )
                );

                $first=array("");
            }
        }

        return $table;
    }
        
    //*
    //* function Certificates_Friend_Table_Titles, Parameter list: $datas
    //*
    //* Creates Friend certificates table title row.
    //*

    function Certificates_Friend_Table_Titles($datas)
    {
        $titles=$this->GetDataTitles($datas);

        array_unshift($titles,$this->EventsObj()->MyMod_ItemName());

        return $titles;
    }
    
    //*
    //* function Certificates_Friend_Table_Html, Parameter list: $friend
    //*
    //* Creates Friend certificates table.
    //*

    function Certificates_Friend_Table_Html($friend)
    {
        $this->ItemData("ID");
        $this->Actions("Show");
        
        $datas=array("Generated","Mailed","Type","Name","Code","Generate",);
        
        $table=$this->Certificates_Friend_Table($datas,$friend);

        if (empty($table)) { return ""; }

        return
            $this->H(1,$this->MyLanguage_GetMessage("Certificate_Friend_Table_Title")).
            $this->H(2,$friend[ "Name" ]).
            $this->Html_Table
            (
               $this->Certificates_Friend_Table_Titles($datas),
               $this->Certificates_Friend_Table($datas,$friend)
            ).
            "";
    }
}

?>