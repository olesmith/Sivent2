<?php


trait DB_Method
{
    //Turns method names into db type names. Currently only MySql.

    //*
    //* function DB_Method, Parameter list: $method
    //*
    //* Returns DB_$type_$function, where $type is $this->DBHash[ "Type" ].
    //*

    function DB_Method($method)
    {
        return
            "DB_".
            $this->DBHash[ "Type" ].
            "_".
            $method;
    }

    //*
    //* function DB_Method_Call, Parameter list: $method,$arg1=null,$arg2=null,$arg3=null,$arg4=null,$arg5=null
    //*
    //* Returns DB_$type_$function, where $type is $this->DBHash[ "Type" ].
    //*

    function DB_Method_Call($method,$arg1=null,$arg2=null,$arg3=null,$arg4=null,$arg5=null)
    {
        $method=$this->DB_Method($method);
        return $this->$method($arg1,$arg2,$arg3,$arg4,$arg5);
    }
}

?>