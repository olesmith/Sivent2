<?php


class Submissions_Authors_Table extends Submissions_Authors_Rows
{
   //*
    //* function Submission_Authors_Table_Html, Parameter list: $n,$edit,$item
    //*
    //* Generates the authors table as html.
    //*

    function Submission_Authors_Table_Html($n,$edit,$item)
    {
        return
            $this->Html_Table
            (
                "",
                $this->Submission_Authors_Table($n,$edit,$item)
            );
    }
    
    //*
    //* function Submissions_Authors_Table, Parameter list: $n,$edit,$item
    //*
    //* Generates the authors table as matrix.
    //*

    function Submission_Authors_Table($n,$edit,$item)
    {
        $table=array();
        for ($m=1;$m<=$this->EventsObj()->Event_Submissions_NAuthors();$m++)
        {
            $row=
                $this->MyMod_Items_Table_Row
                (
                    $edit,
                    $m,
                    $item,
                    $this->Author_Datas_Get($m),
                    $plural=TRUE,
                    $item[ "ID" ]."_"
                );
                
            array_unshift($row,$this->B($m.":"));
            array_push($table,$row);
        }

        return $table;
    }
    
}

?>