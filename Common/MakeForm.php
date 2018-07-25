<?php

include_once("MakeHtml.php");
include_once("Htmls.php");

trait MakeForm
{
    use
        MakeHtml,
        Htmls;

    var $Form_Number=1;
   
    //*
    //* function Form_Defaults, Parameter list: 
    //*
    //* Creates leading part of a FORM.
    //* 
    //*

    function Form_Defaults($rargs)
    {
        $args= array
        (
           "ID"         => $this->Form_Number,
           "Name"       => "Name-me...",
           "Method"     => "post",
           "Action"     => "",
           "Anchor"     => "TOP",
           "Uploads" => FALSE,
           "CGIGETVars" => array(),
           "CGIPOSTVars" => array(),

           "Contents"   => "",
           "Options"    => array(),
           "StartButtons"   => "",
           "EndButtons"   => "",
           "Buttons"   => "",
           "Hiddens"   => array(),

           "Edit"   => 0,
           "Update" => 0,

           "ReadMethod" => "",
           "UpdateMethod" => "",
           "ContentsHtml" => "",
           "ContentsLatex" => "",

           "UpdateCGIVar" => "",
           "UpdateCGIValue" => 1,
           "UpdateItems"   => array(),
           
           "PreTableRows"  => array(),
           "PostTableRows" => array(),
        );

        foreach ($rargs as $key => $value)
        {
            $args[ $key ]=$value;
        }

        return $args;
    }

    //*
    //* function Form_Run, Parameter list: $rargs
    //*
    //* Runs form according to $args and defaults.
    //* 
    //*

    function Form_Run($args)
    {
        $args=$this->Form_Defaults($args);

        $this->Form_Read($args);

        if ($this->Form_ShouldUpdate($args))
        {
            $this->Form_Update($args);
        }

        return $this->Form_Generate($args);
    }

    //*
    //* function Form_Generate, Parameter list: $args
    //*
    //* Generates form.
    //* 
    //*

    function Form_Generate($args)
    {
        return
            
            array
            (
                $this->Form_Start($args),
                $this->Form_Contents($args),
                $this->Form_End($args),
            );
    }

    //*
    //* function Form_Start, Parameter list: $args
    //*
    //* Creates leading part of a FORM.
    //* 
    //*

    function Form_Start($args)
    {
        if ($args[ "Edit" ]!=1) { return ""; }

        if (empty($args[ "StartButtons" ])) { $args[ "StartButtons" ]=$args[ "Buttons" ]; }

        return
            $this->Html_Tag
            (
               "FORM",
               $this->Form_Options($args)
            ).
            $args[ "StartButtons" ].
            "";
    }

    //*
    //* function Form_Contents, Parameter list: $args
    //*
    //* Creates contents part of a FORM.
    //* 
    //*

    function Form_Contents($args)
    {
        $method=$args[ "ContentsHtml" ];
        if ($this->LatexMode() && !empty($args[ "ContentsLatex" ]))
        {
            $method=$args[ "ContentsLatex" ];
        }
        if (empty($method))
        {
            $method=$args[ "Contents" ];
        }

        if (!empty($method))
        {
            //Content method defined?
            if (method_exists($this,$method))
            {
                return $this->$method($args[ "Edit" ],$args);
            }
            else
            {
                //return  "Warning! Form_Contents: Invalid Form Contents method: ".$method;
                $res=FALSE;
            }
        }

        return
            $args[ "Contents" ].
            "";
    }

    //*
    //* function Form_End, Parameter list: $args
    //*
    //* Creates trailing part of a FORM:
    //*
    //* - Hidden UpdateCGIVar=UpdateCGIVarValue field.
    //* - FORM closing tag.
    //*

    function Form_End($args)
    {
        if ($args[ "Edit" ]!=1) { return ""; }

        if (empty($args[ "EndButtons" ])) { $args[ "EndButtons" ]=$args[ "Buttons" ]; }

        return
            $this->Form_POSTs($args).
            $args[ "EndButtons" ].
            $this->Html_Tag_Close("FORM").
            "";
    }

