<?php

trait MyMod_Handle_Show
{
  //*
  //* function MyMod_Handle_Show, Parameter list: 
  //*
  //* Handles module object Show.
  //*

  function MyMod_Handle_Show($title="")
  {
      if ($this->GetGETOrPOST("LatexDoc")>0)
      {
          $this->MyMod_Handle_Print();
      }

      if (empty($title))
      {
          $title=$this->GetRealNameKey($this->Actions[ "Show" ]);
      }

      if (count($this->ItemHash)>0)
      {
          return $this->EditForm
          (
             $title,
             $this->ItemHash,
             0
          );
      }
      else { $this->Warn($this->ItemName." not found!",$this->ModuleName,$this->ItemHash); }
  }
}

?>