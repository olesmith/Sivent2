<?php


class Inscriptions_Handle_Menu extends InscriptionsPreInscriptions
{
    //*
    //* function Inscription_Handle_Menu_Actions, Parameter list: $edit
    //*
    //* 
    //*

    function Inscription_Handle_Menu_Actions($edit)
    {
        return
            array
            (
                "Start" => array
                (
                    "Name" =>    "Início",
                    "Name_ES" => "Início",
                    "Name_UK" => "Start",
                ),
                "EditData" => array
                (
                    "Name" => "Editar Dados do Cadastro",
                    "Name_ES" => "Editar Dados do Cadastro",
                    "Name_UK" => "Edit Registration Data",
                    "Should" => "Registration_Data_Should",
                ),
                "Inscription" => array
                (
                    "Name" =>    "Dados da Inscrição",
                    "Name_ES" => "Dados da Inscriçión",
                    "Name_UK" => "Inscription Data",
                    "Should" => "Inscription_Data_Should",
                ),
                 "Submissions" => array
                (
                    "Name" =>    "Submissão de Trabalhos",
                    "Name_ES" => "Submissión de Trabajos",
                    "Name_UK" => "Proposal Submissions",
                    "Should" => "Submissions_Data_Should",
                ),
                "Collaborations" => array
                (
                    "Name" =>    "Colaborações",
                    "Name_ES" => "Colaboraciónes",
                    "Name_UK" => "Collaborations",
                    "Should" => "Collaborations_Data_Should",
                ),
            );
    }

    
    //*
    //* function Inscription_Handle_Menu, Parameter list: $edit
    //*
    //* Creates Inscription Edit form menu.
    //*

    function Inscription_Handle_Menu($edit)
    {
        return
            $this->Htmls_HRef_Menu
            (
                $this->Inscription_Handle_Menu_ID(),
                $title="",
                $this->Inscription_Handle_Menu_HRefs($edit),
                $titles=array(),
                $args=array(),
                $btitles=array()
            );
    }
    //*
    //* function Inscription_Handle_Menu_HRefs, Parameter list: $edit
    //*
    //* Creates subactions menu hrefs list.
    //*

    function Inscription_Handle_Menu_HRefs($edit)
    {
        $args=$this->CGI_URI2Hash();

        $csubaction=$this->CGI_GET("SubAction");

        $basekey="SubAction";
        $id=$basekey."_Menu";
        
        $hrefs=array();
        foreach ($this->Inscription_Handle_Menu_Actions($edit) as $subaction => $actiondef)
        {
            array_push
            (
                $hrefs,
                $this->Inscription_Handle_Menu_HRef($csubaction,$subaction,$actiondef)
            );
        }

        return $hrefs;
    }
    //*
    //* function Inscription_Handle_Menu_HRef, Parameter list:
    //*
    //* Creates subactions menu hrefs list.
    //*

    function Inscription_Handle_Menu_HRef($csubaction,$subaction,$actiondef)
    {
        $args=$this->CGI_URI2Hash();

        $basekey=$this->Inscription_Handle_Menu_Key();
        $id=$this->Inscription_Handle_Menu_ID();

        $args[ $basekey ]=$subaction;
        $href=$this->GetRealNameKey($actiondef,"Name");

        if (True || $csubaction!=$subaction)
        {
            $href=
                $this->Htmls_HRef
                (
                    "?".$this->CGI_Hash2URI($args),
                    $this->GetRealNameKey($actiondef,"Name"),
                    $title="",
                    $class="",
                    $rargs=array
                    (
                        "Anchor" => $this->Inscription_Handle_Menu_ID(),
                        $basekey => $subaction,
                    )
                );
        }

        return $href;
    }
    
    //*
    //* function Inscription_Handle_Menu_Key, Parameter list: 
    //*
    //* Base cgi key.
    //*

    function Inscription_Handle_Menu_Key()
    {      
        return "SubAction";
    }

    //*
    //* function Inscription_Form_ID, Parameter list: 
    //*
    //* ID tag.
    //*

    function Inscription_Handle_Menu_ID()
    {      
        return $this->Inscription_Handle_Menu_Key()."_Menu";
    }
}

?>