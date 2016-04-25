<?php

include_once("Add/Mail.php");
include_once("Add/New.php");
include_once("Add/Table.php");
include_once("Add/Search.php");

class MyFriendsAdd extends MyFriendsAddSearch
{
    //*
    //* function AddReadFriends, Parameter list: 
    //*
    //* Reads Add friends.
    //*

    function AddReadFriends()
    {
        $where=$this->FriendSelectCGI2Where();

        $unit=$this->GetPOST("Unit");
        if (preg_match('/^(Coordinator)$/',$this->Profile()))
        {
            $unit=$this->ApplicationObj->LoginData[ "Unit" ];
        }

        $friends=array();

        $subtitle="";
        if (!empty($where))
        {
            $friends=$this->SelectHashesFromTable
            (
               "",
               $where,
               $this->FriendSelectDatas,
               FALSE,
               "",
               FALSE
            );
        }

        return $friends;
    }

    //*
    //* function HandleFriendSelect, Parameter list: $newitem,$editlist=TRUE,$leadingrows=array(),$resulthiddens=array()
    //*
    //* Handles Friend Selection.
    //*

    function HandleFriendSelect($newitem,$editlist=TRUE,$leadingrows=array(),$resulthiddens=array())
    {
        $this->ItemData[ "Name" ][ $this->Profile() ]=1;
        $this->ItemData[ "Email" ][ $this->Profile() ]=1;

        $where=$this->FriendSelectCGI2Where();

        $unit=$this->GetPOST("Unit");
        if (preg_match('/^(Coordinator)$/',$this->Profile()))
        {
            $unit=$this->ApplicationObj->LoginData[ "Unit" ];
        }



        $friends=$this->AddReadFriends();

        $subtitle="";
        if (!empty($where))
        {
           if (count($friends)>0)
            {
                $subtitle=$this->FriendSelectTableTitle;
            }
        }

        if ($this->GetPOST("Save")==1)
        {
            $this->FriendSelectResultUpdate($friends);
        }

        $html=
            $this->FriendSelectSearchForm($leadingrows).
            "";

        if ($this->GetPOST("AddFriend")==1)
        {
            $msg=$this->FriendSelectAddFriend($newitem);
            $html.=$this->H(3,$msg);
        }

        $html.=
             $this->FriendSelectResultForm($editlist,$subtitle,$friends,$resulthiddens).
            "";

        if (count($friends)>0)
        {
            $html.=
                $this->H
                (
                   6,
                   $this->FriendSelectPromoteMsg
                ).
                ""; 
        }
        elseif ($this->GetPOST("Search")==1 || $this->GetPOST("AddFriend")==1)
        {
            $html.=
               $this->H
                (
                   6,
                   $this->FriendSelectTableEmpty
                ).
                $this->FriendSelectNewForm($newitem).
                ""; 
        }

        $html.=
            $this->H
            (
               5,
               $this->FriendSelectInfoMsg
            ).                
            "";

        return $html;
    }
}

?>