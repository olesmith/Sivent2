<?php

include_once("MakeCGI/Cookies.php");
include_once("MakeCGI/Upload.php");
include_once("MakeCGI/Script.php");

trait MakeCGI
{
    var $CGI_Args_Sep="&";
    var $CGI_Split_Vars=array();
    var $CGI_SearchVars=array();

    use
        MakeCGI_Cookies,
        MakeCGI_Upload,
        MakeCGI_Script;

    function CGI_Server_Name()
    {
        return $_SERVER[ "SERVER_NAME" ];
    }



    function CGI_Query_String()
    {
        //Retrive query hash
        $argshash=$this->CGI_Query2Hash();
        if (is_array($args))
        {
            //Overwrite specified value
            foreach ($args as $arg => $value)
            {
                $argshash[ $arg ]=$value;
            }
        }
        elseif ($args!="")
        {
            $argshash=$this->CGI_Query2Hash($args);
        }

        //Retransform in query
        $qs=$this->CGI_Hash2Query($argshash);

        //Add ? if necessary
        if (preg_match('/\S/',$qs)) { $qs="?".$qs; }

        return $qs;
    }
    
    //*
    //* sub CGI_Redirect, Parameter list: $uri,$caller=""
    //*
    //* Redirects, sending location header.
    //*
    //*

    function CGI_Redirect($uri,$callerinfo="")
    {
        if (is_array($uri))
        {
            $uri="?".$this->CGI_Hash2URI($uri);
        }

        if (!empty($callerinfo))
        {
            echo 'Location: '.$uri." - Debug: ".$callerinfo;
            exit();
        }

        header( 'Location: '.$uri.$callerinfo);
    }

    //*
    //* sub CGI_Name, Parameter list: $option
    //*
    //* Preprocesses $option name: strtolower
    //*
    //*

    function CGI_TreatValue($value)
    {
        //Multiple selects
        if (is_array($value))
        {
            foreach (array_keys($value) as $id)
            {
                $value[ $id ]=$this->CGI_TreatValue($value[ $id ]);
            }

            return $value;
        }

        $value=htmlentities($value,ENT_QUOTES,'UTF-8' );

        //remove leading and trailing white space.
        $value=preg_replace('/^\s+/',"",$value);
        $value=preg_replace('/\s+$/',"",$value);
        
        return $value;
    }
    //*
    //* sub CGI_Treatint, Parameter list: $value
    //*
    //* Treats int value.
    //*

    function CGI_Treatint($value)
    {
        //Multiple selects
        if (is_array($value))
        {
            foreach (array_keys($value) as $id)
            {
                $value[ $id ]=$this->CGI_Treatint($value[ $id ]);
            }

            return $value;
        }
        $value=$this->CGI_TreatValue($value);
        $value=preg_replace('/[^-\d]+/',"",$value);

        return intval($value);
    }
    
     //*
    //* sub CGI_Treat_Real, Parameter list: $value
    //*
    //* Treats int value.
    //*

    function CGI_Treat_Real($value)
    {
        //Multiple selects
        if (is_array($value))
        {
            foreach (array_keys($value) as $id)
            {
                $value[ $id ]=$this->CGI_Treat_Real($value[ $id ]);
            }

            return $value;
        }
        $value=$this->CGI_TreatValue($value);
        $value=preg_replace('/[^-,\.\d]+/',"",$value);
        $value=preg_replace('/,/',".",$value);

        return floatval($value);
    }
    
    //*
    //* sub CGI_GetPOST, Parameter list: $name
    //*
    //* Returns $_POST $name key.
    //*

    function CGI_POST($name)
    {
        $value="";
        if (isset($_POST[ $name ]))
        {
            $value=$_POST[ $name ];
        }
        
        return $this->CGI_TreatValue($value);
    }

    //*
    //* sub CGI_GetPOSTint, Parameter list: $name
    //*
    //* $_POST $name key as an int.
    //*

    function CGI_POSTint($name)
    {
        $value=$this->CGI_POST($name);

        return $this->CGI_Treatint($value);
    }

