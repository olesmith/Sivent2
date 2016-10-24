<?php


trait MyMod_Items_Menu
{
    //*
    //* Creates menu with with links to $items
    //*

    function MyMod_Items_Menu($args,$items,$argskey,$idkey="ID",$titlekey="Name")
    {
        $current=$this->CGI_GETint($argskey);
        
        $hrefs=array();
        foreach ($items as $id => $item)
        {
            $href=$item[ $titlekey ];
            if ($current!=$item[ $idkey ])
            {
                $args[ $argskey ]=$item[ $idkey ];
                $href=
                    $this->Href
                    (
                       "?".$this->CGI_Hash2URI($args),
                       $item[ $titlekey ]
                     );
             }
            
            array_push($hrefs,$href);
        }

        return
            $this->HRefMenu
            (
               $this->B($this->MyMod_ItemsName().":"),
               $hrefs
            );
        
    }


}

?>