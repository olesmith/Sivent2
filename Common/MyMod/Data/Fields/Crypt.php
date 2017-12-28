<?php


trait MyMod_Data_Fields_Crypt
{    
    //*
    //* Crypt field values.
    //*

    function MyMod_Data_Field_Crypt($data,$newvalue)
    {
        if ($this->MyMod_Data_Field_Is_Crypted($data) && !empty($newvalue))
        {
            if ($this->MyMod_Data_Field_Is_MD5($data))
            {
                $newvalue=$this->ApplicationObj()->MyApp_Auth_Crypt_Password_MD5($newvalue);
            }
            elseif ($this->MyMod_Data_Field_Is_BlowFish($data))
            {
                $newvalue=$this->ApplicationObj()->MyApp_Auth_Crypt_Password_BlowFish($newvalue);
            }
        }

        return $newvalue;
    }
}

?>