<?php
array
(
   "SingularLatexDocs" => array
   (
      "Landscape" => FALSE,
      "Docs" =>  array
      (
         //array
         //(
         //   "Name" => "Horários",
         //   "Name_UK" => "Schedule",
         //   "AltHandler"  => "PrintSchedule",
         //)
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
            "PageHead"  => "Inscriptions/Head.tex",
            "Glue"      => "Inscriptions/List.tex",
            "PageTail"  => "Inscriptions/Tail.tex",
            "Tail"      => "Tail.tex",
            
            "ItemsPerPage"  => 25,
         ),
         array
         (
            "Name" => "Lista de Assinaturas com Código de Barras",
            "Name_UK" => "Signatures List with Barcodes",
            //"AltHandler"  => "Inscriptions_List",
            "Head"      => "Head.tex",
            "PageHead"  => "Inscriptions/Head.Barcodes.tex",
            "Glue"      => "Inscriptions/List.Barcodes.tex",
            "PageTail"  => "Inscriptions/Tail.tex",
            "Tail"      => "Tail.tex",
            
            "ItemsPerPage"  => 25,
         )
      ),
   ),
);
?>
