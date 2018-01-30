<?php


class MyInscriptions_Inscription_Inscribe extends MyInscriptions_Inscription_Contents
{
    //*
    //* function Profile2Friend, Parameter list: $friend=array()
    //*
    //* Figures out friend from CGI.
    //* If profile is Friend, return LoginData.
    //* If coordinator or admin and Friend given via GET,
    //* read this friend.
    //*

    function Profile2Friend()
    {
        if (preg_match('/(Coordinator|Admin)/',$this->Profile()))
        {
            $friend=$this->CGI_GETint("Friend");
            if (!empty($friend))
            {
                $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $friend));
            }
            else
            {
                $friend=$this->ApplicationObj->LoginData;
            }
        }
        elseif (preg_match('/(Friend)/',$this->Profile()))
        {
            $friend=$this->ApplicationObj->LoginData;
        }

        return $friend;
    }
    
    //*
    //* function HandleInscribe, Parameter list: $friend=array()
    //*
    //* Handle  inscription.
    //*

    function HandleInscribe($friend=array())
    {
        $this->EventsObj()->ItemData();
        $this->EventsObj()->ItemDataGroups();

        $this->FriendsObj(TRUE)->ItemData();
        $this->FriendsObj()->ItemDataGroups();

        $edit=1;
        
        $this->Friend=$friend;
        if (empty($this->Friend)) { $this->Friend=$this->Profile2Friend(); }

        echo 
            $this->InscriptionEventTable(0).
            $this->InscriptionForm($edit).
                "";
             
    }


    //*
    //* function MayDoInscribe, Parameter list: 
    //*
    //* Detects if all compulsory data has been lounged.
    //*

    function MayDoInscribe()
    {
        $datas=array();
        foreach ($this->InscriptionSGroupsCompulsoryData() as $data)
        {
            if ($this->MyMod_Data_Field_Is_File($data)) { continue; }
    
            if (isset($_POST[ $data ]))
            {
                $this->Inscription[ $data ]=$this->CGI_POST($data);
            }

            if (empty($this->Inscription[ $data ]))
            {
                array_push($datas,$data);
            }
        }

        return TRUE;
    }

    //*
    //* function DoInscribe, Parameter list: $friend=array()
    //*
    //* Adds DoInscription.
    //*

    function DoInscribe($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        $where=array
        (
           "Unit" => $this->Unit("ID"),
           "Event" => $this->Event("ID"),
           "Friend" => $friend[ "ID" ],
        );

        foreach ($where as $key => $value) { $this->Inscription[ $key ]=$value; }

        $this->AddOrUpdate("",$where,$this->Inscription);
        
        $this->MyMod_Item_Update_CGI
        (
           $this->Inscription,
           $this->MyMod_Data_Field_File_Datas()
        );
    }
}

?>