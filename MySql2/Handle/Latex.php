<?php

class HandleLatex extends HandlePrints
{
  //*
  //* function HandleLatexItem, Parameter list: 
  //*
  //* Handles $item 'latexing'.
  //*

  function HandleLatexItem($item=array())
  {
      if (count($item)==0) { $item=$this->ItemHash; }
      $item=$this->TrimLatexItem($item);
      if (method_exists($this,"InitPrint")) { $item=$this->InitPrint($item); }

      $title=$this->ItemName." ".$item[ "ID" ].": ".$this->GetItemName($item);

      $this->ItemLatexTablePrint($title,$item);
  }

  //*
  //* function HandleLatexItems, Parameter list: 
  //*
  //* Handles items 'latexing', according to $where.
  //*

  function HandleLatexItems($where="")
  {
      $individual=$this->GetCGIVarValue("Individual");

      if ($individual==1)
      {
          $items=$this->ReadItems($where,array_keys($this->ItemData),FALSE,TRUE);
      }
      else
      {
          $items=$this->ReadItems($where);
      }

      $this->TrimLatexItems();

      $items=$this->MyMod_Sort_Items();
      for ($n=0;$n<count($items);$n++)
      {
          if (method_exists($this,"InitPrint")) { $items[$n]=$this->InitPrint($items[$n]); }
      }

      if ($individual==1)
      {
          $this->ItemLatexTablesPrint($items);
      }
      else
      {
          $this->ItemsLatexTable("\\Large{Relatório de ".$this->ItemsName."}\n\n",$items);
      }
  }

}

?>