<?php

class MyFriends_Groups extends MyFriends_Events
{
    var $UpdateGroupHidden="Update";
    var $UpdatePermissionsHidden="Save";
    var $AddGroupVar="AddGroup";
    var $DeleteGroupVar="Delete";

    //*
    //* function GetFriendGroups, Parameter list: $friend
    //*
    //* Returns groups the $friend pertains to.
    //*

    function FriendGroups($friend)
    {
        return $this->GroupsObj()->MySqlUniqueColValues
        (
           "",
           "GID",
           array("FID" => $friend[ "ID" ])
        );
    }    
 
    //*
    //* function HandleFriendGroups, Parameter list:
    //*
    //* Handles Friend groups, showing and adding.
    //*

    function HandleFriendGroups()
    {
        $edit=1;
        $this->MyMod_Item_Read($this->GetGET("ID"));

        if ($edit==1 && $this->GetPOST($this->UpdateGroupHidden)==1)
        {
            $this->UpdateFriendGroups($this->ItemHash);
        }

        foreach (array("Name","Email") as $data)
        {
            $this->ItemData[ $data ][ $this->ApplicationObj->Profile ]=1;
        }

        print
            $this->FriendPermissionForm($edit,$this->ItemHash).
            $this->FriendGroupsForm($edit,$this->ItemHash).
            "";
    }
}

?>