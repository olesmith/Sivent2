<?php

include_once("Certificates/Access.php");
include_once("Certificates/Validate.php");
include_once("Certificates/Latex.php");
include_once("Certificates/Generate.php");
include_once("Certificates/Read.php");
include_once("Certificates/Mail.php");
include_once("Certificates/Code.php");
include_once("Certificates/Verify.php");
include_once("Certificates/Handle.php");


class Certificates_Friend extends Certificates_Verify
{
     //*
    //* function Certificates_Friend_Tables, Parameter list: $friend,$event=array()
    //*
    //* Creates Friend certificates table.
    //*

    function Certificates_Friend_Tables($friend,$event=array())
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

        $n=1;

        $table=array();
        foreach ($this->MyHash_HashesList_Key($certs,"Event") as $eventid => $eventcerts)
        {
            $event=$this->EventsObj()->Sql_Select_Hash(array("ID" => $eventid));

            if (!$this->EventsObj()->Event_Certificates_Published($event)) { continue; }

            $table=
                array_merge
                (
                    $table,
                    $this->Certificates_Table($friend,$event,$eventcerts)
                );
        }

        return $table;
    }
                
    //*
    //* function Certificates_Friend_Tables_Html, Parameter list: $friend,$event=array()
    //*
    //* Creates Friend certificates table.
    //*

    function Certificates_Friend_Tables_Html($friend,$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        $this->ItemData("ID");
        $this->Actions("Show");
        
        if
            (
                !empty($event)
                &&
                $event[ "Certificates_Published" ]!=2
                &&
                !$this->Current_User_Event_Coordinator_Is($event)
            )
        {
            return "";
        }
        
        return
            $this->H(1,$this->MyLanguage_GetMessage("Certificate_Friend_Table_Title")).
            $this->H(2,$friend[ "Name" ]).
            $this->Html_Table
            (
               $this->Certificates_Table_Titles(),
               $this->Certificates_Friend_Tables($friend,$event)
            ).
            "";
    }
}

?>