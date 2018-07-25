<?php

include_once("HorMenu/Action.php");
include_once("HorMenu/Help.php");
include_once("HorMenu/Info.php");

trait MyMod_HorMenu
{
    var $MyMod_HorMenu_Send=0;

    use 
        MyMod_HorMenu_Action,
        MyMod_HorMenu_Info;

    //*
    //* function MyMod_HorMenu_Echo, Parameter list: $plural=FALSE,$id=""
    //*
    //* Prints horisontal menu of Singular and Plural actions.
    //*

    function MyMod_HorMenu_Echo($plural=FALSE,$id="")
    {
        if ($this->MyMod_HorMenu_Send!=0) { return; }

        $singular=$this->MyMod_HorMenu_IsSingular();

        if (method_exists($this->ApplicationObj(),"PreInterfaceMenu"))
        {
            $this->ApplicationObj()->PreInterfaceMenu(!$singular,$id);
        }
        elseif (method_exists($this,"PreInterfaceMenu"))
        {
            $this->PreInterfaceMenu(!$singular,$id);
        }

        echo
            $this->Htmls_Text
            (
                array
                (
                    $this->Htmls_DIV
                    (
                        $this->MyMod_HorMenu_Gen(!$singular,$id),
                        array
                        (
                            "ID" => "HorMenu",
                            "CLASS" => "center tablemenu",
                        )
                    )
                )
            );
        
        if (method_exists($this,"PostInterfaceMenu"))
        {
            $this->PostInterfaceMenu(!$singular,$id);
        }
        elseif (method_exists($this->ApplicationObj(),"PostInterfaceMenu"))
        {
            $this->ApplicationObj()->PostInterfaceMenu(!$singular,$id);
        }

        $this->MyMod_HorMenu_Send=1;
    }

    //*
    //* function MyMod_HorMenu_Gen, Parameter list: $plural=FALSE,$id=""
    //*
    //* Returns horisontal menu of Singular and Plural actions.
    //*

    function MyMod_HorMenu_Gen($plural=FALSE,$id="")
    {
        return array
        (
            $this->Htmls_Comment_Section
            (
                "Horisontal Menu",
                $this->Htmls_Tag
                (
                    "NAV",
                    array_merge
                    (
                        $this->ApplicationObj()->MyApp_Module_Group_Menu_Horisontal($this),
                        $this->MyMod_HorMenu_Menues(!$plural,$id)
                    )
                )
            )
        );
    }



    //*
    //* function MyMod_HorMenu_Menues, Parameter list: $singular,$id=""
    //*
    //* Returns horisontal menues of Singular or Plural actions.
    //*

    function MyMod_HorMenu_Menues($singular,$id="")
    {
        $menues=array();
        foreach ($this->MyMod_HorMenu_Get($singular) as $cssclass => $menu)
        {
            if (count($menu)>0)
            {
                array_push
                (
                   $menues,
                   $this->MyMod_HorMenu_Actions($menu,$cssclass,$id)
                );
            }
        }

        return $menues;
    }

    //*
    //* function MyMod_HorMenu_Get, Parameter list: $singular
    //*
    //* Return HorMenu Plural or Singular menus.
    //*

    function MyMod_HorMenu_Get($singular)
    {
        if ($singular)
        {
            return $this-> MyMod_HorMenu_Singulars();
        }
        else
        {
            return $this->MyMod_HorMenu_Plurals();
        }
    }
 
    //*
    //* function MyMod_HorMenu_Menu_Actions, Parameter list: $menu
    //*
    //* Returns actions for $menu.

    function MyMod_HorMenu_Menu_Actions($menu)
    {
        return $this->ProfileHash[ "Menues" ][ $menu ];
    }

    //*
    //* function MyMod_HorMenu_Singulars, Parameter list: 
    //*
    //* Return HorMenu Singular menus.
    //*

    function MyMod_HorMenu_Singulars()
    {
        return array
        (
           "sptablemenu" => $this->MyMod_HorMenu_Menu_Actions("SingularPlural"),
           "atablemenu"  => $this->MyMod_HorMenu_Menu_Actions("ActionsSingular"),
           "stablemenu"  => $this->MyMod_HorMenu_Menu_Actions("Singular"),
        );
    }

    //*
    //* function MyMod_HorMenu_Plurals, Parameter list: 
    //*
    //* Return HorMenu Plural menus.
    //*

    function MyMod_HorMenu_Plurals()
    {
        $plurals=$this->MyMod_HorMenu_Menu_Actions("Plural");
        if (preg_match('/^Admin$/',$this->Profile()))
        {
            array_push($plurals,"Info");
        }
        
        return array
        (
           "sptablemenu" => $this->MyMod_HorMenu_Menu_Actions("SingularPlural"),
           "ptablemenu"  => $plurals,
           "atablemenu"  => $this->MyMod_HorMenu_Menu_Actions("ActionsPlural"),
        );
    }
}

?>