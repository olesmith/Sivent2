<?php

include_once("Login/Form.php");
include_once("Login/Retrieve.php");
include_once("Login/Password.php");

trait MyApp_Login
{
    use
        MyApp_Login_Form,
        MyApp_Login_Retrieve,
        MyApp_Login_Password;
    //*
    //* function MyApp_Login_Init, Parameter list: 
    //*
    //* Initializes login subsystem.
    //*

    function MyApp_Login_Init()
    {
        $this->LoginType="Public";
        $this->Profile="Public";
        if ($this->Authentication)
        {
            $this->AuthHash();

            $this->MyApp_Login_Detect();
            $this->MyApp_Profile_Detect();
        }
        else
        {
            $this->LoginType="Public";
            $this->Profile="Public";
        }
    }

    //*
    //* function MyApp_Login_SetData, Parameter list: $logindata
    //*
    //* Sets LoginData to $logindata. Also sets LoginData, LoginID and Login
    //*

    function MyApp_Login_SetData($logindata)
    {
        if (is_array($logindata) && count($logindata)>0)
        {
            $this->LoginData=$logindata;

            $this->MyApp_Login_Detect();
            $this->MyApp_Profile_Detect();
        }
    }

    //*
    //* function MyApp_Login_Set_User_Language, Parameter list: 
    //*
    //* Update User Language.
    //*

    function MyApp_Login_Set_User_Language()
    {
        if (method_exists($this,"FriendsObj"))
        {
            $this->FriendsObj()->ItemData();
            if (!empty($this->FriendsObj()->ItemData[ "Language" ]))
            {
                $clang=$this->CGI_GET("Lang");

                if (!empty($clang))
                {
                     if ($this->LoginData[ "Language" ]!=$clang)
                     {
                         if (!empty($this->Languages[ $clang ]))
                         {
                             $this->LoginData[ "Language" ]=$clang;
                             $this->FriendsObj()->Sql_Update_Item_Value_Set
                             (
                                $this->LoginData("ID"),
                                "Language",
                                $clang
                             );
                         }
                     }
                }
                     
                //Take user language settings.
                if (!empty($this->LoginData[ "Language" ]))
                {
                    $this->MyLanguage_Set($this->LoginData[ "Language" ]);
                }
           }
        }
    }


    //*
    //* function MyApp_Login_Detect, Parameter list: 
    //*
    //* Detects login type (Public, Person, Admin), return
    //* values are 2,1 and 0 resp.
    //*

    function MyApp_Login_Detect()
    {
        $this->LoginType="Public";
        $res=2;

        if ($this->LoginData)
        {
            $action=$this->GetCGIVarValue("Action");
            $admin=$this->GetCGIVarValue("Admin");
        
           $this->LoginID=$this->LoginData[ "ID" ];
           $this->Login=$this->LoginData[ $this->AuthHash[ "LoginField" ] ];
           if ($action=="Admin" || $admin==1)
           {
               if ($this->MyApp_Profile_MayBecomeAdmin())
               {
                   $this->LoginType="Admin";
                   $res=0;
               }
           }
           elseif ($this->LoginID>0)
           {
               $this->LoginType="Person";
               $res=1;       
           }

           $this->MyApp_Login_Set_User_Language();
        }
        
        return $res;
    }
}

?>