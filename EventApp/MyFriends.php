<?php

include_once("MyFriends/Events.php");
include_once("MyFriends/Groups.php");
include_once("MyFriends/Add.php");
include_once("MyFriends/Friend.php");
include_once("MyFriends/Access.php");

class MyFriends extends MyFriends_Access
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
        "Assessor" => array
        (
           "Friend" => 1,
        ),
    );

    //Move To messages!!!

    var $FriendSelectProfileName="";
    var $FriendSelectProfile="";

    var $FriendSelectDatas=array("ID","Name","Email","Unit","Profile_Advisor","Profile_Coordinator");
    var $FriendSelectNewDatas=array("Name","Email","Password","Unit");
    var $InscriptionSelectDatas=array();

    /* //var $FriendSelectSearchTitle="Digite (parte do) nome/email do cadastro"; */
    /* //var $FriendSelectSearchButton="Pesquisar Cadastros"; */

    /* //var $FriendSelectNewButton="Adicionar Cadastro"; */

    /* //var $FriendSelectTitle="Cadastros"; */
    /* //var $FriendSelectTableTitle="Cadastros conformando à Pesquisa"; */
    /* //var $FriendSelectTableEmpty="Nenhum Cadastro encontrado. Deseja adicionar Cadastro?"; */
    /* var $FriendSelectPromoteMsg=""; */
    /* var $FriendSelectInfoMsg= */
    /*     "Cadastrantes adicionados neste tela, pode obter acesso a sistema,<BR>, */
    /*      usando o link 'Recuperar Senha' no menu esquerda da tela de Login!<P>\n */
    /*      No primeiro acesso ao sistema, o preenchimento dos dados pessoais será exigido do cadastrante.\n"; */


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

        if (preg_match('/^(Candidate|Assessor)$/',$this->Profile()))
        {
            $this->SqlWhere[ "ID" ]=$this->ApplicationObj->LoginData[ "ID" ];
        }
        elseif (preg_match('/^(Coordinator|Admin)$/',$this->Profile()))
        {
            //$this->SqlWhere[ "Profile_Candidate" ]=2;
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
    //* function MyMod_Setup_ProfilesDataFile, Parameter list:
    //*
    //* Returns name of file with Permissions and Accesses to Modules.
    //* Overrides trait!
    //*

    function MyMod_Setup_ProfilesDataFile()
    {
        return "../EventApp/System/Friends/Profiles.php";
    }
    //*
    //* function PreActions, Parameter list:
    //*
    //* 
    //*

    function PreActions()
    {
        array_unshift($this->ActionPaths,"../EventApp/System/Friends");
    }


    //*
    //* function PostActions, Parameter list:
    //*
    //* 
    //*

    function PostActions()
    {
        /* $this->MyMod_Profiles_Hash_Transfer($this->Actions,"Friend",$this->ApplicationObj()->UserProfiles,TRUE); */
    }

    
    //*
    //* function PreProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PreProcessItemDataGroups()
    {
        array_unshift($this->ItemDataGroupPaths,"../EventApp/System/Friends");
    }

    //*
    //* function PostProcessItemDataGroups, Parameter list:
    //*
    //* 
    //*

    function PostProcessItemDataGroups()
    {
        $this->ItemDataGroups[ "Profiles" ]=array
        (
           "Name" => "Perfis",
           "Name_UK" => "Profiles",
           "Data" => array("No","Edit","Name","Status","Institution","Email",),
           "Admin" => 1,
           "Public" => 0,
           "Person" => 0,

           "Monitor" => 0,
           "Coordinator" => 1,
           "Advisor" => 1,
        );

        
        $this->ItemDataSGroups[ "Profiles" ]=array
        (
           "Name" => "Perfis",
           "Name_UK" => "Profiles",
           "Data" => array(),
           "Admin" => 1,
           "Public" => 0,
           "Person" => 0,

           "Monitor" => 0,
           "Coordinator" => 1,
           "Advisor" => 1,
        );


        foreach ($this->ApplicationObj->Profiles as $profile => $profiledef)
        {
            if ($profile=="Public") { continue;  }

            $pkey="Profile_".$profile;
            array_push($this->ItemDataGroups[ "Profiles" ][ "Data" ],$pkey);
            array_push($this->ItemDataSGroups[ "Profiles" ][ "Data" ],$pkey);
        }

        $this->ItemData[ "CTime" ][ "Name" ]="Cadastro Efetuado";
        $this->MyMod_Data_Group_Defaults_Take($this->ItemDataGroups[ "Profiles" ]);
        /* $this->MyMod_Profiles_Hash_Transfer($this->ItemDataGroups,"Friend",$this->ApplicationObj()->UserProfiles,TRUE); */
        /* $this->MyMod_Profiles_Hash_Transfer($this->ItemDataSGroups,"Friend",$this->ApplicationObj()->UserProfiles,TRUE); */
    }

    //*
    //* function PreProcessItemData, Parameter list:
    //*
    //* Pre process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PreProcessItemData()
    {
        array_unshift($this->ItemDataPaths,"../EventApp/System/Friends");
    }
    

    //*
    //* function PostProcessItemData, Parameter list:
    //*
    //* Post process item data; this function is called BEFORE
    //* any updating DB cols, so place any additonal data here.
    //*

    function PostProcessItemData()
    {
        /* $this->MyMod_Profiles_Hash_Transfer($this->ItemData,"Friend",$this->ApplicationObj()->UserProfiles,TRUE); */
        
        if (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
        {
            $this->ItemData[ "Email" ][ "Iconify" ]=0;
        }

        foreach ($this->ApplicationObj->Profiles as $profile => $profiledef)
        {
            if ($profile=="Public") { continue; }

            $pkey="Profile_".$profile;

            $default=1;
            if ($profile=="Friend") { $default=2; }

            $this->ItemData[ $pkey ]=array
            (
               "Name" => $profiledef[ "Name" ],
               "Name_UK" => $profiledef[ "Name_UK" ],
               "Sql" => "ENUM",
               "Values" => array("Não","Sim"),
               "Values_UK" => array("No","Yes"),
               "Default" => $default,
               "Search" => TRUE,
               "SearchCheckBox" => TRUE,

               "Admin" => 2,
               "Friend" => 0,
               "Assessor" => 0,
               "Coordinator" => 2,
               "Person" => 0,
               "Public" => 0,
            );
        }


        $this->SetProfilePermissions();

        $this->ApplicationObj->MyApp_Profile_Detect();
   }

    //*
    //* function PostInit, Parameter list:
    //*
    //* Runs right after module has finished initializing.
    //*

    function PostInit()
    {
        if (preg_match('/^(Coordinator)$/',$this->Profile()))
        {
            $this->ItemData[ "Profile_Coordinator" ][ "Search" ]=FALSE;
            $this->ItemData[ "Profile_Admin" ][ "Search" ]=FALSE;            
        }

        foreach ($this->StateKeys as $key)
        {
            if (empty($this->ItemData[ $key ])) { continue; }

            $this->ItemData[ $key ][ "Values" ]=$this->ApplicationObj->States;
            if (!empty($this->ApplicationObj->Unit[ "State" ]))
            {
                $this->ItemData[ $key ][ "Default" ]=$this->ApplicationObj->Unit[ "State" ];            
            }
        }
        
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
        $this->MakeSureWeHaveRead("",$item,"Name","TextName");
        $updatedatas=array();
        if (!empty($item[ "Name" ]))
        {
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
    //* function HandleEmails, Parameter list:
    //*
    //* Handle friend inscription. 
    //*

    function HandleEmails()
    {
        $where=array();
        $fixedvars=$where;
        
        echo 
            $this->HandleSendEmails(array("Email" =>  "NOT LIKE ''"),array("ID"),$fixedvars).
             "";
    }

    
    //*
    //* function Friend_Name_Text, Parameter list: $friendid
    //*
    //* Returns Friend text (sort) name.
    //*

    function Friend_Name_Text($friendid)
    {
        $friend=
            $this->FriendsObj()->Sql_Select_Hash
            (
               array("ID" => $friendid),
               array("ID","Name","TextName")
            );

        
        if (empty($friend[ "TextName" ]))
        {
            $this->PostProcessTextName($friend);
        }
        
        $name=preg_replace('/\s+/',".",$friend[ "TextName" ]);
        $name=strtolower($name);

        return $name;
    }
}
?>