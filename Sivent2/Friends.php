<?php

include_once("../EventApp/MyFriends.php");

include_once("Friends/Clean.php");
include_once("Friends/Access.php");
include_once("Friends/Collaborations.php");
include_once("Friends/Submissions.php");
include_once("Friends/Speakers.php");
include_once("Friends/Events.php");
include_once("Friends/Inscriptions.php");
include_once("Friends/Statistics.php");
include_once("Friends/Handle.php");

class Friends extends Friends_Handle
{
    var $StateKeys=array("Address_State","RG_UF");
    var $FriendDataMessages="Friends.php";

    var $Profile2Permissions=array
    (
        "Friend" => array
        (
        ),
        "Coordinator" => array
        (
           "Coordinator" => 1,
           "Friend" => 2,
           "Admin" => 1,
        ),
    );

    //*
    //* function Friends, Parameter list: $args=array()
    //*
    //* Constructor.
    //*

    function Friends($args=array())
    {
        $this->Hash2Object($args);
        $this->AlwaysReadData=array("Name","Unit");
        $this->Sort=array("Name");
        $this->UploadFilesHidden=FALSE;        

        if (preg_match('/^(Friend)$/',$this->Profile()))
        {
            $this->SqlWhere[ "ID" ]=$this->ApplicationObj->LoginData[ "ID" ];
        }
        elseif (preg_match('/^(Coordinator|Admin)$/',$this->Profile()))
        {
        }
    }

    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Overrides SqlTableName, prepending period id.
    //* Calls ApplicationObj->SqlPeriodTableName.
    //*

    function SqlTableName($table="")
    {
        return $this->ApplicationObj->SqlUnitTableName("Friends",$table);
    }

    //*
    //* function MyMod_Setup_Profiles_File, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_Profiles_File()
    {
        return "System/Friends/Profiles.php";
    }
    
    //*
    //* function SetProfilePermissions, Parameter list:
    //*
    //* Based on profile, updates $this->ItemData permissions
    //*

    function SetProfilePermissions()
    {
        if ($this->ApplicationObj->LoginType=="Person")
        {
            $profile=$this->ApplicationObj->Profile;

            $perms=array();
            foreach (array_keys($this->ApplicationObj->Profiles) as $rprofile)
            {
                if ($rprofile=="Public") { continue; }
                $perms[ $rprofile ]=0;
            }

            if (!empty($this->Profile2Permissions[ $profile ]))
            {
                foreach ($this->Profile2Permissions[ $profile ] as $rprofile => $value)
                {
                    $perms[ $rprofile ]=$value;
                }

                foreach ($perms as $rprofile => $value)
                {
                    $pkey="Profile_".$rprofile;
                    $this->ItemData[ $pkey ][ $profile ]=$value;
                }
            }
       }
    }


    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        parent::PostProcessItemData();
   }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        parent::PostInit();
     }

    //*
    //* function PostProcess, Parameter list: $item
    //*
    //* Postprocesses and returns $item.
    //*

    function PostProcess($item)
    {
        $module=$this->GetGET("ModuleName");
        if ($module!="Friends")
        {
            return $item;
        }

        if (!isset($item[ "ID" ]) || $item[ "ID" ]==0) { return $item; }

        $this->PostProcessTextName($item);

        return $item;
    }

    //*
    //* function PostProcessTextName, Parameter list: &$item
    //*
    //* Postprocesses Name to TextName.
    //*

    function PostProcessTextName(&$item)
    {
        $updatedatas=array();
        if (!empty($item[ "Name" ]))
        {
            $this->MakeSureWeHaveRead("",$item,"TextName");
            $name=$this->Html2Sort($item[ "Name" ]);
            $name=$this->Text2Sort($name); 

            if ($item[ "TextName" ]!=$name)
            {
                $item[ "TextName" ]=$name;
                array_push($updatedatas,"TextName");
            }
        }

        if (count($updatedatas)>0)
        {
            $this->MySqlSetItemValues("",$updatedatas,$item);
        }
    }

    //*
    //* function Name, Parameter list: $id=0,$key="Name"
    //*
    //* Creates properly formatted Period name.
    //*

    function Name($id=0,$key="Name")
    {
        if (empty($id)) { return "Nome"; }
        
        if (is_array($id)) { $id=$id[ "ID" ]; }

        if (!isset($this->_Names)) { $this->_Names=array(); }
        if (!isset($this->_Names[ $key ])) { $this->_Names[ $key ]=array(); }

        if (empty($this->_Names[ $key ][ $id ]))
        {
            $this->_Names[ $key ][ $id ]=$this->MySqlItemValue("","ID",$id,$key,TRUE);
        }

        return $this->_Names[ $key ][ $id ];
    }
    
    //*
    //* function Friend_Data_Edit_Link, Parameter list: $friend=array()
    //*
    //* Returns number of Submissions registered for $inscription.
    //*

    function Friend_Data_Edit_Link($friend=array())
    {
        if (empty($friend)) { return $this->MyLanguage_GetMessage("Friend_Data_Edit_Link"); }

        $action=$this->FriendsObj()->MyActions_Entry("Edit",$friend,TRUE);
                
        return $action;
        
    }

    
    //*
    //* Overrides FriendInfo.
    //*
    //* Returns info text for $friend.
    //*

    function FriendInfo($friend,$class="")
    {
        $info="";
        if (!empty($friend[ "Title" ]))
        {
            $info.=$friend[ "Title" ]." ";
        }

        $info.=$friend[ "Name" ];

        if (!empty($friend[ "Institution" ]))
        {
            $info.=", ".$friend[ "Institution" ];
        }
        
        if (!empty($friend[ "Lattes" ]))
        {
            $options=array("TARGET" => '_blank');
            if (!empty($class)) { $options[ "CLASS" ]=$class; }
            
            $info.=" ".$this->A($friend[ "Lattes" ],"Curriculum",$options);
        }
        
        return $info;
    }
}

?>