<?php


trait Html_Input_Buttons
{
    //*
    //* function Html_Input_Button_Make, Parameter list: $type,$title,$options=array()
    //*
    //* Creates a form button.
    //* 

    function Html_Input_Button_Make($type,$title,$options=array())
    {
        if (empty($type)) { return $this->Html_Tags("BUTTON",$title,$options); }

        $options[ "TYPE" ]=$type;
        return $this->Html_Tags("BUTTON",$title,$options);
    }
    
    //*
    //* function Html_Input_Button_Make, Parameter list: $type,$title,$options=array()
    //*
    //* Creates a centered form button.
    //* 

    function Html_Input_Button($type,$title,$options=array())
    {
        return $this->Center
        (
           $this->Html_Input_Button_Make($type,$title,$options)
        );
    }
    
    //*
    //* function Html_Input_Buttons_Make, Parameter list: $type,$title,$options=array()
    //*
    //* Creates form buttons, submit and reset.
    //* 

    function Html_Input_Buttons_Make($buttons,$options=array())
    {
        $html="";
        foreach ($buttons as $button)
        {
            $html.=
                $this->Html_Input_Button_Make
                (
                   $button[ "Type" ],
                   $button[ "Title" ],
                   $options
                );
        }

        return $this->Center($html);
    }
    
    //*
    //* function Html_Input_Buttons, Parameter list: $buttons,$options=array()
    //*
    //* Creates form centered buttons.
    //* 

    function Html_Input_Buttons($buttons,$options=array())
    {
        return $this->Center
        (
           $this->Html_Input_Buttons_Make($buttons,$options)
        );
    }
    
    //*
    //* function Html_Input_Print, Parameter list: $buttons,$options=array()
    //*
    //* Printsform centered buttons.
    //* 

    function Html_Input_Buttons_Print($buttons,$options=array())
    {
        return $this->Center
        (
           $this->Html_Input_Buttons_Make($buttons,$options)
        );
    }
    
    //*
    //* function Html_Input_Button_Image, Parameter list: $img,$name,$value,$options=array()
    //*
    //* Creates form centered buttons.
    //* 

    function Html_Input_Button_Image($img,$name,$value,$options=array())
    {
        $options[ "SRC" ]=$img;
        $options[ "NAME" ]=$name;
        $options[ "VALUE" ]=$value;
        return $this->Html_Input_Button_Make
        (
           'submit',
           $img,
           $options
        );
    }
    
    //*
    //* function Html_Input_Button_Tet, Parameter list: $text,$name,$value,$options=array()
    //*
    //* Creates form centered buttons.
    //* 

    function Html_Input_Button_Text($text,$name,$value,$options=array())
    {
        $options[ "NAME" ]=$name;
        $options[ "VALUE" ]=$value;
        return $this->Html_Input_Button_Make
        (
           'submit',
           $text,
           $options
        );
    }
    
}
?>