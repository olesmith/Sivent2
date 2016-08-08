<?php

include_once("Submissions/Access.php");
include_once("Submissions/Table.php");
include_once("Submissions/Schedule.php");
include_once("Submissions/Certificate.php");
include_once("Submissions/Handle.php");



class Submissions extends SubmissionsHandle
{
    var $Certificate_Type=4;
    
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Submissions($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=
            array
            (
               "Unit","Event",
               "Title","Title_UK",
               "Status","TimeLoad",
               "Friend","Friend2","Friend3"
            );
        
        $this->Sort=array("Title");
        if ($this->CGI_VarValue("Submissions_GroupName")=="Assessments")
        {
            $this->Sort=array("Result");
            $this->Reverse=TRUE;
        }
        $this->IncludeAllDefault=TRUE;
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Submissions",$table);
    }


    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*

    function GetUploadPath()
    {
        $path=
            join
            (
               "/",
               array
               (
                  "Uploads",
                  $this->Unit("ID"),
                  $this->Event("ID"),
                  "Submissions"
               )
            );
        
        $this->Dir_Create_AllPaths($path);
        
        return $path;
    }
    
   
    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        $this->PostProcessUnitData();
        $this->PostProcessEventData();
    }


    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if (!preg_match('/(Submissions|Friends|Inscriptions)/',$module))
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();
        
        $updatedatas=$this->PostProcess_Friends($item);

        $updatedatas=
            array_merge
            (
               $updatedatas,
               $this->MyMod_Item_Language_Data_Defaults($item,"Title")
            );
        
        if (!empty($item[ "Title" ]) && empty( $item[ "Title_UK" ]))
        {
            $item[ "Title_UK" ]=$item[ "Title" ];
            array_push($updatedatas,"Title_UK");
        }

        $this->PostProcess_Certificate_TimeLoad($item,$updatedatas);
        $this->PostProcess_Code($item,$updatedatas);

        
        $this->PostProcess_Certificate($item);
        
        if (count($updatedatas)>0 && !empty($item[ "ID" ]))
        {
             $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        
        return $item;
    }
    
    //*
    //* function PostProcess_Friends, Parameter list: $item,$updatedatas=array()
    //*
    //* Postprocesses $item friends.
    //*

    function PostProcess_Friends(&$item,$updatedatas=array())
    {
        $this->Sql_Select_Hash_Datas_Read($item,array("Author1","Author2","Author3"));

        //Take default author names, if empty
        $hash=array
        (
           "Friend"  => "Author1",
           "Friend2" => "Author2",
           "Friend3" => "Author3",
        );

        foreach ($hash as $fkey => $akey)
        {
            if (empty($item[ $akey ]) && !empty($item[ $fkey ]))
            {
                $item[ $akey ]=$this->FriendsObj()->Sql_Select_Hash_Value($item[ $fkey ],"Name");
                array_push($updatedatas,$akey);
            }

            if (!empty($item[ $fkey ]) && $item[ "Status" ]==2)
            {            
                //Make sure author is speaker
                $this->UpdateSpeaker($item,$fkey,$item[ $fkey ]);
            }
        }

        return $updatedatas;
    }
    
    //*
    //* Overrides InitAddDefaults.
    //* Updates Friend to AddDefaults and AddFixedValues,
    //* then calls parent.
    //*

    function InitAddDefaults()
    {
        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->LoginData("ID");
            $this->AddFixedValues[ "Friend" ]=$this->CGI_GETint("Friend");
            if (!empty($this->AddDefaults[ "Friend" ]))
            {
                $this->AddDefaults[ "Author1" ]=$this->LoginData("Name");
            }
        }
        elseif (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->CGI_GETint("Friend");
        }
        
        return parent::InitAddDefaults();
    }
    
    //*
    //* Overrides SubmissionInfo.
    //*
    //* Returns info text for $submission.
    //*

    function SubmissionInfo($submission)
    {
        return
            $submission[ "Title" ];
    }
    
    //*
    //* Returns list of defined authors, ie Friend[23]>0.
    //*

    function SubmissionID2Authors($submissionid)
    {
        $datas=array("Friend","Friend2","Friend3",);
        
        $submission=$this->Sql_Select_Hash(array("ID" => $submissionid),$datas);
        
        $friends=array();
        foreach ($datas as $data)
        {
            if (!empty($submission[ $data ]) && $submission[ $data ]>0)
            {
                array_push($friends,$submission[ $data ]);
            }
        }

        return $friends;
    }
        
    //*
    //* Overrides UpdateSpeaker.
    //*
    //* Updates speaker value: adds, if not in speakers.
    //*

    function UpdateSpeaker($item,$data,$newvalue)
    {
        if ($item[ "Status" ]!=2) { return $item; }
        
        $friend=array();
        if (!empty($newvalue))
        {
            $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $newvalue));
        }

        $hash=
            array
            (
               "Friend" => "Author1",
               "Friend2" => "Author2",
               "Friend3" => "Author3",
            );

        if (!empty($friend))
        {
            $speaker=$this->SpeakersObj()->Sql_Select_Hash(array("Friend" => $newvalue));
            if (empty($speaker))
            {
                $speaker=
                    array
                    (
                       "Unit" => $this->Unit("ID"),
                       "Event" => $this->Event("ID"),
                       "Friend" => $newvalue,
                       "Name" => $this->FriendsObj()->Sql_Select_Hash_Value($newvalue,"Name"),
                    );

                $this->SpeakersObj()->Sql_Insert_Item($speaker);
            }            
            
            $item[ $data ]=$newvalue;
            $item[ $hash[ $data ] ]=$friend[ "Name" ];
        }
        else
        {
            $item[ $data ]=0;
            $item[ $hash[ $data ] ]="";
        }
            
        
        $this->Sql_Update_Item_Values_Set
        (
           array($hash[ $data ],$data),
           $item
        );

        return $item;
    }
    
    //*
    //* function PostInterfaceMenu, Parameter list: 
    //*
    //* Prints warning messages.
    //*

    function PostInterfaceMenu($args=array())
    {
        $res=$this->ItemExistenceMessage();
        if ($res)
        {
            $res=$this->AreasObj()->ItemExistenceMessage("Areas");
        }

        return $res;
    }
        
    //*
    //* function Inscription2Ors, Parameter list: $friendid,$where=array()
    //*
    //* Creates SQL OR where clause for $friendid.
    //*

    function Friend2Ors($friendid,$where=array())
    {
        $ors=array();
        foreach (array("Friend","Friend2","Friend3",) as $data)
        {
            array_push($ors,$data."='".$friendid."'");
        }
        
        $where[ "__Friend" ]="(".join(" OR ",$ors).")";

        return $where;
    }
        
    //*
    //* function FriendNSubmissions, Parameter list: $friendid,$where=array()
    //*
    //* Returns $friendid submissions.
    //*

    function FriendNSubmissions($friendid,$where=array())
    {
        return
            $this->Sql_Select_NHashes
            (
               $this->Friend2Ors
               (
                  $friendid,
                  $where
               )
            );

    }
        
    //*
    //* function ReadSubmission, Parameter list: &$submission
    //*
    //* Reads event submission Friends and Authors data.
    //*

    function ReadSubmission(&$submission)
    {
        if (!empty($submission[ "Friends" ])) { return; }
        
        $submission[ "Friends" ]=array();
        foreach (array("Friend","Friend2","Friend3") as $rkey)
        {
            if (!empty($submission[ $rkey ]))
            {
                $fid=$submission[ $rkey ];
                array_push($submission[ "Friends" ],$fid);
            }
        }
    }
    
    //*
    //* function ReadSubmissionFriendData, Parameter list: &$submission,$datas=array()
    //*
    //* Reads event submission Friends and Authors data.
    //*

    function ReadSubmissionFriendData(&$submission,$datas=array())
    {
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
    //* function SubmissionAuthors, Parameter list: &$submission
    //*
    //* Returns list of titled authors.
    //*

    function SubmissionAuthors(&$submission)
    {
        $friends=$this->ReadSubmissionFriendData($submission,array("Title","Name","Institution","Lattes"));
        $authors=array();
        foreach ($friends as $id => $friend)
        {
            array_push($authors,$this->FriendsObj()->FriendInfo($friend));
        }

        return $authors;
    }
    
    //*
    //* function SubmissionAuthorsCell, Parameter list: $submission=array()
    //*
    //* Returns $submission cell of titled authors.
    //*

    function SubmissionAuthorsCell($submission=array())
    {
        if (empty($submission)) { return $this->MyLanguage_GetMessage("Submissions_Authors_Title"); }
        
        return join(";".$this->BR(),$this->SubmissionAuthors($submission));
    }
    
    //* function SubmissionNPreInscriptions, Parameter list: $submission
    //*
    //* Returns $submission number of preinscriptions.
    //*

    function SubmissionNPreInscriptions($submission)
    {
        if (empty($submission)) { return $this->MyLanguage_GetMessage("Submissions_NPreInscriptions_Title"); }
        
        return
            $this->PreInscriptionsObj()->Sql_Select_NHashes
            (
               $this->UnitEventWhere(array("Submission" => $submission[ "ID" ]))
            );
    }
    
    //* function SubmissionNPreInscriptionsCell, Parameter list: $edit=0,$submission=array(),$data=""
    //*
    //* Returns $submission cell with number of preinscriptions.
    //*

    function SubmissionNPreInscriptionsCell($edit=0,$submission=array(),$data="")
    {
        if (empty($submission)) { return $this->MyLanguage_GetMessage("Submissions_NPreInscriptions_Title"); }
        
        return $this->SubmissionNPreInscriptions($submission);
    }
    
    //* function SubmissionVacanciesCell, Parameter list: $submission
    //*
    //* Returns $submission  number of vacancies remaining.
    //*

    function SubmissionVacancies($submission)
    {
        return $submission[ "Vacancies" ]-$this->SubmissionNPreInscriptions($submission);
    }
    
    //* function SubmissionVacanciesCell, Parameter list: $edit=0,$submission=array(),$data=""
    //*
    //* Returns $submission cell with number of vacancies remaining.
    //*

    function SubmissionVacanciesCell($edit=0,$submission=array(),$data="")
    {
        if (empty($submission)) { return $this->MyLanguage_GetMessage("Submissions_Vacancies_Title"); }

        $n=$this->SubmissionVacancies($submission);
        if ($n<0) { $n=0; }
        
        return $n;
    }
}
?>