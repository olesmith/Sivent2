<?php

class MyFriends_Friend extends MyFriends_Add
{
     //*
    //* function FriendID2Name, Parameter list: $friendid
    //*
    //* Returns friend name of friend with id $friendid.
    //*

    function FriendID2Name($friendid)
    {
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $friendid),array("Name","Email"));
        
        if (empty($friend))
        {
            $this->DoDie("Friend not found!",$friendid);
        }
        
        return $friend[ "Name" ]." (".$friend[ "Email" ].")";
    }

    
   //*
    //* function FriendDataTable, Parameter list: $edit=0,$friend=array()
    //*
    //* Creates Table with friend's event specific data.
    //*

    function FriendDataTable($edit=0,$friend=array())
    {
        $datas=$this->EventsObj()->EventFriendData();

        $table=$this->ApplicationObj->FriendsObject->ItemTable
        (
            $edit,
            $friend ,
            TRUE,
            $datas,
            array(),
            FALSE,
            FALSE,
            FALSE
        );

        foreach (array_keys($table) as $id)
        {
            $data=$datas[ $id ];

            array_push($table[ $id ],$this->DataPublicDecorator($data));
        }

        if ($edit==1)
        {
            array_push($table,$this->Button('submit',"Salvar Cadastro"));
        }

        return $table;
    }

    //*
    //* function FriendDataHtmlTable, Parameter list: $edit=0,$friend=array()
    //*
    //* Creates HTML Table with inscription specific data.
    //*

    function FriendDataHtmlTable($edit=0,$friend=array())
    {
        return
            $this->Html_Table
            (
               "",
               $this->FriendDataTable($edit,$friend),
               array("ALIGN" => 'center')
            ).
            "";
    }


    //*
    //* function UpdateFriendDataForm, Parameter list: &$friend,$datas=array()
    //*
    //* Updates HTML Form with inscription specific data.
    //*

    function UpdateFriendDataForm(&$friend,$datas=array())
    {
        if ($this->GetPOST("SaveFriend")==1)
        {
            if (empty($datas)) { $datas=$this->EventsObj()->EventFriendData(); }

            $friend=$this->UpdateItem($friend,$datas);
        }
    }
    //*
    //* function FriendDataForm, Parameter list: $edit=0,$friend=array()
    //*
    //* Creates HTML form, optionally editing friend data.
    //*

    function FriendDataForm($edit=0,$friend=array())
    {
        $startform="";
        $endform="";
        if ($edit==1)
        {
            $startform=
                $this->StartForm().
                "";

           $endform=
               $this->MakeHidden("SaveFriend",1).
               $this->EndForm().
               "";
        }

        return
            $this->FrameIt
            (
               $startform.
               $this->H(3,"Dados  do Cadastro Utilizado no Evento:").
               $this->FriendDataHtmlTable($edit,$friend).
               $endform.
               ""
            );
    }

}

?>