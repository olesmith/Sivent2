<?php

class TInterfaceWindowTitle extends TInterfaceCSS
{
    //*
    //* sub ApplicationWindowTitle, Parameter list:
    //*
    //* Simply returns application window title. 
    //* Supposed to be overwritten!
    //*
    //*

    function ApplicationWindowTitle()
    {
        $id=$this->GetGET("ID");

        $vals=array();
        if ($this->Module)
        {
            if ($id!="" && $id>0)
            {
                array_push($vals,$this->Module->ItemName);
            }
            else
            {
                array_push($vals,$this->Module->ItemsName);
            }
        }

        foreach ($this->ExtraPathVars as $id => $var)
        {
            if ($this->$var!="")
            {
                array_push($vals,$this->$var);
            }
        }

        $title=$this->HtmlSetupHash[ "WindowTitle" ]."::";
        $action=$this->MyActions_Detect();
        if ($this->Module)
        {
            if (!empty($action) && isset($this->Module->Actions[ $action ]))
            {
                $action=$this->GetRealNameKey($this->Module->Actions[ $action ],"Name");

                $action=preg_replace('/#ItemsName/',$this->Module->ItemsName,$action);
                $action=preg_replace('/#ItemName/',$this->Module->ItemsName,$action);
                $id=$this->GetGET("ID");
                if ($id!="" && $id>0)
                {
                    $name=$this->Module->GetItemName($this->Module->ItemHash);
                    array_push($vals,$name);
                }
            }
        }
        else
        {
            array_push($vals,$action);
        }

        return 
            $title.
            join("::",$vals).
            "";
    }
}
?>