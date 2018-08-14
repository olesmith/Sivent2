<?php


class HtmlCheckButton extends HtmlHref
{
    //*
    //* sub MakeCheckBox, Parameter list: $name,$value=FALSE,$checked=FALSE,$disabled=FALSE,$options=array()
    //*
    //* Create CheckBox of name $name. The box is checked if argument
    //* $checked is defined.
    //*
    //*

    function MakeCheckBox($name,$value=FALSE,$checked=FALSE,$disabled=FALSE,$options=array())
    {
        return $this->Html_Input_CheckBox_Field($name,$value,$checked,$disabled,$options);
    }

    //*
    //* sub MakeCheckBoxSet, Parameter list: name,$values,$selecteds
    //*
    //* Create set of Check boxes of name $name and values $values[0],...
    //* If $selected is defined, button $n is checked, if
    //* $selected==$values[$n].
    //*
    //*

    function MakeCheckBoxSet($name,$values,$titles,$selecteds=array())
    {
        if (!is_array($selecteds)) { $selecteds=array($selecteds); }

        $boxes=array();
        for ($n=0;$n<count($values);$n++)
        {
            $checked=0;
            $boxname=$name."_".$values[$n];
            if (preg_grep('/^'.$values[$n].'$/',$selecteds))
            {
                $checked=1;
            }

            $boxes[$n]=
                "<B>".$titles[$n].":</B> ".
                $this->MakeCheckBox($boxname,$values[$n],$checked,FALSE,$options);
        }

        return join("",$boxes);
    }

    //*
    //* sub MakeCheckBoxSetTable, Parameter list: name,$values,$selecteds=array(),$ncols=3,$options=array(),$toptions=array(),$troptions=array(),$tdoptions=array
    //*
    //* Create set of Check boxes of name $name and values $values[0],...
    //* If $selected is defined, button $n is checked, if
    //* $selected==$values[$n].
    //* Organized in html table.
    //*
    //*

    function MakeCheckBoxSetTable($name,$values,$titles,$selecteds=array(),$ncols=3,$options=array(),$toptions=array(),$troptions=array(),$tdoptions=array())
    {
        if (!is_array($selecteds)) { $selecteds=array($selecteds); }

        $table=array(array());
        $col=0;$row=0;

        for ($n=0;$n<count($values);$n++)
        {
            $checked=0;
            $boxname=$name."_".$values[$n];
            if (preg_grep('/^'.$values[$n].'$/',$selecteds))
            {
                $checked=1;
            }
            
            if (!isset($table[ $row ])) { $table[ $row ]=array(); }
            $table[ $row ][ 2*$col ]="<B>".$titles[$n].":</B>";
            $table[ $row ][ 2*$col+1 ]=$this->MakeCheckBox($boxname,$values[$n],$checked,FALSE,$options);

            $col++;
            if ($col>=$ncols)
            {
                $row++;
                $col=0;
            }

       }

        return $this->Html_Table("",$table,$toptions,$troptions,$tdoptions);
    }

    //*
    //* sub HtmlInputCheckBox, Parameter list: $name,$value=FALSE,$options=array()
    //*
    //* Create CheckBox of name $name. The box is checked if argument
    //* $checked is defined.
    //*
    //*

    function HtmlInputCheckBox($name,$value,$options=array())
    {
        $cgivalue=$this->GetPOST($name);

        $options[ "TYPE" ]="checkbox";
        $options[ "NAME" ]=$name;
        $options[ "VALUE" ]=$value;

        if ($value==$cgivalue) { $options[ "CHECKED" ]=""; }

 
        return 
            $this->HtmlTag
            (
               "INPUT",
               "",
               $options
            )."\n";
    }
}


?>