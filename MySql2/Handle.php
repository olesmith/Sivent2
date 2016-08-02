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
      $this->MyMod_Handle_Show($title);
  }

  //*
  //* function HandleEdit, Parameter list: $echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE
  //*
  //* Handles edit form.
  //*

  function HandleEdit($echo=TRUE,$formurl=NULL,$title="",$noupdate=FALSE)
  {
      $this->MyMod_Handle_Edit($echo,$formurl,$title,$noupdate);
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
      $this->MyMod_Handle_Delete($echo,$actionname,$formurl,$idvar);
  }

  
  /* //\* */
  /* //\* function , Parameter list:  */
  /* //\* */
  /* //\*  */
  /* //\* */

  /* function HandleComposedAdd() */
  /* { */
  /*     $this->HandleAdd(); */
  /*     $this->HandleList("",TRUE,1); */
  /* } */

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