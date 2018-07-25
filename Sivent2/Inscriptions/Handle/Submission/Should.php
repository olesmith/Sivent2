<?php


class Inscriptions_Handle_Submissions_Should extends Inscriptions_Handle_Submissions_URI
{
    //*
    //* function Inscription_Handle_Submissions_Show_Should, Parameter list: $edit,$friend,$inscription
    //*
    //* Determines whether we should show Submissions.
    //*

    function Inscription_Handle_Submissions_Show_Should($edit,$friend,$inscription)
    {
        $this->Inscription_Handle_Submissions_Read($friend);
        $res=$this->EventsObj()->Event_Submissions_Open();
        if (!$res)
        {
            if (count($this->Submissions)>0)
            {
                $res=True;
            }
        }

        return $res;
    }
}

?>