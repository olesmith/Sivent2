<?php

trait MyApp_CGIVars_CGI
{
    //*
    //* function MyApp_CGIVar_CGI_Read_Def, Parameter list: $cgivar,$def
    //*
    //* GETS global vars system. Hierarquical.
    //*

    function MyApp_CGIVar_CGI_Read_Def($cgivar,$def)
    {
        $value=$this->MyApp_CGIVar_CGI_GetValue($cgivar,$def);

        $object=$def[ "SqlObject" ];

        $destination=$def[ "GlobalKey" ];

        $sqltable=$this->$object($def[ "InitSqlTable" ])->SqlTableName();
        if ($this->Sql_Table_Exists($sqltable))
        {
            $this->$destination=$this->$object($def[ "InitSqlTable" ])->Sql_Select_Hash
            (
               array("ID" => $value),
               array(),
               TRUE
            );

            if (empty($this->$destination) && !empty($def[ "Compulsory" ]))
            {
                if (!empty($def[ "AltAction" ]))
                {
                    $method=$def[ "AltAction" ];
                    $this->$method();
                    exit();
                }
                else
                {
                    $this->DoDie($this->$object()->ItemName." with ID ".$value." nonexistent..");
                }
            }
            
            $this->MyApp_CGIVar_CGI_Post_Method($cgivar,$def,$this->$destination);
            $this->MyApp_CGIVar_CGI_Post_Reads($cgivar,$def,$this->$destination);
        }
        
    }

    //*
    //* function MyApp_CGIVar_CGI_Value, Parameter list: $cgivar,$def
    //*
    //* GETS global vars system. Hierarquical.
    //*

    function MyApp_CGIVar_CGI_Value($cgivar,$def)
    {
        $destination=$def[ "GlobalKey" ];
        $destination=$this->$destination;

        return $destination[ "ID" ];
    }

    //*
    //* function MyApp_CGIVar_CGI_Post_Reads, Parameter list: $cgivar,$def,$hash
    //*
    //* Will Perform $def PostReads
    //*

    function MyApp_CGIVar_CGI_Post_Reads($cgivar,$def,$hash)
    {
        if (!empty($hash) && !empty($def[ "PostReads" ]))
        {
            foreach ($def[ "PostReads" ] as $key => $readdef)
            {
                $method=$readdef[ "ReadMethod" ];
                if (method_exists($this->ApplicationObj(),$method))
                {
                    $this->$method();
                    continue;                
                }
                elseif (!empty($readdef[ "SqlObject" ]))
                {
                    $object=$readdef[ "SqlObject" ];
                    if (method_exists($this->$object(),$method))
                    {
                        $this->$object()->$method();
                        continue;                
                    }
                }

                //Still here: bad luck...
                $this->DoDie("no can do ".$method,$def);
            }
        }
    }

    //*
    //* function MyApp_CGIVar_CGI_Post_Method, Parameter list: $cgivar,$def
    //*
    //* Will Perform $def PostReads
    //*

    function MyApp_CGIVar_CGI_Post_Method($cgivar,$def)
    {
        if (!empty($def[ "PostMethod" ]))
        {
            $method=$def[ "PostMethod" ];

            $this->$method();                    
        }
    }


    //*
    //* function MyApp_CGIVar_CGI_GetValue, Parameter list: $cgivar,$def
    //*
    //* GETS global vars system. Hierarquical.
    //*

    function MyApp_CGIVar_CGI_GetValue($cgivar,$def)
    {
        $value=$this->MyApp_CGIVar_CGI_2Value($cgivar,$def);

        if ($this->MyApp_CGIVar_CGI_Value_IsValid($cgivar,$def,$value))
        {
            return $value;
        }
        else
        {
            if ($this->MyApp_CGIVar_CGI_Value_IsCompulsory($cgivar,$def,$value))
            {
                $this->DoDie("CGI Var '".$cgivar."' compulsory, but not defined: ".$value,$def);
            }
        }

        return 0;
    }



    //*
    //* function MyApp_CGIVar_CGI_ValidValue, Parameter list: $cgivar,$def
    //*
    //* Tests if value read is compulsory (if so defined in $def),
    //* 
    //*

    function MyApp_CGIVar_CGI_Value_IsValid($cgivar,$def,$value)
    {
        if (!preg_match('/^ \d+$/',$value)) { $res=FALSE; }

        $value=intval($value);

        if (!empty($value))
        {
            if ($value>0) { $res=TRUE; }
        }

       return $res;
    }
    //*
    //* function MyApp_CGIVar_CGI_Value_IsCompulsory, Parameter list: $cgivar,$def
    //*
    //* Tests if $cgivar is compulsory, if so defined in $def),
    //* 
    //*

    function MyApp_CGIVar_CGI_Value_IsCompulsory($cgivar,$def)
    {
        $res=FALSE;

        $key="Compulsory".$this->Profile();
        if (isset($def[ $key ]))
        {
            $res=$def[ $key ];
        }
        elseif ($def[ "Compulsory" ]) 
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function MyApp_CGIVar_CGI_2Value, Parameter list: $cgivar,&$def
    //*
    //* Tries all possibilites of $def[ "From" ]'s to retrieve $cgivar from CGI, Login or Default.
    //*

    function MyApp_CGIVar_CGI_2Value($cgivar,&$def)
    {
        $value=0;
        foreach ($def[ "From" ] as $from => $var)
        {
            if (empty($var)) { continue; }

            $value=$this->MyApp_CGIVar_CGI_Type2Value($var,$def,$from);

            //If found, brek
            if (!empty($value)) { $def[ "Found" ]=$from; break; }
        }

        $def[ "Found" ]=FALSE;

        return $value;
    }


    //*
    //* function MyApp_CGIVar_CGI_Type2Value, Parameter list: $cgivar,$def
    //*
    //* GETS global vars system. Hierarquical.
    //*

    function MyApp_CGIVar_CGI_Type2Value($cgivar,$def,$from)
    {
        $value=0;
        if ($from=="GET")
        {
            $value=$this->CGI_GETint($cgivar);
        }
        elseif ($from=="POST")
        {
            $value=$this->CGI_POSTint($cgivar);
        }
        elseif ($from=="COOKIE")
        {
            $value=$this->CGI_POSTint($cgivar);
        }
        elseif ($from=="Login" && $this->IsLogged())
        {
            $value=$this->LoginData($cgivar);
        }
        elseif ($from=="Default")
        {
            $value=$this->$cgivar();
        }

        return $value;
    }
}

?>