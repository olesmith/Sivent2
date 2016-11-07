<?php


trait MyMod_Data_Fields_File_Extensions
{
    //*
    //* Show allowed extensions valid for $data.
    //*

    function MyMod_Data_Fields_File_Extensions_Permitted_Text($data)
    {
        $extensions=$this->MyMod_Data_Fields_File_Extensions_Get($data);

        $text="";
        if (count($extensions)>0)
        {
            $text=
                $this->GetMessage($this->ItemDataMessages,"PermittedFileTypes").
                ": ".
                join(", ",$extensions);
        }

        return $text;
    }

    
    //*
    //* Returns file field allowed extensions.
    //*

    function MyMod_Data_Fields_File_Extensions_Get($data)
    {
        $extensions=$this->ItemData[ $data ][ "Extensions" ];
        if (!is_array($extensions)) { $extensions=array($extensions); }

        return $extensions;
    }
}

?>