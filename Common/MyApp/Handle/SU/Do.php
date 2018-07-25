<?php

trait MyApp_Handle_SU_Do
{
    //*
    //* function ShiftUser, Parameter list: $user
    //*
    //* Attempt to shif user in Session table.
    //*

    function MyApp_Handle_SU_Do($doit=FALSE,$unset=FALSE)
    {
        if (!$doit && $this->GetPOST("Shift")!=1) { return; }
        $person=$this->MyApp_Handle_SU_User_Read();

        var_dump($person);
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

            $args=$this->CGI_Query2Hash();
            $args=$this->CGI_Hidden2Hash($args);
            $query=$this->CGI_Hash2Query($args);

            $this->AddCommonArgs2Hash($args);
            $args[ "Action" ]="Start";

            
            //Now added, reload as edit, preventing multiple adds
            //header("Location: ?".$this->CGI_Hash2Query($args));
            //exit();
        }

        var_dump($person);
        
    }
}

?>