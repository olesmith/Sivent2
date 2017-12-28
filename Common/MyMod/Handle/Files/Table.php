<?php

trait MyMod_Handle_Files_Table
{
    //*
    //* function MyMod_Handle_Files_Table, Parameter list: $path,$table=array(),$prencells=0
    //*
    //* Creates table listing files with subdirs.
    //*

    function MyMod_Handle_Files_Table($path,$table=array(),$prencells=0)
    {
        return
            array_merge
            (
                $this->MyMod_Handle_Files_Subdir_Rows($path),
                $this->MyMod_Handle_Files_Subdirs_Table($path,$prencells),
                $this->MyMod_Handle_Files_Path_Table($path,$prencells)
            );
    }

    //*
    //* function MyMod_Handle_Files_Subdirs_Table, Parameter list: $path,$prencells=0
    //*
    //* Adds subdirs to $table.
    //*

    function MyMod_Handle_Files_Subdirs_Table($path,$prencells=0)
    {
        $subdirs=$this->DirSubdirs($path);
        sort($subdirs);

        $table=array();
        foreach ($subdirs as $subdir)
        {
            $table=array_merge($table,$this->MyMod_Handle_Files_Subdir_Rows($subdir));


            $includetree=$this->GetPOST("Include_".$subdir);
            if ($includetree==1)
            {
                $table=$this->MyMod_Handle_Files_Table($path."/".basename($subdir),$table,$prencells++);
            }
        }
        

        return $table;
    }

    //*
    //* function MyMod_Handle_Files_Table, Parameter list: $path,$prencells
    //*
    //* Adds files to $table.
    //*

    function MyMod_Handle_Files_Path_Table($path,$prencells)
    {
        $files=$this->DirFiles($path);
        sort($files);

        if (count($files)==0) { return; }

        $table=array();
        array_push
        (
           $table,
           $this->MyMod_Handle_File_Title_Row($path,$prencells)
        );

        $comps=preg_split('/\//',$path);
        foreach ($files as $file)
        {
            array_push($table,$this->MyMod_Handle_File_Row($file,$prencells));
        }
        

        return $table;
    }
}

?>