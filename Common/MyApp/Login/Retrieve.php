<?php

trait MyApp_Login_Retrieve
{
    //*
    //* function MyApp_Login_Retrieve_LoginData, Parameter list: $login
    //*
    //* Retrieve login data from AuthHash[ "Table" ], given login.
    //*

    function MyApp_Login_Retrieve_LoginData($login)
    {
        $this->AuthHash();

        $atable=$this->SqlTableName($this->AuthHash[ "Table" ]);
        $this->UsersObj()->Sql_Table_Structure_Update();

        $where=
            "LOWER(".
               $this->Sql_Table_Column_Name_Qualify($this->AuthHash[ "LoginField" ]).
                ")=".
                $this->Sql_Table_Column_Value_Qualify($login);

        return $this->UsersObj()->Sql_Select_Hash_Unique($where,TRUE);
    }


    //*
    //* function MyApp_Login_Retrieve_Data, Parameter list: $login=""
    //*
    //* Retrieve login data from AuthHash[ "Table" ], given login.
    //* Tries login and in sequence $login.AuthHash[ "LoginAppend" ]
    //*

    function MyApp_Login_Retrieve_Data($login="")
    {
        if (!isset($login) || $login=="") { $login=$_POST[ "Login" ]; }

        if (method_exists($this,"FriendsObj"))
        {
            $this->FriendsObj()->ItemData();
            $this->FriendsObj()->Sql_Table_Structure_Update();
        }
        
        $authdata=$this->MyApp_Login_Retrieve_LoginData($login);
        if (is_array($authdata))
        {
            $rauthdata=array("ID","Login","Password"); //"Privileges","Groups");

            $nprofiles=count($this->ValidProfiles);
            if (preg_grep('/^Public$/',$this->ValidProfiles)) { $nprofiles--; }

            $rauth=array();
            foreach ($rauthdata as $id => $data)
            {
                $rauth[ $data ]=$authdata[ $this->AuthHash[ $data."Field" ] ];
            }

            foreach ($this->AuthHash[ "LoginData" ] as $id => $data)
            {
                $rauth[ $data ]=$authdata[ $data ];
            }

            for ($n=0;$n<count($this->ValidProfiles);$n++)
            {
                if ($this->ValidProfiles[$n]!="Public")
                {
                    $data="Profile_".$this->ValidProfiles[$n];
                    $rauth[ $data ]=1;
                    if (isset($authdata[ $data ]))
                    {
                        $rauth[ $data ]=$authdata[ $data ];
                    }
                }
            }

            return $rauth;
        }
        else
        {
            return array();
        }

        $this->DoDie("Unable to retrieve login data",$login);
    }
}

?>