<?php

include_once("Certificates/Access.php");
include_once("Certificates/Validate.php");
include_once("Certificates/Latex.php");
include_once("Certificates/Generate.php");
include_once("Certificates/Mail.php");
include_once("Certificates/Code.php");


class Certificates extends Certificates_Code
{
    var $Certificate_NTypes=4;
    
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
    //* function Type2TimeloadKey, Parameter list: $item
    //*
    //* Returns certificate timeload key of certificate $item.
    //*

    function Type2TimeloadKey($item)
    {
        $type2key=array
            (
                1 => "Certificate_CH",
                2 => "TimeLoad",
                3 => "TimeLoad",
                4 => "Certificate_TimeLoad",
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
    //* function Certificates_Friend_Table, Parameter list: $datas,$friend,$event=array()
    //*
    //* Creates Friend certificates table.
    //*

    function Certificates_Friend_Table($datas,$friend,$event=array())
    {
        $where=$this->UnitWhere(array("Friend" => $friend[ "ID" ]));
        if (!empty($event)) { $where[ "Event" ]=$event[ "ID" ]; }
        
        $certs=
            $this->Sql_Select_Hashes
            (
               $where,
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
            $cht=0;
            foreach ($eventcerts as $eventcert)
            {
                $this->Certificate_TimeLoad_Update($eventcert);
        
                 array_push
                (
                   $table,
                   array_merge
                   (
                      $first,
                      $this->MyMod_Items_Table_Row(0,$n++,$eventcert,$datas)
                   )
                );

                if (!empty($eventcert[ "TimeLoad" ])) { $cht+=$eventcert[ "TimeLoad" ]; }
                
                $first=array("");
            }

            $pos=array_search("TimeLoad",$datas);
            array_push
            (
                $table,
                array
                (
                    $this->MultiCell($this->ApplicationObj->Sigma,$pos+1,'r'),
                    $this->B($cht),
                    ""
                )
            );
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
    //* function Certificates_Friend_Table_Html, Parameter list: $friend,$event=array()
    //*
    //* Creates Friend certificates table.
    //*

    function Certificates_Friend_Table_Html($friend,$event=array())
    {
        $this->ItemData("ID");
        $this->Actions("Show");
        
        $datas=array("Generate","Generated","Mailed","Type","Name","TimeLoad","Code",);
        
        $table=$this->Certificates_Friend_Table($datas,$friend);

        if (empty($table)) { return ""; }

        return
            $this->H(1,$this->MyLanguage_GetMessage("Certificate_Friend_Table_Title")).
            $this->H(2,$friend[ "Name" ]).
            $this->Html_Table
            (
               $this->Certificates_Friend_Table_Titles($datas),
               $this->Certificates_Friend_Table($datas,$friend,$event)
            ).
            "";
    }
}

?>