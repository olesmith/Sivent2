<?php


trait Htmls_Hrefs_Action
{
    //*
    //* function Htmls_HRef_Action, Parameter list: 
    //*
    //* The Form action URI.
    //*

    function Htmls_HRef_Action($href,$args,$anchor,$noqueryargs)
    {
        $orighref=$href;
        $comps=preg_split('/\?/',$href);

        $href="";
        if (count($comps)>0)
        {
            $href=$comps[0];
        }

        if ($this->CGI_Args_Sep!="&")
        {
            $href=preg_replace('/'.$this->CGI_Args_Sep.'/',"&",$href);
            $href=preg_replace('/&/',$this->CGI_Args_Sep,$href);
        }


        $href=
            "?".
            $this->CGI_Hash2URI
            (
                $this->Htmls_HRef_Action_Args
                (
                    $href,
                    $args,
                    $noqueryargs
                )
            );

        if (!empty($anchor)) { $anchor="#".$anchor; }
        
        return $href.$anchor;
    }
    
    //*
    //* function Htmls_HRef_Action_Args, Parameter list: 
    //*
    //* The URI.
    //*

    function Htmls_HRef_Action_Args($href,$args,$noqueryargs)
    {
        $rargs=$this->ApplicationObj()->MyApp_Common_URIs();
        if (!empty($href))
        {
            $rargs=array_merge($rargs,$this->CGI_URI2Hash($href));
        }

        $args=array_merge($rargs,$args);

        if (!is_array($noqueryargs))
        {
            $noqueryargs=array($noqueryargs);
        }

        
        foreach ($noqueryargs as $arg)
        {
            if (!empty($args[ $arg ]))
            {
                unset($args[ $arg ]);
            }
        }

       return $args;
    }
}
?>