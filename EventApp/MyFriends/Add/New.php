<?php

class MyFriendsAddNew extends MyFriendsAddMail
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
              $this->B("Enviar Email para Cadastrante:"),
              $this->MakeCheckBox("SendMail",1,TRUE),
           ),
           $this->Button("submit",$this->FriendSelectNewButton)
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

        $add=TRUE;
        $msgs=array();
        foreach ($newitem as $key => $value)
        {
            if (empty($value))
            {
                $add=FALSE;
                array_push($msgs,$this->GetDataTitle($key)." indefinido.");
            }
        }

        $msg="Cadastro não Adicionado:";
        if ($add)
        {
            if ($this->MySqlNEntries("",array("Email" => $newitem[ "Email" ]))>0)
            {
                $msg="Email existente! Cadastro não Adicionado";
            }
            else
            {
                $this->SendPasswordMail($newitem);

                $newitem[ "Password" ]=md5($newitem[ "Password" ]);
                $this->MySqlInsertItem("",$newitem);
                $msg="Cadastro Adicionado com Êxito!";

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