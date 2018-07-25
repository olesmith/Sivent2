<?php

//include_once("Handle/Start.php");

trait MyApp_Profiles
{
    //Changes: 18/09/2015.

    //*
    //* function MyApp_Profiles_Path, Parameter list: 
    //*
    //* Returns Profiles path.
    //*

    function MyApp_Profiles_Path()
    {
        return $this->ApplicationObj->MyApp_Setup_Path($this->ModuleName);
    }

    //*
    //* function GetProfiles, Parameter list: 
    //*
    //* Reads profiles if necessary.
    //*

    function GetProfiles()
    {
        if (empty($this->Profiles))
        {
            $this->MyApp_Profiles_Read();
        }

        return $this->Profiles;
    }

    //*
    //* function MyApp_Profile_Def, Parameter list: $profile=""
    //*
    //* Returns profile definition belonging to $profile.
    //* If $profile omitted or empty, returns profile
    //* belonging to $this->Profile.
    //*

    function MyApp_Profile_Def($profile="")
    {
        if ($profile=="") { $profile=$this->Profile; }

        return $this->Profiles[ $profile ];
    }

    //*
    //* function MyApp_Profile_Name, Parameter list: $profile="",$plural=FALSE
    //*
    //* Returns name of Profile $profile or current.
    //*

    function MyApp_Profile_Name($profile="",$plural=FALSE)
    {
        if (empty($profile)) { $profile=$this->Profile; }

        if (empty($profile)) { $profile="Public"; }

        $key="Name";
        if ($plural) { $key="PName"; }

        return $this->GetRealNameKey($this->Profiles[ $profile ],$key);
    }

    //*
    //* function MyApp_Profiles_Read, Parameter list:
    //*
    //*

    function MyApp_Profiles_Read()
    {
        if (count($this->Profiles())>0)
        {
            return;
        }

        if (file_exists($this->MyApp_Setup_Profiles_File()))
        {
            $this->Profiles=$this->ReadPHPArray($this->MyApp_Setup_Profiles_File());
            foreach ($this->ValidProfiles as $id => $profile)
            {
                if (empty($this->Profiles[ $profile ]))
                {
                    $this->Warn
                    (
                       "ReadProfiles: Profile ".$profile." unset in ",
                       $this->MyApp_Setup_Profiles_File()
                    );
                }
            }
        }
        else
        {
            $this->DoDie
            (
               "ReadProfiles: No Profiles file: ",
                $this->MyApp_Setup_Profiles_File()
            );
        }

        $this->NProfiles=count($this->ValidProfiles);
        $this->AddCookieVar("Profile");
    }


    //*
    //* function MyApp_Profile_Detect, Parameter list: 
    //*
    //* Detect profile from $this->LoginData, and
    //* then CGI/Cookie value of key Profile. Sets profile
    //* to value found, if allowed. Otherwise, set profile to Public.
    //*


    function MyApp_Profile_Detect()
    {
        $profile=$this->GetCGIVarValue("Profile");
        if (empty($profile))
        {
            $profile=$this->MyApp_Profile_Default();
        }

        $this->MyApp_Profile_Set($profile);
        

    }

    
    //*
    //* function MyApp_Profile_Default, Parameter list:
    //*
    //* Returns default profile - first in $this->AllowedProfiles.
    //*

    function MyApp_Profile_Default()
    {
        //Make sure allowed profiles has been set.
        $this->MyApp_Profile_Allowed_Detect();
        
        $profile="Public";
        if (count($this->AllowedProfiles)>0)
        {
            $profile=$this->AllowedProfiles[0];
        }

        return $profile;
    }

    
    //*
    //* function MyApp_Profile_Cookie_Send, Parameter list:
    //*
    //* Sends the Profile cookie.
    //*

    function MyApp_Profile_Cookie_Send()
    {
        $this->SetCookie("Profile",$this->Profile(),time()+$this->CookieTTL);
    }

    //*
    //* function MyApp_Profile_Trust, Parameter list:
    //*
    //* Detects $profile trust value.
    //*

    function MyApp_Profile_Trust($profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        return intval($this->Profiles($profile,"Trust"));
    }
   
    //*
    //* function MyApp_Profile_Set, Parameter list: $profile
    //*
    //* Tries to set profile to $profile.
    //* Checks if allowed - dies if not.
    //*

    function MyApp_Profile_Set($profile)
    {
        //Make sure allowed profiles has been set.
        $this->MyApp_Profile_Allowed_Detect();

        $res=FALSE;
        if ($profile=="Public")
        {
            $this->Profile=$profile;
            $this->LoginType=$profile;

            $res=TRUE;
        }
        elseif (preg_grep('/^'.$profile.'$/',$this->AllowedProfiles))
        {
            if ($profile=="Admin")
            {
                if ($this->MyApp_Profile_MayBecomeAdmin())
                {
                    $this->Profile=$profile;
                    $this->LoginType="Admin";
                    
                    $this->MyApp_Profile_Cookie_Send();
                
               
                    $res=TRUE;
                }
            }
            else
            {
                $this->Profile=$profile;
                $this->LoginType="Person";
                
                $this->MyApp_Profile_Cookie_Send();
                
                $res=TRUE;
            }
        }

        return $res;
    }

    
    //*
    //* function MyApp_Profile_MayBecomeAdmin, Parameter list: 
    //*
    //* Detects if logged on user may become admin.
    //*

    function MyApp_Profile_MayBecomeAdmin()
    {
        $res=FALSE;

        if ($this->LoginID>0)
        {
            if ($this->LoginData[ "Profile_Admin" ]==2)
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* function MyApp_Profile_MayBecomeAdmin, Parameter list: 
    //*
    //* Detects Allowed profiles from Valid profiles, based on
    //* Login data and profiles.
    //*

    function MyApp_Profile_Allowed_Detect()
    {
        if (count($this->AllowedProfiles)>0) { return; }

        //Necessary?
        $this->NProfiles=count($this->ValidProfiles);

        $this->AllowedProfiles=array();
        if ($this->LoginData)
        {
            foreach ($this->ValidProfiles as $n => $profile)
            {
                if ($profile=="Public") { continue; }

                if (
                      !empty($this->AuthHash[ "ForceProfile" ])
                      ||
                      (
                         isset($this->LoginData[ "Profile_".$profile ])
                         &&
                         $this->LoginData[ "Profile_".$profile ]==2
                      )
                   )
                {
                    array_push($this->AllowedProfiles,$profile);
                }
            }
        }
    }



}

?>