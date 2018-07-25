<?php


trait MyApp_Interface_Head_METAs
{    
    //*
    //* sub MyApp_Interface_METAs, Parameter list:
    //*
    //* Returns interface header META section
    //*
    //*

    function MyApp_Interface_METAs()
    {
        return array
        (
            $this->HtmlTag
            (
               "META",
               "",
               array
               (
                  "HTTP-EQUIV" => 'Content-type',
                  "CONTENT"    => "text/html; charset=".$this->HtmlSetupHash[ "CharSet"  ],
               )
            ),
             $this->HtmlTag
             (
                "META",
                "",
                array
                (
                   "NAME"    => 'Autor',
                   "CONTENT" => $this->HtmlSetupHash[ "Author"  ],
                )
             )
        );
    }
    
    
    
    
}

?>