<?php

include_once("../Base/File.php");
include_once("../Base/Dir.php");
include_once("Language.php");
include_once("Time.php");
include_once("Filters.php");
include_once("Base.php");
include_once("OptionTable.php");
include_once("Zip.php");
include_once("../Base/Mail.php");
include_once("Log.php");
include_once("Html/Form.php");


class Html extends HtmlForm
{
    #var $URL;
    var $LatexMode=FALSE;
    var $HiddenVars=array();
    var $IconsPath="icons";

    var $MessageList=array();
    var $ExtraPathVars=array();
    var $HtmlMessages="Html.php";

    //*
    //* function LatexMode, Parameter list: $name,$value
    //*
    //* Creates and args hash with hidden args and their values.
    //* 
    //*

    function LatexMode($hash=array())
    {
        if (isset($this->ApplicationObj->LatexMode) && $this->ApplicationObj->LatexMode) { return TRUE; }
        if (isset($this->LatexMode) && $this->LatexMode) { return TRUE; }

        return FALSE;
    }

    //*
    //* function MakeHiddenHash, Parameter list: $name,$value
    //*
    //* Creates and args hash with hidden args and their values.
    //* 
    //*

    function MakeHiddenHash($hash=array())
    {
        $hiddens=$this->HiddenVars;

        $rhash=array();
        for ($n=0;$n<count($hiddens);$n++)
        {
            $rhash[ $hiddens[$n] ]=$this->GetCGIVarValue($hiddens[$n]);
        }

        foreach ($hash as $key => $value) { $rhash[ $key ]=$hash[ $key ]; }

        return $rhash;
    }


    //*
    //* function MakeHiddens, Parameter list: $name,$value
    //*
    //* Creates the HIDDEN fields in class array HiddenVars.
    //* 
    //*

    function MakeHiddenArgs($hash=array())
    {
        $hash=$this->MakeHiddenHash($hash);
        return $this->CGI_Hash2Query($hash);
    }

    function FindIconsPath()
    {
        //Set if not detected
        if (empty($this->IconsPath))
        {
            $script=$_SERVER[ "SCRIPT_NAME" ];
            $paths=preg_split('/[\/]/',$script);
            //array_pop($paths);

            $spath="/";
            $found=0;
            $n=0;

            //Looping up through path, untill $spath/$icons is found (max 10...)
            //Paths in the filesystem!
            while ($n<10 && $found==0)
            {
                if (is_dir($spath."/icons")) { $found=1; }
                else                        { $spath="../".$spath; }

                $n++;
            }

            //Take Extra Path Information into consideration,
            //since relative links changes using this feature
            //One up (../)  per / in path info
            $pathinfos=$this->GetExtraPathInfos();
            for ($n=0;$n<count($pathinfos);$n++)
            {
                $spath="../".$spath;
            }

            $this->IconsPath=$spath."icons";
        }
     
        return $this->IconsPath;
    }

}


?>