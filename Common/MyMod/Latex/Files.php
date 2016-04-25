<?php



trait MyMod_Latex_Files
{
    //*
    //* function MyMod_Latex_Paths, Parameter list: 
    //*
    //* Returns paths to use when looking for latex setup files.
    //*

    function MyMod_Latex_Paths()
    {
        $hash=array
        (
           "Module" => $this->ModuleName(),
           "System" => $this->MyMod_Setup_Path(),
        );
        
        foreach (array_keys($this->LatexPaths) as $id)
        {
            $this->LatexPaths[ $id ]=$this->Filter($this->LatexPaths[ $id ],$hash);
        }

        return $this->LatexPaths;
    }

    //*
    //* function MyMod_Latex_Files, Parameter list: 
    //*
    //* Returns contents of $this->.
    //*

    function MyMod_Latex_Files()
    {
        $hash=array
        (
           "Module" => $this->ModuleName(),
           "System" => $this->MyMod_Setup_Path(),
        );
        
        foreach (array_keys($this->LatexFiles) as $id)
        {
            $this->LatexFiles[ $id ]=$this->Filter($this->LatexFiles[ $id ],$hash);
        }

        return $this->LatexFiles;
    }

    //*
    //* function MyMod_Latex_Add_File, Parameter list: $file
    //*
    //* Returns latex def files in $this->MyMod_Data_Files list.
    //*

    function MyMod_Latex_Add_File($file)
    {
        $latexdefs=$this->ReadPHPArray($file);
        foreach (array_keys($latexdefs) as $data)
        {
            $this->MyMod_Latex_Add_Data($data,$latexdefs[ $data ]);
        }
    }

     //*
    //* function MyMod_Latex_Files_Get, Parameter list:
    //*
    //* Returns item  data file.
    //*

    function MyMod_Latex_Files_Get()
    {
        $files=$this->ExistentPathsFiles
        (
           $this->MyMod_Latex_Paths(),
           $this->MyMod_Latex_Files()
        );

        return $files;
    }
    
    //*
    //* function MyMod_Latex_Add_Data, Parameter list: $file
    //*
    //* Returns latex def file $file.
    //*

    function MyMod_Latex_Add_Data($data,$hash)
    {
        if (!isset($this->LatexData[$data  ]))
        {
            $this->LatexData[ $data ]=$hash;
        }
        else
        {
            if (is_array($hash))
            {
                foreach ($hash as $key => $value)
                {
                    $this->LatexData[ $data ][ $key ]=$value;
                }
            }
            else { $this->LatexData[ $data ]=$hash; }
        }
    }
}

?>