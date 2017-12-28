<?php

trait MyMod_Handle_Files_Row
{
    //*
    //* function MyMod_Handle_Files_Subdir_Rows, Parameter list: $subdir,$prencells=0
    //*
    //* Creates subdir row of file system info
    //*

    function MyMod_Handle_Files_Subdir_Rows($subdir,$prencells=0)
    {
        $row=array($this->MultiCell("",$prencells),$subdir);
        
        $row=array_merge($row,$this->MyMod_Handle_File_Info_Row($subdir));

        array_push($row,$this->MyMod_Handle_File_Dir_Include_Box($subdir));
        array_push($row,$this->MyMod_Handle_File_Dir_Choose_All_Box($subdir));

        return array($row);
    }


    //*
    //* function MyMod_Handle_Files_Subdir_Title_Row, Parameter list: $file,$prencells=0
    //*
    //* Creates file row of file system info
    //*

    function MyMod_Handle_Files_Subdir_Title_Row($file,$prencells=0)
    {
        $row=array($this->MultiCell("",$prencells),"","File Name");

        $row=
            array_merge
            (
                $row,
                $this->MyMod_Handle_File_Info_Title_Row($file)
            );

        array_push($row,"");

        return $this->B($row);
    }
 
    //*
    //* function MyMod_Handle_File_Title_Row, Parameter list: $file,$prencells=0
    //*
    //* Creates file row of file system info
    //*

    function MyMod_Handle_File_Title_Row($file,$prencells=0)
    {
        $row=array($this->MultiCell("",$prencells),"","File Name");

        $row=
            array_merge
            (
                $row,
                $this->MyMod_Handle_File_Info_Title_Row($file)
            );

        array_push($row,"Deletar");

        return $this->B($row);
    }
    
    //*
    //* function MyMod_Handle_File_Row, Parameter list: $file,$prencells=0
    //*
    //* Creates file row of file system info
    //*

    function  MyMod_Handle_File_Row($file,$prencells=0)
    {
        $row=
            array
            (
                $this->MultiCell("",$prencells),
                "",
                basename($file)
            );

        $row=
            array_merge
            (
                $row,
                $this->MyMod_Handle_File_Info_Row($file)
            );

        array_push
        (
            $row,
            $this->MyMod_Handle_File_Delete_Box($file)
        );

        return $row;
    }

    //*
    //* function MyMod_Handle_File_Info_Row, Parameter list: $node
    //*
    //* Creates $node cells of file system info
    //*

    function MyMod_Handle_File_Info_Row($node)
    {
        $bool=array("N","Y");
        return array
        (
           date("d/m/Y H:i:s.",filectime($node)),
           date("d/m/Y H:i:s.",filemtime($node)),
           $this->MyMod_Handle_File_Info_Perms($node),
           posix_getpwuid(fileowner($node))[ "name" ],
           posix_getgrgid(filegroup($node))[ "name" ],
           $bool[ is_writable($node) ]
        );
    }

    //*
    //* function MyMod_Handle_File_Info_Title_Row, Parameter list: 
    //*
    //* Creates $node title row of file system info
    //*

    function MyMod_Handle_File_Info_Title_Row($node)
    {
        return
            $this->B
            (
               array
               (
                  "Created",
                  "Modified",
                  "Perms",
                  "User",
                  "Group",
                  "Writeable"
               )
            );
    }



}

?>