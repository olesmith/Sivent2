<?php

include_once("Input/CheckButton.php");
include_once("Input/RadioButton.php");
include_once("Input/Select.php");

class HtmlInput extends HtmlSelect
{

//*
//* function MakeButton, Parameter list: $type,$title,$options=array()
//*
//* Creates a form button.
//* 
//*

function MakeButton($type,$title,$options=array())
{
    return $this->Html_Input_Button_Make($type,$title,$options);
    
    /* if ($type=="") { return "<BUTTON>$title</BUTTON>\n"; } */

    /* $options[ "TYPE" ]=$type; */
    /* $html="<BUTTON".$this->Hash2Options($options).">$title</BUTTON>\n"; */

    /* return $html; */
}

//*
//* function MakeButtons, Parameter list: $defs,$options=array()
//*
//* Creates a form button list.
//* 
//*

function MakeButtons($defs,$options=array())
{
    return $this->Html_Input_Buttons_Make($defs,$options=array());
}


//*
//* function MakeInput, Parameter list: $name,$value,$options,$size
//*
//* Creates an	INPUT field.
//* 
//*

function MakeInput($name,$value="",$size=10,$options=array())
{
    global $NFields;
    $NFields++;

    $options[ "Type" ]="text";
    $options[ "NAME" ]=$name;
    $options[ "ID" ]="Input".$NFields;
    $options[ "VALUE" ]=$value;
    $options[ "SIZE" ]=$size;

    return "<INPUT".$this->Hash2Options($options).">\n";
}

//*
//* function MakePassword, Parameter list: $name,$value,$size=8,$maxsize=0,$options=array()
//*
//* Creates a	PASSWORD field.
//* 
//*

function MakePassword($name,$value,$size=8,$maxsize=0,$options=array())
{
    global $NFields;
    $NFields++;

    $options[ "Type" ]="password";
    $options[ "NAME" ]=$name;
    $options[ "ID" ]="Input".$NFields;
    $options[ "VALUE" ]=$value;
    $options[ "SIZE" ]=$size;
    if ($maxsize>0)
    {
        $options[ "MAXSIZE" ]=$maxsize;
    }

    return "<INPUT".$this->Hash2Options($options).">\n";
}


//*
//* function MakeHidden, Parameter list: $name,$value,$options=array()
//*
//* Creates a	HIDDEN field.
//* 
//*

function MakeHidden($name,$value="",$options=array())
{
    /* if ($value=="") */
    /* { */
    /*     var_dump("GET$name ".$value); */
    /*     $value=$this->GetCGIVarValue($name); */
    /* } */

    $options[ "TYPE" ]='hidden';
    $options[ "NAME" ]=$name;
    $options[ "VALUE" ]=$value;

    return "<INPUT".$this->Hash2Options($options).">\n";
}

//*
//* function POST2Hiddens, Parameter list: $vars,$values=array()
//*
//* Returns a list of hidden fields, all values read from POST.
//* 
//*

function POST2Hiddens($vars,$values=array())
{
    $hiddens=array();
    foreach ($vars as $var)
    {
        $value="";
        if (isset($values[ $var ]))
        {
            $value=$values[ $var ];
        }
        else
        {
            $value=$this->GetPOST($var);
        }

        array_push
        (
           $hiddens,
           $this->MakeHidden($var,$value)
       );
    }

    return join("",$hiddens);
}

//*
//* sub MakeFileField, Parameter list: $name,$name,$options=array()
//*
//* Creates FILE input element.
//*
//*

function MakeFileField($name,$options=array())
{
    if (!isset($options[ "SIZE" ]))
    {
        $options[ "SIZE" ]=25;
    }

    return "<INPUT TYPE='FILE' NAME='".$name."'".$this->Hash2Options($options).">\n";
}

//*
//* function MakeTextArea, Parameter list: $name,$rows,$cols,$value
//*
//* Creates a	TEXTAREA field.
//* 
//*

function MakeTextArea($name,$rows,$cols,$value,$wrap="physical",$options=array())
{
    $html=
        "<TEXTAREA NAME='".$name."' ".
        "COLS='".$cols."' ".
        "ROWS='".$rows."' ".
        "WRAP='".$wrap."' ".
        $this->Hash2Options($options).
        ">\n";

    if (is_array($value))
    {
        for ($n=0;$n<count($value);$n++)
        {
            chop($value[$n]);
            $html.=$value[$n]."\n";
        }
    }
    else
    {
        $html.=$value."\n";
    }
    $html.="</TEXTAREA>\n";

    return $html;
}


//*
//* function HtmlDateInputField, Parameter list: $name,$date="",$options=array()
//*
//* Creates suitable date input field (text).
//* Humans write dd/mm/yyyy, but for computing yyyymmdd is far better,
//* major reason: readily searched and  sorted!
//*
//* Given yyyymmdd (or current date, TimeStamp2DateSort), converts to
//* and presents inpout field with value dd/mm/yyyy.
//*

function HtmlDateInputField($name,$date="",$options=array())
{
    //if (empty($date) && $this->ItemData[ $date ][ "Default" ]=="today") { $date=$this->TimeStamp2DateSort(); }

    if (empty($options[ "TITLE" ]))
    {
        $options[ "TITLE" ]="dd/mm/yyyy - /mm/yyyy para todos os dias do mês...";
    }

    if (!preg_match('/\//',$date))
    {
        $date=$this->SortTime2Date($date);
    }

    return $this->MakeInput
    (
       $name,
       $date,
       10,
       $options
    );
}


//*
//* function HtmlDateInputValue, Parameter list: $name,$search=FALSE
//*
//* Reads date from CGI/POST, reinterprets and returns interpreted value
//* as a sort ready date.
//*
//* Converts back from 'sloppyly written' dd/mm/yyyy to the (internal)
//* yyyymmdd for storage.
//*

function HtmlDateInputValue($name,$search=FALSE,$default=TRUE)
{
    if ($search)
    {
        $name=$this->GetSearchVarCGIName($name);
    }

    $date=$this->GetCGIVarValue($name);
    if ($default && empty($date))
    {
        $date=sprintf
        (
           "%02d/%02d/%d",
           $this->CurrentDate(),
           $this->CurrentMonth(),
           $this->CurrentYear()
        );
    }

    $date=preg_replace('/[^\d]/',"/",$date);
    $dates=preg_split('/\//',$date);

    $year=$this->CurrentYear();
    if ($search)
    {
        $year="____";
    }

    if (count($dates)>0)
    {
        $year=array_pop($dates);
    }

    if ($year!="____" && $year<100)
    {
        if ($year<20) {  $year+=2000; }
        else          {  $year+=1900; }
    } 

    $mon=$this->CurrentMonth();
    if ($search)
    {
        $mon="__";
    }

    if (count($dates)>0)
    {
        $mon=array_pop($dates);
    }

    if ($mon!="__")
    {
        if ($mon>0)
        {
            $mon=sprintf("%02d",$mon);
        }
        else
        {
            $mon="__";
        }
    }


    $day=$this->CurrentDate();
    if ($search)
    {
        $day="__";
    }

    if (count($dates)>0)
    {
        $day=array_pop($dates);
    }

    if ($day!="__")
    {
        if ($day>0)
        {
            $day=sprintf("%02d",$day);
        }
        else
        {
            $day="__";
        }
    }

    return $year.$mon.$day;
}

//*
//* function HtmlTimeInputField, Parameter list: $name,$time="",$options=array()
//*
//* Adds an : to hor min value.
//*

function HtmlTimeInputField($name,$time="",$options=array())
{
    if (empty($date)) { $date=$this->TimeStamp2HourMinSort(); }

    return $this->MakeInput
    (
       $name,
       preg_replace('/(\d\d)(\d\d)/',"$1:$2",$date),
       10,
       $options
    );
}
}


?>