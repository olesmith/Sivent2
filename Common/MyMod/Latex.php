<?php

include_once("Latex/Files.php");


trait MyMod_Latex
{
    use MyMod_Latex_Files;
    
    //*
    //* Creates row with item cells.
    //*

    function MyMod_Latex_Read()
    {
        foreach ($this->MyMod_Latex_Files_Get() as $file)
        {
            if (file_exists($file))
            {
                $this->MyMod_Latex_Add_File($file);
            }
        }

        return;
        
       /*  //First global Latex defs */
       /*  $file= */
       /*      $this->ApplicationObj()->MyApp_Setup_Path(). */
       /*     "/". */
       /*      "Latex.Data.php"; */

       /*  if (file_exists($file)) */
       /*  { */
       /*      $this->LatexData=$this->ReadPHPArray */
       /*      ( */
       /*         $this->ApplicationObj->SetupPath. */
       /*         "/Defs/Latex.Data.php", */
       /*         $this->LatexData */
       /*      ); */
       /*  } */
        
       /* //Add module specific Latex defs */
       /*  $file= */
       /*      $this->MyMod_Setup_Path(). */
       /*     "/". */
       /*      "Latex.Data.php"; */
        
       /*  if (file_exists($file)) */
       /*  { */
       /*      $this->LatexData=$this->ReadPHPArray */
       /*      ( */
       /*         $this->MyMod_Setup_Path(). */
       /*         "/". */
       /*         "Latex.Data.php", */
       /*         $this->LatexData */
       /*      ); */
       /*  } */
    }
    
}

?>