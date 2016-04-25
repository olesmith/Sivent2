<?php

include_once("../Application/TInterface/CSS.php");
include_once("../Application/TInterface/WindowTitle.php");
include_once("../Application/TInterface/HTMLHead.php");
include_once("../Application/TInterface/Support.php");
include_once("../Application/TInterface/Sponsors.php");
include_once("../Application/TInterface/Head.php");
include_once("../Application/TInterface/Tail.php");
include_once("../Application/TInterface/Icons.php");
include_once("../Application/TInterface/Messages.php");

/* global $HtmlMessages; //global and common for all classes */
/* $HtmlMessages=array(); */

class TInterface extends TInterfaceMessages
{
    var $CSSFile="../MySql2/wooid.css";
    var $HtmlSetupHash,$CompanyHash; 
    var $Modules=array();
    var $PreTextMethod="";
    var $InterfacePeriods=array();
    var $NoTail=1;
    var $HeadersSend=0;
    var $DocHeadSend=0;
    var $HeadSend=0;
    var $HTML=FALSE;
    var $TInterfaceDataMessages="TInterface.php";

    //var $HtmlStatusMessages=array();
    //var $HtmlStatus=array();
    //var $EmailMessage=array();

    //var $TInterfaceTitles=array();
    //var $TInterfaceLatexTitles=array();
    //var $TInterfaceIcons=array();
    //var $TInterfaceLatexIcons=array();

    /* //\* */
    /* //\* sub InitTInterfaceTitles, Parameter list: */
    /* //\* */
    /* //\* Takes default titles from CompanyHash. */
    /* //\* */
    /* //\* */

    /* function InitTInterfaceTitles() */
    /* { */
    /*     return; */
    /*     $this->TInterfaceTitles=array */
    /*     ( */
    /*        $this->CompanyHash[ "Institution" ], */
    /*        $this->CompanyHash[ "Department" ], */
    /*        $this->CompanyHash[ "Address" ], */

    /*        $this->CompanyHash[ "Area" ]. */
    /*        ", ". */
    /*        $this->CompanyHash[ "City" ]. */
    /*        "-". */
    /*        $this->CompanyHash[ "State" ]. */
    /*        ", CEP: ". */
    /*        $this->CompanyHash[ "ZIP" ], */

    /*        $this->CompanyHash[ "Url" ]. */
    /*        " - ". */
    /*        $this->CompanyHash[ "Phone" ]. */
    /*        " - ". */
    /*        $this->CompanyHash[ "Email" ], */
    /*     ); */

    /*     $this->TInterfaceLatexTitles=$this->TInterfaceTitles; */

    /*     $this->TInterfaceIcons=array */
    /*     ( */
    /*        1 => array */
    /*        ( */
    /*           "Icon"   => $this->CompanyHash[ "HtmlIcon1" ], */
    /*           "Height" => "100", */
    /*           "Width"  => "", */
    /*        ), */
    /*        2 => array */
    /*        ( */
    /*           "Icon"   => $this->CompanyHash[ "HtmlIcon2" ], */
    /*           "Height" => "100", */
    /*           "Width"  => "", */
    /*        ), */
    /*     ); */

    /*     $this->TInterfaceLatexIcons=array */
    /*     ( */
    /*        1 => array */
    /*        ( */
    /*           "Icon"   => $this->CompanyHash[ "LatexIcon1" ], */
    /*           "Height" => "", */
    /*           "Width"  => "", */
    /*        ), */
    /*        2 => array */
    /*        ( */
    /*           "Icon"   => $this->CompanyHash[ "LatexIcon2" ], */
    /*           "Height" => "", */
    /*           "Width"  => "", */
    /*        ), */
    /*     ); */

    /* } */
}
?>