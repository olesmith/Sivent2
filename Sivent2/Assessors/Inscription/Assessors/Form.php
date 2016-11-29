<?php


class AssessorsInscriptionAssessorsForm extends AssessorsInscriptionAssessorsTable
{
    //*
    //* function Assessors_Friend_Assessor_Authors_Table, Parameter list: $edit,$friend,&$assessor
    //*
    //* Creates $assessor assessment authors inf table.
    //*

    function Assessors_Friend_Assessor_Authors_Table(&$assessor)
    {
        if
            (
                preg_match('/^(Friend)$/',$this->Profile())
                &&
                $this->LoginData("ID")==$assessor[ "Friend" ]
            )
        {
            
            return array();
        }
        
        return
            array_merge
            (
                array
                (
                    $this->H(3,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Friend_Title"))
                ),
                $this->SubmissionsObj()->Submission_Authors_Tables
                (
                    $assessor[ "Submission_Hash" ],
                    array("Name","Email","NickName","Titulation","Curriculum",)
                )
            );
    }

     //*
    //* function Assessors_Friend_Assessor_Submission_Table, Parameter list: $edit,$friend,&$assessor
    //*
    //* Creates $assessor assessment submission inf table.
    //*

    function Assessors_Friend_Assessor_Submission_Table($edit,&$assessor)
    {
        return
            array_merge
            (
                array
                (
                    $this->H(3,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Submission_Title"))
                ),
                $this->SubmissionsObj()->MyMod_Item_Table
                (
                    $edit,
                    $assessor[ "Submission_Hash" ],
                    array("Name","Title","Area","Level","Keywords","Summary","File")
                )
            );
    }

    
    //*
    //* function Assessors_Friend_Assessor_Form, Parameter list: $edit,$friend,&$assessor
    //*
    //* Creates $assessor assessment form.
    //*

    function Assessors_Friend_Assessor_Form($edit,$inscription,&$assessor)
    {
        $frienddatas=array("Name","Email","NickName","Titulation","Curriculum",);
        $submissiondatas=array("Name","Title","Area","Level","Keywords","Summary","File");
        
        return $this->FrameIt
        (
            $this->Assessors_Inscription_Assessors_Menu().
            $this->H(2,$this->MyLanguage_GetMessage("Assessments_Inscriptions_Assessment_Title")).
            $this->Html_Table
            (
                "",
                array_merge
                (
                    $this->Assessors_Friend_Assessor_Authors_Table($assessor),
                    $this->Assessors_Friend_Assessor_Submission_Table(0,$assessor)
                )
            ).
            $this->Assessor_Inscription_Assessments_Form($edit,$assessor).
            ""
        );
    }
    
    //*
    //* function Assessors_Inscription_Assessors_Menu, Parameter list:
    //*
    //* Creates assesments menu: search links: Not assessed, assessed, all.
    //*

    function Assessors_Inscription_Assessors_Menu()
    {
        $args=$this->CGI_URI2Hash();
        unset($args[ "Assessor" ]);
        
        $opts=
            array
            (
                "Todo" => array
                (
                    "Name" => "Não Avaliados",
                    "Name_ES" => "No Avaliados",
                    "Name_UK" => "Not Assessed",
                    "Value" => 1,
                ),
                "Done" => array
                (
                    "Name" => "Avaliados",
                    "Name_ES" => "Avaliados",
                    "Name_UK" => "Assessed",
                    "Value" => 2,
                ),
                "All" => array
                (
                    "Name" => "Todos",
                    "Name_ES" => "Todos",
                    "Name_UK" => "All",
                    "Value" => 3,
                ),
            );

        $hrefs=array();
        foreach ($opts as $opt => $hash)
        {
            $args[ "Cond" ]=$hash[ "Value" ];

            $href=
                $this->Href
                (
                    "?".$this->CGI_Hash2URI($args),
                    $this->GetRealNameKey($hash,"Name"),
                    "","","",0,array(),
                    "CondMenu"
                );
            array_push($hrefs,$href);
        }

        return
            $this->Anchor("CondMenu").
            $this->Center("[".join(" | ",$hrefs)." ]");
    }
    
    //*
    //* function Assessors_Inscription_Assessors_Table, Parameter list: $edit,$friend,&$assessors
    //*
    //* Loops over $assessors, if ID equals POST Assessor, shows this Assessors form.
    //*

    function Assessors_Friend_Assessors_Form($edit,$friend,&$assessors)
    {
        $assessorid=$this->CGI_GETint("Assessor");

        $html="";
        foreach (array_keys($assessors) as $aid)
        {
            if ($assessors[ $aid ][ "ID" ]==$assessorid)
            {
                $html.=$this->Assessors_Friend_Assessor_Form($edit,$friend,$assessors[ $aid ]);
                break;
            }
        }

        return $html;
    }
    
    
}

?>