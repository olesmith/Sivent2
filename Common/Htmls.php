<?php

include_once("Htmls/Tags.php");
include_once("Htmls/List.php");
include_once("Htmls/Table.php");
include_once("Htmls/Form.php");
include_once("Htmls/Select.php");
include_once("Htmls/Radios.php");
include_once("Htmls/Hrefs.php");

global $Htmls_Indent_Level;
$Htmls_Indent_Level=0;
    
global $Htmls_Indent;
$Htmls_Indent="   ";
    

trait Htmls
{
    use
        Htmls_Tags,
        Htmls_List,
        Htmls_Table,
        Htmls_Form,
        Htmls_Select,
        Htmls_Radios,
        Htmls_Hrefs;

    var $URL_CommonArgs=NULL;
    
    //*
    //* sub Htmls_Indent_Inc, Parameter list: $n
    //*
    //* Increments $Htmls_Indent value $n.
    //*
    //*

    function Htmls_Indent_Inc($n)
    {
        global $Htmls_Indent_Level;
        $Htmls_Indent_Level+=$n;
    }
    
    //*
    //* sub Htmls_Text, Parameter list: $html
    //*
    //* Converts a list of $html to printable text.
    //*
    //*

    function Htmls_Text($html)
    {
        if (!is_array($html)) { $html=array($html); }
        
        global $Htmls_Indent_Level;
        global $Htmls_Indent;
        
        $text="";
        foreach ($html as $rhtml)
        {
            if (is_array($rhtml))
            {
                $Htmls_Indent_Level++;
                $text.=$this->Htmls_Text($rhtml);
                $Htmls_Indent_Level--;
            }
            else
            {
                $indent="";
                for ($i=0;$i<$Htmls_Indent_Level;$i++)
                {
                    $indent.=$Htmls_Indent;
                }
                
                $text.=$indent.$rhtml."\n";
            }
        }

        return $text;
    }

    //*
    //* sub Htmls_Comment, Parameter list: $comments
    //*
    //* Formats as list of HTML comments
    //*
    //*

    function Htmls_Comments($comments,$calllevel=2)
    {
        if (!is_array($comments)) { $comments=array($comments); }
        
        if (!is_array($comments)) { $comments=array($comments); }
        
        $traces=debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $function="";
        $file="";
        $line="";

        if (count($traces)>$calllevel-1)
        {
            $function=$traces[$calllevel-1][ 'function' ];
            $file=$traces[$calllevel-1][ 'file' ];
            $line=$traces[$calllevel-1][ 'line' ];
        }
        
        if (count($traces)>$calllevel-2)
        {
            $file=$traces[$calllevel-1][ 'file' ];
            $line=$traces[$calllevel-1][ 'line' ];
        }
        
        $comment="                                                                 ";
        array_push
        (
            $comments,
            "Function: ".$function."()",
            "File: ".$file.", line ".$line,
            $comment
        );
        
        array_unshift($comments,$comment);
        
        foreach (array_keys($comments) as $id)
        {
            $comments[ $id ]="<!-- ".$comments[ $id ]." -->";
        }
        
        return $comments;
    }
    
    //*
    //* sub Htmls_Comment_Section, Parameter list: $comment,$html
    //*
    //* Creates a start/end html comments around $html.
    //*
    //*

    function Htmls_Comment_Section($comment,$html)
    {
        return
            array_merge
            (
                $this->Htmls_Comments($comment.": *START*",3),
                $html,
                $this->Htmls_Comments($comment.": **END**",3),
                array("")
            );
    }
}
?>