<?php


trait MyApp_Interface_Head_LINKs
{    
    //*
    //* sub MyApp_Interface_LINKs, Parameter list:
    //*
    //* Returns interface LINK tags.
    //*
    //*

    function MyApp_Interface_LINKs()
    {
        return
            array_merge
            (
                $this->MyApp_Interface_LINKs_Gen(),
                $this->MyApp_Interface_ShortCut_LINK_Icon(),
                $this->MyApp_Interface_CSS_OnLine()
            );
    }
    
    
    //*
    //* sub MyApp_Interface_LINKs_Gen, Parameter list:
    //*
    //* Returns interface LINK tags.
    //*
    //*

    function MyApp_Interface_LINKs_Gen()
    {
        $links=array();
        foreach ($this->MyApp_Interface_Head_Links as $hash)
        {
            array_push
            (
                $links,
                $this->HtmlTag
                (
                    "LINK",
                    "",
                    $hash
                )
            );
        }

        return $links;
    }
    
    //*
    //* sub MyApp_Interface_ShortCut_LINK_Icon, Parameter list:
    //*
    //* Returns interface header short cut icon entry.
    //*
    //*

    function MyApp_Interface_ShortCut_LINK_Icon()
    {
        return
            array
            (
                $this->HtmlTag
                (
                    "LINK",
                    "",
                    array
                    (
                        "REL"  => 'shortcut icon',
                        "HREF" => "icons/favicon.ico",
                        "TYPE" => "image/x-icon",
                    )
                ),
                $this->HtmlTag
                (
                    "LINK",
                    "",
                    array
                    (
                        "REL"  => 'icon',
                        "HREF" => "icons/favicon.ico",
                        "TYPE" => "image/x-icon",
                    )
                ),
            );
    }
  
    
}

?>