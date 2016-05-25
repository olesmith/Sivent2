<?php

//include_once("Table/Update.php");


class SubmissionsTable extends SubmissionsAccess
{
    //*
    //* function Submissions_Table_Read, Parameter list: $inscription
    //*
    //* Read currently allocated Submissions for $inscription.
    //*

    function Submissions_Table_Read($inscription)
    {
        return 
            $this->Sql_Select_Hashes
            (
               array("Friend" => $inscription[ "Friend" ]),
               array(),
               "ID",
               TRUE
            );
    }

    //*
    //* function Submissions_Table_Row, Parameter list: $edit,$inscription,$n,$submission,$datas
    //*
    //* Creates $submission row. $submission may be empty.
    //*

    function Submissions_Table_Row($edit,$inscription,$n,$submission,$datas)
    {
        $row=$this->MyMod_Items_Table_Row($edit,$n,$submission,$datas,$plural=FALSE,"No_".$n."_");
            
        return $row;
    }
    

    //*
    //* function Submissions_Table_Data, Parameter list: 
    //*
    //* Puts submissions in alphabetical order.
    //*

    function Submissions_Table_Data()
    {
        //return $this->GetRealNameKey($this->ItemDataGroups[ "Submission" ],"Data");
        
        return $this->GetGroupDatas("Submission",FALSE);
    }
    
   
    //*
    //* function Submissions_Table_Sort, Parameter list: $submissions
    //*
    //* Puts submissions in alphabetical order.
    //*

    function Submissions_Table_Sort($submissions)
    {
        return $this->SortList($submissions,array("Title"));
    }
    
    //*
    //* function Submissions_Table_Update, Parameter list: $submissions
    //*
    //* Updates Submissions
    //*

    function Submissions_Table_Update($inscription,$submissions,$datas)
    {
        $n=1;
        $table=array();
        foreach ($submissions as $id => $submission)
        {
            $submissions[ $id ]=$this->MyMod_Item_Update_CGI($submission,$datas,"No_".$n."_");
            $n++;
        }
        
        return $submissions;
    }
    
     //*
    //* function Submissions_Table, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription with $userid.
    //*

    function Submissions_Table($edit,&$inscription)
    {
        $submissions=$this->Submissions_Table_Read($inscription);
        $submissions=$this->Submissions_Table_Sort($submissions);
        
        $datas=$this->Submissions_Table_Data();

        $empty=array
        (
           "Unit" => $this->Unit("ID"),
           "Event" => $this->Event("ID"),
           "Friend" => $inscription[ "Friend" ],
           "Title" => "",
           "Email" => "",
           "Friend" => 0,
        );
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $submissions=$this->Submissions_Table_Update($inscription,$submissions,$datas);
        }
        
        $n=1;
        $table=array();
        foreach ($submissions as $id => $submission)
        {
            array_push($table,$this->Submissions_Table_Row($edit,$inscription,$n++,$submission,$datas));
        }
        
        return $table;
    }
    
     //*
    //* function Submissions_Table_Html, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription with $userid.
    //*

    function Submissions_Table_Html($edit,&$inscription)
    {
        return
            $this->Html_Table
            (
               $this->GetDataTitles($this->Submissions_Table_Data()),
               $this->Submissions_Table($edit,$inscription)
            ).
            "";
    }
    
    //*
    //* function Submissions_Show, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription in .
    //*

    function Submissions_Table_Show($edit,&$inscription)
    {
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $inscription[ "Friend" ],array("Name","Email")));

        $startform="";
        $endform="";
        if ($edit==1)
        {
            $startform=
                $this->StartForm().
                $this->Buttons().
                "";
            $endform =
                $this->MakeHidden("Update",1).
                $this->Buttons().
                $this->EndForm().
                "";
        }

        $action=$this->MyActions_Entry("Add",array(),TRUE);
        if (!empty($action))
        {
            $action=$this->Html_BR().$this->Html_BR().$action;
        }
        
        return
                $this->H
                (
                   3,
                   $this->MyLanguage_GetMessage("Submissions_User_Table_Title").
                   ": ".
                   $this->FriendsObj()->FriendID2Name($inscription[ "Friend" ])
                ).
                $this->H
                (
                   5,
                   $this->MyLanguage_GetMessage("Inscription_Period").
                   ": ".
                   $this->EventsObj()->Event_Collaborations_Inscriptions_DateSpan().
                   ". ".
                   $this->EventsObj()->Event_Collaborations_Inscriptions_Status()
                ).
            $startform.
            $this->Submissions_Table_Html($edit,$inscription).
            $endform.
            "";
    }
    
    //*
    //* function Collaborators_Friend_Submissions_Handle, Parameter list: ()
    //*
    //* Shows currently allocated Submissions for inscription in .
    //*

    function Collaborators_Friend_Submissions_Handle()
    {
        $userid=$this->CGI_GETint("Friend");
        $inscription=$this->Sql_Select_Hash(array("Friend" => $userid));

        echo
            $this->Submissions_Table_Show(1,$inscription);
    }
}

?>