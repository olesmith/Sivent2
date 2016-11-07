<?php

class InscriptionsOverrides extends InscriptionsAccess
{
    //*
    //* function MyMod_Data_Upload_Path, Parameter list: 
    //*
    //* Creates Inscription edit html table.
    //*

    function MyMod_Data_Upload_Path()
    {
        return parent::MyMod_Data_Upload_Path();

        exit();
    }

    
    //*
    //* function InscriptionFriendTableData, Parameter list: 
    //*
    //* Creates Inscription edit html table.
    //*

    function InscriptionFriendTableData()
    {
        $datas=
            array
            (
               "Name","NickName","Email","Cell",
               
            );

        if (
               $this->FriendsObj()->Friend_Speakers_Has()
               ||
               $this->FriendsObj()->Friend_Collaborations_Has()
               ||
               $this->FriendsObj()->Friend_Submissions_Has()
           )
        {
            array_push($datas,"Curriculum","MiniCurriculum","Photo");
        }
        else
        {
            array_push($datas,"Friend_Data_Edit_Link");
        }

        return $datas;
    }    
}

?>