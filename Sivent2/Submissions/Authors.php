<?php


class Submissions_Authors extends Submissions_Author
{   
    //*
    //* function Submission_Author_Data, Parameter list: 
    //*
    //* Datas to show for friend.
    //*

    function Submission_Author_Data()
    {
        return
            array
            (
                "Title","Name","Institution","Lattes",
            );
    }

    
    //*
    //* function Submission_Authors_Read, Parameter list: &$submission,$datas=array()
    //*
    //* Reads event submission Authors data.
    //*

    function Submission_Authors_Read(&$submission,$datas=array())
    {
        if (empty($datas)) { $datas=$this->Submission_Author_Data(); }
    
        $this->ReadSubmission($submission);
        
        $where=$this->UnitWhere();
        
        $friends=array();
        foreach ($submission[ "Friends" ] as $id => $fid)
        {
            $where[ "ID" ]=$fid;
            array_push
            (
               $friends,
               $this->FriendsObj()->Sql_Select_Hash($where,$datas)
            );
        }

        return $friends;
    }
    //*
    //* function SubmissionAuthors, Parameter list: &$submission,$friends=array()
    //*
    //* Returns list of titled authors.
    //*

    function Submission_Authors(&$submission,$friends=array())
    {
        if (empty($friends))
        {
            $friends=$this->Submission_Authors_Read($submission);
        }

        $authors=array();
        foreach ($friends as $id => $friend)
        {
            array_push($authors,$this->FriendsObj()->FriendInfo($friend));
        }

        

        return $submission[ "Authors" ];
    }
    
    //*
    //* function Submission_Authors_Info, Parameter list: &$submission,$friends=array()
    //*
    //* Returns list of titled authors.
    //*

    function Submission_Authors_Info(&$submission,$friends=array())
    {
        if (empty($friends))
        {
            $friends=$this->Submission_Authors_Read($submission);
        }

        $authors=array();
        foreach ($friends as $id => $friend)
        {
            array_push($authors,$this->FriendsObj()->FriendInfo($friend));
        }

        return
            //join("; ",$this->Submission_Authors($submission,$friends)).
            $this->Submission_Authors_Info_Tables($submission,$friends);
    }

    //*
    //* function Submission_Authors_Info_Tables, Parameter list: $submission,$friends=array()
    //*
    //* Returns list of titled authors.
    //*

    function Submission_Authors_Info_Tables($submission,$friends=array())
    {
        if (empty($friends))
        {
            $friends=$this->Submission_Authors_Read($submission);
        }

        $tables=array();
        foreach ($friends as $id => $friend)
        {
            array_push
            (
                $tables,
                $this->Submission_Author_Info_Table($submission,$friend)
            );
        }

        return $this->Html_Table("",array($tables));
    }
    
    //*
    //* function Submission_Author_Info_Table, Parameter list: &$submission,$friends=array()
    //*
    //* Returns list of titled authors.
    //*

    function Submission_Author_Info_Table($submission,$friend)
    {
        return
            $this->FriendsObj()->MyMod_Item_Table_Html
            (
                0,
                $friend,
                array
                (
                    "Name","Title","Institution","Curriculum","MiniCurriculum","Photo"
                )
            );
    }

    
    //*
    //* function Submission_Authors_Cell, Parameter list: $submission=array()
    //*
    //* Returns $submission cell of titled authors.
    //*

    function Submission_Authors_Cell($submission=array())
    {
        if (empty($submission)) { return $this->MyLanguage_GetMessage("Submissions_Authors_Title"); }
        
        return join(";".$this->BR(),$this->Submission_Authors($submission));
    }
    //*
    //* function Submission_Author_Table, Parameter list: $friendid,$datas=array()
    //*
    //* Creates table with author data.
    //*

    function Submission_Author_Table($friendid,$datas=array())
    {
        if (empty($datas)) { $datas=array("Name","Institution"); }
        
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $friendid));

        return $this->FriendsObj()->MyMod_Item_Table_Html(0,$friend,$datas);
    }
    
    //*
    //* function Submission_Authors_Table, Parameter list: $submission
    //*
    //* Creates $assessor assessment form.
    //*

    function Submission_Authors_Tables($submission,$datas=array())
    {
        $row=array();
        foreach ($this->Authors_Datas("Friend") as $data)
        {
            if (!empty($submission[ $data ]) && $submission[ $data ]>0)
            {
                array_push
                (
                    $row,
                    $this->Submission_Author_Table($submission[ $data ],$datas)
                );
            }
        }

        return array($row);
    }    
}
?>