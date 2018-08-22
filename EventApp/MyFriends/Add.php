<?php

include_once("Add/Mail.php");
include_once("Add/New.php");
include_once("Add/Table.php");
include_once("Add/Search.php");

class MyFriends_Add extends MyFriends_Add_Search
{
    //*
    //* function MyFriend_Add_Form, Parameter list: 
    //*
    //* Creates (mini) form for adding a friend.
    //*

    function MyFriend_Add_Form()
    {
        $datas=$this->MyMod_Data_Compulsories();

        return "AddFriendForm";
    }

    
    //*
    //* function AddReadFriends, Parameter list: 
    //*
    //* Reads Add friends.
    //*

    function AddReadFriends()
    {
        $where=$this->FriendSelectCGI2Where();

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
        $newitem[ "Email" ]=preg_replace('/\s+/',"",$newitem[ "Email" ]);
        $newitem[ "Name" ]=preg_replace('/^\s+/',"",$newitem[ "Name" ]);
        $newitem[ "Name" ]=preg_replace('/\s+$/',"",$newitem[ "Name" ]);
        
        $this->ItemData[ "Name" ][ $this->Profile() ]=1;
        $this->ItemData[ "Email" ][ $this->Profile() ]=1;

        $where=$this->FriendSelectCGI2Where();

        $unit=$this->GetPOST("Unit");
        if (preg_match('/^(Coordinator)$/',$this->Profile()))
        {
            $unit=$this->ApplicationObj->LoginData[ "Unit" ];
        }



        $friends=array();
        if (!empty($newitem[ "Email" ]) || !empty($newitem[ "Name" ]))
        {
            $friends=$this->AddReadFriends();
        }

        $subtitle="";
        if (!empty($where))
        {
           if (count($friends)>0)
            {
                $subtitle=$this->MyLanguage_GetMessage("Friend_Select_Table_Title");
            }
        }

        if ($this->GetPOST("Save")==1)
        {
            $this->FriendSelectResultUpdate($friends);
        }

        $html=
            $this->FriendSelectSearchForm($leadingrows).
            "";
        #if ($this->GetPOST("AddFriend")==1)
        if (!empty($newitem[ "Email" ]) && !empty($newitem[ "Name" ]))
        {
            $html.="".
                $this->H
                (
                    3,
                    $this->FriendSelectAddFriend($newitem)
                ).
                "";
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
                   $this->MyLanguage_GetMessage("Friend_Select_Table_Promote_Msg")
                ).
                ""; 
        }

        if (!empty($newitem[ "Email" ]))
        {
            if ($this->MyEmail_Address_Valid($newitem[ "Email" ]))
            {
                if (!empty($newitem[ "Name" ]))
                {
                    $friends=$this->Sql_Select_Hashes(array("Email" => $newitem[ "Email" ]));

                    if (
                           count($friends)==0
                           &&
                           (
                               $this->GetPOST("Search")==1
                               ||
                               (
                                   !empty($newitem[ "Email" ]) && !empty($newitem[ "Name" ])
                               )
                               
                           )
                       )
                    {
                        $html.=
                            $this->H
                            (
                                6,
                                $this->MyLanguage_GetMessage("Friend_Select_Table_Empty")
                            ).
                            $this->FriendSelectNewForm($newitem).
                            "";
                    }
                }
                else
                {
                    $html.=
                        $this->Div
                        (
                            $this->MyLanguage_GetMessage("Friend_Select_Name_Empty"),
                            array("CLASS" => 'errors')
                        ).
                        "";
                }
            }
            else
            {
                $html.=
                    $this->H
                    (
                        6,
                        $this->MyLanguage_GetMessage("Friend_Select_Email_Invalid")
                    ).
                    "";
            }
        }
        //else { $html.="???"; }

        $html.=
            $this->DIV
            (
                $this->DIV
                (
                    $this->MyLanguage_GetMessage("Friend_Select_Table_Info_Msg"),
                    array("CLASS" => "message-body has-text-centered")
                ),
                array("CLASS" => "message is-primary")
            ).
            "";

        return $html;
    }
}

?>