    //*
    //* sub CGI_GetPOSTs, Parameter list: $name
    //*
    //* $_POST $name key as a list.
    //*

    function CGI_POSTs($name)
    {
        $values=$this->CGI_POST($name);
        if (!is_array($values)) { $values=array($values); }
        
        $rvalues=array();
        foreach ($values as $value)
        {
            $value=$this->CGI_TreatValue($value);
            if (!empty($value))
            {
                array_push($rvalues,$value);
            }
        }

        return $rvalues;
    }
    
    //*
    //* sub CGI_GetPOSTints, Parameter list: $name
    //*
    //* $_POST $name key as an list of ints.
    //*

    function CGI_POSTints($name)
    {
        $values=$this->CGI_POST($name);
        if (!is_array($values)) { $values=array($values); }
        
        $rvalues=array();
        foreach ($values as $value)
        {
            $value=$this->CGI_Treatint($value);
            if (!empty($value))
            {
                array_push($rvalues,$value);
            }
        }

        return $rvalues;
    }

    //*
    //* sub CGI_GetPOSTint, Parameter list: $name
    //*
    //* $_POST $name key as an int.
    //*

    function CGI_POST_Real($name)
    {
        $value=$this->CGI_POST($name);

        return $this->CGI_Treat_Real($value);
    }

    //*
    //* sub CGI_GetPOSTdate, Parameter list: $name
    //*
    //* $_POST $name key as a date. Exepcts dd/mm/yyyy and converts to yyyymmdd.
    //*

    function CGI_GetPOSTdate($name)
    {
        $value=$this->CGI_POST($name);

        return $this->CGI_Treatdate($value);
    }

    //*
    //* sub CGI_GET, Parameter list: $name
    //*
    //* Returns $_GET $name key.
    //*

    function CGI_GET($name)
    {
        $value="";
        if (isset($_GET[ $name ]))
        {
            $value=$_GET[ $name ];
        }

        $value=preg_replace('/\?.*/',"",$value);

        return $this->CGI_TreatValue($value);
    }

    //*
    //* sub CGI_GETint, Parameter list: $name
    //*
    //* Returns $_GET $name key as an int.
    //*

    function CGI_GETint($name)
    {
        if (!is_array($name)) { $name=array($name); }
        
        $value=0;
        foreach ($name as $rname)
        {
            $value=$this->CGI_GET($rname);

            if (!empty($value)) { break; }
        }

        return $this->CGI_Treatint($value);
    }

    //*
    //* sub CGI_Cookie, Parameter list: $name
    //*
    //* Returns $_COOKIE $name key.
    //*

    function CGI_Cookie($name)
    {
        $value="";
        if (isset($_COOKIE[ $name ]))
        {
            $value=$_COOKIE[ $name ];
        }
        
        return $this->CGI_TreatValue($value);
    }

    //*
    //* sub CGI_POSTOrGET, Parameter list: $name
    //*
    //*Returns $_POST or $_GET $name key.
    //*

    function CGI_POSTOrGET($name)
    {
        $value="";
        if (isset($_POST[ $name ]))
        {
            $value=$_POST[ $name ];
        }
        else
        {
            if (isset($_GET[ $name ]))
            {
                $value=$_GET[ $name ];
            }
        }

        return $this->CGI_TreatValue($value);
    }
    //*
    //* sub CGI_GETOrPOST, Parameter list: $name
    //*
    //*Returns $_GET or $_POST $name key.
    //*

    function CGI_GETOrPOST($name)
    {
        $value="";
        if (isset($_GET[ $name ]))
        {
            $value=$_GET[ $name ];
        }
        else
        {
            if (isset($_POST[ $name ]))
            {
                $value=$_POST[ $name ];
            }
        }

        return $this->CGI_TreatValue($value);
    }

    //*
    //* sub CGI_POSTOrGETint, Parameter list: $name
    //*
    //*Returns $_GET or $_POST $name key.
    //*

