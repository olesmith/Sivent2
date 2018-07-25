<?php

include_once("Speakers/Access.php");
include_once("Speakers/Emails.php");



class Speakers extends Speakers_Emails
{
    //*
    //* function Units, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Speakers($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Unit","Event","Name","Friend",);
        $this->IncludeAllDefault=TRUE;
        $this->Sort=array("Sort","Name");
        $this->IDGETVar="Speaker";
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj()->SqlEventTableName("Speakers",$table);
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

        $file="System/Speakers/Data.Itinerary.php";
        $itinerarydata=$this->ReadPHPArray($file);

        //Force update, when changed
        $this->DataFilesMTime=$this->Max(filemtime($file),$this->DataFilesMTime);
        
        $file="System/Speakers/Itinerary.php";
        $itineraries=$this->ReadPHPArray($file);
        foreach ($itineraries as $itinerarykey => $itinerary)
        {
            foreach ($itinerarydata as $data => $datadef)
            {
                $this->ItemData[ $itinerarykey."_".$data ]=$datadef;
            }
        }
    }

    
    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* Post process item data groups.
    //*

    function PostProcessItemDataGroups()
    {
        $file="System/Speakers/Itinerary.php";
        $itineraries=$this->ReadPHPArray($file);
        
        $file="System/Speakers/Groups.Itinerary.php";
        $itinerarydatagroups=$this->ReadPHPArray($file);

        foreach ($itineraries as $itinerarykey => $itinerary)
        {
            $datas=preg_grep('/^'.$itinerarykey.'_/',array_keys($this->ItemData));
            foreach ($itinerarydatagroups as $group => $groupdef)
            {
                $ikey=$itinerarykey."_".$group;
                $this->ItemDataGroups[ $ikey ]=$groupdef;
                foreach ($itinerary as $key => $value)
                {
                    $this->ItemDataGroups[ $ikey ][ $key ]=$value;
                }

                $this->ItemDataGroups[ $ikey ][ "Data" ]=
                    array_merge
                    (
                       $this->ItemDataGroups[ $ikey ][ "Data" ],
                       $datas
                    );
            }
        }
        $file="System/Speakers/SGroups.Itinerary.php";
        $itinerarydatagroups=$this->ReadPHPArray($file);

        foreach ($itineraries as $itinerarykey => $itinerary)
        {
            $datas=preg_grep('/^'.$itinerarykey.'_/',array_keys($this->ItemData));
            foreach ($itinerarydatagroups as $group => $groupdef)
            {
                $ikey=$itinerarykey."_".$group;
                $this->ItemDataSGroups[ $ikey ]=$groupdef;
                foreach ($itinerary as $key => $value)
                {
                    if (empty($this->ItemDataSGroups[ $ikey ][ $key ]))
                    {
                        $this->ItemDataSGroups[ $ikey ][ $key ]=$value;
                    }
                    else
                    {
                        $this->ItemDataSGroups[ $ikey ][ $key ].=", ".$value;
                    }
                }

                $this->ItemDataSGroups[ $ikey ][ "Data" ]=
                    array_merge
                    (
                       $this->ItemDataSGroups[ $ikey ][ "Data" ],
                       $datas
                    );
            }
        }
    }

    
    
    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
    }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Speakers")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $updatedatas=array();

        $nsubmissions=
            $this->SubmissionsObj()->FriendNSubmissions
            (
               $item[ "Friend" ],
               array("Status"   => 2)
            );

        //Change to check schedule!
        
        $allocated=2;
        if ($nsubmissions>0) { $allocated=1; }

        if ($item[ "Allocated" ]!=$allocated)
        {
            $item[ "Allocated" ]=$allocated;
            array_push($updatedatas,"Allocated");
        }
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        return $item;
    }

    
    //*
    //* function Speaker2Submissions, Parameter list: $speaker,$datas=array()
    //*
    //* Returns speaker's submissions
    //*

    function Speaker2Submissions($speaker,$datas=array())
    {
        if (is_array($speaker)) $speaker=$speaker[ "Friend" ];

        $where=$this->UnitEventWhere();
        $where[ "__Speaker" ]=
            $this->Sql_Where_Data_Ors
            (
                $this->SubmissionsObj()->Authors_Datas("Friend"),
                $speaker
            );

        //var_dump($where);
        return $this->SubmissionsObj()->Sql_Select_Hashes($where,$datas);
    }

    
    //*
    //* function HandleSchedule, Parameter list: $item
    //*
    //* Shows speaker.
    //*

    function HandleSchedule()
    {
        $this->SchedulesObj()->ItemData("ID");
        $this->SchedulesObj()->ItemDataGroups("Basic");
        $this->SchedulesObj()->Actions("Show");
        
        $this->MyMod_Handle_Show();
        $item=$this->ItemHash;
        
        $datas=$this->SchedulesObj()->MyMod_Data_Group_Datas_Get("Basic");

        $schedules=$this->SchedulesObj()->Speaker2Schedules($item,array());

        print
            $this->H(2,"Horários na Grade").
            $this->SchedulesObj()->SchedulesHtmlTable($schedules,$datas).
            "";
    }
    
    //*
    //* Overrides MySql2::AddForm.
    //*

    function MyMod_Handle_Add_Form($title,$addedtitle,$echo=TRUE)
    {
        echo
            $this->FriendsObj()->MyFriend_Add_Form();
        
        parent::MyMod_Handle_Add_Form($title,$addedtitle,$echo);
    }
}

?>