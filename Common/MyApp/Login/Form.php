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
            $this->MyApp_Login_Headers_Send();
        }

        echo
            $this->Htmls_Text
            (
                $this->Htmls_Comment_Section
                (
                    "Login Form",
                    array
                    (
                        $this->MyApp_Login_Form_Pre_Messages(),
                        $this->Htmls_Form
                        (
                            1,
                            "Login_Form",
                            "?Action=Logon",
                            array_merge
                            (
                                array
                                (
                                    $this->H
                                    (
                                        2,
                                        $this->GetMessage($this->LoginMessages,"Login")
                                    ),
                                    $this->H(3,$msg1),
                                    $this->H(4,join(",",$this->HtmlStatusMessages)),
                                ),
                                $this->Htmls_Table
                                (
                                    array(),
                                    $this->MyApp_Login_Table()
                                )
                            ),
                            array
                            (
                                "Hiddens" => array
                                (
                                    "Logon" => 1,
                                ),
                                "Method" => "post",
                                "Uploads" => False,
                                "Supress" => array("ModuleName"),
                            ),
                            $options=array()
                        ),
                        array
                        (
                            $this->H(3,$msg2),
                            $this->Htmls_Tag
                            (
                                "DIV",
                                $this->Auth_Message,
                                array("CLASS" => 'errors')
                            ),
                            $this->MyApp_Login_Form_Post_Messages(),
                            $this->BR().$this->BR(),
                        ),
                    )
                )
            );
    }

    //*
    //* function LoginPostMessage, Parameter list: 
    //*
    //* Returns post message to Login form.
    //*

    function MyApp_Login_PostMessage()
    {
        return
            $this->Htmls_Text
            (
                $this->MyApp_Login_Form_Post_Messages()
            );
    }
    
    //*
    //* function MyApp_Login_Form_Post_Message, Parameter list:
    //*
    //* Returns login form post message.
    //*

    function MyApp_Login_Form_Post_Messages()
    {
        return
            $this->Htmls_Tag
            (
                "DIV",
                $this->Htmls_DIV
                (
                    $this->GetMessage
                    (
                        $this->LoginMessages,
                        "LoginPostMessage"
                    ),
                    array
                    (
                        "CLASS" => 'postloginmsg message-body',
                    )
                ),
                array
                (
                    "CLASS" => "message is-warning"
                )
            );
    }

    
    //*
    //* function MyApp_Login_Form_Pre_Message, Parameter list:
    //*
    //* Returns login form pre message.
    //*

    function MyApp_Login_Form_Pre_Messages()
    {
        $premsg=array();
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

        return $premsg;
    }
}

?>