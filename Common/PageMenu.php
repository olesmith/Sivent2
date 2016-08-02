<?php

trait PageMenu
{
    //*
    //* function PageMenu, Parameter list: $npages,$args=array(),$nlinksperline=10
    //*
    //* Creates paging menu.
    //*

    function PageMenu($npages,$args=array(),$nlinksperline=10)
    {
        if (empty($args)) { $args=$this->CGI_Query2Hash(); }

        $hrefs=array();
        for ($n=1;$n<=$npages;$n++)
        {
            $args[ "Page" ]=$n;
            array_push
            (
               $hrefs,
               $this->HRef("?".$this->CGI_Hash2Query($args),$n)
            );
        }
        $hrefs=$this->MyHashes_Page($hrefs,$nlinksperline);

        $html="";
        foreach ($hrefs as $page => $phrefs)
        {
            $html.="[ ".join(" | ",$phrefs)." ]<BR>";
        }

        return $this->Center($html);
    }
}

?>