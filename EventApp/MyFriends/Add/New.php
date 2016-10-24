<?php

class MyFriends_Add_New extends MyFriends_Add_Mail
{
    //*
    //* function FriendSelectNewTable, Parameter list: $newitem
    //*
    //* Generates Friend Select new item table.
    //*

    function FriendSelectNewTable($newitem)
    {
        $profile=$this->Profile();
        $this->ItemData[ "Name"     ][ $profile ]=2;
        $this->ItemData[ "Email"    ][ $profile ]=2;
        $this->ItemData[ "Unit"     ][ $profile ]=1;
        $this->ItemData[ "Password" ][ $profile ]=2;

        $editunit=0;
        if ($this->Profile()=="Admin")
        {
             $editunit=1;
        }

        $table= 
            $this->ItemTable
            (
               1,
               $newitem,
               FALSE,
               $this->FriendSelectNewDatas,
               array(),
               FALSE,
               FALSE,
               FALSE
            );

        array_push
        (
           $table,
           array
           (
              $this->B($this->MyLanguage_GetMessage("Friend_Select_Search_SendMail").":"),
              $this->MakeCheckBox("SendMail",1,TRUE),
           ),
           $this->Button("submit",$this->MyLanguage_GetMessage("Friend_Select_Search_Button_New"))
        );

        return $table;
    }

    //*
    //* function FriendSelectAddFriend, Parameter list: &$newitem
    //*
    //* Actuall adds friend.
    //*

    function FriendSelectAddFriend(&$newitem)
    {
        if ($this->GetPOST("AddFriend")!=1) { return; }

        $name=$this->Html2Sort($newitem[ "Name" ]);
        $name=$this->Text2Sort($name); 
        $newitem[ "TextName" ]=$name;
        $newitem[ "Profile_Friend" ]=2;

        if (empty($newitem[ "Password" ]))
        {
            list($usec, $sec) = explode(' ', microtime());
            $newitem[ "Password" ]=(float) $sec + ((float) $usec * 100000);
        }
        
        $add=TRUE;
        $msgs=array();
        foreach ($newitem as $key => $value)
        {
            if (empty($value))
            {
                $add=FALSE;
                array_push
                (
                   $msgs,
                   $this->GetDataTitle($key).": ".
                   $this->MyLanguage_GetMessage("Friend_Undefined").
                   ""
                );
            }
        }

        $msg=$this->MyLanguage_GetMessage("Friend_Select_Add_Not");
        if ($add)
        {
            if ($this->MySqlNEntries("",array("Email" => $newitem[ "Email" ]))>0)
            {
                $msg=$this->MyLanguage_GetMessage("Friend_Select_Add_Email_Already");
            }
            else
            {
                $this->SendPasswordMail($newitem);

                $newitem[ "Password" ]=md5($newitem[ "Password" ]);
                $newitem[ "Status" ]=2;
                $this->MySqlInsertItem("",$newitem);
                $msg=$this->MyLanguage_GetMessage("Friend_Select_Add_Success");
            }
        }

        array_unshift($msgs,$msg,"");
        return join($this->BR(),$msgs);
    }


    //*
    //* function FriendSelectNewForm, Parameter list: $newitem
    //*
    //*Generates Friend Select new friend form.
    //*

    function FriendSelectNewForm($newitem)
    {
        return
            $this->StartForm("","post",0,array(),array("Friend")).
            $this->Html_Table
            (
               "",
               $this->FriendSelectNewTable($newitem),
               array(),
               array(),
               array(),
               TRUE,TRUE
            ).
            $this->MakeHidden("AddFriend",1).
            $this->EndForm().
            "";
    }
}

?>