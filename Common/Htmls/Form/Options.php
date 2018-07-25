<?php

trait Htmls_Form_Options
{
    //* function Htmls_Form_Options, Parameter list:
    //*
    //* Generates a HTML form options array.
    //*

    function Htmls_Form_Options($id,$action="",$contents=array(),$args=array(),$options=array())
    {        
        $options[ "ID" ]=$id;
        $anchor=$id;
        if (!empty($options[ "Anchor" ]))
        {
            $anchor=$options[ "Anchor" ];
            unset($options[ "Anchor" ]);
        }
        
        if (!empty($options[ "ID" ]))
        {
            $anchor=$options[ "ID" ];
            unset($options[ "ID" ]);
        }
        
        $anchor=preg_replace('/#/',"",$anchor);

        $options[ "METHOD" ]=$this->Htmls_Form_Options_Method($args);
        $options[ "ENCTYPE" ]=$this->Htmls_Form_Options_EncType($args);
        


        $options[ "ACTION" ]=$this->Htmls_Form_Action($id,$action,$args);
        
        $anchor=$this->Htmls_Form_Action_Anchor($id,$args);
        if (!preg_match('/^_/',$anchor))
        {
            $options[ "ID" ]=$anchor;
        }

        return $options;
    }

   
    //*
    //* function Htmls_Form_Options_Method, Parameter list:
    //*
    //* Detects form method option from args. Default is post.
    //*

    function Htmls_Form_Options_Method($args)
    {
        $method="post";
        if (!empty($args[ "Method" ])) { $method=$args[ "Method" ]; }

        return $method;
            
    }
    
    //*
    //* function Htmls_Form_Options_EncType, Parameter list:
    //*
    //* Detects whether we have file uploads or not.
    //*

    function Htmls_Form_Options_EncType($args)
    {
        ##Always turn on file upload... hehehe.
        return "multipart/form-data";
        /* return "application/x-www-form-urlencoded"; */
    }
    
    //*
    //* function Htmls_Form_CGI_Suppress, Parameter list:
    //*
    //* Detects cgi vars to suppress on action link.
    //*

    function Htmls_Form_CGI_Suppress($args)
    {
        $suppresscgis=array();
        if (!empty($args[ "Supress" ])) { $suppresscgis=$args[ "Supress" ]; }
        
        
        return $suppresscgis;
    }
}

?>