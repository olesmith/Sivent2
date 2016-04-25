<?php



trait MyMod_Data_Groups_Files
{
    //*
    //* function MyMod_Data_Groups_Files_Paths, Parameter list: $singular
    //*
    //* Returns paths to use when looking form group files.
    //*

    function MyMod_Data_Groups_Files_Paths($singular)
    {
        $paths=$this->ItemDataGroupPaths;

        if (!$this->IsMain())
        {
            array_push($paths,$this->MyMod_Setup_Path());
        }

        return $paths;
    }

    //*
    //* function MyMod_Data_Groups_Files_Files, Parameter list: $singular
    //*
    //* Returns contents of $this->ItemDataGroupFiles or $this->ItemDataSGroupFiles .
    //*

    function MyMod_Data_Groups_Files_Files($singular)
    {
        if ($singular)
        {
            return $this->ItemDataSGroupFiles;
        }
        else
        {
            return $this->ItemDataGroupFiles;
        }
    }

    //*
    //* function MyMod_Data_Groups_FilesGetFiles, Parameter list: $singular
    //*
    //* Application initializer.
    //*

    function MyMod_Data_Groups_Files_GetFiles($singular)
    {
        return $this->ExistentPathsFiles
        (
           $this->MyMod_Data_Groups_Files_Paths($singular),
           $this->MyMod_Data_Groups_Files_Files($singular)
        );
    }
}

?>