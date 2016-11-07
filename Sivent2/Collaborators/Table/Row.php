<?php

class Collaborators_Table_Row extends Collaborators_Table_Cell
{
    //*
    //* function Collaborators_Table_Collaborations_Titles, Parameter list: 
    //*
    //* 
    //*

    function Collaborators_Table_Collaborations_Titles()
    {
        $rdatas=$this->CollaborationsObj()->GetGroupDatas("Inscription");
        $datas=array("Homologated","TimeLoad");

        return
            array_merge
            (
               $this->CollaborationsObj()->GetDataTitles($rdatas),
               array("Inscrito"),
               $this->GetDataTitles($datas)
            );
    }
    
    //*
    //* function Collaborators_Table_Collaborations_Row, Parameter list: $n,$collaboration,$rdatas
    //*
    //* 
    //*

    function Collaborators_Table_Collaborations_Row($edit,$n,$collaboration,$rdatas,$item,$datas,$empties)
    {
        $row=$this->CollaborationsObj()->MyMod_Items_Table_Row(0,$n++,$collaboration,$rdatas,$plural=TRUE);            
        if (!empty($item))
        {
            array_push
            (
                $row,
                $this->Collaborators_Table_Collaborations_Inscribed_Cell($edit,$collaboration,$item)
            );
            
            if (empty($item[ "Homologated" ]))
            {
                $item[ "Homologated" ]=1;
            }

         
            $row=array_merge
            (
               $row,
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
        else
        {
            array_push
            (
                $row,
                $this->Collaborators_Table_Collaborations_Inscribe_Cell($edit,$collaboration,$item)
            );
            $row=array_merge($row,$empties);
        }

        return $row;
    }
}

?>