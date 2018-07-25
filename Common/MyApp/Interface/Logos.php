<?php

//include_once("Tail/Thanks.php");


trait MyApp_Interface_Logos
{
    var $Interface_Logos=array
    (
       1 => array
       (
          "Icon" => "icons/ipredes.png",
          "Height" => "",
          "Width" => "150",
       ),
       2 => array
       (
          "Icon" => "icons/owl2.svg",
          "Height" => "",
          "Width" => "150",
       ),
    );

    var $Interface_Logos_Latex=array
    (
       1 => array
       (
          "Icon" => "icons/ipredes.png",
          "Height" => "",
          "Width" => "",
       ),
       2 => array
       (
          "Icon" => "icons/owl.png",
          "Height" => "",
          "Width" => "",
       ),
    );
    //*
    //* sub MyApp_Interface_Logo_Get, Parameter list: $n
    //* 
    //* Returns as string left ($n=1) resp. right ($n=2) icons. 
    //*

    function MyApp_Interface_Logo_Get($n)
    {
        $key='HtmlIcon'.$n;

        $icon=$this->Interface_Logos[ $n ][ "Icon" ];
        if (!empty($this->CompanyHash[ $key ]))
        {
            $icon=$this->CompanyHash[ $key ];
        }

        return $icon;
    }
    

    //*
    //* sub MyApp_Interface_Logo, Parameter list: $n
    //* 
    //* Returns left ($n=1) resp. right ($n=2) icons. 
    //*

    function MyApp_Interface_Logo($n)
    {
        $options=
            array
            (
                "BORDER" => 0,
                "ALT" => 'Logo',
            );

        foreach (array("Height","Width") as $key)
        {
            if (!empty($this->Interface_Logos[ $n ][ $key ]))
            {
                $options[ strtoupper($key) ]=$this->Interface_Logos[ $n ][ $key ];
            }
        }
        
        return
            $this->Html_IMG
            (
                $this->MyApp_Interface_Logo_Get($n),
                "Logo",
                $options
            );
    }
}

?>