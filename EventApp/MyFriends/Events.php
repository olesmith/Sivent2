<?php

include_once("Events/Read.php");
include_once("Events/Rows.php");
include_once("Events/Table.php");

class MyFriends_Events extends MyFriends_Events_Table
{   
    //*
    //* function Friend_Events_Type, Parameter list: $msgkey,&$n,$excludeevents
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Events_Type_Rows($friend,$msgkey,&$n,$events,$excludeevents=array())
    {
        return
            array_merge
            (
                array($this->H(1,$this->MyLanguage_GetMessage($msgkey))),
                $this->Friend_Events_Table($friend,$n,$events,$excludeevents)
            );
    }

    
    //*
    //* function Handle, Parameter list: $friend=array()
    //*
    //* Show suitable events for friend.
    //*

    function Friend_Events_Handle($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        $this->EventsObj()->ItemData();
        $this->EventsObj()->Actions();
        $this->CertificatesObj()->ItemData();
        $this->CertificatesObj()->Actions();

        $opens=$this->Friend_Events_Read_Open();
        $inscribeds=$this->Friend_Events_Read_Inscribed();
        $all=$this->Friend_Events_Read_All();

        $titles=$this->Html_Table_Head_Row($this->EventsObj()->MyMod_Data_Titles($this->Friend_Event_Datas()));

        $omit=array();
        foreach ($opens as $event)
        {
            $omit[ $event[ "ID" ] ]=$event;
        }
        
        foreach ($inscribeds as $event)
        {
            $omit[ $event[ "ID" ] ]=$event;
        }
        
        $n=1;
        echo
            $this->Html_Table
            (
                "",
                array_merge
                (
                    $this->Friend_Events_Type_Rows
                    (
                        $friend,
                        "Friend_Events_Open_Table_Title",
                        $n,
                        $opens
                    ),
                    array($this->HR(array("WIDTH" => "50%")).$this->BR()),
                    $this->Friend_Events_Type_Rows
                    (
                        $friend,
                        "Friend_Events_Inscribed_Table_Title",
                        $n,
                        $inscribeds,
                        $opens
                    ),
                    array($this->HR(array("WIDTH" => "50%")).$this->BR()),
                    $this->Friend_Events_Type_Rows
                    (
                        $friend,
                        "Friend_Events_Table_Title",
                        $n,
                        $all,
                        $omit
                    )
                )
            ).
            "";
    }
}

?>