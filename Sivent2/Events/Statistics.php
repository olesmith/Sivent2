<?php

class Events_Statistics extends Events_Subactions
{
    //*
    //* function Event_Statistics_Handle, Parameter list: $event=array()
    //*
    //* Creates Statistics info table.
    //*

    function Event_Statistics_Handle($event=array())
    {
        echo 
            $this->H(3,$this->GetRealNameKey($this->Actions("Statistics"),"Title")).
            $this->Html_Table
            (
                "",
                $this->Event_Statistics_Table($event)
            ).
            "";
    }
    
    //*
    //* function Event_Statistics_Table, Parameter list: $event=array()
    //*
    //* Creates Statistics info table.
    //*

    function Event_Statistics_Table($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }

        $table=array();
        foreach (array("Inscriptions","Collaborators","Caravans","Submissions","Assessors","Schedules",) as $module)
        {
            $accessor=$module."Obj";
            $method=$module."_Statistics_Rows";
            
            $table=array_merge
            (
                $table,
                $this->$accessor()->$method($event)
            );
        }
        
        
        return $table;
    }
}

?>