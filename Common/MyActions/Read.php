<?php

//include_once("Actions/Defaults.php");

trait MyActions_Read
{
    //*
    //* function MyActions_Read, Parameter list: 
    //*
    //* Application initializer.
    //*

    function MyActions_Read()
    {
        if (method_exists($this,"PreActions"))
        {
            $this->PreActions();
        }

        $this->Actions=array();
        $this->MyActions_AddFiles
        (
           $this->MyActions_GetFiles()
        );

        //Update module Profile Action entries.
        $this->MyActions_SetPermissions();

        //If we are read only, prevent access to Actions with Edits==1.
        if ($this->ReadOnly)
        {
            foreach ($this->Actions as $id => $action)
            {
                if (
                      !isset($this->Actions[ $id ][ "Edits" ])
                      ||
                      $this->Actions[ $id ][ "Edits" ]==1
                   )
                {
                    $this->Actions[ $id ][ $this->LoginType ]=0;
                    $this->Actions[ $id ][ $this->Profile ]=0;
                }
            }
        }

        if (method_exists($this,"PostActions"))
        {
            $this->PostActions();
        }

        //Will refrase all ItemData language specific key into base
        //For example, if language is UK and $this->ItemData[ $data ][ "Name_UK" ] exists,
        //sets $this->ItemData[ $data ][ "Name" ] to this value.

        $this->MyLanguage_HashTakeNameKeys($this->Actions);
        $this->MyLanguage_HashTakeItemNames($this->Actions);
    }
}

?>