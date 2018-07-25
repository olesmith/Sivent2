<?php

trait Htmls_Form_Action
{
    //*
    //* function Htmls_Form_Action, Parameter list:
    //*
    //* Detects form action option from args.
    //*

    function Htmls_Form_Action($id,$action,$args)
    {
        if (preg_match('/(.*)\?(.*)/',$action,$matches))
        {
            $action=$matches[2];
        }

        return
            "?".
            $this->CGI_Hash2Query
            (
                $this->Htmls_Form_Args($action,$args)
            ).
            "#".
            $this->Htmls_Form_Action_Anchor($id,$args);
    }
    
    //*
    //* function Htmls_Form_Action_Anchor, Parameter list:
    //*
    //* Detects form action option from args.
    //*

    function Htmls_Form_Action_Anchor($id,$args)
    {
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

        return $anchor;
    }
}

?>