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
    }
    
}

?>