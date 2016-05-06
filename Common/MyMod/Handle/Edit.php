<?php

trait MyMod_Handle_Edit
{
    //*
    //* function MyMod_Handle_Edit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
    //*
    //* Handles module object Edit.
    //*

    function MyMod_Handle_Edit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
    {
        if ($this->GetGETOrPOST("LatexDoc")>0)
        {
            $this->HandlePrint();
        }

        if (empty($title)) { $title=$this->GetRealNameKey($this->Actions[ "Edit" ]); }

        if (count($this->ItemHash)>0)
        {
            return $this->EditForm
            (
               $title,
               $this->ItemHash,
               1,
               $noupdate,
               array(),
               $echo,
               array(),
               $formurl
            );
        }
        else { $this->Warn( $this->ItemName." not found!",$this->ItemHash); }
  }
}

?>