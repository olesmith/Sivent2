<?php

class Certificates_Latex extends Certificates_Validate
{
    //*
    //* function Certificate_Latex_Filter, Parameter list: $cert,$inscription=array(),$friend=array(),$eventkey=""
    //*
    //* Generates cert.
    //*

    function Certificate_Latex_Filter($cert,$latex)
    {
        foreach (array("Event","Friend","Inscription","Collaboration","Collaborator","Caravaneer","Submission","Certificate","Inscription",) as $data)
        {
            $this->Certificate_Latex_Filter_Data($data,$cert,$latex);
        }

        return $latex;
    }
}

?>