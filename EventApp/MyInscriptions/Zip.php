<?php

class MyInscriptions_Zip extends MyInscriptions_Access
{
    //*
    //* function MyMod_Handle_Zip_Item_Field_FileName, Parameter list: $item,$data
    //*
    //* Returns name of $item $data file in ZIP file.
    //*

    function MyMod_Handle_Zip_Item_Field_FileName($item,$data)
    {
        if (preg_match('/^(Admin)$/',$this->Profile()))
        {
            return
                //$this->GetUploadPath().
                //"/".
                parent::MyMod_Handle_Zip_Item_Field_FileName($item,$data);
        }

        $this->Sql_Select_Hash_Datas_Read($item,array("Friend"));
        
        $friend=
            $this->FriendsObj()->Sql_Select_Hash
            (
               array("ID" => $item[ "Friend" ]),
               array("TextName")
            );

        $name=preg_replace('/\s+/',".",$friend[ "TextName" ]);
        
        return
            $name.".".parent::MyMod_Handle_Zip_Item_Field_FileName($item,$data);
    }

 }

?>