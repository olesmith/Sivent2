<?php

class HandlePrints extends HandleList
{
  //*
  //* function HandlePrint, Parameter list: $item
  //*
  //* Handles $item printing.
  //*

  function HandlePrint($item=array())
  {
      if (count($item)==0) { $item=$this->ItemHash; }
      $item=$this->TrimLatexItem($item);

      $latexdocno=$this->CGI2LatexDocNo();

      if (!empty($this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ]))
      {
          $handler=$this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ];
          $this->$handler();
          exit();
      }

     if (method_exists($this,"InitPrint")) { $item=$this->InitPrint($item); }

     $this->PrintItem($item);
  }

  //*
  //* function HandlePrints, Parameter list: $where=""
  //*
  //* Handles items printing, according to $where.
  //*

  function HandlePrints($where="")
  {
      $datas=array_keys($this->ItemData);

      $latexdocno=$this->CGI2LatexDocNo();
      $nempties=$this->GetPOST("NEmptyLines");


      $sort="";
      if (isset($this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "Sort" ]))
      {
          $sort=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "Sort" ];
      }

      if ($sort=="")
      {
          $this->DetectSort();
      }
      else
      {
          $this->Sort=$sort;
      }

      $this->ReadItems($where,$datas,FALSE,TRUE); //searching, but no paging

      $this->TrimLatexItems();

      if (count($this->ItemHashes)==0)
      {
          $this->ApplicationObj->MyApp_Interface_Head();
          echo 
              $this->H(4,"Nemhum item selecionado!").
              $this->H(4,"Volte, define alguma chave de pesquisa (ou marque 'Incluir Todos') e tente novamente.");
          exit();
      }

      $this->SortItems();

      if (method_exists($this,"InitPrint"))
      {
          foreach (array_keys($this->ItemHashes) as $id)
          {
              $this->ItemHashes[$id]=$this->InitPrint($this->ItemHashes[$id]);
          }
      }

      if (!empty($this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ]))
      {
          $handler=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ];
          $this->$handler();
          exit();
      }

      $nmax=count(array_keys($this->ItemHashes) );

      $empty=array();
      foreach ($datas as $id => $data) { $empty[ $data ]=""; }
      for ($n=0;$n<$nempties;$n++)
      {
          $item=$empty;
          $item[ "No" ]=$nmax+$n+1;
          array_push($this->ItemHashes,$item);
      }

      $this->PrintItems($this->ItemHashes);
  }
}

?>