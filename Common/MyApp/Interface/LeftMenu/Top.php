<?php


trait MyApp_Interface_LeftMenu_Top
{
    //*
    //* function MyApp_Interface_LeftMenu_Top_Welcome, Parameter list:
    //*
    //* Retrusn welcome message.
    //*

    function MyApp_Interface_LeftMenu_Top_Welcome()
    {
        return
            $this->DIV
            (
               $this->MyLanguage_GetMessage("LMWelcomeMessage").": ".
               $this->HtmlSetupHash[ "ApplicationName"  ].
               ", Ver. ".
               $this->HtmlSetupHash[ "ApplicationVersion"  ].
               "<BR>".
               $this->TimeStamp2Text(),

               array("CLASS" => "userinfotable")
            );
    }

    //*
    //* function MyApp_Interface_LeftMenu_Top_UserInfo, Parameter list:
    //*
    //* Returns user info.
    //*

    function MyApp_Interface_LeftMenu_Top_UserInfo()
    {
        if (is_array($this->LoginData) && $this->LoginData[ "Name" ]!="")
        {
            $file=$this->LoginData[ "ID" ].".png";
            $name=$this->IconText($file,$this->LoginData[ "Email" ]);


            $table=array
            (
               array
               (
                  "Login: ",
                  $this->LoginData[ "Email" ].
                  " (".$this->LoginData[ "ID" ].")"
               ),
               array
               (
                  "Alias: ",
                  $this->LoginData[ "Name" ]
               ),
               array
               (
                  "Perfil:",
                  $this->MyApp_Profile_Name()
               ),
            );

            return
                $this->BR().
                $this->HtmlTable("",$table,array(),TRUE,"userinfotable").
                "";

        }
        else
        {
            return 
                $this->MyLanguage_GetMessage("LMAnonymousAccessMessage").
                $this->BR().
                "";
        }
    }

    //*
    //* function MyApp_Interface_LeftMenu_Top_ReadOnlyMessage, Parameter list:
    //*
    //* Returns user info.
    //*

    function MyApp_Interface_LeftMenu_Top_ReadOnlyMessage()
    {
        $html="";
        if (is_array($this->LoginData) && $this->LoginData[ "Name" ]!="")
        {
            if ($this->ReadOnly && $this->LoginType!="Public")
            {
                $html=$this->H(5,"Somente Leitura!");
            }
            else
            {
                $html=$this->BR();
            }
        }

        return $html;
    }


    //*
    //* function MyApp_Interface_LeftMenu_Top_AdminInfo, Parameter list:
    //*
    //* Returns user info.
    //*

    function MyApp_Interface_LeftMenu_Top_AdminInfo()
    {
        $html="";
        if ($this->LoginType=="Admin")
        {
            $html.=$this->DIV
            (
               " >> Admin << ",
               array("CLASS" => 'adminnotice')
            ).
            "<BR>";
        }

        return $html;
    }
}

?>