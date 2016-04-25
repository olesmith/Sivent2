<?php


trait ItemsFormContents
{
    //*
    //* function ItemsForm_DataGroupsMenu, Parameter list:
    //*
    //* Generates horisontl menu with links to data groups.
    //* 
    //*

    function ItemsForm_DataGroupsMenu()
    {
        if ($this->Args[ "GroupsMenu" ])
        {
            $args=$this->CGI_URI2Hash();
            foreach ($this->Args[ "IgnoreGETVars" ] as $key) { unset($args[ $key ]); }
            foreach ($this->Args[ "DetailsAddVars" ] as $key) { $args[ $key ]=$this->CGI_GET($key); }

            return
                $this->DataGroupsMenu($this->B("Dados: "),$args).
                $this->BR().
                "";
        }

        return "";
    }

    //*
    //* function ItemsForm_Contents, Parameter list:
    //*
    //* Generates table listing, with possible edit row - and add row.
    //* 
    //*

    function ItemsForm_Contents()
    {
        return
            $this->H(2,$this->Args[ "FormTitle" ]).
            $this->Anchor("TOP").
            $this->ItemsForm_DataGroupsMenu().
            $this->BR().
            $this->Table_Html($this->Args).
            "";
    }

}

?>