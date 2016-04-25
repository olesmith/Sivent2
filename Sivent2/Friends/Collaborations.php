<?php


class FriendsCollaborations extends FriendsClean
{
    //*
    //* function Friend_Collaborations_Has, Parameter list: $item=array()
    //*
    //* Checks whether event has collaborations.
    //*

    function Friend_Collaborations_Has($item=array())
    {
        return $this->EventsObj()->Event_Collaborations_Has();
    }
    
    //*
    //* function Friend_Collaborations_Select_Table, Parameter list: 
    //*
    //* Returns friend specification table.
    //*

    function Friend_Collaborations_Select_Table()
    {
        return
            array
            (
               array($this->H(1,$this->GetRealNameKey($this->Actions("Collaborations"),"Title"))),
               array($this->H(2,$this->GetRealNameKey($this->Event(),"Title"))),
               array
               (
                  $this->B($this->MyLanguage_GetMessage("Friends_Collaborators_SelectField")),
                  $this->Friend_Collaborator_SelectField()
               ),
               array
               (
                  $this->B($this->MyLanguage_GetMessage("Friends_Collaborations_Inscribeds")),
                  $this->Html_Input_CheckBox_Field
                  (
                     "Inscribeds",
                     1,
                     $this->Friend_Collaborations_Inscribeds_Only()
                   )
               ),
               array
               (
                  $this->B($this->MyLanguage_GetMessage("Friends_Collaborations_Candidates")),
                  $this->Html_Input_CheckBox_Field
                  (
                     "Candidates",
                     1,
                     $this->Friend_Collaborations_Candidates_Only()
                   )
               ),
               array
               (
                  $this->Button("submit","GO")
               ),
            );
    }

    
    //*
    //* function Friend_Collaborations_Handle, Parameter list: 
    //*
    //* Handles addition and currently allocated collaborations for current friend (if specified).
    //*

    function Friend_Collaborations_Handle()
    {
        echo
            $this->H(1,$this->GetRealNameKey($this->Actions("Collaborations"),"Title")).
            $this->H(2,$this->GetRealNameKey($this->Event(),"Title")).
            $this->StartForm("","post",0,array(),array("Friend","Inscribeds","Candidates")).
            $this->Html_Table
            (
               "",
               $this->Friend_Collaborations_Select_Table()
            ).
            $this->EndForm().
            $this->H(3,$this->MyLanguage_GetMessage("Friends_Collaborator_Selected")).
            $this->Friend_Collaborations_Friend_Forms().
            "";
    }

    //*
    //* function Friend_Collaborations_Candidates_Only, Parameter list: 
    //*
    //* Checks from CGI whether we should only include inscribeds.
    //*

    function Friend_Collaborations_Candidates_Only()
    {
        $res=FALSE;
        if ($this->CGI_GETOrPOST("Candidates")==1)
        {
            $res=TRUE;
        }
        
        return $res;
    }
 
    //*
    //* function Friend_Collaborations_Inscribeds_Only, Parameter list: 
    //*
    //* Checks from CGI whether we should only include inscribeds.
    //*

    function Friend_Collaborations_Inscribeds_Only()
    {
        $res=$this->Friend_Collaborations_Candidates_Only();
        if ($this->CGI_GETOrPOST("Inscribeds")==1)
        {
            $res=TRUE;
        }
        
        return $res;
    }
 
    //*
    //* function Friend_Collaborators_Read, Parameter list: 
    //*
    //* Produces a friend select field.
    //*

    function Friend_Collaborators_Read()
    {
        $where=array();
        if ($this->Friend_Collaborations_Inscribeds_Only())
        {
            $rwhere=array();
            if ($this->Friend_Collaborations_Candidates_Only())
            {
                $rwhere[ "Collaborations" ]=2;
            }
            
            $where[ "__IDs__" ]=
                "IN ('".
                join
                (
                   "', '",
                   $this->InscriptionsObj()->Inscriptions_Read_Friend_IDs($rwhere)
                ).
                ")";
        }
        
        return $this->Sql_Select_Hashes(array(),array("ID","Name","Email"),"Name");
    }
    
    //*
    //* function Friend_Collaborations_SelectField, Parameter list: 
    //*
    //* Produces a friend select field.
    //*

    function Friend_Collaborator_SelectField()
    {
        return
            $this->Html_SelectField
            (
               $this->Friend_Collaborators_Read(),
               "Friend",
               "ID",
               "#Name","#Name (#Email)",
               $this->CGI_GETOrPOSTint("Friend")
            ).
            "";
    }
    
    //*
    //* function Friend_Collaborations_Friend_Read, Parameter list: 
    //*
    //* Reads friend from db, if specified.
    //*

    function Friend_Collaborations_Friend_Read()
    {
        $friend=$this->CGI_GETOrPOSTint("Friend");
        if (!empty($friend))
        {
            $friend=$this->Sql_Select_Hash(array("ID" => $friend));

            $this->Friend=$friend;
            return $friend;
        }

        return array();
    }

