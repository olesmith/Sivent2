<?php

global $HtmlMessages; //global and common for all classes
$HtmlMessages=array();
    

trait MyApp_Interface_Messages
{
    var $HtmlStatusMessages=array();

    //*
    //* sub MyApp_Interface_ExecTime, Parameter list: 
    //*
    //* Returns exectime, if initialized.
    //*

    function MyApp_Interface_ExecTime()
    {
        if (isset($this->ExecMTime))
        {
            return
                $this->B("Module Exec Time: ").
                 $this->ExecMTime."<BR>";
        }

        return "";
   }

    //*
    //* sub MyApp_Interface_Status, Parameter list: 
    //*
    //* Returns exectime, if initialized.
    //*

    function MyApp_Interface_Status()
    {
        if (!empty($this->Auth_Message))
        {
            array_push($this->HtmlStatusMessages,$this->Auth_Message);
        }
     

        $status="Status: OK";
        $options=array();
        if (!empty($this->HtmlStatusMessages))
        {
            $class="errors";
            $status="Erro!";
            $options=array("CLASS" => $class);
        }
        
        return 
            "<BR>".
            $status.
            $this->HtmlList($this->HtmlStatusMessages);
    }

    //*
    //* sub AddHtmlStatusMessage, Parameter list: $msg
    //*
    //* Adds a message to HtmlStatusMessages.
    //*
    //*

    function AddHtmlStatusMessage($msg)
    {
        array_push($this->HtmlStatusMessages,$msg);
    }

    //*
    //* sub PrintStatusMessage, Parameter list: $msg
    //*
    //* Prints message - and adds to HtmlStatusMessages.
    //*
    //*

    function PrintStatusMessage($msg)
    {
        $this->AddHtmlStatusMessage($msg);
        echo
            $this->Div($msg,array("CLASS" => "diagnostics"));
    }

    //*
    //* sub AddEmailMessage, Parameter list: $msg
    //*
    //* Adds a message to .
    //*
    //*

    function AddEmailMessage($msg)
    {
        array_push($this->EmailMessage,$msg);
    }


    //*
    //* sub MyApp_Interface_Messages, Parameter list:
    //*
    //* Prints table of gathered HtmlStatusMessages.
    //*
    //*

    function MyApp_Interface_Messages()
    {
        return
            $this->MyApp_Interface_Messages_Status().
            $this->MyApp_Interface_Messages_Email().
            "";
            
    }

    //*
    //* sub MyApp_Interface_Messages_Status_Status, Parameter list:
    //*
    //* Prints table of gathered HtmlStatusMessages.
    //*
    //*

    function MyApp_Interface_Messages_Status()
    {
        if (!empty($this->HtmlStatusMessages))
        {
            return
                "Mensagens:<BR>".
                $this->HtmlList($this->HtmlStatusMessages)."<BR>";
        }

        return "";
    }


    //*
    //* sub MyApp_Interface_Messages_Email, Parameter list:
    //*
    //* Prints table of gathered HtmlStatusMessages.
    //*
    //*

    function MyApp_Interface_Messages_Email()
    {
        if (!empty($this->EmailMessage))
        {
            return $this->HtmlList($this->EmailMessage)."<BR>";
        }

        return "";
    }

    
    //*
    //* sub MyApp_Interface_Messages_System, Parameter list:
    //*
    //* Prints table of gathered System messages.
    //*
    //*

    function MyApp_Interface_Messages_System()
    {
        global $HtmlMessages;
        $text=array("No messages"); 
        if (count($HtmlMessages)>0)
        {
            $table=array();
            for ($n=0;$n<count($HtmlMessages);$n++)
            {
                array_push($table,array($n+1,$HtmlMessages[ $n ]));
            }

            $text=
                $this->Htmls_Tag
                (
                    "DIV",
                    array
                    (
                        $this->H(4,"Mensagens gerado durante a execu&ccedil;&atilde;o:"),
                        $this->HTMLs_Table("",$table)
                    ),
                    array
                    (
                        "CLASS" => 'messages'
                    )
                );
        }

        return $text;
    }

    
}

?>