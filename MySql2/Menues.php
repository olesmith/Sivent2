<?php


class Menues extends Export
{
    var $Menu=array();
    var $MenuMessages="Menues.php";
    var $LeftMenuPostTextMethod="";
    var $DataGroupMenuWritten=FALSE;
    var $NoInterfaceMenu=FALSE;
    var $NoLogonMenu=TRUE;

    var $HorisontalMenues=array("Singular","Plural","SingularPlural","ActionsSingular","ActionsPlural",);

    //*
    //* function InitMenues, Parameter list:
    //*
    //* Initilizes Menus class, that is herits horisontal menues from ProfileHash;.
    //*

    function InitMenues()
    {
        if (empty($this->ProfileHash[ "Menues" ])) { return; }

        foreach (array_keys($this->ProfileHash[ "Menues" ]) as $id => $menu)
        {
            $varname="Actions".$menu;
            $this->$varname=$this->ProfileHash[ "Menues" ][ $menu ];
       }
    }



    //*
    //* function SystemMenu, Parameter list: 
    //*
    //* Prints horisontal system menu.
    //*

    function SystemMenu()
    {
        echo $this->MyMod_HorMenu_Actions(array("Backup","SysInfo","Process","Profiles","Zip"),"atablemenu","");
    }
}
?>