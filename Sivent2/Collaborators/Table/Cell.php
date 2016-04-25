<?php

class CollaboratorsTableCell extends CollaboratorsAccess
{
   //*
    //* function Collaborators_Table_Collaborations_Cell_Name, Parameter list: $collaboration
    //*
    //* 
    //*

    function Collaborators_Table_Collaborations_Cell_Name($collaboration)
    {
        return $collaboration[ "ID" ]."_Collaboration";
   }
    //*
    //* function Collaborators_Table_Collaborations_Inscribe_Cell, Parameter list: $edit,$collaboration
    //*
    //* 
    //*

    function Collaborators_Table_Collaborations_Inscribe_Cell($edit,$collaboration)
    {
        $disabled=FALSE;
        if ($collaboration[ "Inscriptions" ]!=2) {  $disabled=TRUE; }
        if ($edit!=1) { $disabled=TRUE; }
        
        return
            $this->Html_Input_CheckBox_Field
            (
               $this->Collaborators_Table_Collaborations_Cell_Name($collaboration),
               $value=1,
               $checked=FALSE,
               $disabled
            );
    }

    //*
    //* function Collaborators_Table_Collaborations_Inscribed_Cell, Parameter list: $edit,$collaboration,$item
    //*
    //* 
    //*

    function Collaborators_Table_Collaborations_Inscribed_Cell($edit,$collaboration,$item)
    {
        $disabled=FALSE;
        if (empty($item[ "Homologated" ])) { $item[ "Homologated" ]=1; }
        
        if ($collaboration[ "Inscriptions" ]!=2) {  $disabled=TRUE; }
        if (!empty($item[ "Homologated" ]) && $item[ "Homologated" ]==2) { $disabled=TRUE; }
        if ($edit!=1) { $disabled=TRUE; }
        
        return
            $this->Html_Input_CheckBox_Field
            (
               $this->Collaborators_Table_Collaborations_Cell_Name($collaboration),
               $value=1,
               $checked=TRUE,
               $disabled
            );
    }
}

?>