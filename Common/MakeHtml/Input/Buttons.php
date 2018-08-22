<?php


trait Html_Input_Buttons
{
    //*
    //* function Button, Parameter list: $type,$title,$options=array()
    //*
    //* Creates a form button.
    //* 
    //*

    function Button($type,$title,$options=array())
    {
        return $this->Html_Input_Button($type,$title,$options);
    }

     //*
    //* function Buttons, Parameter list: $reset="",$submit="",$options=array()
    //*
    //* Creates the form buttons.
    //* 
    //*

    function Buttons($submit="",$reset="",$options=array())
    {
        if (empty($submit))
        {
            $submit=
                $this->GetMessage($this->HtmlMessages,"SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->GetMessage($this->HtmlMessages,"ResetButton");
        }

        return
            $this->Center
            (
                $this->Html_Input_Button_Make("submit",$submit,$options).
                $this->Html_Input_Button_Make("reset",$reset,$options)
            );
    }
    
    //*
    //* function PButtons, Parameter list: $reset="",$submit="",$options=array()
    //*
    //* Creates the form buttons inlcuding a PDF button.
    //* 
    //*

    function PrintButtons($submit="",$reset="",$options=array())
    {
        if (empty($submit))
        {
            $submit=$this->GetMessage($this->HtmlMessages,"SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->GetMessage($this->HtmlMessages,"ResetButton");
        }

        return
            $this->Center
            (
                $this->Html_Input_Button_Make("submit",$submit,$options).
                //$this->Caller(). //debugging
                $this->Html_Input_Button_Make("reset",$reset,$options).
                $this->Html_Input_Button_Make
                (
                   "submit",
                   "PDF",
                   array_merge
                   (
                      $options,
                      array
                      (
                         "NAME" => "Latex",
                         "VALUE" => "1",
                      )
                   )
                 )
            );
    }
    //*
    //* function PButtons, Parameter list: $reset="",$submit="",$options=array()
    //*
    //* Creates the form buttons inlcuding a PDF button.
    //* 
    //*

    function PrintAndWhiteButtons($submit="",$reset="",$options=array())
    {
        if (empty($submit))
        {
            $submit=$this->GetMessage($this->HtmlMessages,"SendButton");
        }
        
        if (empty($reset))
        {
            $reset=$this->GetMessage($this->HtmlMessages,"ResetButton");
        }

        return
            $this->Center
            (
                $this->Html_Input_Button_Make("submit",$submit,$options).
                //$this->Caller(). //debugging
                $this->Html_Input_Button_Make("reset",$reset,$options).
                $this->Html_Input_Button_Make
                (
                   "submit",
                   "PDF",
                   array_merge
                   (
                      $options,
                      array
                      (
                         "NAME" => "Latex",
                         "VALUE" => "1",
                      )
                   )
                ).
                $this->Html_Input_Button_Make
                (
                   "submit",
                   "Em Branco",
                   array_merge
                   (
                      $options,
                      array
                      (
                         "NAME" => "Latex",
                         "VALUE" => "2",
                      )
                   )
                 )
            );
    }

    
    //*
    //* function Html_Input_Button_Make, Parameter list: $type,$title,$options=array()
    //*
    //* Creates a form button.
    //* 

    function Html_Input_Button_Make($type,$title,$options=array())
    {
        if (empty($type)) { return $this->Html_Tags("BUTTON",$title,$options); }

        $options[ "TYPE" ]=$type;
        $options[ "CLASS" ]="button";

        if ($type == "submit") {
            $options[ "CLASS" ]="button is-info";
        }

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
    //* function Html_Input_Button_Text, Parameter list: $text,$name,$value,$options=array()
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