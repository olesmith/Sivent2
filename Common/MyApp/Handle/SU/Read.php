<?php

trait MyApp_Handle_SU_Read
{
    //*
    //* function MyApp_Handle_SU_Read_Allowed_User_IDs, Parameter list:
    //*
    //* Returns permitted shift users.
    //*

    function MyApp_Handle_SU_Read_Allowed_User_IDs()
    {
        return $this->UsersObj()->Sql_Select_Unique_Col_Values
        (
           "ID",
           $this->MyApp_Handle_SU_Where(),
           ""
        );
    }

    //*
    //* function MyApp_Handle_SU_Read_Datas, Parameter list: 
    //*
    //* Datas to read.
    //*

    function MyApp_Handle_SU_Read_Datas()
    {
        $datas=array("ID","Name","Email",);
        foreach (array_keys($this->Profiles) as $profile)
        {
            if (preg_match('/^(Public)$/',$profile)) { continue; }

            array_push($datas,"Profile_".$profile);
        }

        return $datas;
    }
    //*
    //* function MyApp_Handle_SU_Users_Read, Parameter list: 
    //*
    //* Reads relevant users.
    //*

    function MyApp_Handle_SU_Users_Read()
    {
        return
            $this->UsersObj()->MyMod_Sort_List
            (
                $this->UsersObj()->SelectHashesFromTable
                (
                    "",
                    $this->MyApp_Handle_SU_Where(),
                    $this->MyApp_Handle_SU_Read_Datas(),
                    FALSE,
                    "Name"
                ),
                array("Name")
            );
    }
    
    //*
    //* function MyApp_Handle_SU_Users_Read_Per_Profile, Parameter list: 
    //*
    //* Read users indexed per profile.
    //*

    function MyApp_Handle_SU_Users_Read_Per_Profile()
    {
        $people=$this->MyApp_Handle_SU_Users_Read();
        
        $profile2people=array();
        foreach ($this->MyApp_Handle_SU_Profiles_Allowed() as $profile)
        {
            if (preg_match('/^(Public)$/',$profile)) { continue; }

            $profile2people[ $profile ]=$this->SublistKeyEqValue($people,"Profile_".$profile,2);
        }

        return $profile2people;
    }
    
    //*
    //* function MyApp_Handle_SU_User_Read, Parameter list: 
    //*
    //* Creates shift user select field.
    //*

    function MyApp_Handle_SU_User_Read()
    {
        $user=$this->MyApp_Handle_SU_CGI_Value();
        if (!preg_grep('/'.$user.'/',$this->MyApp_Handle_SU_Read_Allowed_User_IDs()))
        {
            die("Not allowed...");
        }

        return
            $this->UsersObj()->SelectUniqueHash
            (
                "",
                array("ID" => $user)
            );      
    }
}

?>