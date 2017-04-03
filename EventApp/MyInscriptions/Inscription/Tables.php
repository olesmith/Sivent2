<?php

class MyInscriptions_Inscription_Tables extends MyInscriptions_Inscription_SGroups
{
    //*
    //* function InscriptionHtmlTable, Parameter list: $edit,$buttons=FALSE,$inscription,$title="",$includeassessments=FALSE
    //*
    //* Creates Inscription edit html table.
    //*

    function InscriptionHtmlTable($edit,$buttons=FALSE,$inscription,$title="",$includeassessments=FALSE)
    {
        $table=$this->InscriptionTable($edit,$buttons,$inscription,$includeassessments);
        if (!empty($title)) { array_unshift($table,$title); }

        return $this->Html_Table("",$table);
    }
    
    //*
    //* function InscriptionEventTable, Parameter list: 
    //*
    //* Creates Inscription event data table
    //*

    function InscriptionEventTable()
    {        
        return $this->FrameIt
        (
            $this->Html_Table
            (
               "",
               $this->EventsObj()->MyMod_Item_Group_Tables
               (
                  $this->InscriptionEventTableSGroups,
                  $this->ApplicationObj->Event()
               )
            )
        ).
        $this->BR().
        "";
    }

    //*
    //* function InscriptionFriendTable, Parameter list: $edit,$friend=array()
    //*
    //* Creates Inscription friend data table
    //*

    function InscriptionFriendForm($edit,$friend=array(),$inscription=array())
    {
        if (empty($friend)) { $friend=$this->Friend; }
        if ($this->LatexMode()) { $edit=0; }

        $btitle="DoInscription";
        if (!empty($inscription))
        {
            $btitle="SaveUserData";
        }

        return join
        (
           "",
            array
            (
               $this->H
               (
                  1,
                  $this->Messages("Friend_Table_Title")
               ),
               $this->FriendsObj()->MyMod_Item_Table_Form
               (
                  array
                  (
                     "Edit"          => $edit,
                     "Item"          => $friend,
                     "Datas"         => $this->InscriptionFriendTableData(),
                     "TablePostRows" => array($this->InscriptionMessageRow()),
                     "Action"        => "?".$this->CGI_Hash2URI($this->CGI_URI2Hash()),
                     "EndButtons"   => $this->Buttons
                     (
                         $this->MyLanguage_GetMessage($btitle)
                     ),
                  )
               ),
            )
        );
    }
    
    //*
    //* function Inscription_Compulsory_Undef, Parameter list: $inscription
    //*
    //* Returns list of undefined data.
    //*

    function Inscription_Compulsory_Undef($inscription,$singular)
    {
        $compdatas=$this->MyMod_Item_Groups_Compulsory_Data($this->InscriptionSGroups(0),$singular);

        $datas=array();
        foreach ($compdatas as $data)
        {
            if (empty($inscription[ $data ]))
            {
                array_push($datas,$data);
            }
        }

        return $datas;
    }
    
    //*
    //* function Inscription_Diag_Message, Parameter list: $inscription
    //*
    //* Creates Inscription pure dig message.
    //*

    function Inscription_Diag_Message($inscription)
    {
        $lkey="Friend_Data_Diag_";

        $singular=TRUE;
        $compdatas=$this->Inscription_Compulsory_Undef($inscription,$singular);

        $rkey=$lkey."OK";
        if (count($compdatas)>0)
        {
            $rkey=$lkey."Error";
        }

        return $this->Messages($rkey);
    }

    
    //*
    //* function Inscription_Diag_Msg, Parameter list: $inscription
    //*
    //* Creates Inscription dig message.
    //*

    function Inscription_Diag_Msg($inscription)
    {
       return
            $this->H(5,$this->Inscription_Diag_Message($inscription)).
            "";
    }

    
    //*
    //* function InscriptionDiagList, Parameter list: $inscription
    //*
    //* Creates Inscription digag list (datas undefined).
    //*

    function InscriptionDiagList($inscription)
    {
        $lkey="Friend_Data_Diag_";

        $singular=TRUE;
        
        $compdatas=$this->Inscription_Compulsory_Undef($inscription,$singular);

        $messages=array();
        foreach ($compdatas as $data)
        {
            array_push
            (
                $messages,
                $this->GetDataTitle($data).
                ": ".
                $this->Messages($lkey."Message")."."
            );
        }

        $message=$this->Inscription_Diag_Msg($inscription);
        
        if (count($messages)>0)
        {
            return
                $message.
                $this->DIV
                (
                   $this->HtmlList($messages),
                   array("ALIGN" => 'left') 
                );
        }

        return
            $message.
            $this->InscriptionReceitLink($inscription);
    }
    
    
    //*
    //* function InscriptionReceitLink, Parameter list: $inscription
    //*
    //* Creates Inscription receit link, if all compulsory defined.
    //*

    function InscriptionReceitLink($inscription)
    {
        return
            $this->Center
            (
                $this->MyActions_Entry("Receit",$inscription)
            );
    }

    //*
    //* function Inscriptions_Table_Groups, Parameter list: $edit,$buttons=FALSE,$inscription=array(),
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function Inscriptions_Table_Groups($edit,$buttons=FALSE,$inscription=array())
    {
        $buttons="";
        if ($edit==1) { $buttons=$this->Buttons(); }
        
        $this->SGroups_NumberItems=TRUE;
        
        return
            $this->MyMod_Item_Group_Tables
            (
                $this->InscriptionSGroups($edit),
                $inscription,
                $buttons
            );
    }
    
    //*
    //* function InscriptionTable, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates Inscription edit table as matrix.
    //*

    function InscriptionTable($edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE)
    {
        if (empty($inscription)) { $inscription=$this->Inscription; }
        
        $table=$this->Inscriptions_Table_Groups($edit,$buttons,$inscription);

        array_unshift
        (
            $table,
            $this->InscriptionDiagList($inscription)
        );

        return $table;
    }
    
    //*
    //* function Inscription_Event_Typed_Tables, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Event typed tables:
    //*

    function Inscription_Event_Typed_Tables($edit,$friend,$inscription)
    {        
        return "";
    }
}

?>