<?php

include_once("Import/Cells.php");
include_once("Import/Rows.php");
include_once("Import/Table.php");
include_once("Import/Detect.php");
include_once("Import/Update.php");
include_once("Import/Show.php");


trait MyMod_Handle_Import
{
    use
        MyMod_Handle_Import_Cells,
        MyMod_Handle_Import_Rows,
        MyMod_Handle_Import_Table,
        MyMod_Handle_Import_Detect,
        MyMod_Handle_Import_Update,
        MyMod_Handle_Import_Show;
    
    var $Import_Datas=array();
    var $Import_Mail_Status=
        array
        (
            "Invalid",
            "Valid",
            "Registered",
            "Inscribed",
            "Certified"
        );
    
    //*
    //* function MyMod_Handle_Import, Parameter list: 
    //*
    //* Handles items export.
    //*

    function MyMod_Handle_Import()
    {
        echo
            $this->H(1,"Import Inscriptions from Text File").
            $this->MyMod_Handle_Import_Form().
            "";

        if ($this->CGI_POSTint("Detect")==1 || $this->CGI_POSTint("Save")==1)
        {
            echo
                $this->MyMod_Handle_Import_Items_Show();
            
        }
    }

    //*
    //* function MyMod_Handle_Import_Email_Is_Registered, Parameter list: &$item
    //*
    //* Returns true if email is already registered.
    //*

    function MyMod_Handle_Import_Email_Is_Registered(&$item)
    {
        $friend=
            $this->FriendsObj()->Sql_Select_Hash
            (
                array("Email" => $item[ "Email" ]),
                array("ID")
            );
        
        $res=FALSE;
        if (!empty($friend))
        {
            $item[ "Friend_Hash" ]=$friend;
            $res=TRUE;
        }
        
        return $res;
    }
    
   //*
    //* function MyMod_Handle_Import_Friend_Is_Inscribed, Parameter list: &$item
    //*
    //* Returns true if email is already registered.
    //*

    function MyMod_Handle_Import_Friend_Is_Inscribed(&$item)
    {
        $inscription=array();
        if (!empty($item[ "Friend_Hash" ]))
        {
            $inscription=
                $this->InscriptionsObj()->Sql_Select_Hash
                (
                    array("Friend" => $item[ "Friend_Hash" ][ "ID" ]),
                    array("ID","Certificate","Certificate_CH")
                );
        }
        
        $res=FALSE;
        if (!empty($inscription))
        {
            $item[ "Inscription_Hash" ]=$inscription;
            $res=TRUE;
            
        }

        return $res;
    }
    
    //*
    //* function MyMod_Handle_Import_Form, Parameter list: 
    //*
    //* Handles items export.
    //*

    function MyMod_Handle_Import_Form()
    {
        return
            $this->StartForm($action="Import",$method="post").
            $this->Html_Table
            (
                "",
                array
                (
                    array
                    (
                        $this->B("Select File:"),
                        $this->MakeFileField
                        (
                            "File",
                            $options=array()
                        )
                    ),
                    array
                    (
                        $this->B("Parse:"),
                        $this->Button("submit","GO"),
                        
                    ),
                )
            ).
            $this->MakeHidden("Detect",1).
            $this->EndForm().
            "";
    }
}
?>