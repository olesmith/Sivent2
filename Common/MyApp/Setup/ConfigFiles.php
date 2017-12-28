<?php


trait MyApp_Setup_ConfigFiles
{
    //*
    //* function MyApp_Setup_ConfigFiles, Parameter list: $rpath,$files,$paths=array()
    //*
    //* Walks though $paths or $this->ConfigPaths, looking for files
    //* $this->ConfigPaths/$this->SetupPath/$file.
    //*

    function MyApp_Setup_ConfigFiles($rpath,$files,$paths=array())
    {
        if (!is_array($files)) { $files=array($files); }

        if (count($paths)==0) { $paths=$this->ConfigPaths; }

        $rfiles=array();
        foreach ($files as $file)
        {
            foreach ($paths as $path)
            {
                $rfile=$path."/".$rpath."/".$file;
                if (file_exists($rfile))
                {
                    array_push($rfiles,$rfile);
                }
            }
        }
 
        return $rfiles;
    }

    //*
    //* function MyApp_Setup_ConfigFiles2Hash, Parameter list: $file,&$hash
    //*
    //* Walks though $this->ConfigPaths, looking for files
    //* $this->ConfigPaths/$this->SetupPath/$file.
    //* Each file is read with method ReadPHPArray(),
    //* additively added to $hash.
    //*

    function MyApp_Setup_ConfigFiles2Hash($rpath,$files,&$hash,$paths=array())
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