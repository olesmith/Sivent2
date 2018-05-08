<?php


trait Cookies
{
    //*
    //* function Cookies_Set, Parameter list:
    //*
    //* Sets cookies conforming to $cookievars.
    //*

    function Cookies_Set($cookievars)
    {
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

    //*
    //* function Cookies_Reset, Parameter list: $cookievars=array()
    //*
    //* Resets actual cookies included in $this->CookieVars, ie.
    //* sets them with value less than time().
    //*

    function Cookies_Reset($cookievars=array())
    {
        foreach ($_COOKIE as $cookievar => $cookievalue)
        {
            if (!preg_grep('/^'.$cookievar.'$/',$this->ConstantCookieVars))
            {
                $this->SetCookie($cookievar,"",time()-$this->CookieTTL);

                array_push($msgs,$cookievar);
            }
        }
    }


    //*
    //* sub Cookie_Get, Parameter list: $name
    //*
    //* Returns value of $name in $_Cookie.
    //*

    function Cookie_Get($name)
    {
        return $_COOKIE[ $name ];
    }

    //*
    //* sub Cookie_Set, Parameter list: $name,$value,$expire=""
    //*
    //* Sets cookie $cookie to value $value. If $expire is "",
    //* uses time()+$this->CookieTTL as expires value.
    //*

    function Cookie_Set($name,$value="",$expire="")
    {
        if ($expire=="") { $expire=time()+$this->CookieTTL; }
        if ($value!="" && isset($this->$value)) { $value=$this->$value; }

        setcookie($name,$value,$expire,$this->CGI_Script_Path());
        $_COOKIE[ $name ]=$value;

        $this->CookiesSet[ $name ]=$value;

        return $value;
    }
}


?>