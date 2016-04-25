<?php


trait MyMod_Actions
{
    //*
    //* function MyMod_Action_IsSingular, Parameter list: $action=""
    //*
    //* Detects whether oMod $action is sinngular or not.
    //*

    function MyMod_HorMenu_IsSingular($action="")
    {
        if (empty($action)) { $action=$this->MyActions_Detect(); }

        if (is_string($action) && !empty($this->Actions[ $action ]))
        {
            $action=$this->Actions[ $action ];
        }

        $res=FALSE;
        if (!empty($action[ "Singular" ]))
        {
            $res=TRUE;
        }

        return $res;
    }
}

?>