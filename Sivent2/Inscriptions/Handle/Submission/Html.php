<?php


class Inscriptions_Handle_Submissions_Html extends Inscriptions_Handle_Submissions_Info
{
    //*
    //* function Inscription_Handle_Submissions_Html, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Inscription submissions html.
    //*

    function Inscription_Handle_Submissions_Html($edit,$friend,$inscription)
    {
        if (!$this->Inscription_Handle_Submissions_Show_Should($edit,$friend,$inscription))
        {
            return array();
        }

        return
            array
            (
                $this->Inscription_Handle_Submissions_Info($edit,$friend,$inscription),
                $this->Htmls_DIV
                (
                    $this->MyLanguage_GetMessage("Submissions_Table_Title"),
                    array
                    (
                        "CLASS" => $this->CSS[ "Table_Title" ],
                    )
                ),
                $this->SubmissionsObj()->MyMod_Group_Html_Table
                (
                    "",
                    $edit=0,
                    $group="Inscription",
                    $this->Submissions,
                    $titles=array(),$cgiupdatevar="Update",
                    $noitemshtml=array("empties"),
                    array(),
                    array(),
                    array(),
                    True,True
                ),
                /* $this->Htmls_Table */
                /* ( */
                /*     "", */
                /*     $this->Inscription_Handle_Submissions_Table($edit,$friend,$inscription), */
                /*     array(), */
                /*     array(), */
                /*     array(), */
                /*     True,True */
                /* ) */
            );
    }
}

?>