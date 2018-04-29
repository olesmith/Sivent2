<?php

class LoginPasswordRecoverForms extends LoginPasswordChange
{
    //*
    //* function InitRecoverPasswordForm, Parameter list: $logindata
    //*
    //* Creates solicitation of reset pássword form.
    //*

    function InitRecoverPasswordForm()
    {
        $login=$this->GetPOST("Recover_Login");
        if (empty($login)) { $login=$this->GetGET("Login"); }

        echo 
            $this->H(2,$this->GetMessage($this->LoginMessages,"Recover_Password_Title")).
            $this->StartForm().
            $this->H
            (
               3,
               $this->GetMessage($this->LoginMessages,"Recover_Password_SubTitle")." ".
               $this->MakeInput
               (
                   "Recover_Login",
                   $login,
                   25
               ).
               $this->MakeButton
               (
                  "submit",
                  $this->GetMessage($this->LoginMessages,"Recover_Password_Button")
               ).
               $this->MakeHidden("Update",1)
            ). 
            $this->H
            (
               4,
               $this->GetMessage($this->LoginMessages,"Recover_Password_Info")
            ).
            $this->EndForm();
    }

    //*
    //* function FinalRecoverPasswordForm, Parameter list:
    //*
    //* Final recover password dialogue. Tests if Login and Code are given,
    //* and if they are, prints the newpassword and repeat password fields.
    //* If Update is set, and passwords match, changes the password and resets
    //* the access code.
    //*

    function FinalRecoverPasswordForm()
    {
        $changed=FALSE;
        $message="";

        $login=$this->GetGETOrPOST("Login");
        $code=$this->GetGETOrPOST("Code");

        if (
            $this->GetPOST("Update")==1
            &&
            $login!="" //only POST, should com from form hidden fields
            &&
            preg_match('/^\S+\@\S+$/',$login)
            &&
            $code!=""
            &&
            preg_match('/^\d+$/',$code)
           )
        {
            $user=$this->MySqlItemValues
            (
               $this->AuthHash[ "Table" ],
               $this->AuthHash[ "LoginField" ],
               $login,
               array("ID",$this->AuthHash[ "LoginField" ],"RecoverCode","RecoverMTime") 
            );

            $dtime=time()-$user[ "RecoverMTime" ];
            if (
                preg_match('/^\d+$/',$user[ "ID" ])
                &&
                $user[ "ID" ]>0
                &&
                $code==$user[ "RecoverCode" ]
                &&
                $dtime>0
                &&
                $dtime<$this->RecoverPasswordTTL
               )
            {
                $pwd1=$this->GetPOST("Password1");
                $pwd2=$this->GetPOST("Password2");
                if ($pwd1==$pwd2)
                {
                    if ($this->MyApp_Login_Password_Valid_Is($pwd1,$message)>=8)
                    {
                        $user[ "NewPassword" ]=$pwd1;
                        $user[ $this->AuthHash[ "PasswordField" ] ]=
                            $this->MyApp_Auth_Crypt_Password_Crypt($pwd1);
                        $user[ "RecoverCode" ]=0;
                        $user[ "RecoverMTime" ]=0;

                        $this->Sql_Update_Item_Values_Set
                        (
                           array
                           (
                              $this->AuthHash[ "PasswordField" ],
                              "RecoverCode",
                              "RecoverMTime"
                           ),
                           $user,
                           $this->AuthHash[ "Table" ]
                        );
                        /* $this->MySqlSetItemValues */
                        /* ( */
                        /*    $this->AuthHash[ "Table" ], */
                        /*    array */
                        /*    ( */
                        /*       $this->AuthHash[ "PasswordField" ], */
                        /*       "RecoverCode", */
                        /*       "RecoverMTime" */
                        /*    ), */
                        /*    $user */
                        /* ); */

                        $this->SendPasswordRecoveredMail($user);

                        print $this->H
                        (
                           4,
                           $this->GetMessage($this->LoginMessages,"Password_Updated")
                        );

                        exit();
                    }
                    else { $message=$this->GetMessage($this->LoginMessages,"Error_PasswordNotAccepted"); }
                }
                else { $message=$this->GetMessage($this->LoginMessages,"Error_PasswordMismatch"); }
            }
            else { $message=$this->GetMessage($this->LoginMessages,"Error_InvalidCode"); }
        }

        $unit=$this->Unit;
        if (is_array($unit) && !empty($unit[ "ID" ])) { $unit=$unit[ "ID" ]; }


        echo 
            $this->H(1,$this->GetMessage($this->LoginMessages,"Update_Password_Title")).
            $this->H(4,$message).
            $this->H(2,$this->GetMessage($this->LoginMessages,"Update_Password_Msg")).
            $this->StartForm("?Action=Recover").
            $this->HTMLTable
            (
               "",
               array
               (
                  array
                  (
                     $this->B($this->GetMessage($this->LoginMessages,"Login_User").":"),
                     $this->GetGETOrPOST("Login")
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
            $this->MakeHidden("Login",$this->GetGETOrPOST("Login")).
            $this->MakeHidden("Unit",$unit).
            $this->MakeHidden("Code",$this->GetGETOrPOST("Code")).
            $this->MakeHidden("Update",1).
            $this->MakeHiddenFields().
            $this->Buttons().
            $this->EndForm();


        exit();

    }
    
 
}


?>