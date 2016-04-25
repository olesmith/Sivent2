<?php

trait MyMod_Access
{
    //*
    //* function MyMod_Access_HashAccess, Parameter list: $hash,$value=array(1)
    //*
    //* Tests if $hash has $this->LoginType and $this->Profile keys with value $value.
    //*

    function MyMod_Access_HashAccess($hash,$values=array(1))
    {
        if (!is_array($values)) { $values=array($values); }

        $logintype=$this->LoginType();
        $profile=$this->Profile();

        $res=$this->MyHash_Hash2Access($hash,$values);

        if ($logintype=="Person")
        {
            if (!empty($hash[ "ConditionalAdmin" ]))
            {
                if ($this->ApplicationObj()->MyApp_Profile_MayBecomeAdmin())
                {
                    if (preg_grep('/^'.$hash[ "ConditionalAdmin" ].'$/',$values))
                    {
                        $res=TRUE;
                    }
                }
            }
        }
        
        if ($res>0)
        {
            if (!empty($hash[ "AccessMethod" ]))
            {
                $method=$hash[ "AccessMethod" ];
                //$res=$this->$method($hash); 02/01/2016
                $res=$this->$method();
            }
        }

        return $res;
    }

}

?>