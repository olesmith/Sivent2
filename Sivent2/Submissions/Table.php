<?php



class Submissions_Table extends Submissions_Emails
{
    //*
    //* function Submissions_Table_Read, Parameter list: $friend,$inscription
    //*
    //* Read currently allocated Submissions for $inscription.
    //*

    function Submissions_Table_Read($friend,$inscription)
    {
        $submissions= 
            $this->Sql_Select_Hashes
            (
               array("Friend" => $friend[ "ID" ]),
               array(),
               "ID",
               TRUE
            );

        foreach (array_keys($submissions) as $sid)
        {
            
        }

        return $submissions;
    }

    //*
    //* function Submissions_Table_Row, Parameter list: $edit,$inscription,$n,$submission,$datas
    //*
    //* Creates $submission row. $submission may be empty.
    //*

    function Submissions_Table_Row($edit,$inscription,$n,$submission,$datas)
    {
        $this->SubmissionsObj()->Submission_Speakers_Update($submission);
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
        return $this->GetGroupDatas("Submission",FALSE);
    }
    
   
    //*
    //* function Submissions_Table_Sort, Parameter list: $submissions
    //*
    //* Puts submissions in alphabetical order.
    //*

    function Submissions_Table_Sort($submissions)
    {
        return $this->MyMod_Sort_List($submissions,array("Title"));
    }
    
    //*
    //* function Submissions_Table_Update, Parameter list: &$submissions,$datas
    //*
    //* Updates Submissions
    //*

    function Submissions_Table_Update(&$submissions,$datas)
    {
        $n=1;
        $table=array();
        foreach (array_keys($submissions) as $id)
        {
            $submissions[ $id ]=$this->MyMod_Item_Update_CGI($submissions[ $id ],$datas,"No_".$n."_");
            $n++;
        }
    }
    
     //*
    //* function Submissions_Table, Parameter list: $edit,$friend,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription with $userid.
    //*

    function Submissions_Table($edit,$friend,&$inscription)
    {
        $submissions=$this->Submissions_Table_Read($friend,$inscription);
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
            $this->Submissions_Table_Update($submissions,$datas);
        }
        
        $n=1;
        $table=array();
        foreach ($submissions as $id => $submission)
        {
            array_push
            (
               $table,
               $this->Submissions_Table_Row($edit,$inscription,$n++,$submission,$datas)
            );
        }

        if ($edit==1 && count($table)>0)
        {
             array_push($table,$this->Buttons());
        }
        
        return $table;
    }
    
     //*
    //* function Submissions_Table_Html, Parameter list: $edit,$friend,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription with $userid.
    //*

    function Submissions_Table_Html($edit,$friend,&$inscription)
    {
        return
            $this->Html_Table
            (
               $this->GetDataTitles($this->Submissions_Table_Data()),
               $this->Submissions_Table($edit,$friend,$inscription)
            ).
            "";
    }
    
    //*
    //* function Submissions_Show, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription in .
    //*

    function Submissions_Table_Show($edit,$friend,&$inscription)
    {
        $this->Actions("Show");

        $startform="";
        $endform="";
        if ($edit==1)
        {
            $startform=
                $this->StartForm().
                "";
            $endform =
                $this->MakeHidden("Update",1).
                $this->EndForm().
                "";
        }

        $action="";
        if ($this->EventsObj()->Event_Submissions_Inscriptions_Open())
        {
            $action=$this->MyActions_Entry("Add",array(),TRUE);
            if (!empty($action))
            {
                $action=$this->Center($action);
            }
        }

        return
            $this->H
            (
               3,
               $this->MyLanguage_GetMessage("Submissions_User_Table_Title").
               ": ".
               $this->FriendsObj()->FriendID2Name($friend[ "ID" ])
            ).
            $this->H
            (
               5,
               $this->MyLanguage_GetMessage("Inscription_Period").
               ": ".
               $this->EventsObj()->Event_Submissions_Inscriptions_DateSpan().
               ". ".
               $this->EventsObj()->Event_Submissions_Inscriptions_Status()
            ).
            $action.
            $startform.
            $this->Submissions_Table_Html($edit,$friend,$inscription).
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
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $userid));
        $inscription=$this->Sql_Select_Hash(array("Friend" => $userid));

        echo
            $this->Submissions_Table_Show(1,$friend,$inscription);
    }
}

?>