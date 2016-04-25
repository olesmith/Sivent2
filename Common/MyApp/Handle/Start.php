<?php

trait MyApp_Handle_Start
{
    //*
    //* function MyApp_Handle_Start, Parameter list: $echo=TRUE
    //*
    //* The Start Handler. Should display some basic info.
    //*

    function MyApp_Handle_Start($echo=TRUE)
    {
        if ($this->GetCGIVarValue("Action")=="Start")
        {
            $this->ResetCookieVars();
        }

        //$this->InitHTML();
        $this->MyApp_Interface_Head();

        if ($echo)
        {
            echo
                "\n<BR>\n".
                $this->Html_Table
                (
                   "",
                   array
                   (
                      array
                      (
                         $this->DIV
                         (
                          "Seja bem Vindo à:",
                          array
                          (
                            "CLASS" => 'applicationtitle',
                          )
                         ).
                         "\n<BR><BR>\n".
                         $this->DIV
                         (
                            $this->HtmlSetupHash[ "ApplicationName" ].
                            "<BR><BR>".
                            $this->HtmlSetupHash[ "ApplicationTitle" ].
                            "<BR><BR>",
                            array
                            (
                              "CLASS" => 'applicationname',
                            )
                         ).
                         "\n<BR><BR>\n".
                         $this->DIV
                         (
                            "Por favor, navegue usando o menu na esquerda.",
                            array
                            (
                               "CLASS" => 'applicationtitle',
                            )
                         )
                      ),
                   ),
                   array("ALIGN" => 'center',"BORDER" => 1)
                ).
                "\n";
        }

        
        if (empty($this->LoginData))
        {
            $this->MyApp_Login_Form();
        }
        elseif (method_exists($this,"HandleStart"))
        {
            $this->HandleStart();
            return;
        }
        
    }

}

?>