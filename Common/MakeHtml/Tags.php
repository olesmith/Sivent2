<?php

// Common HTML tags shorcut functions.


trait MakeHtml_Tags
{
    //*
    //* sub Html_Tag_Start, Parameter list: $tag,$options=array()
    //*
    //* Returns only opening html tag <$tag options> and appends $contents.
    //*
    //*

    function Html_Tag_Start($tag,$options=array())
    {
        return 
            "<".strtoupper($tag).
            $this->Hash2Options($options).">".
            "";
    }
    //*
    //* sub Html_Tag, Parameter list: $tag,$options=array(),$contents=""
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
            $this->Html_Tag_Start($tag,$options).
            $contents.
            "";
    }

    //*
    //* sub Html_Tag_Close, Parameter list: $tag
    //*
    //* Returns only closing html tag </$tag>
    //*
    //*

    function Html_Tag_Close($tag)
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

        return $this->Html_Tag("HR",$options);
    }

    //*
    //* sub Html_BR, Parameter list: $options=array()
    //*
    //* Returns BR tag.
    //*
    //*

    function Html_BR($options=array())
    {
        return $this->Html_Tag("BR",$options);
    }

    //*
    //* sub Html_P, Parameter list: $h,$contents,$options=array()
    //*
    //* Returns H tag.
    //*
    //*

    function Html_P($contents,$options=array())
    {
        return $this->Html_Tags("P",$contents,$options);
    }

    //*
    //* sub Html_H, Parameter list: $h,$contents,$options=array()
    //*
    //* Returns H tag.
    //*
    //*

    function Html_H($h,$contents,$options=array())
    {
        return $this->Html_Tags("H".$h,$contents,$options);
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
        $options[ "CLASS" ]="image";
        if (!empty($alttext))
        {
            $options[ "ALT" ]=$alttext;
        }

        return $this->Html_Tag("IMG",$options);
    }    
}

?>