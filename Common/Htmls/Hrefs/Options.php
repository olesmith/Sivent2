<?php


trait Htmls_Hrefs_Options
{
    //*
    //* function Htmls_HRef_Options, Parameter list: 
    //*
    //* Creates a href options as hash.
    //* 
    //*

    function Htmls_HRef_Options($options,$href,$title,$class,$anchor,$args,$noqueryargs,$target)
    {
        $options[ "HREF" ]=
            $this->Htmls_HRef_URI_Path($href).
            $this->Htmls_HRef_Action
            (
                $href,
                $args,
                $anchor,
                $noqueryargs
            );


        if (!empty($title))  { $options[ "TITLE" ] =$title; }
        if (!empty($target)) { $options[ "TARGET" ]=$target; }
        if (!empty($class))  { $options[ "CLASS" ]=$class; }
        if (!empty($target)) { $options[ "TARGET" ]=$target; }

        return $options;
    }
}
?>