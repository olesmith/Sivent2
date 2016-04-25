<?php

include_once("Handle/Download.php");
include_once("Handle/Files.php");
include_once("Handle/Zip.php");
include_once("Handle/List.php");
include_once("Handle/Prints.php");
include_once("Handle/Latex.php");

class Handle extends HandleLatex
{
  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleHelp()
  {      
      return $this->ApplicationObj->HandleHelp();;
  }
  
  //*
  //* function HandleAdd, Parameter list: 
  //*
  //* 
  //*

  function HandleAdd($echo=TRUE)
  {      
      $title=$this->GetRealNameKey($this->Actions[ "Add" ]);
      $ptitle=$this->GetRealNameKey($this->Actions[ "Add" ],"PName");

      return $this->AddForm($title,$ptitle,$echo);
  }
  
  
  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleShow($title="")
  {
      if ($this->GetGETOrPOST("LatexDoc")>0)
      {
          $this->HandlePrint();
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

  //*
  //* function HandleEdit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
  //*
  //* Handles edit form.
  //*

  function HandleEdit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
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

  //*
  //* function HandleCopy, Parameter list: 
  //*
  //* 
  //*

  function HandleCopy()
  {
      $title=$this->GetRealNameKey($this->Actions[ "Copy" ]);
      $ptitle=$this->GetRealNameKey($this->Actions[ "Copy" ],"PName");

      $this->CopyForm($title,$ptitle);
  }

  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleDelete($echo=TRUE,$actionname="Delete",$formurl="?Action=Delete",$idvar="ID")
  {
      if ($this->MyAction_Allowed($actionname))
      {
          $title=$this->GetRealNameKey($this->Actions[ $actionname ]);
          $ptitle=$this->GetRealNameKey($this->Actions[ $actionname ],"PName");
          
          return $this->DeleteForm($title,$ptitle,array(),$echo,$formurl,$idvar);
      }
      else { $this->DoDie("Deletar não permitido"); }
  }

  
  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleComposedAdd()
  {
      $this->HandleAdd();
      $this->HandleList("",TRUE,1);
  }

  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleExport()
  {
      $this->ExportForm();
  }

  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleProcess()
  {
      $this->PostProcessAllItems();
  }

  //*
  //* function , Parameter list: 
  //*
  //* 
  //*

  function HandleImport()
  {
      $this->ImportForm();
  }  
}

?>