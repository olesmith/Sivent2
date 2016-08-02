<?php

trait MyApp_Handle_Import
{
    //*
    //* function MyApp_Handle_Export_Handle, Parameter list:
    //*
    //* Does actual system Export (via PHP).
    //*

    function MyApp_Handle_Import_Handle()
    {
        echo
            $this->MyApp_Interface_Head();

        if (!empty($_FILES[ "Import" ]) && !empty($_FILES[ "Import" ][ 'tmp_name' ]))
        {
            $this->MyApp_Handle_Import_Do();
        }
        else
        {
            echo
                $this->H(3,"No file uploaded...");
        }

        
    }
    //*
    //* function MyApp_Handle_Export_Do, Parameter list:
    //*
    //* Does actual system Export (via PHP).
    //*

    function MyApp_Handle_Import_Do()
    {
        $file=$_FILES[ "Import" ][ 'tmp_name' ];
        $lines=$this->ReadPHPArray($file);

        foreach ($lines as $sqltable => $items)
        {
            $comps=preg_split('/_+/',$sqltable);
            $module=array_pop($comps);
            $obj=$module."Obj";
            if (method_exists($this,$obj))
            {
                echo
                    $this->$obj()->MyMod_Items_Import($items,$sqltable).
                    "end: ".$sqltable;
            }
        }
    }

}

?>