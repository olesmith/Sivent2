<?php

class Events_Handle extends Events_SubActions
{
    //*
    //* function MyMod_Handle_Event_Menu, Parameter list: 
    //*
    //* Creates horisontal menu with access to different SGroups.
    //*

    //*
    //* function MyMod_Handle_Show, Parameter list: $title
    //*
    //* Overrides module object Show handler.
    //*

    function MyMod_Handle_Show($title="")
    {
        echo $this->MyMod_SubActions_Menu();

        $this->MyMod_SubActions_Groups_Init();

        return parent::MyMod_Handle_Show($title);
    }

    //*
    //* function MyMod_Handle_Edit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
    //*
    //* Overrides module object Edit handler.
    //*

    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
    {
        echo $this->MyMod_SubActions_Menu();

        $this->MyMod_SubActions_Groups_Init();

        return parent::MyMod_Handle_Edit($echo,$formurl,$title,$noupdate);
    }
}

?>