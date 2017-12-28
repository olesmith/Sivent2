<?php


class Submissions_Authors_Rows extends Submissions_Authors_Data
{
    //*
    //* function Submission_Authors_Row, Parameter list: $n,$edit,$item,$plural
    //*
    //* Returns row with author data.

    function Submission_Authors_Row($n,$edit,$item,$plural)
    {
        $datas=$this->Author_Datas_Get($n);

        $row=
            $this->MyMod_Item_Row
            (
                $edit,
                $item,
                $datas,
                $even=FALSE,
                $plural
           );
        
        array_unshift($row,$this->B($n.":"));

        return $row;
    }

    //*
    //* function Submission_Author_Titles, Parameter list: 
    //*
    //* Returns row with author data.

    function Submission_Authors_Titles()
    {
        $titles=$this->Author_Datas_Get(1);
        $titles=$this->MyMod_Data_Titles($titles);
        $this->Html_Table_Head_Row($titles);
        array_unshift($titles,"Nº");
        
        return $this->B($titles);
    }
    
    //*
    //* function Submission_Authors_Empty, Parameter list: 
    //*
    //* Generates the author Group table rows.
    //*

    function Submission_Authors_Empty()
    {
    }

    
    //*
    //* function Submission_Authors_Rows, Parameter list: $n,$edit,$item
    //*
    //* Generates the author Group table rows.
    //*

    function Submission_Authors_Rows($n,$edit,$item)
    {
        $predatas=$this->ItemDataGroups[ "Authors" ][ "Data" ];
        $empties=array();
        for ($k=1;$k<=$this->ItemDataGroups[ "Authors" ][ "NIndent" ];$k++)
        {
            array_push($empties,"&nbsp;");
        }

        $table=array();
        
        $row=
            $this->MyMod_Items_Table_Row
            (
                0,
                $n,
                $item,
                $predatas
            );

        array_push($table,$row);
        $rtable=$this->Submission_Authors_Table_Html($n,$edit,$item);
        
        $row=$empties;
        array_push($row,$rtable);
        
        array_push($table,$row);
        return $table;
    }
    
}

?>