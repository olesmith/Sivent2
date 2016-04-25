<?php


include_once("Users/Registration.php");

class AppUsers extends AppUsersRegistration
{
    //*
    //* function UsersObj, Parameter list:
    //*
    //* Initializes and return Users module, according to keys 
    //* from AuthHash.
    //*

    function UsersObj()
    {
        $usersobj=$this->AuthHash[ "Object" ];
        if (empty($this->$usersobj))
        {
            $objacessor=preg_replace('/Object$/',"Obj",$usersobj);
            
            return $this->$objacessor();
        }

        return $this->$usersobj;
    }
}

?>