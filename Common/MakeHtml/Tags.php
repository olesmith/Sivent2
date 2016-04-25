<?php

// Common HTML tags shorcut functions.


trait MakeHtml_Tags
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
}

?>