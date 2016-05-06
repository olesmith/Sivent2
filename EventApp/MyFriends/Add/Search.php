<?php

class MyFriendsAddSearch extends MyFriendsAddTable
{
    //*
    //* function FriendSelectSearchTable, Parameter list: $leadingrows=array()
    //*
    //* Generates Friend Select search table.
    //*

    function FriendSelectSearchTable($table=array())
    {
        array_unshift
        (
           $table,
           array
           (
            $this->H(5,$this->MyLanguage_GetMessage("Friend_Select_Search_Title")),
           )
        );

        if (isset($_GET[ "Friend" ]))
        {
            $friend=$this->GetGETint("Friend");
            if ($friend>0)
            {
                $hash=$this->SelectUniqueHash("",array("ID" => $friend),FALSE,array("Name","Email"));
            }
        }
        else
        {
            $hash=array
            (
               "Name" => $this->GetPOST("Name"),
               "Email" => $this->GetPOST("Email"),
            );
        }

        array_push
        (
           $table,
           array
           (
              $this->B($this->MyLanguage_GetMessage("Friend_Add_Name").":"),
              $this->MakeInput("Name",$hash[ "Name" ],25),
           ),
           array
           (
              $this->B($this->MyLanguage_GetMessage("Friend_Add_Email").":"),
              $this->MakeInput("Email",$hash[ "Email" ],25),
           ),
           array
           (
              $this->Button("submit",$this->MyLanguage_GetMessage("Friend_Select_Search_Button")),
           )
        );

        return $table;
    }

    //*
    //* function FriendSelectSearchForm, Parameter list: $leadingrows=array()
    //*
    //*Generates Friend Select search form.
    //*

    function FriendSelectSearchForm($leadingrows=array())
    {
        return
            $this->H(1,$this->MyLanguage_GetMessage("Friend_Select_Title")).
            $this->StartForm("","post",0,array(),array("Friend")).
            $this->Html_Table
            (
               "",
               $this->FriendSelectSearchTable($leadingrows),
               array(),
               array(),
               array(),
               TRUE,TRUE
            ).
            $this->MakeHidden("Search",1).
            $this->EndForm().
            "";
    }

    //*
    //* function FriendSelectCGI2Where, Parameter list: 
    //*
    //* Generates Friend Select where clause.
    //*

    function FriendSelectCGI2Where()
    {
        $name=$this->GetPOST("Name");
        $email=$this->GetPOST("Email");

        $email=$this->Text2Sort($email);
        $email=preg_replace('/\s+/',"",$email);

        //$name=$this->Text2Sort($name);
        $name=$this->Html2Sort($name);
        $names=preg_split('/\s+/',$name);
        $names=preg_grep('/\S/',$names);

        $where=array();
        if (!empty($email))
        {
            $where[ "__Email" ]=
                "LOWER(".
                $this->Sql_Table_Column_Name_Qualify("Email").
                ") LIKE ".
                $this->Sql_Table_Column_Value_Qualify('%'.$email.'%');
        }

        if (count($names)>0)
        {
            $where[ "__Name" ]= 
                "LOWER(".
                $this->Sql_Table_Column_Name_Qualify("TextName").
                ") LIKE ".
                $this->Sql_Table_Column_Value_Qualify('%'.join("%",$names).'%');
        }

        return $where;
    }

}

?>