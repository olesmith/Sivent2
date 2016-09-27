<?php



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
            //array_unshift($table,$this->Buttons());
            array_push($table,$this->Buttons());
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
        $this->Actions("Show");
        $friend=
            $this->FriendsObj()->Sql_Select_Hash
            (
               array("ID" => $inscription[ "Friend" ]),
               array("Name","Email")
            );

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
               $this->FriendsObj()->FriendID2Name($inscription[ "Friend" ])
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

    
    //*
    //* function Submission_Assessments_Update, Parameter list:
    //*
    //* Displays search list of submissions.
    //*

    function Submission_Assessments_Update()
    {
        foreach (array_keys($this->ItemHashes) as $sid)
        {
            $key=$this->ItemHashes[ $sid ][ "ID" ]."_Status";
            $newvalue=$this->CGI_POSTint($key);
            if ($this->ItemHashes[ $sid ][ "Status" ]!=$newvalue)
            {
                $this->ItemHashes[ $sid ][ "Status" ]=$newvalue;
                $this->Sql_Update_Item_Values_Set_Query(array("Status"),$this->ItemHashes[ $sid ]);
            }
        }
    }
    
    //*
    //* function Submission_Assessments_Table, Parameter list: $edit
    //*
    //* Displays search list of submissions.
    //*

    function Submission_Assessments_Table($edit)
    {
        $this->AssessorsObj()->Sql_Table_Structure_Update();
        $this->AssessorsObj()->ItemData();
        $this->AssessorsObj()->ItemDataGroups();
        $this->AssessorsObj()->Actions();
        
        
        $datas=$this->GetGroupDatas("Assessments");

        $profile=$this->Profile();
        
        foreach ($datas as $data)
        {
            if (!preg_match('/^(Status)$/',$data))
            {
                if (!empty($this->ItemData[ $data ][ $profile ]))
                {
                    $this->ItemData[ $data ][ $profile ]=1;
                }
            }
        }

        if ($this->CGI_POSTint("Update")==1)
        {
            $this->Submission_Assessments_Update();
        }

        
        $table=array();
        $n=1;
        foreach ($this->ItemHashes as $submission)
        {
            $submission[ "No" ]=$n;
            $table=array_merge
            (
               $table,
               $this->Submission_Assessments_Rows($edit,$n++,$datas,$submission)
            );
        }
        
        return
            $this->Html_Table
            (
               $this->GetDataTitles($datas),
               $table
            ).
            "";
    }
    
    //*
    //* function Submission_Assessments_Rows, Parameter list: $edit,$n,$datas,$submission
    //*
    //* Generatres $submission rows: $datas row and assessments rows.
    //*

    function Submission_Assessments_Rows($edit,$n,$datas,$submission)
    {
        $rows=array($this->MyMod_Items_Table_Row($edit,$n,$submission,$datas,TRUE,$submission[ "ID" ]."_"));

        $assessorsgroup="Assessments";
        
        $assessors=$this->Submissions_Handle_Assessors_Read($submission);

        if (count($assessors)>0)
        {
            $table=$this->FrameIt
            (
               $this->H
               (
                  3,
                  $this->AssessorsObj()->ItemDataGroups($assessorsgroup,"Name")
               ).
               $this->AssessorsObj()->MyMod_Items_Group_Table_Html
               (
                  0,
                  $assessors,
                  "",
                  $assessorsgroup
               )
            );

            array_push
            (
               $rows,
               array
               (
                  $this->MultiCell("",3),
                  $this->MultiCell($table,count($datas)-3),
                  ""
               )
            );
        }
        
        return $rows;
        
    }
}

?>