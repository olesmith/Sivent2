<?php


class Friends_Speakers extends Friends_Submissions
{
    //*
    //* function Friend_Speakers_Has, Parameter list: $friend=array()
    //*
    //* Checks whether $friend has collaborations.
    //*

    function Friend_Speakers_Has($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        return
            $this->SpeakersObj()->Sql_Select_Hashes_Has
            (
                $this->UnitEventWhere(array("Friend" => $friend[ "ID" ]))
            );
    }
}

?>