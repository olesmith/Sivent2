<?php

class MyEventApp_Accessors extends MyEventApp_CGIVars
{
    //*
    //*
    //* function SqlUnitTableName, Parameter list: $module,$table=""
    //*
    //* Used by specific module to override SqlTableName, prepending Unit id.
    //*

    function SqlUnitTableName($module,$table="")
    {
        if (empty($table)) { $table="#Unit__".$module; }

        return preg_replace('/#Unit/',$this->Unit("ID"),$table);
    }

    //*
    //*
    //* function SqlEventTableName, Parameter list: $module,$table="",$event=array()
    //*
    //* Used by specific module to override SqlTableName, prepending Unit id.
    //*

    function SqlEventTableName($module,$table="",$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        if (empty($table)) { $table="#Unit__#Event_".$module; }

        $eventid=0;
        if ($this->CGI_GETint("ModuleName")=="Events")
        {
            $eventid=$this->CGI_GET("ID");
        }

        if (empty($eventid))
        {
            $eventid=$this->CGI_GETint("Event");
        }

        if (!empty($event))
        {
            $eventid=$event[ "ID" ];
        }

        $table=preg_replace('/#Event/',$eventid,$table);
        return preg_replace('/#Unit/',$this->Unit("ID"),$table);
    }
}
?>