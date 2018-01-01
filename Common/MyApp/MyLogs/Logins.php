<?php


trait MyLogs_Logins
{
    var $__Logins__=array();
    
    //*
    //* function Logs_Info_Logins_Read, Parameter list: $date,$values
    //*
    //* Reads accumutatively login data for $values, stores in $this->__Logins__.
    //*

    function Logs_Info_Logins_Read($date,$values)
    {
        foreach
            (
                $this->FriendsObj()->Sql_Select_Hashes_ByID
                (
                    array("ID" => $values),
                    array("ID","Name","Email")
                ) as $item)
        {
            $this->__Logins__[ $item[ "ID" ] ]=$item;
        }
        
        return $this->__Logins__;
    }

     //*
    //* function Logs_Info_Login_Name, Parameter list: $friend
    //*
    //* Reads login name from $friend.
    //*

    function Logs_Info_Login_Read($friend)
    {
        if (!empty($friend) && empty($this->__Logins__[ $friend ]))
        {
            $this->__Logins__[ $friend ]=
                $this->FriendsObj()->Sql_Select_Hash
                (
                    array("ID" => $friend),
                    array("ID","Name","Email")
                );
        }

        if (empty($friend)  || empty($this->__Logins__[ $friend ]))
        {
            return
                array
                (
                    "ID" => $friend,
                    "Name" => "No such Login",
                    "Email" => "-"
                );
        }

        return $this->__Logins__[ $friend ];
    }

    
    //*
    //* function Logs_Info_Login_Name, Parameter list: $friend
    //*
    //* Returns login name from $friend.
    //*

    function Logs_Info_Login_Name($friend)
    {
        $friend=$this->Logs_Info_Login_Read($friend);
        
        return $friend[ "Name" ];
    }
    
    //*
    //* function Logs_Info_Login_Email, Parameter list: $friend
    //*
    //* Returns login name with email from $friend.
    //*

    function Logs_Info_Login_Name_And_Email($friend)
    {
        $friend=$this->Logs_Info_Login_Read($friend);
        
        return $friend[ "Name" ]. " (".$friend[ "ID" ].": ".$friend[ "Email" ].")";
    }

    
    //*
    //* function Logs_Cells_Login_Select, Parameter list: 
    //*
    //* Creates select for current Login.
    //*

    function Logs_Cells_Login_Select($where,$date)
    {
        return
            $this->Logs_CGI_Var_Select
            (
                $where,
                "Login",
                $date,
                "Logs_Info_Login_Name",
                "Logs_Info_Login_Name_And_Email",
                "Logs_Info_Logins_Read"
            );
    }


}

?>