<?php

trait Htmls_Radios
{
    //*
    //* sub Htmls_Radio, Parameter list: name,$value,$checked,$disabled=0,$options=array()
    //*
    //* Create Radio button of name $name. The button is checked if argument
    //* $checked is defined. Listed version.
    //*
    //*

    function Htmls_Radio($name,$value,$checked=0,$disabled=0,$options=array())
    {
        $roptions=
            array
            (
                "TYPE" => "radio",
                "VALUE" => $value,
                "NAME" => $name,
            );
        
        if ($checked!=0 || $disabled!=0)  { unset($roptions[ "CHECKED" ]); }
    
        return
            $this->Htmls_Tag_Start
            (
                "INPUT",
                "",
                array_merge($options,$roptions)
            );
    }
    
    //*
    //* sub Htmls_Radios, Parameter list: name,$values,$selected=-1
    //*
    //* Create set of Radio buttons of name $name and values $values[0],...
    //* If $selected is defined, button $n is checked, if
    //* $selected==$values[$n].
    //*
    //*

    function Htmls_Radios($name,$values,$titles,$selected=-1,$tabindex=0,$options=array())
    {
        $radios=array();
        for ($n=0;$n<count($values);$n++)
        {
            $checked=0;
            if (intval($selected)>0 && preg_match('/^'.$selected.'$/',$values[$n]) || count($values)==1)
            {
                $checked=1;
            }

            if (!empty($tabindex))
            {
                $options[ "TABINDEX" ]=$tabindex+$n;
            }
        
            array_push
            (
                $radios,
                $this->B($titles[$n].": "),
                $this->MakeRadio($name,$values[$n],$checked,$disabled=0,$options)
            );
        }

        return $radios;
    }
}

?>