<?php
array
(
   "SingularLatexDocs" => array
   (
      "Landscape" => FALSE,
      "Docs" =>  array
      (
      ),
   ),
   "PluralLatexDocs" => array
   (
      "Landscape" => FALSE,
      "Docs" =>  array
      (
         array
         (
            "Name" => "Lista de Assinaturas",
            "Name_UK" => "Signatures List",
            //"AltHandler"  => "Inscriptions_List",
            "Head"      => "Head.tex",
            "PageHead"  => "PreInscriptions/Head.tex",
            "Glue"      => "PreInscriptions/List.tex",
            "PageTail"  => "PreInscriptions/Tail.tex",
            "Tail"      => "Tail.tex",
            
            "ItemsPerPage"  => 20,
         ),
         array
         (
            "Name" => "Lista de Assinaturas com Código de Barras",
            "Name_UK" => "Signatures List with Barcodes",
            //"AltHandler"  => "Inscriptions_List",
            "Head"      => "Head.tex",
            "PageHead"  => "PreInscriptions/Head.Barcodes.tex",
            "Glue"      => "PreInscriptions/List.Barcodes.tex",
            "PageTail"  => "PreInscriptions/Tail.tex",
            "Tail"      => "Tail.tex",
            
            "ItemsPerPage"  => 20,
         )
      ),
   ),
);
?>
