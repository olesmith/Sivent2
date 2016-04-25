<?php

global $ClassList;
array_push($ClassList,"Cookies");

class Cookies extends Latex
{
    var $URL;
    var $ConstantCookieVars=array("SID","Profile");
    var $CookieVars=array();
    var $CookieValues=array();
    var $CookieTTL=3600;
    var $CookiesWritten=0;
    var $CookiesSet=array();
    var $CookieLog=array();

    //*
    //* function AddCookieVar, Parameter list: $var,$value=""
    //*
    //* Add $var to list of Cookies, $this->CookieVars
    //*

    function AddCookieVar($var,$value="")
    {
        array_push($this->CookieVars,$var);

        if ($value!="") { $this->CookieValues[ $var ]=$value; }
    }


    //*
    //* function SetCookieVars, Parameter list:
    //*
    //* Sets actual cookies included in $this->CookieVars.
    //*

    function SetCookieVars($cookievars=array(),$values=array())
    {
        if ($this->GetCookieOrGET("NoHeads")==1)
        {
            array_push($this->CookieVars,"NoHeads");
            array_push($cookievars,"NoHeads");
            $values["NoHeads" ]=1;
        }

        if ($this->CookiesWritten==0)
        {
            if ($this->CookieTTL==0) { $this->CookieTTL=60*60; }
            if (count($cookievars)==0) { $cookievars=$this->CookieVars; }

            $rcookievars=array();
            foreach ($cookievars as $cookievar)
            {
                $cookievalue="";
                if (isset($values[ $cookievar ]))
                {
                    $cookievalue=$values[ $cookievar ];
                }

                if (
                      $cookievalue==""
                      &&
                      isset($this->CookieValues[ $cookievar ])
                   )
                {
                    $cookievalue=$this->CookieValues[ $cookievar ];
                }

                if ($cookievar=="Admin")
                {
                    if ($this->GetCGIVarValue("Action")=="Admin")
                    {
                        $cookievalue=1;
                    }
                    elseif ($this->GetCGIVarValue("Action")=="NoAdmin")
                    {
                        $cookievalue=0;
                    }
                    else
                    {
                        $cookievalue=$_COOKIE[ "Admin" ];
                    }
                    $cookievalue=$this->GetCGIVarValue($cookievar,1);
                }
                else
                {
                    $cookievalue=$this->GetCGIVarValue($cookievar,1);
                }

                $rcookievars[ $cookievar ]=$this->SetCookie($cookievar,$cookievalue,time()+$this->CookieTTL);
            }
        }
        else
        {
            //print "Late write cookies...";
            //exit();
        }

        $this->CookiesWritten=1;
    }

    //*
    //* function ResetCookieVars, Parameter list: $cookievars=array()
    //*
    //* Resets actual cookies included in $this->CookieVars, ie.
    //* sets them with value less than time().
    //*

    function ResetCookieVars($cookievars=array())
    {
        $noheads=$this->GetCookieOrGET("NoHeads");



        $msgs=array();
        if ($this->CookiesWritten==0)
        {
            if ($this->CookieTTL==0) { $this->CookieTTL=60*60; }
            if (count($cookievars)==0) { $cookievars=$this->CookieVars; }

            foreach ($_COOKIE as $cookievar => $cookievalue)
            {
                if (!preg_grep('/^'.$cookievar.'$/',$this->ConstantCookieVars))
                {
                    $this->SetCookie($cookievar,"",time()-$this->CookieTTL);

                    array_push($msgs,$cookievar);
                }
            }

            if ($noheads==1)
            {
                $this->SetCookie("NoHeads",1,time()+$this->CookieTTL);
            }
        }
        else
        {
            //print "Late reset cookies...";
            //exit();
        }

        //print join(", ",$msgs); exit();
        //$this->CookiesWritten=1;
    }


    //*
    //* sub GetCookie, Parameter list: $name
    //*
    //* Returns value of $name in $_Cookie.
    //*

    function GetCookie($name)
    {
        return $_COOKIE[ $name ];
    }

    //*
    //* sub SetCookie, Parameter list: $name,$value,$expire=""
    //*
    //* Sets cookie $cookie to value $value. If $expire is "",
    //* uses time()+$this->CookieTTL as expires value.
    //*

    function SetCookie($name,$value="",$expire="")
    {
        if ($expire=="") { $expire=time()+$this->CookieTTL; }
        if ($value!="" && isset($this->$value)) { $value=$this->$value; }

        if (is_array($value))
        {
            return FALSE;
        }

        if ($this->Handle && $this->CookiesWritten==0)
        {
            if (!$this->ApplicationObj()->HeadersSend)
            {
                setcookie($name,$value,$expire,$this->ScriptPath());
                $_COOKIE[ $name ]=$value;

                $this->CookiesSet[ $name ]=$value;

                return $value;
            }
        }
        elseif ($this->CookiesWritten!=0)
        {
            //print "Late cookie: $name";
            //exit();
        }

        return FALSE;
    }
}


?>