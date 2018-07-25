<?php

class Dir extends File
{
    //**
    //** function , Parameter list: 
    //**
    //** 
    //** 

    function DirFiles($path,$regex='',$includepath=TRUE)
    {
        $files=array();
        if ($DH = opendir($path))
        {
            while (false !== ($file = readdir($DH)))
            {
                if ($file != "." && $file != "..")
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
    //** function , Parameter list: 
    //**
    //** 
    //** 

    function CreateDir($path)
    {
        $res=TRUE;
        if (!file_exists($path))
        {
            $res=mkdir($path,0777,TRUE);
        }

        return $res;
    }


    /* //\** */
    /* //\** function , Parameter list:  */
    /* //\** */
    /* //\**  */
    /* //\**  */

    /* function CreateDirAllPaths($path) */
    /* { */
    /*     $comps=preg_split('/\/+/',$path); */


    /*     $path=""; */
    /*     for ($n=0;$n<count($comps);$n++) */
    /*     { */
    /*         if ($path!="") */
    /*         { */
    /*             $path.="/"; */
    /*         } */

    /*         $path.=$comps[$n]; */

    /*         if (!is_dir($path)) */
    /*         { */
    /*             mkdir($path); */
    /*         } */
            
    /*     } */
    /* } */

    //**
    //** function , Parameter list: 
    //**
    //** 
    //** 

    function DirSubdirs($path,$regex='',$includepath=TRUE)
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
    //** function , Parameter list: 
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