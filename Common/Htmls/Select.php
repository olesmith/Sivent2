<?php

trait Htmls_Select
{
    //*
    //* sub Htmls_Select, Parameter list: $name,$values,$valuenames,$selected="",
    //*                                       $disableds=array(),$titles=array(),$title="",
    //*                                       $maxlen=0,$noincludedisableds=FALSE,$multiple=FALSE,
    //*                                       $onchange=NULL,$options=array()
    //*
    //* Creates SELECT input element, listed version.
    //*
    //*

    function Htmls_Select($name,$values,$valuenames,$selected="",$args=array(),$htmloptions=array())
    {
        $disableds=array();
        if (!empty($args[ "Disableds" ])) { $disableds=$args[ "Disableds" ]; }
        
        $titles=array();
        if (!empty($args[ "Titles" ])) { $titles=$args[ "Titles" ]; }
        
        $title="";
        if (!empty($args[ "Title" ])) { $title=$args[ "Title" ]; }

        
        $maxlen=0;
        if (!empty($args[ "MaxLen" ])) { $maxlen=$args[ "MaxLen" ]; }
        
        $noincludedisableds=FALSE;
        if (!empty($args[ "ExcludeDisableds" ])) { $noincludedisableds=$args[ "ExcludeDisableds" ]; }
        
        $multiple=FALSE;
        if (!empty($args[ "Multiple" ])) { $multiple=$args[ "Multiple" ]; }
        
        $empty=FALSE;
        if (!empty($args[ "Empty" ])) { $empty=$args[ "Empty" ]; }
        
        $onchange=NULL;
        if (!empty($args[ "OnChange" ])) { $onchange=$args[ "OnChange" ]; }
        
        if (!empty($args[ "Options" ])) { $options=array_merge($options,$args[ "Options" ]); }
        
        $selectedok=FALSE;

        $htmloptions[ "NAME" ]=$name;
        if (!empty($onchange)) { $htmloptions[ "ONCHANGE" ]=$onchange; }
        if (!empty($title))    { $htmloptions[ "TITLE" ]=$title; }
        if ($multiple)         { $htmloptions[ "MULTIPLE" ]=""; }

        if (empty($selected))
        {
            $val=$this->CGI_POST($name);
            if (!empty($val))
            {
                $selected=$val;
            }
        }

        $options=array();
        if ($empty)
        {
            array_push
            (
                $options,
                $this->Htmls_Tag
                (
                    "OPTION",
                    "",
                    array("VALUE" => 0)
                )
            );
        }

        foreach ($values as $n => $value)
        {
            $opthtmloptions=array();
            $valuename=$valuenames[$n];
            if
                (
                    count($values)==1
                    ||
                    $this->TestIfSelected($value,$values,$n,$selected)
                )
            {
                $opthtmloptions[ "SELECTED" ]="";
                $selectedok=TRUE;
            }

            $class="";
            $disabled=FALSE;
            if
                (
                    !empty($disableds[$n])
                    ||
                    preg_match('/^disabled$/',$values[$n])
                )
            {
                $opthtmloptions[ "DISABLED" ]="";
                $values[ $n]="";
                $class="disabled";
                $disabled=TRUE;
            }
        
            if (isset($titles[ $n ])) { $selectopt[ "TITLE" ]=$titles[ $n ]; }

            $valuename=html_entity_decode($valuename,ENT_QUOTES,"UTF-8");
            if ($maxlen>0 && strlen($valuename)>$maxlen)
            {
                $valuename=substr($valuename,0,$maxlen);
            }

            if (!$noincludedisableds || !$disabled)
            {
                if (!empty($class))
                {
                    $opthtmloptions[ "CLASS" ]=$class; 
                }

                $opthtmloptions[ "VALUE" ]=$values[$n]; 

                if ($this->Debug>=2)
                {
                    $valuename.=" [".$values[$n]."]";
                }
                
                array_push
                (
                    $options,
                    $this->Htmls_Tag
                    (
                        "OPTION",
                        $valuename,
                        $opthtmloptions
                    )
                );
            }
        }

        if (!$selectedok && !empty($selected) && !is_array($selected))
        {
            $this->AddMsg("Warning MakeSelectField: $name, Value: '$selected' undefined");
        }
        
        return
            $this->Htmls_Tag
            (
                "SELECT",
                $options,
                $htmloptions
            );
    }
    
    //*
    //* sub Htmls_Select_Hashes_Field, Parameter list: 
    //*
    //* HTML select input field from list of items. List version
    //*

    function Htmls_Select_Hashes_Field($fieldname,$items,$args=array(),$selectoptions=array(),$optionsoptions=array())
    {
        $selected=$this->MyHash_Default($args,"Selected",0);
        $namekey=$this->MyHash_Default($args,"Name_Key","Name");
        $titlekey=$this->MyHash_Default($args,"Title_Key","Title");
        $idkey=$this->MyHash_Default($args,"ID_Key","ID");
        $emptytext=$this->MyHash_Default($args,"Empty_Text","");
        
        $optionsoptions[ "VALUE" ]=" 0";
        $selects=
            array
            (
                $this->Html_Tags
                (
                    "OPTION",
                    $emptytext,
                    $optionsoptions
                )
            );

        foreach ($items as $rid => $item)
        {
            //Copy of options, preventing mixing option options.
            $roptionsoptions=$optionsoptions;
            
            $id=$item[ $idkey ];
            $title=$this->Html_Option_Title($titlekey,$item,$namekey);;
            if ($id==$selected)
            {
                $roptionsoptions[ "SELECTED" ]="";
                $roptionsoptions[ "CLASS" ]="selected";
                $roptionsoptions[ "CLASS" ]="selected";
                $selectoptions[ "TITLE" ]=$title;
            }

            $roptionsoptions[ "VALUE" ]=$id;
            $roptionsoptions[ "TITLE" ]=$this->Html_Option_Title($titlekey,$item);

            if (!empty($item[ "Disabled" ]))
            {
                $roptionsoptions[ "DISABLED" ]=" ";
                $roptionsoptions[ "CLASS" ]= "disabled";
            }

            array_push
            (
                $selects,
                $this->Html_Tags
                (
                   "OPTION",
                   $item[ $namekey ],
                   $roptionsoptions
                )
            );
        }
        
        $selectoptions[ "NAME" ]=$fieldname;

        return
            $this->Htmls_Tag
            (
                "SELECT",
                array($selects),
                $selectoptions
            );
    }
}


?>