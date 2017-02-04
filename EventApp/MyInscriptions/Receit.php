<?php


class MyInscriptions_Receit extends MyInscriptions_Inscription
{
    //*
    //* function Receit_Friend_Table, Parameter list:
    //*
    //* Generates Receit friend table for friend referenced by $inscription.
    //*

    function Receit_Friend_Table($inscription)
    {
        $friend=$this->FriendsObj()->Sql_Select_Hash($inscription[ "Friend" ]);
        $friend=$this->TrimLatexItem($friend);
        $ftable=
            $this->FriendsObj()->MyMod_Item_Table_Form
            (
                array
                (
                    "Edit"          => 0,
                    "Item"          => $friend,
                    "Datas"         => $this->InscriptionFriendTableData(),
                    "TablePostRows" => array($this->InscriptionMessageRow($inscription)),
                    "Action"        => "?".$this->CGI_Hash2URI($this->CGI_URI2Hash()),
                    "Form_Title"    => "Dados Cadastrais",
                )
            );
        
        $ftable=
            $this->FriendsObj()->MyMod_Item_Table
            (
                0,
                $friend,
                $this->InscriptionFriendTableData()
            );

        return $ftable;
    }
    
    //*
    //* function Receit_Latex, Parameter list:
    //*
    //* Generates Receit latex code for inscription.
    //*

    function Receit_Latex($inscription)
    {
        $inscription=$this->TrimLatexItem($inscription);
        $ftable=$this->Receit_Friend_Table($inscription);
        
        array_unshift($ftable,$this->H(3,"Dados Cadastrais"));
        array_push
        (
            $ftable,
            array
            (
                $this->B($this->MyLanguage_GetMessage("Inscriptions_Receit_SubTitle").": "),
                $this->Event("Title"),
            ),
            array
            (
                $this->B($this->MyLanguage_GetMessage("Inscriptions_Receit_Status_Title").": "),
                $this->Inscription_Diag_Message($inscription)
            )
        );
       
        return
            $this->H(1,$this->MyLanguage_GetMessage("Inscriptions_Receit_Title")).
            $this->Latex_Table("",$ftable).
            $this->H(2,$this->MyLanguage_GetMessage("Inscriptions_Receit_Datas_Title")).
            $this->MyMod_Item_Groups_Tables_Latex
            (
                $this->InscriptionSGroups(0),
                $inscription,
                array
                (
                    "Spec" => "|p{5cm}|p{9cm}|"
                )
            ).
            "\n\n\\clearpage\n\n";
    }

    
    //*
    //* function Receit_Latex, Parameter list: $inscriptions
    //*
    //* Generates Receit latex code for inscription.
    //*

    function Receits_Latex($inscriptions)
    {
        $latex="";
        foreach ($inscriptions as $inscription)
        {
            $latex.=$this->Receit_Latex($inscription);
        }
        
        return $latex;
    }
}

?>