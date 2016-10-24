<?php


class MyInscriptions_Add extends MyInscriptions_Handle
{
    //*
    //* function FriendInscribedInEvent, Parameter list: $event,$friend
    //*
    //* Returns TRUE if $friend inscribed in $event.
    //*

    function FriendInscribedInEvent($event,$friend)
    {
        return $this->EventsObj()->FriendIsInscribed($event,$friend);
    }

    
    //*
    //* function AddIsInscribedCell, Parameter list: $friend=array()
    //*
    //* Generate inscription yes/no cell for $friend.
    //*

    function AddIsInscribedCell($friend=array())
    {
        if (empty($friend)) { return "Inscrito"; }

        $event=$this->Event();
        
        if (empty($event))
        {
            $this->CGI2Event();
        }
        
        if (empty($event))
        {
            return "No event...";
        }

        $res=$this->FriendInscribedInEvent($event,$friend);

        if ($res) { $res="Sim"; }
        else      { $res="Não"; }

        return $res;
    }


    //*
    //* function AddInscribeCGIKey, Parameter list: $friend
    //*
    //* Generate inscription inscribe checkbox cgi key for $friend.
    //*

    function AddInscribeCGIKey($friend)
    {
        return "Inscribe_".$friend[ "ID" ];
    }

    //*
    //* function AddInscribeCGIValue, Parameter list: $friend
    //*
    //* Generate inscription inscribe checkbox cgi value for $friend.
    //*

    function AddInscribeCGIValue($friend)
    {
        return $this->GetPOST($this->AddInscribeCGIKey($friend));
    }

    //*
    //* function AddInscribeCell, Parameter list: $friend=array()
    //*
    //* Generate inscription inscribe checkbox for $friend.
    //*

    function AddInscribeCell($friend=array())
    {
        if (empty($friend)) { return "Inscrever"; }

        $res=$this->FriendInscribedInEvent($this->Event(),$friend);

        $res=$this->MakeCheckBox
        (
           $this->AddInscribeCGIKey($friend),
           1,
           $res,
           $res
        );

        return $res;
    }

    //*
    //* function InscriptionStatusCell, Parameter list: $friend=array()
    //*
    //* Generate inscription status box for $friend.
    //*

    function InscriptionStatusCell($friend=array())
    {
        if (empty($friend)) { return "Status"; }

        $res=$this->FriendInscribedInEvent($this->Event(),$friend);

        $cell="-";
        if ($res)
        {
            $inscription=$this->SelectUniqueHash
            (
               "",
               array
               (
                  "Event" => $this->Event("ID"),
                  "Friend" => $friend[ "ID" ],
               ),
               FALSE,
               array("ID","Status")
            );

            $cell=$this->MyMod_Data_Fields_Show("Status",$inscription);
        }

        return $cell;
    }

    //*
    //* function AddInscribe, Parameter list: 
    //*
    //* Generate inscription inscribe checkbox for $friend.
    //*

    function AddInscribe()
    {
        if ($this->GetPOST("Save")!=1) { return; }

        $friends=$this->FriendsObj()->AddReadFriends();
        foreach ($friends as $friend)
        {
            $res=$this->FriendInscribedInEvent($this->Event(),$friend);

            $value=$this->AddInscribeCGIValue($friend);
            if (!$res)
            {
                if ($value==1)
                {
                    $where=array
                    (
                       "Event" => $this->Event("ID"),
                       "Friend" => $friend[ "ID" ],
                    ); 

                    $newitem=$where;

                    $newitem[ "Unit" ]=$this->EventsObj()->MySqlItemValue
                    (
                       "",
                       "ID",
                       $this->Event("ID"),
                       "Unit"
                    );

                    $newitem[ "Name" ]=$this->FriendsObj()->MySqlItemValue
                    (
                       "",
                       "ID",
                       $friend[ "ID" ],
                       "Name"
                    );

                    $newitem[ "CTime" ]=time();
                    $newitem[ "ATime" ]=time();
                    $newitem[ "MTime" ]=time();
                    $this->MySqlInsertUnique("",$where,$newitem);
                }
            }
        }
    }

    //*
    //* function CGI2Event, Parameter list: 
    //*
    //* Handle add advisor.
    //*

    function CGI2Event()
    {
        $this->ApplicationObj()->Event=array();
        $event=$this->CGI_GETOrPOSTint("Event");

        if (!empty($event))
        {
            $this->ApplicationObj()->Event=$this->EventsObj()->Sql_Select_Hash(array("ID" => $event));
        }
    }

    
    //*
    //* function HandleAdd, Parameter list: $echo=TRUE
    //*
    //* Handle add advisor.
    //*

    function HandleAdd($echo=TRUE)
    {
        $this->IDGETVar="";
        $this->PrintDocHeadsAndInterfaceMenu(); 
        $this->FriendsObj()->InitActions();

        array_push($this->FriendsObj()->FriendSelectNewDatas,"Profile_Monitor");

        $this->FriendsObj()->FriendSelectNewDatas=array("Name","Email","Password",);
        $this->FriendsObj()->FriendSelectDatas=array("ID","Name","Email","Profile_Friend");
        $this->FriendsObj()->InscriptionSelectDatas=array("Certificate","Certificate_CH");
        //$this->FriendsObj()->FriendSelectTitle="Adicionar Inscrição ou Cadastro";
        $this->FriendsObj()->FriendSelectProfileName="Candidato";
        $this->FriendsObj()->FriendSelectProfile="Friend";

        $this->FriendsObj()->FriendSelectNewButton="Adicionar Candidato";


        $this->FriendsObj()->SubObject=$this;
        $this->FriendsObj()->SubObjectData=array("AddIsInscribedCell","AddInscribeCell","InscriptionStatusCell");
        if ($this->EventsObj()->Event_Certificates_Has())
        {
            array_push($this->FriendsObj()->SubObjectData,"Certificate","Certificate_CH");
        }


        $this->CGI2Event();
        
        $newitem=array
        (
           "Name" => $this->GetPOST("Name"),
           "Email" => $this->GetPOST("Email"),
           "Password" => $this->GetPOST("Password"),
        );


        if ($this->CGI_POSTint("Save")==1) { $this->AddInscribe(); }

        $resulthiddens=array("Event");
        $leadingrows=array
        (
           array
           (
              $this->B($this->MyLanguage_GetMessage("Inscriptions_Add_Event_Title").":"),
              $this->ApplicationObj()->EventSelect
              (
                 "Event",
                 $this->Event(),
                 1
              )
           )
        );

        echo 
            $this->FriendsObj()->HandleFriendSelect($newitem,TRUE,$leadingrows,$resulthiddens);
    }
}

?>