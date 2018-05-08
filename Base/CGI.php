<?php

include_once("Html.php");
include_once("CSV.php");
include_once("Latex.php");
//include_once("Cookies.php");
include_once("../Base/Messages.php");
include_once("SqlQuery.php");
include_once("Lists.php");

class CGI extends Lists
{
    var $HiddenVars=array();

    var $URL_Args_Separator="&";

    function CGI()
    {
        $this->InitCGI();
    }

    function ReadExtraPathInfo()
    {
        $pathinfos=$this->CGI_Script_Extra_Path_Infos();
        foreach ($this->ExtraPathVars as $id => $var)
        {
            if (count($pathinfos)>0)
            {
                $value=array_shift($pathinfos);
                $this->$var=$value;
            }

            if ($this->$var=="")
            {
                $value=$this->GetCGIVarValue($var);
                if ($value!="")
                {
                    $this->AddMsg("Extra path info from cgi: ".$var."=".$value,2,TRUE);
                    $this->$var=$value;
                }
            }
        }
    }

    /* function ExtraPathPathCorrection() */
    /* { */
    /*     $comps=preg_split('/\//',$this->GetExtraPathInfo()); */

    /*     $pathinfos=array(); */
    /*     foreach ($comps as $id => $val) */
    /*     { */
    /*         if ($val!="") */
    /*         { */
    /*             array_push($pathinfos,".."); */
    /*         } */
    /*     } */

    /*     $pc=""; */
    /*     if (count($pathinfos)>0) */
    /*     { */
    /*         $pc=join("/",$pathinfos); */
    /*     } */

    /*     return $pc; */
    /* } */

    function FilterExtraPathVars($text)
    {
        $hash=array();
        foreach ($this->ExtraPathVars as $id => $var)
        {
            $hash[ $var ]=$this->$var;
        }

        return $this->FilterHash($text,$hash);
    }

    function GenExtraPathInfo()
    {
        $pathinfos=array();
        foreach ($this->ExtraPathVars as $id => $var)
        {
            if ($this->$var!="")
            {
                array_push($pathinfos,$this->$var);
            }
        }

        if (count($pathinfos)>0)
        {
            return "/".join("/",$pathinfos);
        }

        return "";
    }

    function InitCGI($hash=array())
    {
        $this->ReadExtraPathInfo();

        $lang=$this->GetCGIVarValue("Lang");
        if ($lang!="")
        {
            array_push($this->CookieVars,"Lang");
            $this->Language=$lang;
        }

        foreach ($this->GlobalGCVars as $key => $def)
        {
            $rvalue=$this->$key;
            $value=$this->GetCookieOrGET($key);
            if ($value!="")
            {
                $this->$key=$value;
            }

            if ($this->$key=="")
            {
                $this->$key=$def[ "Default" ];
            }

            $rvalue=$this->$key;
            if ($rvalue=="")
            {
                print "No $key, ciiiiao! (".$rvalue.")";
                exit();
            }

            $values=$def[ "Values" ];
            if (!preg_grep('/^'.$rvalue.'$/',$values))
            {
                print "Invalid '$key'-value: '$rvalue', tiiau!";
                exit();
            }
        }
    }




  /* function MakeHiddenFields($tabmovesdown=FALSE) */
  /* { */
  /*     return $this->CGI_MakeHiddenFields($tabmovesdown); */
  /* } */

  function MakeHiddenQuery()
  {
      $fields=array();
      if (is_array($this->HiddenVars))
      {
          foreach ($this->HiddenVars as $var)
          {
              $value=$_GET[ $var ];
              if ($value=="") { $value=$_POST[ $var ]; }
              if ($value!="") { array_push($fields,join("=",array($var,$value))); }
          }
      }

      return join($this->URL_Args_Separator,$fields);
  }


    //*
    //* sub TreatCGIValue, Parameter list: $value
    //*
    //* Clean value retrieved from the CGI, ie:
    //*
    //* turn ''s into "&#39;". Calls htmlentities.

    function TreatCGIValue($value)
    {
        //$value=preg_replace('/\\\\\'/',"&#39;",$value);
        $value=htmlentities($value,ENT_QUOTES,'UTF-8' );

        return $value;
    }

    //*
    //* sub TreatCGIint, Parameter list: $value
    //*
    //* Treats int value.

    function TreatCGIint($value)
    {
        $value=$this->TreatCGIValue($value);
        $value=preg_replace('/[^\d]+/',"",$value);

        return intval($value);
    }

