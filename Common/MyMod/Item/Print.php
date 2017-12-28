<?php


trait MyMod_Item_Print
{
    //*
    //* Print one file name.
    //*

    function MyMod_Item_Print_FileName($item)
    {
        return
            $this->ApplicationObj->HtmlSetupHash[ "WindowTitle" ].
            $this->ModuleName."-".
            $item[ "ID" ]."-".
            $this->MTime2FName().
            ".tex";
    }
    
    //*
    //* Prints items.
    //*

    function MyMod_Item_Print($item=array())
    {
        if  (count($item)==0) { $item=$this->ItemHash; }

        return $this->Latex_PDF
        (
           $this->MyMod_Item_Print_FileName($item),
           $this->MyMod_Latex_Head
           (
               "Singular",
               $this->CGI2LatexDocNo()
           ).
           $this->MyMod_Item_Latex($item).
           $this->LatexTail()
        );
    }
}

?>