<?php


trait MyMod_Items_Menu
{
    //*
    //* Creates menu with with links to $items
    //*

    function MyMod_Items_Menu_HRefs($args,$items,$argskey,$idkey="ID",$namekeys=array(),$titlekeys=array(),$title="",$current=0,$anchor="")
    {
        if (empty($namekeys)) { $namekeys=array("Name"); }
        
        if (!is_array($namekeys))
        {
            $namekeys=array($namekeys);
        }
        
        if (!empty($titlekeys) && !is_array($titlekeys))
        {
            $titlekeys=array($titlekeys);
        }

        if (empty($current))
        {
            $current=$this->CGI_GETint($argskey);
        }

        $hrefs=array();
        foreach ($items as $id => $item)
        {
            $name=
                join
                (
                    " - ",
                    $this->MyHash_Values_Get($item,$namekeys)
                );
            
            $href=$name;
            if (empty($current) || $current!=$item[ $idkey ])
            {
                $args[ $argskey ]=$item[ $idkey ];

                $href=
                    $this->Href
                    (
                       "?".$this->CGI_Hash2URI($args),
                       $name,
                       join
                       (
                           " - ",
                           $this->MyHash_Values_Get($item,$titlekeys)
                       ),
                       "",
                       "",
                       False,
                       array(),
                       $anchor
                    );
            }
            
            array_push($hrefs,$href);
        }

        return $hrefs;        
    }
    
    //*
    //* Creates menu with with links to $items
    //*

    function MyMod_Items_Menu_Horisontal($args,$items,$argskey,$idkey="ID",$namekeys=array(),$titlekeys=array(),$title="",$current=0,$anchor="")
    {
        return
            $this->HRefMenu
            (
                $title,
                $this->MyMod_Items_Menu_HRefs
                (
                    $args,
                    $items,
                    $argskey,
                    $idkey,
                    $namekeys,
                    $titlekeys,
                    $title,
                    $current,
                    $anchor
                )
            );
        
    }

    //*
    //* Creates menu with with links to $items
    //*

    function MyMod_Items_Menu($args,$items,$argskey,$idkey="ID",$namekeys=array(),$titlekeys=array())
    {
        return
            $this->MyMod_Items_Menu_Horisontal
            (
                $args,
                $items,
                $argskey,
                $idkey,
                $namekeys,
                $titlekeys,
                $this->B($this->MyMod_ItemsName().":")
            ).
            "";
        
    }


}

?>