<?php

include_once("Submissions/Access.php");
include_once("Submissions/Emails.php");
include_once("Submissions/Table.php");
include_once("Submissions/Export.php");
include_once("Submissions/Schedule.php");
include_once("Submissions/Certificate.php");
include_once("Submissions/Authors.php");
include_once("Submissions/Assessors.php");
include_once("Submissions/Assessments.php");
include_once("Submissions/Statistics.php");
include_once("Submissions/Handle.php");


class Submissions extends Submissions_Handle
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
        
        $this->Sort=array("Name","Title");
        /* if ($this->CGI_VarValue("Submissions_GroupName")=="Assessments") */
        /* { */
        /*     $this->Sort=array("Result","Name","Title"); */
        /*     $this->Reverse=TRUE; */
        /* } */
        
        $this->IncludeAllDefault=TRUE;

        $this->Coordinator_Type=5;
        $this->NItemsPerPage=10;

        $this->MyMod_Language_Data=array("Title");
        
        $this->CellMethods[ "Submission_Authors_Cell" ]=TRUE;
        $this->CellMethods[ "SubmissionNPreInscriptionsCell" ]=TRUE;
        $this->CellMethods[ "SubmissionVacanciesCell" ]=TRUE;
        $this->CellMethods[ "SubmissionNPreInscriptionsCell" ]=TRUE;
        $this->CellMethods[ "SubmissionVacanciesCell" ]=TRUE;
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
    //* Returns full (relative) upload path: UploadPath/#Unit/#Event/Submissions.
    //*

    function MyMod_Data_Upload_Path()
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

        $this->Actions();
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
        $updatedatas=$this->PostProcess_Results($item,$updatedatas);
        
        
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
        $this->Sql_Select_Hash_Datas_Read($item,array("Event","Author1","Author2","Author3"));

        //Take default author names, if empty
        $hash=array
        (
           "Friend"  => "Author1",
           "Friend2" => "Author2",
           "Friend3" => "Author3",
        );

        $event=array("ID" => $item[ "Event" ]);
        foreach ($hash as $fkey => $akey)
        {
            if (empty($item[ $akey ]) && !empty($item[ $fkey ]))
            {
                $item[ $akey ]=$this->FriendsObj()->Sql_Select_Hash_Value($item[ $fkey ],"Name");
                array_push($updatedatas,$akey);

                $friend=array("ID" => $item[ $fkey ]);
                $isinscribed=$this->EventsObj()->Friend_Inscribed_Is($event,$friend);
                if (!$isinscribed)
                {
                    $this->InscriptionsObj()->DoInscribe($friend);
                }
            }
        }

        $this->Submission_Speakers_Update($item);

        return $updatedatas;
    }
    
    //*
    //* function PostProcess_Results, Parameter list: $item,$updatedatas=array()
    //*
    //* Postprocesses $item friends.
    //*

    function PostProcess_Results(&$item,$updatedatas=array())
    {
        if (isset($item[ "Result" ]))
        {
            $where=$this->UnitEventWhere(array("Submission" => $item[ "ID" ]));
            
            $assessors=$this->AssessorsObj()->Sql_Select_Hashes($where,array("ID","Result"));

            $n=0;
            $result=0.0;
            foreach ($assessors as $assessor)
            {
                if ($assessor[ "Result" ]>0)
                {
                    $n++;
                    $result+=$assessor[ "Result" ];
                }
            }

            if ($n>0)
            {
                $result/=(1.0*$n);
            }

            if ($item[ "Result" ]!=$result)
            {
                $item[ "Result" ]=$result;
                array_push($updatedatas,"Result");
            }
        }
        
        return $updatedatas;
    }

    
    //*
    //* Overrides InitAddDefaults.
    //* Updates Friend to AddDefaults and AddFixedValues,
    //* then calls parent.
    //*

    function InitAddDefaults($hash=array())
    {
        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->LoginData("ID");
            $this->AddFixedValues[ "Friend" ]=$this->LoginData("ID");
            if (!empty($this->AddDefaults[ "Friend" ]))
            {
                $this->AddDefaults[ "Author1" ]=$this->LoginData("Name");
            }
        }
        elseif (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $this->AddDefaults[ "Friend" ]=$this->CGI_GETint("Friend");
        }
        
        return parent::InitAddDefaults($hash);
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
    //* function UpdateSpeakers, Parameter list: $item,$updatedatas=array()
    //*
    //* Postprocesses $item friends.
    //*

    function Submission_Speakers_Update(&$item)
    {
        $this->Sql_Select_Hash_Datas_Read($item,array("Event","Author1","Author2","Author3"));

        //Take default author names, if empty
        $hash=array
        (
           "Friend"  => "Author1",
           "Friend2" => "Author2",
           "Friend3" => "Author3",
        );

        $event=array("ID" => $item[ "Event" ]);
        foreach ($hash as $fkey => $akey)
        {
            if (!empty($item[ $fkey ]) && $item[ "Status" ]==2)
            {            
                //Make sure author is speaker
                $this->UpdateSpeaker($item,$fkey,$item[ $fkey ]);
            }
        }
    }
    
    //*
    //* Overrides UpdateSpeaker.
    //*
    //* Updates speaker value: adds, if not in speakers.
    //*

    function UpdateSpeaker($item,$data,$newvalue)
    {
        // if ($item[ "Status" ]!=2) { return $item; }
        
        $oldvalue=0;
        if (!empty($item[ $data ])) { $oldvalue=$item[ $data ]; }
        $item[ $data ]=$newvalue;
        

        /* if ($oldvalue==$newvalue) */
        /* { */
        /*     return $item; */
        /* } */
       
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

        $updatedatas=array();
        if (!empty($friend))
        {
            $this->SpeakersObj()->Sql_Table_Structure_Update();
            
            $speaker=$this->SpeakersObj()->Sql_Select_Hash(array("Friend" => $newvalue));
            if (empty($speaker) && $item[ "Status" ]==2)
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

                var_dump("added speaker");
            }
            
            $item[ $data ]=$newvalue;
            if ($oldvalue!=$newvalue)
            {
                $item[ $hash[ $data ] ]=$friend[ "Name" ];
                $updatedatas=array($hash[ $data ],$data);
           }
        }
            
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set
            (
               $updatedatas,
               $item
            );
        }

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
        foreach (array("Friend","Friend2","Friend3") as $key)
        {
            if (!empty($submission[ $key ]))
            {
                $fid=$submission[ $key ];
                array_push($submission[ "Friends" ],$fid);
            }
        }
        
        $submission[ "Authors" ]=array();
        foreach (array("Author1","Author2","Author3") as $key)
        {
            if (!empty($submission[ $key ]))
            {
                array_push($submission[ "Authors" ],$submission[ $key ]);
            }
        }
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
    
    //*
    //* function AddForm_PreText, Parameter list:
    //*
    //* Pretext function. Shows add inscriptions form.
    //*

    function AddForm_PreText()
    {
        return
            $this->FrameIt($this->InscriptionsObj()->DoAdd());
    }   
}
?>