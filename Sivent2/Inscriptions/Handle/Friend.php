<?php


class Inscriptions_Handle_Friend extends Inscriptions_Handle_Menu
{
    //*
    //* function Inscription_Handle_Friend_Form_Edit, Parameter list: 
    //*
    //* Detects whether to edit friend data form.
    //*

    function Inscription_Handle_Friend_Form_Edit($edit=0)
    {
        if ($this->CGI_GET("SubAction")!="EditData")
        {
            $edit=0;
        }
        
        if ($this->LatexMode()) { $edit=0; }

        return $edit;
    }
    
    //*
    //* function Inscription_Handle_Friend_Form, Parameter list: $edit,$friend=array(),$inscription=array()
    //*
    //* Creates Inscription friend data form.
    //*

    function Inscription_Handle_Friend_Form($edit,$friend,$inscription)
    {    
        return
            $this->Htmls_Comment_Section
            (
                "Inscription Friend Form",
                $this->Htmls_Table
                (
                    "",
                    array
                    (
                        array
                        (
                            $this->InscriptionFriendTable
                            (
                                $this->Inscription_Handle_Friend_Form_Edit($edit),
                                "SaveUserData",
                                $friend,
                                $inscription
                            )
                        ),
                    )
                )
            );
    }    
}

?>