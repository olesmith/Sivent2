<?php

class Collaborators_Friend_Form extends Collaborators_Friend_Html
{
    //*
    //* function Collaborators_Friend_Collaborations_Form, Parameter list: $edit,$friend,$group="Basic",$inscriptionsonly=TRUE,$inscribedonly=False
    //*
    //* 
    //*

    function Collaborators_Friend_Collaborations_Form($edit,$friend,$group="Basic",$inscriptionsonly=TRUE,$inscribedonly=False)
    {
        $this->ItemData("ID");
        $this->ItemDataGroups($group);
        $this->Collaborators_Friend_Read($userid,$inscriptionsonly,$inscribedonly);

        $friendid=0;
        if (!empty($friend[ "ID" ]))
        {
            $friendid=$friend[ "ID" ];
        }

        if (empty($friendid))
        {
            $edit=0;
        }
        
        return
            array
            (
                $this->Collaborators_Friend_Collaborations_Info($edit,$userid),
                $this->Htmls_Form
                (
                    $edit,
                    "Collaborations",
                    $action="",
                    #Content
                    $this->Collaborators_Friend_Collaborations_Html($edit,$userid,$group,$titlekey="")
                ),
                #Content end
                
                $args=array
                (
                    "Hiddens" => array
                    (
                        "Friend" => $userid,
                        "Update" => 1,
                    )
                ),
                $options=array()
            );
     }
}

?>