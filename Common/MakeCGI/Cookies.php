<?php

trait MakeCGI_Cookies
{
    var $MakeCGI_Cookie_TTL=3600;
    var $MakeCGI_Cookie_Written=FALSE;

    //*
    //* sub MakeCGI_Cookie_Set, Parameter list: $name,$value,$expire=""
    //*
    //* Sets cookie $cookie to value $value. If $expire is "",
    //* uses time()+$this->CookieTTL as expires value.
    //*

    function MakeCGI_Cookie_Set($name,$value="",$expire="")
    {
        if ($expire=="") { $expire=time()+$this->MakeCGI_Cookie_TTL; }
        if ($value!="" && isset($this->$value)) { $value=$this->$value; }

        if (is_array($value))
        {
            return FALSE;
        }

        setcookie($name,$value,$expire,$this->ScriptPath());
        $_COOKIE[ $name ]=$value;

        return $value;
    }
}
?>