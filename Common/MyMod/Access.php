<?php

trait MyMod_Access
{
    //*
    //* function MyMod_Access_Has, Parameter list:
    //*
    //* Returns true if access to module allowed.
    //* Supposed to be overwritten.
    //*

    function MyMod_Access_Has()
    {
        return TRUE;
    }

    //*
    //* function MyMod_Access_HashAccess, Parameter list: $hash,$value=array(1,2),$profile="",$logintype=""
    //*
    //* Tests if $hash has $this->LoginType and $this->Profile keys with value $value.
    //*

    function MyMod_Access_HashAccess($hash,$values=array(1,2),$profile="",$logintype="")
    {
        if (!is_array($values)) { $values=array($values); }
        $res=$this->MyHash_Hash2Access($hash,$values,$profile,$logintype);

        if (empty($profile)) { $profile=$this->Profile(); }
        
        if (empty($logintype))
        {
            if (!preg_match('/^(Admin|Public)/',$profile))
            {
                $logintype="Person";
            }
        }
        
        if (empty($logintype)) { $logintype=$this->LoginType(); }
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
        
        if ($res)
        {
            $key="AccessMethod";
            if (!empty($hash[ $key ]))
            {
                if (!is_array($hash[ $key ]))
                {
                    $hash[ $key ]=array($hash[ $key ]);
                }

                foreach ($hash[ $key ] as $method)
                {
                    if (method_exists($this,$method))
                     {
                        $res=$res && $this->$method();
                     }
                     else
                     {
                         $this->Debug=1;
                         $this->AddMsg("MyMod_Access_HashAccess: Invalid sgroup def access method: ".$method.", ignored");
                     }
                }
            }
        }
        
        return $res;
    }

    //*
    //* function MyMod_Access_HashesAccess, Parameter list: $hashes,$value=array(1)
    //*
    //* Tests if $hashes, as an ItemData, Actions entry (or other hash), is
    //* permitted for current user.
    //*
    //* Considered are LoginType and Profile keys. 
    //*

    function MyMod_Access_HashesAccess($hashes,$values=array(1,2),$profile="",$logintype="")
    {
        $names=array();
        foreach ($hashes as $name => $hash)
        {
            if ($this->MyMod_Access_HashAccess($hash,$values,$profile,$logintype))
            {
                array_push($names,$name);
            }
        }

        return $names;
    }
}

?>