<?php


class Inscriptions_Handle_Collaborations_Update extends Inscriptions_Handle_Collaborations_Group
{
    //*
    //* function Inscription_Handle_Collaborations_Update, Parameter list: $edit,$friend,&$inscription
    //*
    //* Updates Inscription Collaborations form.
    //*

    function Inscription_Handle_Collaborations_Update($edit,$friend,&$inscription,$group)
    {
        if (!$this->Inscription_Handle_Collaborations_Show_Should($edit,$friend,$inscription))
        {
            return array();
        }

        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Inscription_Group_Update($group,$inscription);
        }
    }
}

?>