<?php


trait MyActions_Error
{
    //*
    //* function MyAction_Error, Parameter list: $msg,$action
    //*
    //*

    function MyAction_Error($msg,$action)
    {
        $info=array();

        if (is_array($action))                    { $info=$action; $action=$action[ "Action" ]; }
        elseif (isset($this->Actions[ $action ])) { $info=$this->Actions[ $action ]; }
        elseif (isset($this->ApplicationObj()->Actions[ $action ])) { $info=$this->ApplicationObj()->Actions[ $action ]; }

        $this->MyMessage_Die
        (
           $msg.": ".$action." ".$this->LoginType,
           $info
        );
    }
}
?>