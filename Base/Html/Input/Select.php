<?php


class HtmlSelect extends HtmlRadioButton
{


    //*
    //* sub GetSelectNumbers, Parameter list: $list
    //*
    //* For elements in $list, create the slect numbers< 1,..,nelements in $list.
    //*

    function GetSelectNumbers(&$list)
    {
        $names=array();
        $numbers=array();
        if ($list[0]!="")
        {
            array_unshift($names,"");
            array_unshift($numbers,0);
        }
        else
        {
            array_shift($list);
        }

        $n=1;
        foreach ($list as $id => $val)
        {
            array_push($names,$val);
            array_push($numbers,$n);
            $n++;
        }

        $list=$names;

        return $numbers;
    }

    function TestIfSelected($value,$values,$n,$selected="")
    {
        if (is_array($selected))
        {
            if (!empty($selected[ $value ])) { return TRUE; }
        }
        elseif (
                  $selected
                  &&
                  preg_match('/^'.$selected.'$/',$values[$n])
               )
            {
                return TRUE;
            }

        return FALSE;
    }

//*
//* sub MakeSelectField, Parameter list: $name,$values,$valuenames,$selected="",
//*                                       $disableds=array(),$titles=array(),$title="",
//*                                       $maxlen=0,$noincludedisableds=FALSE,$multiple=FALSE,
//*                                       $onchange=NULL,$options=array()
//*
//* Creates SELECT input element.
//*
//*

function MakeSelectField($name,$values,$valuenames,$selected="",$disableds=array(),$titles=array(),$title="",$maxlen=0,$noincludedisableds=FALSE,$multiple=FALSE,$onchange=NULL,$options=array())
{
    return
        $this->Htmls_Select
        (
            $name,$values,$valuenames,$selected,
            array
            (
                "Disableds" => $disableds,
                "Titles" => $titles,
                "Title" => $title,
                "MaxLen" => $maxlen,
                "ExcludeDisableds" => $noincludedisableds,
                "Multiple" => $multiple,
                "OnChange" => $onchange,
            ),
            $options
        );
    
    /* $selectedok=FALSE; */

    /* $options[ "NAME" ]=$name; */
    /* if (!empty($onchange)) { $options[ "ONCHANGE" ]=$onchange; } */
    /* if (!empty($title))    { $options[ "TITLE" ]=$title; } */
    /* if ($multiple)         { $options[ "MULTIPLE" ]=""; } */

    /* $select=""; */
    /* foreach ($values as $n => $value) */
    /* { */
    /*     $valuename=$valuenames[$n]; */
    /*     $selectopt=array(); */
    /*     if ( */
    /*           count($values)==1 */
    /*           || */
    /*           $this->TestIfSelected($value,$values,$n,$selected) */
    /*        ) */
    /*     { */
    /*         $selectopt[ "SELECTED" ]=""; */
    /*         $selectedok=TRUE; */
    /*     } */

    /*     $class=""; */
    /*     $disabled=FALSE; */
    /*     if ( */
    /*         !empty($disableds[$n]) */
    /*         || */
    /*         preg_match('/^disabled$/',$values[$n])) */
    /*     { */
    /*         $selectopt[ "DISABLED" ]=""; */
    /*         $values[ $n]=""; */
    /*         $class="disabled"; */
    /*         $disabled=TRUE; */
    /*      } */

    /*     if (isset($titles[ $n ])) { $selectopt[ "TITLE" ]=$titles[ $n ]; } */

    /*     $valuename=html_entity_decode($valuename,ENT_QUOTES,"UTF-8"); */
    /*     if ($maxlen>0 && strlen($valuename)>$maxlen) */
    /*     { */
    /*         $valuename=substr($valuename,0,$maxlen); */
    /*     } */

    /*     if (!$noincludedisableds || !$disabled) */
    /*     { */
    /*         if (!empty($class)) */
    /*         { */
    /*             $selectopt[ "CLASS" ]=$class;  */
    /*         } */

    /*         $selectopt[ "VALUE" ]=$values[$n];  */
    /*         $select.= */
    /*             "   ". */
    /*             $this->HtmlTags */
    /*             ( */
    /*                "OPTION", */
    /*                $valuename, */
    /*                $selectopt */
    /*             )."\n"; */

    /*         if ($this->Debug>=2) */
    /*         { */
    /*             $select.=" [".$values[$n]."]\n"; */
    /*         } */
    /*     } */
    /* } */

    /* $select=$this->HtmlTags("SELECT","\n".$select,$options)."\n"; */

    /* if (!$selectedok && !empty($selected) && !is_array($selected)) */
    /* { */
    /*     $this->AddMsg("Warning MakeSelectField: $name, Value: '$selected' undefined"); */
    /* } */

    /* return "\n".$select; */
}

}


?>