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