<?php

class LoginPasswordChange extends LoginLogoff
{

    //*
    //* function ChangePasswordForm, Parameter list: $logindata
    //*
    //* Creates the change password form.
    //*

    function ChangePasswordForm()
    {
        $password=$this->GetPOST("Password");

        $message="";
        if ($this->GetPOST("Update")==1 && $password!="")
        {
            $logindata=$this->LoginData;
            if (count($this->LoginData)>0)
            {
                $rlogin=$this->LoginData[ $this->AuthHash[ "LoginField" ] ];
                $rpassword=$this->LoginData[ $this->AuthHash[ "PasswordField" ] ];

                $rrpassword=$password;
                if ($this->CheckHashKeyValue($this->AuthHash,"MD5",1))
                {
                    $rrpassword=md5($password);
                }

                if ($rrpassword==$rpassword)
                {
                    $pwd1=$this->GetPOST("Password1");
                    $pwd2=$this->GetPOST("Password2");
                    if ($pwd1==$pwd2)
                    {
                        if ($this->IsAValidPassword($pwd1,$message)>=8)
                        {
                            $rpwd=$pwd1;
                            if ($this->AuthHash[ "MD5" ])
                            {
                                $rpwd=md5($rpwd);
                            }

                            $this->MySqlSetItemValue
                            (
                               $this->SqlTableName($this->AuthHash[ "Table" ]),
                               $this->AuthHash[ "IDField" ],
                               $this->LoginData[ "ID" ],
                               $this->AuthHash[ "PasswordField" ],
                               $rpwd
                            );

                            $message=$this->GetMessage($this->LoginMessages,"Password_Updated"); 
                        }
                    }
                    else { $message=$this->GetMessage($this->LoginMessages,"Error_PasswordNotAccepted"); }
                }
                else { $message=$this->GetMessage($this->LoginMessages,"Error_LoginIvalid1"); }
            }
            else { $message=$this->GetMessage($this->LoginMessages,"Error_LoginIvalid2"); }
        }
        elseif ( $password!="") { $message=$this->GetMessage($this->LoginMessages,"Error_NoPassword"); }

        $this->MyApp_Interface_Head();

        print 
            $this->H(1,$this->GetMessage($this->LoginMessages,"Update_Password_Title")).
            $this->H(4,$message).
            $this->H(2,$this->GetMessage($this->LoginMessages,"Update_Password_Msg")).
            $this->StartForm("?Action=NewPassword").
            $this->HTMLTable
            (
               "",
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
                     $this->B($this->GetMessage($this->LoginMessages,"Login_OldPassword").":"),
                     $this->MakePassword("Password","",10)
                  ),
                  array
                  (
                     $this->B($this->GetMessage($this->LoginMessages,"Login_Password1").":"),
                     $this->MakePassword("Password1","",10)
                  ),
                  array
                  (
                     $this->B($this->GetMessage($this->LoginMessages,"Login_Password2").":"),
                     $this->MakePassword("Password2","",10)
                  ),
               )
            ).
            $this->MakeHidden("Update",1).
            $this->MakeHiddenFields().
            $this->Buttons().
            $this->EndForm();


        exit();

    }
}


?>