    //*
    //* sub GetPOST, Parameter list: $name
    //*
    //*

    function GetPOST($name)
    {
        $value="";
        if (isset($_POST[ $name ]))
        {
            $value=$_POST[ $name ];
        }
        
        
        return $this->TreatCGIValue($value);
    }

    //*
    //* sub GetPOSTint, Parameter list: $name
    //*
    //*

    function GetPOSTint($name)
    {
        $value=$this->GetPOST($name);

        return $this->TreatCGIint($value);
    }

    //*
    //* sub GetGET, Parameter list: $name
    //*
    //*

    function GetGET($name)
    {
        $value="";
        if (isset($_GET[ $name ]))
        {
            $value=$_GET[ $name ];
        }

        $value=preg_replace('/\?.*/',"",$value);

        return $this->TreatCGIValue($value);
    }

    //*
    //* sub GetGETint, Parameter list: $name
    //*
    //*

    function GetGETint($name)
    {
        $value=$this->GetGET($name);

        return $this->TreatCGIint($value);
    }

    //*
    //* sub GetCookie, Parameter list: $name
    //*
    //*

    function GetCookie($name)
    {
        $value="";
        if (isset($_COOKIE[ $name ]))
        {
            $value=$_COOKIE[ $name ];
        }
        
        return $this->TreatCGIValue($value);
    }
    //*
    //* sub GetGETOrPOST, Parameter list: $name
    //*
    //*

    function GetGETOrPOST($name)
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

        return $this->TreatCGIValue($value);
    }

    //*
    //* sub GetCookieOrGET, Parameter list: $name
    //*
    //*

    function GetCookieOrGET($name)
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

        return $this->TreatCGIValue($value);
    }

    //*
    //* sub GetCookieOrPOST, Parameter list: $name
    //*
    //*

    function GetCookieOrPOST($name)
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
        
        return $this->TreatCGIValue($value);
    }

    //*
    //* sub GetCGIVarValue, Parameter list: $name
    //*
    //*

    function GetCGIVarValue($name)
    {
        $value="";

        $value=$this->GetGET($name);
        if ($value=="")
        {
            $value=$this->GetPOST($name);
            if ($value=="")
            {
                if (isset($_COOKIE[ $name ]))
                {
                    $value=$_COOKIE[ $name ];
                }          
            }
        }

        return $this->TreatCGIValue($value);
    }

    //*
    //* sub GetCGIVarRegexValue, Parameter list: $name
    //*
    //*

    function GetCGIVarRegexValue($regex)
    {
        $keys=array_keys($_GET);
        $keys=preg_grep('/'.$regex.'/',$keys);
        if (count($keys)==1)
        {
            return $this->GetCGIVarValue(array_pop($keys));
        }

        $keys=array_keys($_POST);
        $keys=preg_grep('/'.$regex.'/',$keys);
        if (count($keys)==1)
        {
            return $this->GetCGIVarValue(array_pop($keys));
        }

        $keys=array_keys($_COOKIE);
        $keys=preg_grep('/'.$regex.'/',$keys);
        if (count($keys)==1)
        {
            return $this->GetCGIVarValue(array_pop($keys));
        }
    }

    //*
    //* sub GetFirstPOSTDefined, Parameter list: $name
    //*
    //*

    function GetFirstPOSTDefined($fieldnames)
    {
        $value="";
        $n=0;
        while ($value=="" && $n<count($fieldnames))
        {
            if (isset($_POST[ $fieldnames[ $n ] ]))
            {
                $value=$_POST[ $fieldnames[ $n ] ];
            }

            $n++;
        }
        
        return $this->TreatCGIValue($value);
    }



    //*
    //* sub ReadUploadedFile, Parameter list: $field,$extensions=array()
    //*
    //* Reads uploaded file $data
    //*

    function ReadUploadedFile($field,$extensions=array())
    {
        $uploadinfo=$_FILES[ $field ];

        $lines=array();
        if (is_array($uploadinfo) && $uploadinfo[ 'tmp_name' ]!="")
        {
            $error=$uploadinfo['error']; //react!

            $comps=preg_split('/\./',$uploadinfo['name']);
            $ext=array_pop($comps);
            if (count($extensions)==0 || preg_grep('/^'.$ext.'$/',$extensions))
            {
                $lines=$this->MyReadFile($uploadinfo['tmp_name']);
            }
        }

        return $lines;
    }



}


?>