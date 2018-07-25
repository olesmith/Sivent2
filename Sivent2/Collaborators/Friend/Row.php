<?php

class Collaborators_Friend_Row extends Collaborators_Friend_Cell
{
    //*
    //* function Collaborators_Friend_Collaborations_Titles, Parameter list: 
    //*
    //* 
    //*

    function Collaborators_Friend_Collaborations_Titles()
    {
        $rdatas=$this->CollaborationsObj()->MyMod_Data_Group_Datas_Get("Inscription");
        $datas=array("Homologated","TimeLoad");

        return
            array_merge
            (
               $this->CollaborationsObj()->MyMod_Data_Titles($rdatas),
               array("Inscrito"),
               $this->MyMod_Data_Titles($datas)
            );
    }
    
    //*
    //* function Collaborators_Friend_Collaborations_Row, Parameter list: $n,$collaboration,$rdatas
    //*
    //* 
    //*

    function Collaborators_Friend_Collaborations_Row($edit,$n,$collaboration,$rdatas,$item,$datas,$empties)
    {
        $method="Inscribed";
        if (empty($item))
        {
            $method="Inscribe";
        }
        
        $method="Collaborators_Friend_Collaborations_Row_".$method."_Cells";
        return
            array_merge
            (
                $this->CollaborationsObj()->MyMod_Items_Table_Row
                (
                    0,
                    $n++,
                    $collaboration,
                    $rdatas,
                    $plural=TRUE
                ),
                $this->$method
                (
                    $edit,
                    $n,
                    $collaboration,
                    $rdatas,
                    $item,
                    $datas,
                    $empties
                )
            );
    }
    
    //*
    //* function Collaborators_Friend_Collaborations_Row_Inscribed_Cells, Parameter list: $n,$collaboration,$rdatas
    //*
    //* Creates row with inscribed $collaboration.
    //*

    function Collaborators_Friend_Collaborations_Row_Inscribed_Cells($edit,$n,$collaboration,$rdatas,$item,$datas,$empties)
    {
        if (empty($item[ "Homologated" ]))
        {
            $item[ "Homologated" ]=1;
        }
         
        return
            array_merge
            (
                array
                (
                    $this->Collaborators_Friend_Collaborations_Inscribed_Cell($edit,$collaboration,$item)
                ),
                $this->MyMod_Items_Table_Row
                (
                    1,
                    0,
                    $item,
                    $datas,
                    $plural=TRUE,
                    $item[ "ID" ]."_"
                )
            );
    }
    //*
    //* function Collaborators_Friend_Collaborations_Row_Inscribe_Cells, Parameter list: $n,$collaboration,$rdatas
    //*
    //* Creates row with $collaboration to inscribe.
    //*

    function Collaborators_Friend_Collaborations_Row_Inscribe_Cells($edit,$n,$collaboration,$rdatas,$item,$datas,$empties)
    {
        $row=$this->CollaborationsObj()->MyMod_Items_Table_Row(0,$n++,$collaboration,$rdatas,$plural=TRUE);
        return
            array_merge
            (
                array
                (
                    $this->Collaborators_Friend_Collaborations_Inscribe_Cell($edit,$collaboration,$item)
                ),
                $empties
            );
    }
}

?>