    //*
    //* function Form_POSTs, Parameter list: $args
    //*
    //* Creates POST vars as hiddens
    //*

    function Form_POSTs($args)
    {
        $hiddens=array();

        if (!empty($args[ "UpdateCGIVar" ]) && !empty($args[ "UpdateCGIValue" ]))
        {
            array_push
            (
               $hiddens,
               $this->Html_Hidden
               (
                  $args[ "UpdateCGIVar" ],
                  $args[ "UpdateCGIValue" ]
               )
            );
        }

        foreach ($args[ "CGIPOSTVars" ] as $var)
        {
            array_push
            (
               $hiddens,
               $this->Html_Hidden
               (
                  $var,
                  $this->CGI_POST($var)
               )
            );
            
        }

        foreach ($args[ "Hiddens" ] as $var => $value)
        {
            array_push
            (
               $hiddens,
               $this->Html_Hidden($var,$value)
            );
            
        }

        return join("",$hiddens);
    }

    //*
    //* function Form_Read, Parameter list: &$args
    //*
    //* Execute form read method, if defined.
    //* 
    //*

    function Form_Read(&$args)
    {
        //Read method given?
        $method=$args[ "ReadMethod" ];
        if (!empty($method))
        {
            //Read method defined?
            if (method_exists($this,$method))
            {
                $this->$method($args);
            }
            else
            {
                echo "Warning! Form_Read: Invalid Form Read method: ".$method;
                $res=FALSE;
            }
        }
     }

    //*
    //* function Form_ShouldUpdate, Parameter list: $args
    //*
    //* Detects whether we shuld call update or not.
    //* 
    //*

    function Form_ShouldUpdate($args)
    {
        if ($args[ "Update" ]!=1) { return FALSE; }

        $res=FALSE;
        if ($args[ "Edit" ]==1) { $res=TRUE; }

        if ($args[ "Update" ]!=1)
        {
            $res=FALSE;
        }
        if ($args[ "Update" ]!=1 || empty($args[ "UpdateCGIVar" ]))
        {
            $res=FALSE;
        }
        else
        {
            $value=$this->CGI_POSTint($args[ "UpdateCGIVar" ]);
            if ($value!=1)
            {
                $res=FALSE;
            }
        }

        return $res;
    }

    //*
    //* function Form_Update, Parameter list: &$args
    //*
    //* Rruns form update.
    //* 
    //*

    function Form_Update(&$args)
    {
        $res=TRUE;
        if (!$this->Form_ShouldUpdate($args)) { return FALSE; }


        $res=TRUE;

        //Update method given?
        $method=$args[ "UpdateMethod" ];
        if (!empty($method))
        {
            //Update method defined?
            if (method_exists($this,$method))
            {
                $this->$method($args);
            }
            else
            {
                echo "Warning! Form_Update: Invalid Form Update method: ".$method;
                $res=FALSE;
            }
        }

        return $res;
    }

    //*
    //* function Form_Options, Parameter list: $args
    //*
    //* Creates FORM options hash.
    //* 
    //*

    function Form_Options($args)
    {
        $options=$args[ "Options" ];

        $options[ "ID" ]=$args[ "ID" ];
        $this->Form_Number++;

        $options[ "METHOD" ]=$args[ "Method" ];
        $options[ "NAME" ]=$args[ "Name" ];

        $options[ "ENCTYPE" ]="application/x-www-form-urlencoded";
        if ($args[ "Uploads" ])
        {
            $options[ "ENCTYPE" ]="multipart/form-data";
        }

        $action=$args[ "Action" ];

        $url=array();
        if (preg_match('/=/',$action))
        {
            $url=$this->CGI_URI2Hash($action);
        }

        foreach ($args[ "CGIGETVars" ] as $getvar)
        {
            $url[ $getvar ]=$this->CGI_GET($getvar);
        }

        $action=$this->CGI_Hash2URI($url);
        if (!empty($args[ "Anchor" ]))
        {
            $action.="#".$args[ "Anchor" ];
        }

        $options[ "ACTION" ]="?".$action;
        
        return $options;
     }
}
?>