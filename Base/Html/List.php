<?php

class HtmlList extends HtmlTags
{
    //*
    //* function HtmlList , Parameter list: $list,$ul,$options=array(),$lioptions=array()
    //*
    //* Prints a HTML list (UL) with elements in $list
    //* 
    //*

    function HtmlList($list,$ul="UL",$options=array(),$lioptions=array())
    {
        if (count($list)==0) { return ""; }

        if ($this->LatexMode())
        {
            if ($ul=="UL") { $ul="itemize"; }
            else           { $ul="enumerate"; }

            return $this->LatexList($list,$ul);
        }
        else
        {
            return $this->HtmlTags
            (
               $ul,
               $this->HtmlTagList($list,"LI",$lioptions),
               $options
            );
        }
    }

}


?>