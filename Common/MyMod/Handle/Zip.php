<?php

trait MyMod_Handle_Zip
{
    var $ZipShowDatas=array("No","Edit","Name");
    var $ZipTmpFiles=array();
    
    //*
    //* function MyMod_Handle_Zip, Parameter list: 
    //*
    //* Handles Module zipping of file.
    //*

    function MyMod_Handle_Zip()
    {
        if ($this->CGI_POSTint("Zip")==1)
        {
            $this->MyMod_Handle_Zip_Do();
            exit();
        }

        $this->MyMod_Handle_Zip_Show();
        
    }

    //*
    //* function MyMod_Handle_Zip_Show, Parameter list: 
    //*
    //* Shows files in $this->ApplicationObj()->MyApp_Globals_Upload_Paths().
    //*

    function MyMod_Handle_Zip_Show()
    {
        $this->ApplicationObj()->MyApp_Interface_Head();
        
        echo
            $this->MyDirs_Form
            (
                "Uploaded Files",
                $this->ApplicationObj()->MyApp_Globals_Upload_Paths()
            ).
            "";

    }

    
    //*
    //* function MyMod_Handle_Zip_Files, Parameter list: $paths
    //*
    //* List of files in upload paths
    //*

    function MyMod_Handle_Zip_Files($paths)
    {
        $files=array();
        foreach ($paths as $path)
        {
            $rfiles=$this->TreeFiles($path);
            foreach ($rfiles as $file)
            {
                $rfile=preg_replace('/[\/\.]/',"_",$file);
                $include=$this->CGI_POSTint($rfile);
                
                if ($include==1) { array_push($files,$file); }
            }
        }

        return $files;
    }

    //*
    //* function MyMod_Handle_Zip_Paths, Parameter list: $paths
    //*
    //* List of files in upload paths
    //*

    function MyMod_Handle_Zip_Paths($files)
    {
        $paths=array();
        foreach ($files as $file)
        {
            $path=dirname($file);
            $paths[ $path ]=1;
        }

        return array_keys($paths);
    }

    
    //*
    //* function MyMod_Handle_Zip_Do, Parameter list: 
    //*
    //* Will do the actual zipping on searched items.
    //*

    function MyMod_Handle_Zip_Do()
    {
        $zipname="/tmp/".$this->ModuleName.".".$this->MTime2FName().".zip";

        $zip=$this->OpenZip($zipname);

        $paths=$this->ApplicationObj()->MyApp_Globals_Upload_Paths();
        $files=$this->MyMod_Handle_Zip_Files($paths);
        
        $rpaths=$this->MyMod_Handle_Zip_Paths($files);

        $this->MyMod_Handle_Zip_Paths_Add($zip,$rpaths);
        $this->MyMod_Handle_Zip_Files_Add($zip,$files);

        $this->CloseZip($zip,$zipname);
        $this->SendZip($zipname);

        $this->MyMod_Handle_Zip_Tmp_Remove($zipname);
        exit();
    }


    //*
    //* function MyMod_Handle_Zip_Paths_Add, Parameter list: $zip,$files
    //*
    //* Will create list of paths in zip file.
    //*

    function MyMod_Handle_Zip_Paths_Add($zip,$paths)
    {
        foreach ($paths as $path)
        {
            $zip->addEmptyDir($path);
        }
    }

    
    //*
    //* function MyMod_Handle_Zip_Files_Add, Parameter list: $zip,$files
    //*
    //* Will do the actual zipping on searched items.
    //*

    function MyMod_Handle_Zip_Files_Add($zip,$files)
    {
        $paths=array();
        foreach ($files as $file)
        {
            $path=dirname($file);
            $paths[ $path ]=1;
        }

        $paths=array_keys($paths);
        $this->MyMod_Handle_Zip_Paths_Add($zip,$paths);
        
        foreach ($files as $file)
        {
            $zip->addFile($file);
        }
    }

}

?>