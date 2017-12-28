<?php

trait MakeCGI_Upload
{
    //*
    //* sub MakeCGI_Upload_File, Parameter list: $data
    //*
    //* Returns CGI FILE filed uploaded file.
    //*

    function MakeCGI_Upload_File($data)
    {
        $lines=array();
        if (!empty($_FILES[ $data ]) && !empty($_FILES[ $data ][ 'tmp_name' ]))
        {
            $uploadinfo=$_FILES[ $data ];

            $lines=$this->MyReadFile($_FILES[ $data ][ 'tmp_name' ]);
        }
        
        return $lines;
    }
}
?>