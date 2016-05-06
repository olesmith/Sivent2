<?php

include_once("MakeCGI.php");
include_once("MakeOptions.php");

include_once("MakeHtml/Input.php");
include_once("MakeHtml/Tags.php");

trait MakeHtml
{
    use
        MakeOptions,MakeCGI,
        MakeHtml_Tags,
        MakeHtml_Input;

    //*
    //* sub Html_Tag, Parameter list: $tag,$options=array(),$contents="
    //*
    //* Returns only opening html tag <$tag options> and appends $contents.
    //*
    //*

    function Html_Tag($tag,$options=array(),$contents="")
    {
        if (is_array($contents))
        {
            $contents=join("\n",$contents);
        }

        return 
            "<".strtoupper($tag).
            $this->Hash2Options($options).">".
            $contents;
    }

    //*
    //* sub Html_CloseTag, Parameter list: $tag
    //*
    //* Returns only closing html tag </$tag>
    //*
    //*

    function Html_CloseTag($tag)
    {
        return "</".strtoupper($tag).">";
    }

    //*
    //* sub Html_Tags, Parameter list: $tag,$contents,$options=array()
    //*
    //* Returns matching html tags <$tag>$contents</$tag>
    //*
    //*

    function Html_Tags($tag,$contents,$options=array())
    {
        $tag=strtoupper($tag);
        if (is_array($contents)) { $contents="\n".join("\n",$contents); }

        return 
            "<".$tag.
            $this->Options_FromHash($options).">".
            $contents.
            "</".$tag.">";
    }

    //*
    //* sub Html_HR, Parameter list: $width,$options=array()
    //*
    //* Returns HR tag.
    //*
    //*

    function Html_HR($width,$options=array())
    {
        $options[ "WIDTH" ]=$width;

        return $this->Html_Tag("HR",$options)."\n";
    }

    //*
    //* sub Html_BR, Parameter list: $options=array()
    //*
    //* Returns BR tag.
    //*
    //*

    function Html_BR($options=array())
    {
        return $this->Html_Tag("BR",$options)."\n";
    }

    //*
    //* sub Html_IMG, Parameter list: $src,$alttext="",$options=array()
    //*
    //* Returns IMG tag.
    //*
    //*

    function Html_IMG($src,$alttext="",$options=array())
    {
        $options[ "SRC" ]=$src;
        if (!empty($alttext))
        {
            $options[ "ALT" ]=$alttext;
        }

        return $this->Html_Tag("IMG",$options)."\n";
    }

}
?>