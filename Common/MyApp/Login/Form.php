<?php

trait MyApp_Login_Form
{
    //*
    //* function MyApp_Login_Form, Parameter list: $msg1="",$msg2=""
    //*
    //* Creates login form.
    //*

    function MyApp_Login_Form($msg1="",$msg2="")
    {
        if ($this->Caller()!="LoginForm" && method_exists($this,"LoginForm"))
        {
            $this->LoginForm();

            return;
        }

        if ($this->HeadersSend==0)
        {
            $this->LoginType="Public";
            $this->LogMessage("LoginForm","-");

            $this->MakeCGI_Cookie_Set("SID","",time()-$this->CookieTTL);
            $this->MakeCGI_Cookie_Set("Admin","",time()-$this->CookieTTL);
            $this->MakeCGI_Cookie_Set("Profile","",time()-$this->CookieTTL);
            $this->MakeCGI_Cookie_Set("ModuleName","",time()-$this->CookieTTL);

            $this->ResetCookieVars();

            $this->MyApp_Interface_Head();
        }

        $login=$this->CGI_VarValue("Login");
        if (empty($login))
        {
            $login=$this->CGI_GET("Email");
        }
        
        $table=array
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
        );

        $premsg="";
        if ($this->LoginPreMessage!="")
        {
            if (method_exists($this,$this->LoginPreMessage))
            {
                $method=$this->LoginPreMessage;
                $premsg=$this->$method();
            }
            else
            {

                $premsg=$this->H(2,$this->LoginPreMessage);
            }
        }

        $formtitle=$this->GetMessage($this->LoginMessages,"Login");

        echo 
            /* $this->H(1,$title). */
            $premsg.
            $this->H(3,$msg1).
            $this->H(2,$formtitle).
            $this->H(4,join(",",$this->HtmlStatusMessages)).
            $this->StartForm
            (
               "?Action=Logon",
               "post",
               $enctype=0,
               $options=array(),
               array("ModuleName")
            ).
            $this->FrameIt
            (
               $this->HTML_Table("",$table,array())
            ).
            $this->MakeHidden("Logon",1).
            $this->Buttons($this->GetMessage($this->LoginMessages,"LoginSendButton")).
            $this->EndForm().
            $this->H(3,$msg2).
            $this->Div($this->Auth_Message,array("CLASS" => 'errors')).
            $this->MyApp_Login_PostMessage().
            "<BR><BR>";
    }

    //*
    //* function LoginPostMessage, Parameter list: 
    //*
    //* Returns post message to Login form.
    //*

    function MyApp_Login_PostMessage()
    {
        return 
            "<TABLE BORDER='1' WIDTH='80%' ALIGN='center'><TR><TD>\n".
            "<DIV CLASS='postloginmsg'>".
            $this->GetMessage
            (
               $this->LoginMessages,
               "LoginPostMessage"
            ).
            "</DIV>\n".
            "</TD></TR></TABLE>";

        if ($this->LoginPostMessage!="")
        {
            if (method_exists($this,$this->LoginPostMessage))
            {
                $method=$this->LoginPostMessage;
                $this->$method();
            }
            else
            {

                $this->H(2,$this->LoginPostMessage);
            }
        }
    }
}

?>