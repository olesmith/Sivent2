<?php

class HtmlHref extends HtmlTable
{
    var $URL_CommonArgs=NULL;
//*
//* function HRef, Parameter list: $href,$name,$title,$target,$class="",$noqueryargs=FALSE,$options=array(),$anchor="HorMenu"
//*
//* Creates a href.
//* 
//*

    function HRef($href,$name="",$title="",$target="",$class="",$noqueryargs=FALSE,$options=array(),$anchor="HorMenu")
{
    if ($this->LatexMode()) { return $name; }
    $comps=preg_split('/\?/',$href);

    $href="";
    $args="";
    if (count($comps)>0)
    {
        $href=$comps[0];
        if (count($comps)>1)
        {
            $args=$comps[1];
        }
    }

    $hash=array();
    if (!$noqueryargs) { $hash=$this->CGI_Query2Hash($args); }

    if (count($hash)>0)
    {
        $hiddenargs=$this->MakeHiddenArgs($hash);
    }
    else
    {
        $hiddenargs=$args;
    }

    if ($this->URL_CommonArgs)
    {
         $hiddenargs=$this->URL_CommonArgs."&".$hiddenargs;
    }

    if ($hiddenargs!="")
    {
         $href.="?".$hiddenargs;
    }

    if ($name=="")
    {
        $name=$href;
    }

    if ($this->CGI_Args_Sep!="&")
    {
        $href=preg_replace('/'.$this->CGI_Args_Sep.'/',"&",$href);
        $href=preg_replace('/&/',$this->CGI_Args_Sep,$href);
    }

    $args=$this->CGI_URI2Hash($href);
    $href="?".$this->CGI_Hash2URI($args);
    
    $href=preg_replace('/index.php/',"",$href);

    if (!empty($anchor))
    {
        $href.="#".$anchor;
    }

    $options[ "HREF" ]=$href;
    if ($title!="")  { $options[ "TITLE" ] =$title; }
    if ($target!="") { $options[ "TARGET" ]=$target; }
    if ($class!="")  { $options[ "CLASS" ]=$class; }

    return "<A".$this->Hash2Options($options).">".$name."</A>";
}

//*
//* function HRefList, Parameter list: $links,$titles
//*
//* HRefs a list of links.
//* 
//*

function HRefList($links,$titles,$btitles=array(),$class="menuitem",$inactiveclass="menuinactive",$current="")
{
    if (empty($btitles)) { $btitles=$titles; }

    $rlinks=array();
    for ($n=0;$n<count($links);$n++)
    {
        if (! preg_match("/\S/",$titles[$n]) ) { $titles[$n]=$links[$n]; }
        $rlinks[$n]=$titles[$n];
        if (!empty($links[$n]))
        {
            if ($current!=$titles[$n])
            {
                $rlinks[$n]=$this->HRef($links[$n],$titles[$n],$btitles[$n],"",$class);
            }
            else
            {
                $rlinks[$n]=$this->SPAN($btitles[$n],array("CLASS" => $inactiveclass));
            }
        }
    }

    return $rlinks;
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
    if (is_array($titles) && count($titles)>0)
    {
        $hrefs=$this->HRefList($links,$titles,$btitles,$class,$inactiveclass,$current);
    }
    else
    {
        $hrefs=$links;
    }

    $hhrefs=array();
    $rhrefs=array();
    for ($n=0;$n<count($hrefs);$n++)
    {
        if ($nperline>0 && ($n%$nperline)==($nperline-1))
        {
            $list=$rhrefs;
            array_push($list,$hrefs[$n]);
            array_push($hhrefs,$list);

            $rhrefs=array();
        }
        else
        {
            array_push($rhrefs,$hrefs[$n]."\n");                
        }
    }

    if (count($rhrefs)>0)
    {
        array_push($hhrefs,$rhrefs);
    }

    $hrefs=array();
    foreach ($hhrefs as $id => $rhrefs)
    {
        array_push($hrefs,join(" | ",$rhrefs) );
    }

    if (count($hrefs)>=1)
    {
        $hrefs=join(" ]<BR>[ ",$hrefs);

        if ($title!="")
        {
            $title=$this->SPAN($title,array("CLASS" => $titleclass));
        }

        return $this->CENTER
        (
           $title."\n[ ".$hrefs." ]\n"
        );
    }

    return "";
}

//*
//* function HRefMenu, Parameter list: $links,$titles
//*
//* Returns menu with HRefs (ie links).
//* 
//*

function HRefVerticalMenu($title,$links,$titles=array(),$btitles=array(),$class="")
{
    if (is_array($titles) && count($titles)>0)
    {
        $hrefs=$this->HRefList($links,$titles,$btitles,$class);
    }
    else
    {
        $hrefs=$links;
    }

    if (count($hrefs)>=1)
    {
        return
            $this->B($title)."\n".
            "<BR>\n".
            $this->HtmlList($hrefs).
            "";
    }

    return "";
}


//*
//* function Anchor, Parameter list: $name,$text=""
//*
//* Returns ancher A.
//* 
//*

function Anchor($name,$text="")
{
    return "<A NAME=".$name."></A>".$this->B($text);
}
}


?>