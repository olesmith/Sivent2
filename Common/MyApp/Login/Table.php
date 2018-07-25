<?php

trait MyApp_Login_Table
{
    //*
    //* function MyApp_Login_Table, Parameter list:
    //*
    //* Creates login form table.
    //*

    function MyApp_Login_Table()
    {
        $login=$this->CGI_VarValue("Login");
        if (empty($login))
        {
            $login=$this->CGI_GET("Email");
        }
 
        return array
        (
            array
            (
               $this->B
               (
                  $this->GetMessage($this->LoginMessages,"LoginDataTitle").
                  ":"
               ),
               $this->MakeInput("Login",$login,25)
            ),
            array
            (
               $this->B
               (
                  $this->GetMessage($this->LoginMessages,"PasswordDataTitle").
                  ":"
               ),
               $this->MakePassword("Password","",15)
            ),
            array
            (
                $this->Buttons
                (
                    $this->GetMessage($this->LoginMessages,"LoginSendButton")
                ),
            )
        );

    }
}

?>