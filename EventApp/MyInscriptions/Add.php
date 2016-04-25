<?php


class MyInscriptionsAdd extends MyInscriptionsHandle
{
    //*
    //* function AddIsInscribedCell, Parameter list: $friend=array()
    //*
    //* Generate inscription yes/no cell for $friend.
    //*

    function AddIsInscribedCell($friend=array())
    {
        if (empty($friend)) { return "Inscrito"; }

        if (empty($this->Announcement))
        {
            $this->CGI2Announcement();
        }
        
        if (empty($this->Announcement))
        {
            return "Sem Editais...";
        }

        $res=$this->FriendInscribedInAnnoucement($this->Announcement,$friend);

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

        $res=$this->FriendInscribedInAnnoucement($this->Announcement,$friend);

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

        $res=$this->FriendInscribedInAnnoucement($this->Announcement,$friend);

        $cell="-";
        if ($res)
        {
            $inscription=$this->SelectUniqueHash
            (
               "",
               array
               (
                  "Announcement" => $this->Announcement[ "ID" ],
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
            $res=$this->FriendInscribedInAnnoucement($this->Announcement,$friend);

            $value=$this->AddInscribeCGIValue($friend);
            if (!$res)
            {
                if ($value==1)
                {
                    $where=array
                    (
                       "Announcement" => $this->Announcement[ "ID" ],
                       "Friend" => $friend[ "ID" ],
                    ); 

                    $newitem=$where;

                    $newitem[ "Unit" ]=$this->AnnouncementsObj()->MySqlItemValue
                    (
                       "",
                       "ID",
                       $this->Announcement[ "ID" ],
                       "Unit"
                    );
                    $newitem[ "Period" ]=$this->AnnouncementsObj()->MySqlItemValue
                    (
                       "",
                       "ID",
                       $this->Announcement[ "ID" ],
                       "Period"
                    );
                    $newitem[ "City" ]=$this->AnnouncementsObj()->MySqlItemValue
                    (
                       "",
                       "ID",
                       $this->Announcement[ "ID" ],
                       "City"
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
        $this->Event=array();

        $unit=$this->Unit("ID");

        $where=array();
        if (preg_match('/^(Coordinator)$/',$this->Profile()))
        {
            $unit=$this->ApplicationObj()->LoginData[ "Unit" ];
            $where=array("Unit" => $unit);
        }


        $event=$this->GetGETOrPOST("Event");
        if (!empty($event))
        {
            $this->Event[ "ID" ]=$event;
        }
        elseif (!empty($where))
        {
            $ids=$this->EventsObj()->Sql_Select_Unique_Col_Values("ID",$where);

            $this->Event[ "ID" ]=array_pop($ids);
        }
    }

    
    //*
    //* function HandleAdd, Parameter list: $echo=TRUE
    //*
    //* Handle add advisor.
    //*

    function HandleAdd($echo=TRUE)
    {
        $this->PrintDocHeadsAndInterfaceMenu(); 
        $this->FriendsObj()->InitActions();

        array_push($this->FriendsObj()->FriendSelectNewDatas,"Profile_Monitor");

        $this->FriendsObj()->FriendSelectNewDatas=array("Name","Email","Password",);
        $this->FriendsObj()->FriendSelectDatas=array("ID","Name","Email","Profile_Monitor");
        $this->FriendsObj()->FriendSelectTitle="Adicionar Inscrição ou Cadastro";
        $this->FriendsObj()->FriendSelectProfileName="Candidato";
        $this->FriendsObj()->FriendSelectProfile="Monitor";

        $this->FriendsObj()->FriendSelectNewButton="Adicionar Candidato";


        $this->FriendsObj()->SubObject=$this;
        $this->FriendsObj()->SubObjectData=array("AddIsInscribedCell","AddInscribeCell","InscriptionStatusCell");

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
              $this->B("Selecione Evento:"),
              $this->AnnouncementSelect
              (
                 "Event",
                 $this->Announcement,
                 1
              )
           )
        );

        echo 
            $this->FriendsObj()->HandleFriendSelect($newitem,1,$leadingrows,$resulthiddens);
    }
}

?>