    //*
    //* function Friend_Collaborations_Friend_Table, Parameter list: 
    //*
    //* Returns the friend data table.
    //*

    function Friend_Collaborations_Friend_Table()
    {
        return $this->MyMod_Item_Table(0,$this->Friend,array("Name","Email"));
    }
    
    
    //*
    //* function Friend_Collaborations_Friend_Forms, Parameter list: 
    //*
    //* Create collaborations forms: Add and EditList.
    //*

    function Friend_Collaborations_Friend_Forms()
    {
        $this->Friend_Collaborations_Friend_Read();
        if (empty($this->Friend))
        {
            return "-";
        }

        return
            $this->Html_Table
            (
               "",
               array_merge
               (
                  array($this->H(3,$this->MyLanguage_GetMessage("Friends_Collaborations_Table"))),
                  $this->Friend_Collaborations_Friend_Table(),
                  array($this->H(3,$this->MyLanguage_GetMessage("Friends_Collaborations_Inscription_Table"))),
                  $this->Friend_Collaborations_Inscription_Table()
                )
            ).
            $this->Friend_Collaborations_Add_Form().
            $this->CollaboratorsObj()->Collaborators_User_Table_Form
            (
               1,
               $this->Friend[ "ID" ]
            ).
            "";
    }
    
    //*
    //* function Friend_Collaborations_Inscription_Read, Parameter list: 
    //*
    //* Tries to read $friend inscription.
    //*

    function Friend_Collaborations_Inscription_Read()
    {
        $this->Inscription=
            $this->InscriptionsObj()->Sql_Select_Hash(array("Friend" => $this->Friend[ "ID" ]));

        return $this->Inscription;
    }

    //*
    //* function Friend_Collaborations_Inscription_Table, Parameter list: $friend
    //*
    //* Tries to read $friend inscription.
    //*

    function Friend_Collaborations_Inscription_Table()
    {
        $inscription=$this->Friend_Collaborations_Inscription_Read();
        
        return
            $this->InscriptionsObj()->MyMod_Item_Table
            (
               0,
               $inscription,
               array("Collaborations","Collaborations_Activity")
            );
    }

    //*
    //* function Friend_Collaborations_Read, Parameter list: 
    //*
    //* Tries to read $friend inscription.
    //*

    function Friend_Collaborations_Read()
    {
        if (empty($this->Collaborations))
        {
           $this->Collaborations=
               $this->CollaborationsObj()->Sql_Select_Hashes
               (
                   array("Event" => $this->Event("ID")),
                   array("ID","Name","TimeLoad")
               );
        }
    }
    
    //*
    //* function Friend_Collaborations_SelectField, Parameter list: 
    //*
    //* Tries to read $friend inscription.
    //*

    function Friend_Collaborations_SelectField()
    {
        $this->Friend_Collaborations_Read();
        
        return 
            $this->Html_SelectField
            (
               $this->Collaborations,
               "Collaboration",
               "ID",
               "#Name","#Name (#TimeLoad)",
               $this->CGI_GETOrPOSTint("Friend")
            ).
            "";
    }

    
    //*
    //* function Friend_Collaborations_Add_Form_DoAdd, Parameter list: 
    //*
    //* Tries to read $friend inscription.
    //*

    function Friend_Collaborations_Add_Form_DoAdd()
    {
        $collaboration=$this->CGI_POSTint("Collaboration");
        $friend=$this->Friend[ "ID" ];

        if (empty($friend) || empty($collaboration))
        {
           $this->DoDie("Empty friend or collaboration",$friend,$collaboration);
        }

        $collaborator=array
        (
           "Unit" => $this->Unit("ID"),
           "Event" => $this->Event("ID"),
           "Collaboration" => $collaboration,
           "Friend" => $friend,
        );

        $this->CollaboratorsObj()->Sql_Insert_Item($collaborator);
        $collaborator=$this->CollaboratorsObj()->PostProcess($collaborator);
    }

    
    //*
    //* function Friend_Collaborations_Add_Form, Parameter list: 
    //*
    //* Tries to read $friend inscription.
    //*

    function Friend_Collaborations_Add_Form()
    {
        if ($this->CGI_POSTint("Add")==1)
        {
           $this->Friend_Collaborations_Add_Form_DoAdd();
        }
        return
            $this->H(3,$this->MyLanguage_GetMessage("Friends_Collaborations_Add")).
            $this->StartForm("","post",0,array(),array("Friend","Inscribeds","Candidates")).
            $this->Html_Table
            (
               "",
               array
               (
                  array
                  (
                     $this->B("Selecione Colaboração:"),
                     $this->Friend_Collaborations_SelectField()
                  ),
                  array
                  (
                     $this->MakeHidden("Friend",$this->Friend[ "ID" ]).
                     $this->MakeHidden("Add",1).
                     $this->Button("submit","Adicionar").
                     ""
                  ),
               )
            ).
            $this->EndForm();       
    }

    
}

?>