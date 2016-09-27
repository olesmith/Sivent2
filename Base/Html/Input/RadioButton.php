<?php

class HtmlRadioButton extends HtmlCheckButton
{



//*
//* sub MakeRadio, Parameter list: name,$value,$checked,$disabled=0,$options=array()
//*
//* Create Radio button of name $name. The button is checked if argument
//* $checked is defined.
//*
//*

function MakeRadio($name,$value,$checked=0,$disabled=0,$options=array())
{
    $options[ "TYPE" ]="radio";
    $options[ "VALUE" ]=$value;
    $options[ "NAME" ]=$name;

    if ($checked!=0)  { $options[ "CHECKED" ]=""; }
    if ($disabled!=0) { $options[ "CHECKED" ]=""; }
    
    return $this->HtmlTag
    (
       "INPUT",
       "",
       $options
    )."\n";
}

//*
//* sub MakeRadioSet, Parameter list: name,$values,$selected=-1
//*
//* Create set of Radio buttons of name $name and values $values[0],...
//* If $selected is defined, button $n is checked, if
//* $selected==$values[$n].
//*
//*

function MakeRadioSet($name,$values,$titles,$selected=-1,$tabindex=0,$options=array())
{
    $radios=array();
    for ($n=0;$n<count($values);$n++)
    {
        $checked=0;
        if (intval($selected)>0 && preg_match("/^$selected$/",$values[$n]) || count($values)==1)
        {
            $checked=1;
        }

        if (!empty($tabindex))
        {
            $options[ "TABINDEX" ]=$tabindex+$n;
        }
        
        $radios[$n]=
            $this->B($titles[$n].": ").
            $this->MakeRadio($name,$values[$n],$checked,$disabled=0,$options);
    }

    return join("",$radios);
}



}


?>