<?php

class HtmlHref extends HtmlTable
{
    //*
    //* function HRef, Parameter list: $href,$name,$title,$target,$class="",$noqueryargs=FALSE,$options=array(),$anchor="HorMenu"
    //*
    //* Creates a href.
    //* 
    //*

    function HRef($href,$name="",$title="",$target="",$class="",$noqueryargs=FALSE,$options=array(),$anchor="HorMenu")
    {
        return 
            $this->Htmls_Text
            (
                $this->Htmls_HRef
                (
                    $href,
                    $name,
                    $title,
                    $class,
                    $args=array
                    (
                        "Target"      => $target,
                        "NoQueryArgs" => $noqueryargs,
                        "Anchor"      => $anchor,
                    ),
                    $options
                )
            );
   }

    //*
    //* function HRefList, Parameter list: $links,$titles
    //*
    //* HRefs a list of links.
    //* 
    //*

    function HRefList($links,$titles,$btitles=array(),$class="menuitem",$inactiveclass="menuinactive",$current="")
    {
        return 
            $this->Htmls_Text
            (
                $this->Htmls_HRef_Menu
                (
                    "method_HRefList",
                    $links,
                    $titles,
                    $args=array
                    (
                        "Class"         => $class,
                        "ClassInactive" => $inactiveclass,
                        "Current"       => $current,
                    ),
                    $btitles
                )
            );
    }

    //*
    //* function HRefMenu, Parameter list: $links,$titles
    //*
    //* Returns menu with HRefs (ie links).
    //* 
    //*

    function HRefMenu($title,$links,$titles=array(),$btitles=array(),$nperline=8,
                  $class="ptablemenu",$inactiveclass="inactivemenuitem",$titleclass="menutitle",
                  $current="")
    {
        return
            $this->Htmls_Text
            (
                $this->Htmls_HRef_Menu
                (
                    "method_HRefList",
                    $title,
                    $links,
                    $titles,
                    $args=array
                    (
                        "NPerLine"      => $nperline,
                        "Class"         => $class,
                        "ClassInactive" => $inactiveclass,
                        "Title"         => $titleclass,
                        "Current"       => $current,
                    ),
                    $btitles
                )
            );
    }
}


?>