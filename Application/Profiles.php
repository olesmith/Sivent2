<?php


class Profiles extends Perms
{
    var $ValidProfiles=array();
    var $Menus=array();
    var $DefaultProfile=0;
    var $AllowedProfiles=array();
    var $Profiles=array();
    var $Profile="";
    var $NProfiles=0;

    var $ProfilesSubPath="Profiles";
    var $ProfilesPath="System/Profiles";

    //*
    //* function ProfilesDatas, Parameter list:
    //*
    //* Add Profile_$profile, for each profile;
    //*

    function ProfilesDatas()
    {
        $datas=array();
        foreach (array_keys($this->Profiles()) as $profile)
        {
            if ($profile=="Public") { continue; }
            
            array_push($datas,"Profile_".$profile);
        }
        
        return $datas;
    }
}

?>