    function CGI_POSTOrGETint($name)
    {
        $value="";
        if (isset($_POST[ $name ]))
        {
            $value=$_POST[ $name ];
        }
        else
        {
            if (isset($_GET[ $name ]))
            {
                $value=$_GET[ $name ];
            }
        }

        return $this->CGI_Treatint($value);
    }

    //*
    //* sub CGI_GETOrPOSTint, Parameter list: $name
    //*
    //*Returns $_GET or $_POST $name key.
    //*

    function CGI_GETOrPOSTint($name)
    {
        $value="";
        if (isset($_GET[ $name ]))
        {
            $value=$_GET[ $name ];
        }
        else
        {
            if (isset($_POST[ $name ]))
            {
                $value=$_POST[ $name ];
            }
        }

        return $this->CGI_Treatint($value);
    }

    //*
    //* sub CGI_GETOrCOOKIE, Parameter list: $name
    //*
    //* Returns $_GET or $_COOKIE $name key.
    //*

    function CGI_GETOrCOOKIE($name)
    {
        $value="";
        if (isset($_GET[ $name ]))
        {
            $value=$_GET[ $name ];
        }
        else
        {
            if (isset($_COOKIE[ $name ]))
            {
                $value=$_COOKIE[ $name ];
            }
        }

        return $this->CGI_TreatValue($value);
    }

    //*
    //* sub CGI_POSTOrCOOKIE, Parameter list: $name
    //*
    //* Returns $_POST or $_COOKIE $name key.
    //*

    function CGI_POSTOrCOOKIE($name)
    {
        $value="";
        if (isset($_POST[ $name ]))
        {
            $value=$_POST[ $name ];
        }
        else
        {
            if (isset($_COOKIE[ $name ]))
            {
                $value=$_COOKIE[ $name ];
            }
        }
        
        return $this->CGI_TreatValue($value);
    }

    //*
    //* sub CGI_VarValue, Parameter list: $name
    //*
    //*
    //*

    function CGI_VarValue($name)
    {
        $value="";

        $value=$this->CGI_GET($name);
        if ($value=="")
        {
            $value=$this->CGI_POST($name);
            if ($value=="")
            {
                if (isset($_COOKIE[ $name ]))
                {
                    $value=$_COOKIE[ $name ];
                }          
            }
        }

        return $this->CGI_TreatValue($value);
    }

    //*
    //* sub CGI_URI2Hash, Parameter list: $uri="",$hash=array()
    //*
    //* Parses $uri into $args. If $uri empty, gets $_SERVER[ "QUERY_STRING" ].
    //*

    function CGI_URI2Hash($uri="",$hash=array())
    {
        if (empty($uri)) { $uri=$_SERVER[ "QUERY_STRING" ]; }
        $uri=preg_replace('/^\S*\?/',"",$uri);

        if (preg_match('/\S/',$uri))
        {
            $qargs=preg_split('/\s*&(amp;)?\s*/',$uri);
            foreach ($qargs as $arg)
            {
                $argss=preg_split('/\s*=\s*/',$arg);
                if (isset($argss[1]))
                {
                    $hash[ $argss[0] ]=$argss[1];
                }
            }
        }

        return $hash;
    }

    //*
    //* sub CGI_Hash2URI, Parameter list: $hash=array()
    //*
    //* Parses hash back out to URI.
    //*

    function CGI_Hash2URI($hash)
    {
        $queries=array();
        foreach ($hash as $arg => $value)
        {
            if (!empty($value))
            {
                $string=$arg."=".$value;
                array_push($queries,$arg."=".$value);
            }
        }

        return join("&",$queries);
    }


    //*
    //* sub CGI_GET2Hash, Parameter list: $cgivar,$sqltable,$key="",$attrname=""
    //*
    //* Reads, dynamically $cgivar, interpreting it as an ID, stores
    //* in $this->$attrname.
    //* Returns $this->$attrname[ $key ] if $key nonempty, the hash
    //* $this->$attrname otherwise.
    //*
    //*

