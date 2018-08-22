<?php


trait Htmls_Hrefs_Menu
{    
    //*
    //* function Htmls_HRef_Menu, Parameter list: $links,$titles
    //*
    //* Returns menu with HRefs (ie links), listed version.
    //* 
    //*

    function Htmls_HRef_Menu($id,$title,$links,$titles=array(),$args=array(),$btitles=array())
    {
        $nperline=8;
        if (!empty($args[ "NPerLine" ])) { $nperline=$args[ "NPerLine" ]; }
        
        $class="ptablemenu";
        if (!empty($args[ "Class" ])) { $class=$args[ "Class" ]; }
        
        $inactiveclass="inactivemenuitem";
        if (!empty($args[ "ClassInactive" ])) { $inactiveclass=$args[ "ClassInactive" ]; }
        
        $title="menutitle";
        if (!empty($args[ "Title" ])) { $titleclass=$args[ "Title" ]; }
        
        $current="";
        if (!empty($args[ "Current" ])) { $current=$args[ "Current" ]; }
        
        if (is_array($titles) && count($titles)>0)
        {
            $hrefs=
                $this->Htmls_HRef_List
                (
                    $links,
                    $titles,
                    $args=array
                    (
                        "Class" => $class,
                        "ClassInactive" => $inactiveclass,
                        "Current" => $current,
                    ),
                    $btitles
                );
        }
        else
        {
            $hrefs=$links;
        }

        return
            $this->Htmls_Tag
            (
                "DIV",
                $this->Htmls_List($hrefs),
                array
                (
                    "ID" => $id,
                    "CLASS" => "tabs is-centered is-fullwidth"
                )
            );
    }
}
?>