<?php


trait MyMod_Search_HTML
{
    //*
    //* function ,MyMod_Search_HTML Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown=""
    //*
    //* Creates  form search vars table as html.
    //*

    function MyMod_Search_HTML($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown="",$buttons=array())
    {
        if ($this->MyMod_Search_Table_Written) { return ""; }

        if (empty($module)) { $module=$this->MyMod_Search_Table_Module; }
        if (empty($module)) { $module=$this->ModuleName; }

        if (empty($action))
        {
            $action=$this->CGI_GETOrPOST("Action");
        }
        
        if (empty($action)) { $action="Search"; }

        $anchor=preg_replace('/^[^#]+#/',"",$action);
        $action=preg_replace('/#[^#]+$/',"",$action);

        $options=array();
        if (!empty($anchor))
        {
            $options[ "Anchor" ]=$anchor;
        }
        

        $this->Singular=FALSE;
        $this->Plural=TRUE;
        $this->MyMod_Search_Table_Written=FALSE;
        
        $table=
            $this->MyMod_Search_Table_Matrix
            (
                $omitvars,
                $title,
                $action,
                $addvars,
                $fixedvalues,
                $tabmovesdown,
                $buttons
            );
        $this->MyMod_Search_Table_Written;


        return
            $this->FrameIt
            (
               $this->Html_Table
               (
                  "",
                  $table,
                  array
                  (
                     "ALIGN" => 'center',
                     "CLASS" => 'searchtable'
                  ),
                  array(),
                  array(),
                  TRUE
               )
            ).
            "";
    }

}

?>