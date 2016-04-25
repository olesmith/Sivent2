<?php

trait Iconss
{
    //var $Icons="icons/";

    function FindIconsPath_000()
    {
        $this->Icons="icons/";

        /* //Set if not detected */
        /* if (empty($this->Icons)) */
        /* { */
        /*     $script=$_SERVER[ "SCRIPT_NAME" ]; */
        /*     $paths=preg_split('/[\/]/',$script); */
        /*     array_pop($paths); */

        /*     $spath="/"; */
        /*     $found=0; */
        /*     $n=0; */

        /*     //Looping up through path, untill $spath/$icons is found (max 10...) */
        /*     //Paths in the filesystem! */
        /*     while ($n<10 && $found==0) */
        /*     { */
        /*         if (is_dir($spath."icons")) { $found=1; } */
        /*         else                        { $spath="../".$spath; } */

        /*         $n++; */
        /*     } */

        /*     //Take Extra Path Information into consideration, */
        /*     //since relative links changes using this feature */
        /*     //One up (../)  per / in path info */
        /*     $pathinfos=$this->GetExtraPathInfos(); */
        /*     for ($n=0;$n<count($pathinfos);$n++) */
        /*     { */
        /*         $spath="../".$spath; */
        /*     } */

        /*     $this->Icons=$spath."icons"; */
        /* } */
     
        return $this->Icons;
    }


    //*
    //* sub GetHtmlIcon, Parameter list: $n
    //*
    //* 
    //*
    //*

    function GetHtmlIcon($n)
    {
        $key='HtmlIcon'.$n;

        $icon="";
        if (!empty($this->UnitHash[ $key ]))
        {
            $icon=$this->UnitHash[ $key ];
        }

        if (empty($icon) && !empty($this->CompanyHash[ $key ]))
        {
            $icon=$this->CompanyHash[ $key ];
        }

        return $this->Center
        (
           $this->Img
           (
              $this->TInterfaceIcons[ $n ][ "Icon" ],
              "",
              $this->TInterfaceIcons[ $n ][ "Height" ],
              $this->TInterfaceIcons[ $n ][ "Width" ],
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