<?php

class Events_Handle extends Events_Statistics
{
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
        echo
            $this->EventMod_Import_Menu_Horisontal().
            $this->BR().$this->BR().
            $this->MyMod_SubActions_Menu().
            "";
        
        $this->MyMod_SubActions_Groups_Init();

        $this->NonGetVars=array("ID");
        return
            parent::MyMod_Handle_Edit
            (
                $echo,
                $formurl,
                $title,
                $noupdate
            );
    }
}

?>