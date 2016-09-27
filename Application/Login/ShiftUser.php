<?php

class LoginShiftUser extends LoginLogin
{
    //*
    //* function ShiftUsersSqlWhere, Parameter list: $peoplewhere=array()
    //*
    //* Returns sql where for allowed users.
    //* Supposed to be overwritten by application.
    //*

    function ShiftUsersSqlWhere($peoplewhere=array())
    {
        if (
              $this->Profile!="Admin"
              &&
              $this->Unit 
              &&
              !empty($this->UsersObj()->ItemData[ "Unit" ]))
        {
            $profiles=$this->ApplicationObj()->ShiftUserUnallowedProfiles();

            $peoplewhere[ "Unit" ]=$this->Unit[ "ID" ];
            foreach ($profiles as $profile)
            {
                $peoplewhere[ "Profile_".$profile ]=1;
            }
        }

        return $this->UsersObj()->GetRealWhereClause($peoplewhere);
    }

    //*
    //* function GetShiftUsers, Parameter list:
    //*
    //* Returns permitted shift users.
    //*

    function GetShiftUsers()
    {
        return $this->UsersObj()->MySqlUniqueColValues
        (
           "",
           "ID",
           $this->ShiftUsersSqlWhere(),
           ""
        );
    }

    //*
    //* function ShiftUser, Parameter list: $user
    //*
    //* Attempt to shif user in Session table.
    //*

     function ShiftUser($user,$doit=FALSE,$unset=FALSE)
    {
        if (!$doit && $this->GetPOST("Shift")!=1) { return; }

        $allowedusers=$this->GetShiftUsers();

        if (!preg_grep('/'.$user.'/',$allowedusers))
        {
            die("Not allowed...");
        }


        $person=$this->UsersObj()->SelectUniqueHash
        (
           "",
           array("ID" => $user)
        );

        if ($person[ "Profile_Admin" ]==2)
        {
            die("SU to Admin not allowed...");
        }

        $user=$person[ "Email" ];
        $logindata=$this->MyApp_Login_Retrieve_Data($user);

        if (is_array($logindata) && count($logindata)>0)
        {
            $session=$this->SessionData;

            if ($unset)
            {
                $session[ "SULoginID" ]=$this->LoginData[ "ID" ];
            }
            else
            {
                $session[ "SULoginID" ]=0;
            }

            $session[ "LoginID" ]=$logindata[ "ID" ];
            $session[ "Login" ]=$user;
            $session[ "LoginName" ]=$logindata[ "Name" ];

            $this->Sql_Update_Item
            (
               $session,
               "SID='".$session[ "SID" ]."'",
               array(),
               $this->GetSessionsTable()
            );

            $this->ConstantCookieVars=preg_grep
            (
               '/^Profile$/',
               $this->ConstantCookieVars,
               PREG_GREP_INVERT
            );

            array_push($this->ConstantCookieVars,"SID");
            $this->ResetCookieVars();

            $args=$this->Query2Hash();
            $args=$this->Hidden2Hash($args);
            $query=$this->Hash2Query($args);

            $this->AddCommonArgs2Hash($args);
            $args[ "Action" ]="Start";

            //Now added, reload as edit, preventing multiple adds
            header("Location: ?".$this->Hash2Query($args));
            exit();
        }
    }


    //*
    //* function ShiftUserSelectField, Parameter list: 
    //*
    //* Creates shift user secelct field.
    //*

    function ShiftUserSelectField()
    {
        $datas=array("ID","Name","Email",);
        foreach (array_keys($this->Profiles) as $profile)
        {
            if (preg_match('/^(Public)$/',$profile)) { continue; }

            array_push($datas,"Profile_".$profile);
        }

        $people=$this->UsersObj()->SelectHashesFromTable
        (
           "",
           $this->ShiftUsersSqlWhere(),
           $datas,
           FALSE,
           "Name"
        );

        $people=$this->UsersObj()->MyMod_Sort_List($people,array("Name","ID"));

        $selectids=array();
        $selectnames=array();

        foreach ($this->Profiles as $profile => $pdef)
        {
            if (preg_match('/^(Public)$/',$profile)) { continue; }

            $rpeople=$this->SublistKeyEqValue($people,"Profile_".$profile,2);

            if (count($rpeople)>0)
            {
                array_push($selectids,"disabled");
                array_push($selectnames,$this->GetRealNameKey($pdef,"PName"));
                foreach ($rpeople as $person)
                {
                    if ($person[ "Profile_Admin" ]==2) { continue; } //newer su to admin!
                    if (empty($person[ "Email" ]))     { continue; }

                    $name=
                        preg_replace('/^\s+/',"",$person[ "Name" ]).
                        " (".$person[ "Email" ]." - ".
                        $person[ "ID" ].")".
                        "";

                    array_push($selectids,$person[ "ID" ]);
                    array_push($selectnames,$name);
                }
            }
        }

        return $this->MakeSelectField("User",$selectids,$selectnames);
    }


    //*
    //* function ShiftUserForm, Parameter list: 
    //*
    //* Presents Form for shifting user (admin only).
    //*

    function ShiftUserForm()
    {
        $msg="";
        if ($this->GetPOST("Shift")==1)
        {
            $user=$this->GetPOST("User");
            $this->ShiftUser($user);

            //Still here, user id invalid.
            $msg=$this->H(4,"Usário Inválido, tente de novo");
        }


        $this->MyApp_Interface_Head();

        print
            $this->H(2,"Trocar Usuário").
            $msg.
            $this->StartForm().
            $this->HtmlTable
            (
               "",
               array
               (
                  array
                  (
                     $this->B("Usuário:"),
                     $this->ShiftUserSelectField()
                  ),
                  array
                  (
                     $this->MakeHidden("Shift",1).
                     $this->Button("submit","GO")
                  ),
               )
            ).
            $this->EndForm().
            "";
    }
}


?>