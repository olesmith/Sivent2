<?php

include_once("Hrefs/List.php");
include_once("Hrefs/Menu.php");
include_once("Hrefs/Action.php");
include_once("Hrefs/Hiddens.php");
include_once("Hrefs/Options.php");

trait Htmls_Hrefs
{

    use
        Htmls_Hrefs_List,
        Htmls_Hrefs_Menu,
        Htmls_Hrefs_Action,
        Htmls_Hrefs_Hiddens,
        Htmls_Hrefs_Options;
    //*
    //* function Htmls_HRef, Parameter list: $href,$name="",$title="",$class="",$args=array(),$options=array()
    //*
    //* Creates a href.
    //* 
    //*

    function Htmls_HRef($href,$name="",$title="",$class="",$args=array(),$options=array())
    {
        $target="";
        if (isset($args[ "Target" ]))
        {
            $target=$args[ "Target" ];
            unset($args[ "Target" ]);
        }
        
        $noqueryargs=array();
        if (isset($args[ "NoQueryArgs" ]))
        {
            $noqueryargs=$args[ "NoQueryArgs" ];
            unset($args[ "NoQueryArgs" ]);
        }
        
        $anchor="HorMenu";
        if (isset($args[ "Anchor" ]))
        {
            $anchor=$args[ "Anchor" ];
            unset($args[ "Anchor" ]);
        }

        $hash=$this->CGI_URI2Hash($href);
        $args=array_merge($args,$hash);
       
    
        if ($this->LatexMode()) { return $name; }

        return
            $this->Htmls_Tag
            (
                "A",
                $this->Htmls_HRef_Name($href,$name),
                $this->Htmls_HRef_Options
                (
                    $options,
                    $href,
                    $title,
                    $class,
                    $anchor,
                    $args,
                    $noqueryargs,
                    $target
                )
            );
    }
    

    //*
    //* function Htmls_HRef_URI_Path, Parameter list: 
    //*
    //* Path part of URI.
    //*

    function Htmls_HRef_URI_Path($href)
    {
        $path="";
        $comps=preg_split('/\?/',$href);
        if (count($comps)>0)
        {
            $path=$comps[0];
        }

        return $path;        
    }

    //*
    //* function Htmls_HRef_Name, Parameter list: 
    //*
    //* Creates a href args as hash.
    //* 
    //*

    function Htmls_HRef_Name($href,$name)
    {
        if (empty($name))
        {
            $name=$href;
        }

        return $name;
    }
    

}
?>