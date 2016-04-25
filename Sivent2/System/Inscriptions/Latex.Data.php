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
         )
      ),
   ),
);
?>
