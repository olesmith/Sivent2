<?php

trait MyMod_Profiles
{
    //*
    //* function MyMod_Profiles_Path(), Parameter list: 
    //*
    //* Returns module SetupDataPath.
    //*

    function MyMod_Profiles_Path()
    {
        return $this->ApplicationObj()->MyApp_Setup_Path($this->ModuleName);
    }

     //*
    //* function MyMod_Profile_In_Profiles, Parameter list: $profiles,$profile=""
    //*
    //* Detects if logged on user may become admin.
    //*

    function MyMod_Profile_In_Profiles($profiles,$profile="")
    {
        if (empty($profile)) { $profile=$this->Profile(); }
        
        $res=FALSE;
        if (preg_match('/^('.join("|",$profiles).')$/',$profile))
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function MyMod_Profile_Trust, Parameter list: $profile=""
    //*
    //* Sends the Profile cookie.
    //*

    function MyMod_Profile_Trust($profile="")
    {
        return $this->ApplicationObj()->MyApp_Profile_Trust($profile);
    }



    //*
    //* function MyMod_Profiles_AddDefaultKeys, Parameter list: &$action
    //*
    //* Adds default profiles/logintypes permissions.
    //*

    function MyMod_Profiles_AddDefaultKeys(&$action)
    {
        foreach ($this->Profiles() as $profile => $def)
        {
            if (empty($action[ $profile ]))
            {
                $action[ $profile ]=0; 
            }       
        }

        foreach (array("Public" => 0,"Person" => 0,"Admin" => 1) as $logintype => $access)
        {
            if (empty($action[ $logintype ]))
            {
                $action[ $logintype ]=$access;
            } 
        }
    }


    //*
    //* function MyMod_Profiles_Read, Parameter list: $module=""
    //*
    //* Reads module profile file.
    //*

    function MyMod_Profiles_Read()
    {
        $file=$this->MyMod_Setup_Profiles_File();
        if (!file_exists($file))
        {
            $this->DoDie("No Module Profile file: ".$file."<BR>\n");
        }


        $this->ModuleProfiles=$this->ReadPHPArray($file);
        $this->ModuleProfiles[ "File" ]=$file;
   }

    //*
    //* function MyMod_Profiles_Init, Parameter list: $module=""
    //*
    //* Inititlizes module profile.
    //*

    function MyMod_Profiles_Init()
    {
        $modfile=$this->MyMod_Setup_Profiles_File();

        $profiles=$this->ReadPHPArray($modfile);

        $profiles[ "File" ]=$modfile;
        $this->MyMod_Profiles_Init_Access($profiles,$this->ModuleName);
        $this->MyMod_Profiles_Init_Menues($profiles,$this->ModuleName);
    }


    //*
    //* function MyMod_Profiles_Init_Access, Parameter list: $profiles,$module=""
    //*
    //* Initilizes Profile class, Access part.
    //*

    function MyMod_Profiles_Init_Access($profiles,$module="")
    {
        $this->ProfileHash=array();
        $this->ProfileHash[ "Access" ]=0;
        if (
              !empty($profiles[ "Access" ][ $this->LoginType ])
              &&
              $profiles[ "Access" ][ $this->LoginType ]>0
           )
        {
            $this->ProfileHash[ "Access" ]=
                $profiles[ "Access" ][ $this->LoginType ];
        }

        if (
            !empty($profiles[ "Access" ][ $this->Profile ])
            &&
            $profiles[ "Access" ][ $this->Profile ]>0
           )
        {
            $this->ProfileHash[ "Access" ]=
                $profiles[ "Access" ][ $this->Profile ];
        }
    }
    
    //*
    //* function MyMod_Profiles_Hash_Transfer, Parameter list: &$hash,$profile,$profiles,$unset=FALSE
    //*
    //* Transfers $profile values to $profiles in $hash
    //*

    function MyMod_Profiles_Hash_Transfer(&$hash,$profile,$profiles,$unset=FALSE)
    {
        foreach (array_keys($hash) as $data)
        {
            if (isset($hash[ $data ][ $profile ]))
            {
                foreach ($profiles as $rprofile)
                {
                    $hash[ $data ][ $rprofile ]=$hash[ $data ][ $profile ];
                }

                if ($unset) { unset($hash[ $data ][ $profile ]); }
            }
        }
    }

    //*
    //* function MyMod_Profiles_Hash_Transfer, Parameter list: $profile,$profiles,$unset=FALSE
    //*
    //* Transfers $profile values to $profiles.
    //*

    function MyMod_Profiles_Transfer($profile,$profiles,$unset=FALSE)
    {
        $this->MyMod_Profiles_Hash_Transfer($this->ItemData,$profile,$profiles,$unset);
        $this->MyMod_Profiles_Hash_Transfer($this->ItemDataGroups,$profile,$profiles,$unset);
        $this->MyMod_Profiles_Hash_Transfer($this->ItemDataSGroups,$profile,$profiles,$unset);
        $this->MyMod_Profiles_Hash_Transfer($this->Actions,$profile,$profiles,$unset);
    }


    //*
    //* function MyMod_Profiles_Init_Menues, Parameter list: $profiles,$module=""
    //*
    //* Initilizes Profile class, (horisontal) Menus part.
    //*

    function MyMod_Profiles_Init_Menues($profiles,$module="")
    {
        $this->ProfileHash[ "Menues" ]=array();
        foreach (array_keys($this->DefaultMenues) as $menu)
        {
            $this->ProfileHash[ "Menues" ][ $menu ]=array();

            foreach ($this->DefaultMenues[ $menu ] as $action=> $value)
            {
                if ($value>0)
                {
                    $this->ProfileHash[ "Menues" ][ $menu ][ $action ]=$value;
                }
            }

            if (!isset($profiles[ "Menues" ][ $menu ][ $this->LoginType ])) { continue; }

            foreach ($profiles[ "Menues" ][ $menu ][ $this->LoginType ] as $action => $value)
            {
                if ($value>0)
                {
                    $this->ProfileHash[ "Menues" ][ $menu ][ $action ]=1;;
                }
            }

            if (!isset($profiles[ "Menues" ][ $menu ][ $this->Profile ])) { continue; }

            foreach ($profiles[ "Menues" ][ $menu ][ $this->Profile ] as $action => $value)
            {
                if ($value>0)
                {
                    $this->ProfileHash[ "Menues" ][ $menu ][ $action ]=1;
                }
            }

            $this->ProfileHash[ "Menues" ][ $menu ]=array_keys($this->ProfileHash[ "Menues" ][ $menu ]);
        }
    }
}

?>