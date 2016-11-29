<?php


trait MakeHtml_Form
{
    //*
    //* function Html_Form_Start, Parameter list: $edit,$action="",$anchor=""
    //*
    //* Starts html form.
    //* 
    //*

    function Html_Form_Start($edit,$action="",$anchor="HorMenu")
    {
        $html="";
        if ($edit==1)
        {
            $html=$this->StartForm($action,"post",FALSE,array("Anchor" => $anchor));
        }

        return $html;
    }
    
    //*
    //* function Html_Form_End, Parameter list: $edit,$buttons="",$hiddens=array()
    //*
    //* Starts html form.
    //* 
    //*

    function Html_Form_End($edit,$buttons="",$hiddens=array())
    {
        $html="";
        if ($edit==1)
        {
            $html=
                $this->Html_Hiddens($hiddens).
                $buttons.
                $this->EndForm();
        }

        return $html;
    }
    
    //*
    //* function Html_Form, Parameter list: $contents,$edit,$buttons="",$hiddens=array()
    //*
    //* Calls Html_Form_Start and Html_Form_End.
    //* 
    //*

    function Html_Form($contents,$edit,$buttons="",$hiddens=array(),$action="",$anchor="HorMenu")
    {
        if (empty($hiddens)) { $hiddens=array("Update" => 1); }
        $html=
            $this->Html_Form_Start($edit,$action,$anchor).
            $contents.
            "";
        
        if ($edit==1)
        {
            $html.=
                $this->Html_Hiddens($hiddens).
                $buttons.
                $this->EndForm();
        }

        return $this->FrameIt($html);
    }
}
?>