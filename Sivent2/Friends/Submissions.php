<?php


class Friends_Submissions extends Friends_Collaborations
{
    //*
    //* function Friend_Submissions_Has, Parameter list: $friend=array()
    //*
    //* Checks whether $friend has submission.
    //*

    function Friend_Submissions_Has($friend=array())
    {
        if (empty($friend)) { $friend=$this->LoginData(); }
        
        return
            $this->SubmissionsObj()->Sql_Select_Hashes_Has
            (
                $this->UnitEventWhere(array("Friend" => $friend[ "ID" ]))
            );
        return $this->EventsObj()->Event_Collaborations_Has();
    }
}

?>