    function CGI_GET2Hash($cgivar,$obj,$key="",$attrname="",$die=TRUE,$warn=FALSE)
    {
        if (empty($attrname)) { $attrname=$cgivar;}

        if (empty($this->$attrname))
        {
            $id=$this->CGI_GETint($cgivar);
            if (empty($id) && !preg_match('/^Admin$/',$this->Profile))
            {
                 $msg=
                    "CGI_GET2Hash: Fatal error! Invalid ".
                    $cgivar.
                    ": ".$id." Dying...".
                    "";

                $trace=debug_backtrace();
                $caller=$trace[1];

                $msg.=" Caller: ".$caller['function'];
                if (isset($caller['class']))
                {
                    $msg.="Class:  ".$caller['class'];
                }

                    if ($die)       { die($msg); }
                elseif ($warn)      { echo $msg; }

                return "";
            }

            if (!empty($attrname))
            {
                if (method_exists($this,$obj))
                {
                    $this->$attrname=$this->$obj()->Sql_Select_Hash(array("ID" => $id));
                }
                else
                {
                    die("No such ".$attrname." method, ".$obj);
                    
                }
            }
        }

        if (empty($key))
        {
            return $this->$attrname;
        }
        else
        {
            $hash=$this->$attrname;
            if (isset($hash[ $key ]))
            {
                return $hash[ $key ];
            }
            
            print "Warning! Invalid key ".$key;
            return NULL;
        }
    }
    
    function CGI_Query2Hash($qs="",$argshash=array())
    {
        if ($qs=="") { $qs=$_SERVER[ "QUERY_STRING" ]; }
        $qs=preg_replace('/\?/',"",$qs);

        if (preg_match('/\S/',$qs))
        {
            $qargs=preg_split('/\s*&(amp;)?\s*/',$qs);
            foreach ($qargs as $arg)
            {
                $argss=preg_split('/\s*=\s*/',$arg);
                if (isset($argss[1]))
	            {
                    $argshash[ $argss[0] ]=$argss[1];
                }
            }
        }

        return $argshash;
    }
    
    function CGI_Hash2Query($argshash=array())
    {
        $queries=array();
        foreach ($argshash as $arg => $value)
        {
            $string=$arg."=".$value;
            array_push($queries,$string);
        }

        return join($this->CGI_Args_Sep,$queries);
    }
    
    function CGI_Hidden2Hash($hash=array())
    {
        if (is_array($this->HiddenVars))
        {
            foreach ($this->HiddenVars as $var)
            {
                if (isset($_POST[ $var ]) && $_POST[ $var ]!="")
                {
                    $hash[ $var ]=$value;
                }
            }
        }

        return $hash;
    }
  function CGI_MakeHiddenFields($tabmovesdown=FALSE)
  {
      $fields=array();
      if ($tabmovesdown)
      {
          array_push
          (
             $fields,
             $this->MakeHidden
             (
                $this->ModuleName."_TabMovesDown",
                $this->GetPOST($this->ModuleName."_TabMovesDown")
             )
          );
      }

      if (is_array($this->HiddenVars))
      {
          foreach ($this->HiddenVars as $var)
          {
              $value=$this->GetGETOrPOST($var);
              if ($value!="") { array_push($fields,$this->MakeHidden($var,$value)); }
          }
      }

      if (is_array($this->CGI_Split_Vars))
      {
          foreach ($this->CGI_Split_Vars as $var => $def)
          {
              $vvar=$this->ItemName."_".$var;
              $val=$this->GetCGIVarValue($vvar."_Only");
           
              if ($val!="")
              {
                  array_push($fields,$this->MakeHidden($vvar."_Only",$val));
              }
          }
      }
      
      if (is_array($this->CGI_SearchVars))
      {
          foreach ($this->CGI_SearchVars as $var => $def)
          {
              $vvar=$this->ItemName."_".$var;
              $val=$this->GetCGIVarValue($vvar."_Search");
           
              if ($val!="")
              {
                  array_push($fields,$this->MakeHidden($vvar."_Search",$val));
              }
          }
      }


      return join("",$fields);
  }
}
?>