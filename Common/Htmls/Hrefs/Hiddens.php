<?php


trait Htmls_Hrefs_Hiddens
{
    //*
    //* function Htmls_HRef_Hidden_Args, Parameter list: 
    //*
    //* Creates a href args as hash.
    //* 
    //*

    function Htmls_HRef_Hidden_Args($args,$noqueryargs)
    {
        $hash=array();
        if (!$noqueryargs)
        {
            #$hash=$this->CGI_Query2Hash($args);
            $hash=$args;
        }
        
        $hiddenargs=array();
        if (count($hash)>0)
        {
            $hiddenargs=$this->MakeHiddenArgs($hash);
        }
        else
        {
            $hiddenargs=$args;
        }

        if ($this->URL_CommonArgs)
        {
            $hiddenargs=
                $this->URL_CommonArgs
                ."&".
                $this->CGI_Hash2URI($hiddenargs);
        }

        return $hiddenargs;
    }
}
?>