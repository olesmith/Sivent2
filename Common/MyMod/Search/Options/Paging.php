<?php


trait MyMod_Search_Options_Paging
{
    //*
    //* function MyMod_Search_Options_Paging_Row, Parameter list: $omitvars
    //*
    //* 
    //*

    function MyMod_Search_Options_Paging_Rows($omitvars)
    {
        if (preg_grep('/^Paging/',$omitvars))
        {
            return array();
        }
        
        $nopagingfield=$this->ModuleName."_NoPaging";

        $pagingvalue=0;
        if ($this->CGI_GETOrPOST($nopagingfield)==1) { $pagingvalue=1; }

        $nitemspp=$this->CGI_GETOrPOST($this->ModuleName."_NItemsPerPage");
        if ($this->IntIsDefined($nitemspp)) { $this->NItemsPerPage=$nitemspp; }

        
        $nameacc="ItemsName".$this->MyLanguage_GetLanguageKey();

        return array
        (
           array
           (
              $this->B
              (
                  $this->GetMessage($this->MyMod_Search_Messages,"PagingTitle").":"
              ),
              $this->MakeInput
              (
                 $this->ModuleName."_NItemsPerPage",
                 $this->NItemsPerPage,
                 2
              ).
              $this->$nameacc." ".
              $this->GetMessage($this->MyMod_Paging_Messages,"PerPage"),
              $this->B
              (
                  $this->GetMessage($this->MyMod_Paging_Messages,"Page").": "
              ).
              $this->MakeInput
              (
                  $this->ModuleName."_Page",
                  $this->MyMod_Paging_Page_No_Get(),
                  2
              ),
              $this->B
              (
                  $this->GetMessage($this->MyMod_Paging_Messages,"NoPaging").": "
              ).
              $this->MakeCheckBox
              (
                  $nopagingfield,
                  1,
                  $pagingvalue
              ),
           )
        );
     }
    
}

?>