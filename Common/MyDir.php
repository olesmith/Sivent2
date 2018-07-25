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

    function Dir_Create0000000000($path)
    {
        $res=TRUE;
        if (!file_exists($path))
        {
            $res=mkdir($path,0777,TRUE);
        }

        return $res;
    }


    //**
    //** function Dir_Create, Parameter list: $path
    //**
    //** Creates dir, if createable.
    //** 
    //**

    function Dir_Create($path,$tell=False)
    {
        if (!$this->MyFile_Exists($path))
        {
            $parentpath=dirname($path);
            if ($this->MyFile_Writeable($parentpath))
            {
                $res=mkdir($path);
                if ($tell)
                {
                    var_dump
                    (
                        "Path ".$path." created: ".$res
                    );
                }

                return $res;
            }
            elseif ($tell)
            {
                var_dump
                (
                    "Path ".$parentpath." exists, but is unwritable",
                    "Please run: mkdir ".$path,
                    $this->MyFile_Writeable($path)
                );
            }

            return -1;
        }
        
        return 0;
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
                $this->Dir_Create($path);
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

    //**
    //** function MyDirs_Title_Row, Parameter list: 
    //**
    //** Creates dir table title row (list).
    //** 
    //**

    function MyDirs_Title_Row()
    {
        $selectall="";
        if (!$this->CheckBox_All_Sent) { $selectall="Select All: ".$this->MyDir_CheckBox(); }
        
        $this->CheckBox_All_Sent=True;
        return
            array
            (
                "Path",
                "Created",
                "Modified",
                "Owner",
                "Group",
                "Permissions",
                $selectall
            );
    }
    //**
    //** function MyDirs_Title_Rows, Parameter list: 
    //**
    //** Creates file table title rows (matrix).
    //** 
    //**

    function MyDirs_Title_Rows()
    {
        return
            array
            (
                $this->MyDirs_Title_Row(),
            );
    }

        
    //**
    //** function MyDir_CheckBox, Parameter list: $path
    //**
    //** Creates checkbox for file: to select all files in path.
    //** 
    //**

    function MyDir_CheckBox()
    {
        return
            $this->Html_Input_CheckBox_Field
            (
                "CheckAll",
                1,
                $checked=FALSE,
                $disabled=FALSE,
                array
                (
                    "ID" => "select_1",
                )
            );
    }

    //**
    //** function MyDir_Row, Parameter list: $file
    //**
    //** Creates row of file info.
    //** 
    //**

    function MyDir_Row($path)
    {
        $userinfo=posix_getpwuid(fileowner($path));
        $groupinfo=posix_getgrgid(filegroup($path));
        return
            array
            (
                $path,
                $this->MyFile_Date_Time(filectime($path)),
                $this->MyFile_Date_Time(filemtime($path)),
                $userinfo[ "name" ],
                $groupinfo[ "name" ],
                substr(sprintf('%o', fileperms($path)), -4),
                "",#$this->MyDir_CheckBox($path),
            );
    }

    //**
    //** function MyDir_Rows, Parameter list: $file
    //**
    //** Creates rows of file info.
    //** 
    //**

    function MyDir_Rows($path)
    {
        return
            array
            (
                $this->MyDir_Row($path),
            );
    }
    
    //**
    //** function MyDir_Files_Table, Parameter list: ($path,$files=array(),$table=array())
    //**
    //** Creates table of file info.
    //** 
    //**

    function MyDir_Files_Table($path,$files=array(),$table=array())
    {        
        if (empty($files))
        {
            $files=$this->Dir_Files($path);
            sort($files);
        }

        $titles=array();
        if (!empty($files))
        {
            $titles=
                $this->Html_Table_Head_Rows
                (
                    $this->MyDirs_Title_Rows() 
                );
        }

        return
            array_merge
            (
                $this->MyDir_Rows($path),
                array
                (
                    array
                    (
                        "",
                        $this->HTML_Table
                        (
                            "",
                            $this->MyFiles_Table($files)
                        ),
                    ),
                ),
                $titles
            );
    }

    //**
    //** function MyDir_Subdirs_Table, Parameter list: $path,$subdirs=array(),$table=array()
    //**
    //** Creates table of subdirs info.
    //** 
    //**

    function MyDir_Subdirs_Table($path,$subdirs=array(),$table=array())
    {        
        if (empty($subdirs))
        {
            $subdirs=$this->Dir_Subdirs($path);
            sort($subdirs);
        }

        foreach ($subdirs as $subdir)
        {
            $rtable=$this->MyDir_Table($subdir);
            
            $table=array_merge($table,$rtable);
        }

        return $table;
    }

    //**
    //** function MyDirs_Tables, Parameter list: $path
    //**
    //** Creates table of file info.
    //** 
    //**

    function MyDir_Table($path,$table=array())
    {        
        return
            array_merge
            (
                $this->MyDir_Subdirs_Table($path),
                $this->MyDir_Files_Table($path)
            );
    }
    
    //**
    //** function MyDirs_Tables, Parameter list: $paths,$table=array()
    //**
    //** Creates table of file info.
    //** 
    //**

    function MyDirs_Tables($paths,$table=array())
    {
        #Only sent select all checkbox once
        $this->CheckBox_All_Sent=False;
        
        $table=
            array_merge
            (
                $table,
                $this->Html_Table_Head_Rows
                (
                    $this->MyDirs_Title_Rows()
                )
            );
        
        foreach ($paths as $path)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->MyDir_Table($path)
                );
        }

        return $table;
    }

    
    
    //**
    //** function MyDirs_HTML, Parameter list: $title,$paths
    //**
    //** Creates HTML table of file info.
    //** 
    //**

    function MyDirs_HTML($title,$paths)
    {
        return
            $this->H(1,$title).
            $this->HTML_Table
            (
                "",
                array_merge
                (
                    array(array
                    (
                        $this->Button("submit","ZIP").
                        $this->MakeHidden("Zip",1)
                    )),
                    $this->MyDirs_Tables($paths),
                    array(array($this->Button("submit","ZIP")))
                )
            ).
            "";
    }
    
    //**
    //** function MyDirs_Form, Parameter list: $title,$paths
    //**
    //** Creates HTML form of file info.
    //** 
    //**

    function MyDirs_Form($title,$paths)
    {
        return
            $this->StartForm().
            $this->MyDirs_HTML($title,$paths).
            $this->EndForm().
            "";
    }
    
}
?>