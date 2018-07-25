<?php


class Inscriptions_Handle_Collaborations_Form extends Inscriptions_Handle_Collaborations_Update
{
    //*
    //* function Inscription_Handle_Collaborations_Html, Parameter list: $edit,$friend,$inscription,$group=""
    //*
    //* Creates Inscription Collaborations form.
    //*

    function Inscription_Handle_Collaborations_Form($edit,$friend,$inscription,$group="")
    {
        if (!$this->Inscription_Handle_Collaborations_Show_Should($edit,$friend,$inscription))
        {
            return array();
        }

        $this->CollaborationsObj()->Sql_Table_Structure_Update();
        $this->CollaboratorsObj()->Sql_Table_Structure_Update();

        $this->Inscription_Handle_Collaborations_Update($edit,$friend,$inscription,$group);
        
        return
            array
            (
                $this->Inscription_Handle_Collaborations_Info($edit,$friend,$inscription),
                $this->Htmls_Form
                (
                    $edit,
                    "Collaborations",
                    $action="",
                    #Content
                    $this->CollaboratorsObj()->Collaborators_Friend_Collaborations_Html
                    (
                        $edit,
                        $friend,
                        $this->Inscription_Handle_Collaborations_Group($group)
                    ),
                    #Content end
                
                    $args=array
                    (
                        "Buttons" => $this->Buttons(),
                        "Hiddens" => array
                        (
                            "Update" => 1,
                        )
                    ),
                    $options=array()
                )
            );
    }
    
}

?>