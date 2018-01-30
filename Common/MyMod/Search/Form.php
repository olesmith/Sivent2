<?php


trait MyMod_Search_Form
{
    //*
    //* function ,MyMod_Search_HTML Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown=""
    //*
    //* Creates search vars table as html form.
    //*

    function MyMod_Search_Form($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$module="",$tabmovesdown="",$buttons=array())
    {
        if ($this->MyMod_Search_Table_Written) { return ""; }

        if (empty($module)) { $module=$this->MyMod_Search_Table_Module; }

        if (empty($module)) { $module=$this->ModuleName; }

        if (empty($action))
        {
            $action=$this->GetGETOrPOST("Action");
        }
        if (empty($action)) { $action="Search"; }

        $anchor=preg_replace('/^[^#]+#/',"",$action);
        $action=preg_replace('/#[^#]+$/',"",$action);

        $options=array();
        if (!empty($anchor))
        {
            $options[ "Anchor" ]=$anchor;
        }
        
        return
            $this->StartForm
            (
               "?ModuleName=".$module."&Action=".$action,
               "post",
               0,
               $options,
               array
               (
                  $module."_NItemsPerPage",
                  $module."_Page",
                  $module."_NoPaging",
                  $module."_TabMovesDown",
                  "Page",
               )
            ).
            $this->MyMod_Search_HTML
            (
                $omitvars=array(),
                $title="",
                $action="",
                $addvars=array(),
                $fixedvalues=array(),
                $module="",
                $tabmovesdown="",
                $buttons=array()
            ).
            //determines if search button has been pressed
            $this->MyMod_Search_CGI_Pressed_Hidden().

            $this->MyMod_Search_Post_Text.

            $this->EndForm().
            "";
     }

}

?>