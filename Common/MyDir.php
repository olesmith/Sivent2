<?php

trait MyDir
{
    //**
    //** function Dir_Files, Parameter list: $path,$regex='',$includepath=TRUE
    //**
    //** Returns files in $path. Optionally $regex is applied - and if
    //** $includepath is set, incudes full ppath (default).
    //** 

    function Dir_Files($path,$regex='',$includepath=TRUE)
    {
       $files=array();
        if ($DH = opendir($path))
        {
            while (false !== ($file = readdir($DH)))
            {
                if (!preg_match('/^\.\.?$/',$file))
                {
                    $fname=join("/",array($path,$file));
                    if (!is_dir($fname) && preg_match('/'.$regex.'/',$file))
                    {
                        if ($includepath) { array_push($files,$fname); }
                        else              { array_push($files,$file); }
                    }
                }
            }

            closedir($DH);
        }

        return $files;
    }

    //**
    //** function Dir_Create, Parameter list: $path
    //**
    //** 
    //** 

    function Dir_Create($path)
    {
        $res=TRUE;
        if (!file_exists($path))
        {
            $res=mkdir($path,0777,TRUE);
        }

        return $res;
    }


    //**
    //** function Dir_Create_AllPaths, Parameter list: 
    //**
    //** Creates whatever part of $path.
    //** 

    function Dir_Create_AllPaths($path)
    {
        $comps=preg_split('/\/+/',$path);


        $path="";
        for ($n=0;$n<count($comps);$n++)
        {
            if ($path!="")
            {
                $path.="/";
            }

            $path.=$comps[$n];

            if (!is_dir($path))
            {
                mkdir($path);
            }
            
        }
    }

    //**
    //** function Dir_Subdirs, Parameter list: 
    //**
    //** 
    //** 

    function Dir_Subdirs($path,$regex='',$includepath=TRUE)
    {
        $files=array();
        if ($DH = opendir($path))
        {
            while (false !== ($file = readdir($DH)))
            {
                if ($file!=".." && $file!=".")
                {
                    $fname=join("/",array($path,$file));
                    if (is_dir($fname) && preg_match('/'.$regex.'/',$file))
                    {
                        if ($includepath) { array_push($files,$fname); }
                        else              { array_push($files,$file); }
                    }
                }
            }

            closedir($DH);
        }

        return $files;
    }


    //**
    //** function TreeFiles, Parameter list: $path,&$files=array(),$regex='',$includepath=TRUE
    //**
    //** 
    //** 

    function TreeFiles($path,&$files=array(),$regex='',$includepath=TRUE)
    {
        $rfiles=$this->DirFiles($path,$regex,$includepath);
        foreach ($rfiles as $id => $file)
        {
            array_push($files,$file);
        }

        $rdirs=$this->DirSubdirs($path,$regex,$includepath);
        foreach ($rdirs as $id => $dir)
        {
            $this->TreeFiles($dir,$files,$regex,$includepath);
        }

        return $files;
    }

    //**
    //** function , Parameter list: 
    //**
    //** 
    //** 

    function TreeSubdirs($path,&$dirs=array(),$regex='',$includepath=TRUE)
    {
        array_push($dirs,$path);
        $rdirs=$this->DirSubdirs($path,$regex,$includepath);
        foreach ($rdirs as $id => $dir)
        {
            $this->TreeSubdirs($dir,$dirs,$regex,$includepath);
        }

        return $dirs;
    }
}
?>