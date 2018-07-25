<?php

trait Htmls_Form_Args
{
    //*
    //* function Htmls_Form_Args, Parameter list:
    //*
    //* Form Action URI args as hash.
    //*

    function Htmls_Form_Args($action,$args)
    {
        $suppresscgis=$this->Htmls_Form_CGI_Suppress($args);
        
        $args=$this->CGI_Query2Hash();
        $args=$this->CGI_Query2Hash($action,$args);
        $args=$this->CGI_Hidden2Hash($args);

        $query=$this->CGI_Hash2Query($args);

        $this->AddCommonArgs2Hash($args);

        if (preg_match('/(.*)\?(.*)/',$action,$matches))
        {
            $aargs=$matches[2];
            $args=$this->CGI_Query2Hash($aargs,$args);
        }

        //CGI vars to explicitly suppress
        foreach ($suppresscgis as $cgivar) { unset($args[ $cgivar ]); }
        
        if (method_exists($this,"MyMod_Search_Vars"))
        {
            //Supress search var value as forms GET args
            foreach ($this->MyMod_Search_Vars() as $data)
            {
                $rdata=$this->MyMod_Search_CGI_Name($data);
                unset($args[ $rdata  ]);
            }
        }

        if (method_exists($this,"GroupDataCGIVar"))
        {
            unset($args[ $this->GroupDataCGIVar() ]);
        }

        return $args;
    }}

?>