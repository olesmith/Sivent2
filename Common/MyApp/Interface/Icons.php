<?php

//include_once("Tail/Thanks.php");


trait MyApp_Interface_Icons
{
    var $Interface_Icons=array
    (
       1 => array
       (
          "Icon" => "icons/ipredes.png",
          "Height" => "",
          "Width" => "150",
       ),
       2 => array
       (
          "Icon" => "icons/sade_owl2.png",
          "Height" => "",
          "Width" => "150",
       ),
    );

    var $Interface_Icons_Latex=array
    (
       1 => array
       (
          "Icon" => "icons/ipredes.png",
          "Height" => "",
          "Width" => "",
       ),
       2 => array
       (
          "Icon" => "icons/sade_owl2.png",
          "Height" => "",
          "Width" => "",
       ),
    );
    //*
    //* sub MyApp_Interface_Icon_Get, Parameter list: $n
    //* 
    //* Returns as string left ($n=1) resp. right ($n=2) icons. 
    //*

    function MyApp_Interface_Icon_Get($n)
    {
        $key='HtmlIcon'.$n;

        $icon=$this->Interface_Icons[ $n ][ "Icon" ];
        if (!empty($this->CompanyHash[ $key ]))
        {
            $icon=$this->CompanyHash[ $key ];
        }

        return $icon;
    }
    

    //*
    //* sub MyApp_Interface_Icon, Parameter list: $n
    //* 
    //* Returns left ($n=1) resp. right ($n=2) icons. 
    //*

    function MyApp_Interface_Icon($n)
    {
        return $this->Center
        (
           $this->Img
           (
              $this->MyApp_Interface_Icon_Get($n),
              "",
              $this->Interface_Icons[ $n ][ "Height" ],
              $this->Interface_Icons[ $n ][ "Width" ],
              array
              (
                 "BORDER" => 0,
                 "ALT" => 'Logo',
              )
           )
        );
    }
}

?>