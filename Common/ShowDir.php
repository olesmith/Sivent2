<?php

trait ShowDir
{
    //*
    //* function ShowDir_Handle, Parameter list: $path
    //*
    //* Shows dirs stored in file system.
    //*

    function ShowDir_Handle($path="Uploads")
    {
        $this->MyApp_Interface_Head();
        $table=array();

        $subdirs=$this->TreeSubdirs($path);
        sort($subdirs);
        
        foreach ($subdirs as $dir)
        {
            $table=array_merge
            (
               $table,
               $this->ShowDir_Subdir_Rows($dir)
            );
        }

        echo
            $this->H(1,"Files in directory: ".$dir).
            $this->Html_Table
            (
               array
               (
                  "Path","File","Modified","Size",
                  "Module",
                  "ID in SQL Table","Modified","Size"
               ),
               $table
            );
    }

    //*
    //* function ShowDir_Subdir_Rows, Parameter list: $dir
    //*
    //* Shows dirs stored in file system.
    //*

    function ShowDir_Subdir_Rows($dir)
    {
        $rows=array($this->ShowDir_Subdir_Row($dir));

        $files=$this->Dir_Files($dir);
        sort($files);
        
        foreach ($files as $file)
        {
            array_push($rows,$this->ShowDir_File_Row($file));
        }

        return $rows;
    }
    
    //*
    //* function ShowDir_Subdir_Row, Parameter list: $dir
    //*
    //* Shows dirs stored in file system.
    //*

    function ShowDir_Subdir_Row($dir)
    {
        return
            array
            (
               $dir,
               "",""
            );
    }
    
    //*
    //* function ShowDir_File_Row, Parameter list: $dir
    //*
    //* Shows dirs stored in file system.
    //*

    function ShowDir_File_Row($file)
    {
        $dir=dirname($file);
        $filename=basename($file);

        $paths=preg_split('/\//',$dir);
        $module=array_pop($paths);
        
        $dbid="-";
        $dbsize="-";
        $dbtime="-";
        if (preg_match('/^(\S+)_(\d+)\.\S+$/',$filename,$matches))
        {
            $col=$matches[1];
            $dbid=$matches[2];
            $mod=$module."Obj";
            
            if (method_exists($this,$mod))
            {
                if ($this->$mod()->Sql_Table_Field_Exists($col."_Contents"))
                {
                    $dbinfo=$this->$mod()->Sql_Select_Hash
                    (
                       array("ID" => $dbid),
                       array("ID",$col."_Contents",$col."_Time")
                    );

                    if (!empty($dbinfo[ $col."_Contents" ]))
                    {
                        $dbsize=strlen($this->$mod()->DB2FileContents($dbinfo[ $col."_Contents" ]));
                        $dbtime=$dbinfo[ $col."_Time" ];
                    }
                }
            }
        }
        
        return
            array
            (
               "",
               $filename,
               date ("F d Y H:i:s.", filemtime($file)),
               filesize($file),
               $module,
               $dbid,
               $this->TimeStamp2Text($dbtime),
               $dbsize,
            );
    }
}

?>