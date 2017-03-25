<?php

class App_Events extends App_CGIVars
{
    //Global Criterias
    var $Criterias=array();

    //*
    //* function Criterias, Parameter list: $id=0,$key=""
    //*
    //* All modules Criterias accessor!
    //*

    function Criterias($id=0,$key="")
    {
        if (empty($this->Criterias))
        {
            $this->Criterias=$this->CriteriasObj()->Criterias_Read();
            $this->Criterias=$this->MyHash_HashesList_2ID($this->ApplicationObj()->Criterias,"ID");
        }

        if (!empty($id))
        {
            if (!empty($key))
            {
                return $this->Criterias[ $id ][ $key ];
            }
            
            return $this->Criterias[ $id ];
        }

        return $this->Criterias;
    }

    
           
    //*
    //* function EventSelect, Parameter list: $data,$item,$edit,$rdata=""
    //*
    //* Creates event select field.
    //*

    function EventSelect($data,$item,$edit,$rdata="")
    {
        $cell="";
        $where=array();

        if (!empty($item[ "ID" ])) { $item[ "Event" ]=$item[ "ID" ]; }
        
        $cell=
            $this->EventsObj()->MakeSelectFieldWithWhere
            (
               $edit,
               "Event",
               $where,
               array("ID","Name"),
               "#Name",
               "Name",
               $item,
               $rdata
            );

        return $cell;
    }
    
    //*
    //* function  HtmlEventsMenuDef, Parameter list: 
    //*
    //* Returns menu def as read from system file. May be overridden.
    //*

    function HtmlEventsMenuDef()
    {
        $menudef=parent::HtmlEventsMenuDef();
        
        $this->MyMod_Profiles_Hash_Transfer
        (
           $menudef,
           "Friend",
           $this->ApplicationObj()->UserProfiles,
           TRUE
        );
        
        $menudef=$this->ReadPHPArray("System/Events/LeftMenu.php",$menudef);

        return $menudef;
    }
    
    //*
    //* function GetCoordinatorEvents, Parameter list: 
    //*
    //* Handle coord entry.
    //*

    function GetCoordinatorEvents()
    {
        $events=
            $this->PermissionsObj()->Sql_Select_Unique_Col_Values
            (
               "Event",
               array("User" => $this->LoginData("ID"))
            );

        if (preg_grep('/^0$/',$events))
        {
            $events=$this->EventsObj()->Sql_Select_Unique_Col_Values("ID");
        }

        return
            $this->EventsObj()->Sql_Select_Hashes
            (
               array
               (
                  "ID" => $this->Sql_Where_IN($events)
               ),
               array(),
               "Date DESC"
            );
    }}
