<?php

class LoginLoginChange extends LoginLoginMail
{

    //*
    //* function ChangeLoginForm, Parameter list: $logindata
    //*
    //* Creates the change login (email) form.
    //*

    function ChangeLoginForm()
    {
        $newemail=$this->GetGETOrPOST("NewEmail");
        $code=$this->GetGETOrPOST("Code");

        $newemail=preg_replace('/\s/',"",$newemail);
        $code=preg_replace('/\s/',"",$code);

        $this->MyApp_Interface_Head();

        echo 
            $this->H(1,$this->GetMessage($this->LoginMessages,"Update_Login_Title")).
            $this->StartForm("?Action=NewLogin").
            $this->ChangeLoginTable($newemail,$code).
            $this->MakeHidden("Update",1).
            $this->MakeHiddenFields().
            $this->Button("submit","Enviar").
            $this->EndForm();

        if ($this->GetPOST("Update")==1)
        {
            if (empty($code))
            {
                $this->UpdateChangeLogin($newemail);
            }
            else
            {
                $this->UpdateChangeCode($newemail,$code);
            }
        }

        exit();

    }

    //*
    //* function TestNewEmail, Parameter list: $newemail
    //*
    //* Returns true/false, whether $newemail is valid and different from current.
    //*

    function TestNewEmail($newemail)
    {
        if ($this->LoginData[ "Email" ]==$newemail) { return FALSE; }

        $items=$this->FriendsObj()->Sql_Select_Hashes(array("Email" => $newemail),array("ID"));
        if (count($items)>0) { return FALSE; }

        return $this->ValidEmailAddress($newemail);
    }


    //*
    //* function ChangeLoginTable, Parameter list: $newemail,$code
    //*
    //* Creates the change password table.
    //*

    function ChangeLoginTable($newemail,$code)
    {
        $table=
            array
            (
               array
               (
                  $this->B($this->GetMessage($this->LoginMessages,"Login_Name").":"),
                  $this->LoginData[ "Name" ]
               ),
               array
               (
                  $this->B($this->GetMessage($this->LoginMessages,"Login_User").":"),
                  $this->LoginData[ "Email" ]
               ),
               array
               (
                  $this->B($this->GetMessage($this->LoginMessages,"Login_NewEmail").":"),
                  $this->MakeInput("NewEmail",$newemail,20)
               ),
            );

        if (!$this->TestNewEmail($newemail))
        {
            array_push
            (
               $table,
               array
               (
                  $this->B($this->GetMessage($this->LoginMessages,"Login_NewEmailInvalid")),
               )
            );
        }
        else
        {
            array_push
            (
               $table,
               array
               (
                  $this->B($this->GetMessage($this->LoginMessages,"Login_Code").":"),
                  $this->MakeInput("Code",$code,20)
               )
           );
        }

        return 
            $this->H(2,$this->GetMessage($this->LoginMessages,"Update_Login_Msg")).
            $this->Html_Table("",$table,array(),array(),array(),TRUE,TRUE);
    }

    //*
    //* function UpdateChangeLogin, Parameter list: $newemail
    //*
    //* Updates the change password table.
    //*

    function UpdateChangeLogin($newemail)
    {
        if (!$this->TestNewEmail($newemail)) { return FALSE; }

        $this->AddRecoverEntry($this->LoginData);

        $this->SendChangeLoginMail($newemail,$this->LoginData);

        echo 
            $this->H(3,$this->GetMessage($this->LoginMessages,"Recover_Login_Mail_Message"));
    }

    //*
    //* function UpdateChangeCode, Parameter list: $newemail,$code
    //*
    //* Checks code and does alteration of match.
    //*

    function UpdateChangeCode($newemail,$code)
    {
        if (!$this->TestNewEmail($newemail)) { return FALSE; }

        $dtime=time()-$this->LoginData[ "RecoverMTime" ];

        if (
              strlen($code>=18)
              &&
              $code==$this->LoginData[ "RecoverCode" ]
              &&
              $dtime<$this->RecoverPasswordTTL
           )
        {
            $oldemail=$this->LoginData[ "Email" ];

            $this->LoginData[ "Email" ]=$newemail;
            $this->LoginData[ "RecoverCode" ]="";
            $this->LoginData[ "RecoverMTime" ]=0;

            $this->MySqlSetItemValues
            (
                $this->AuthHash[ "Table" ],
                array("Email","RecoverCode","RecoverMTime"),
                $this->LoginData
            );

            $this->MySqlSetItemValue
            (
                $this->SessionsTable,
                "LoginID",
                $this->LoginData[ "ID" ],
                "Login",
                $this->LoginData[ "Email" ]
            );
  
            $this->SendChangedLoginMail($oldemail,$this->LoginData);

            echo 
                $this->H(3,$this->GetMessage($this->LoginMessages,"Recovered_Login_Mail_Message"));
        }
        else
        {
            echo 
                $this->H(3,$this->GetMessage($this->LoginMessages,"Recovered_Login_Error"));
        }
    }
}



?>