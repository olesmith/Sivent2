<?php

class HandlePrints extends HandleList
{
  /* //\* */
  /* //\* function HandlePrint, Parameter list: $item */
  /* //\* */
  /* //\* Handles $item printing. */
  /* //\* */

  /* function HandlePrint($item=array()) */
  /* { */
  /*     if (count($item)==0) { $item=$this->ItemHash; } */
  /*     $item=$this->TrimLatexItem($item); */

  /*     $latexdocno=$this->CGI2LatexDocNo(); */

  /*     if (!empty($this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ])) */
  /*     { */
  /*         $handler=$this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ][ "AltHandler" ]; */
  /*         $this->$handler(); */
  /*         exit(); */
  /*     } */

  /*    if (method_exists($this,"InitPrint")) { $item=$this->InitPrint($item); } */

  /*    $this->PrintItem($item); */
  /* } */
}

?>