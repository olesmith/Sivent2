<?php


trait MyApp_Setup_Defs
{
    //*
    //* Returns name of file containing setup data
    //*

    function MyApp_Setup_DataDef_FileName($fid)
    {
        if (is_array($this->SetupFileDefs[ $fid ]))
        {
            return preg_replace
            (
               '/#Setup/',
               $this->SetupPath,
               $this->SetupFileDefs[ $fid ][ "DefFile" ]
            );
        }
    }

    //*
    //* function MyApp_Setup_Filedefs, Parameter list: 
    //*
    //* Walks though $this->ConfigPaths, looking for files
    //* $this->ConfigPaths/$this->SetupPath/$file.
    //* Each file is read with method ReadPHPArray(),
    //* additively added to $hash.
    //*

    function MyApp_Setup_Filedefs($rpath,$files,&$hash,$paths=array())
    {
        if (!is_array($files)) { $files=array($files); }

        if (count($paths)==0) { $paths=$this->ConfigPaths; }

        foreach ($this->MyApp_Setup_ConfigFiles($rpath,$files,$paths) as $file)
        {
            $this->ReadPHPArray($file,$hash);
        }
 
        return $hash;
    }

}

?>