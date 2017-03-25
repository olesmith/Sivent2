<?php


class Submissions_Authors_SGroups extends Submissions_Authors_Table
{
    //*
    //* function Submission_Authors_SGroup_Gen, Parameter list: $edit,$item,$group
    //*
    //* Generates the authors SGroup table.

    function Submission_Authors_SGroup_Gen($edit,$item,$group)
    {
        $table=array($this->Submission_Authors_Titles());
        for ($n=1;$n<=$this->EventsObj()->Event_Submissions_NAuthors();$n++)
        {
            array_push
            (
                $table,
                $this->Submission_Authors_Row($n,$edit,$item,$plural=FALSE)
            );
        }

        return $table;
    }
}

?>