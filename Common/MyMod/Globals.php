<?php



trait MyMod_Globals
{
    //*
    //* function Module2Object, Parameter list: $data
    //*
    //* Shortcut function for get module object.
    //*

    function Module2Object($data)
    {
        return $this->MyMod_Data_Fields_Module_2Object($data);
    }
    //*
    //* function DBHash, Parameter list: $key=""
    //*
    //* Read dbhash file.
    //*

    function DBHash($key="")
    {
        if (empty($this->ApplicationObj()->DBHash))
        {
            $this->ApplicationObj()->DBHash=$this->ReadPHPArray(".DB.php");
        }

        if (!empty($key)) { return $this->ApplicationObj()->DBHash[ $key ]; }
        else              { return $this->DBHash; }
    }


    //*
    //* function IsMain, Parameter list:
    //*
    //* Returns FALSE here in MyMod, TRUE in MyAppd.
    //*

    function IsMain()
    {
        return $this->IsMain;
    }

    //*
    //* function ApplicationObj, Parameter list: 
    //*
    //* For application modules to work with ApplicationObj accessor.
    //*

    function ApplicationObj()
    {
        return $this->ApplicationObj;
    }



    //*
    //* function ModuleName, Parameter list:
    //*
    //* ModuleName accessor.
    //*

    function ModuleName()
    {
        if ($this->IsMain())
        {
            return "Application";
        }
        else
        {
            return $this->ModuleName;
        }
    }

    //*
    //* function SubModulesVars, Parameter list: $module,$key =""
    //*
    //* Accessor to SubModuleVars global array.
    //*

    function SubModulesVars($module,$key="")
    {
        return $this->MyHash_HashHashes_Get($this->ApplicationObj()->SubModulesVars,$module,$key);
    }

    //*
    //* function Warn, Parameter list: $msgs,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Short accessor for error reporting method.
    //*

    function Warn($msgs,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        return $this->ApplicationObj()->MyMessage_Warn($msgs,$info1,$info2,$info3,$info4,$info5);
    }

    //*
    //* function DoExit, Parameter list: $msgs,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Prints $msgs and exits.
    //*

    function DoExit($msgs=array(),$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        if (is_array($msgs))
        {
            $msgs=join("<BR>\n",$msgs);
        }
        echo
            $msgs;
        exit();
    }

    //*
    //* function DoDie, Parameter list: $msgs,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Short accessor for error reporting method.
    //*

    function DoDie($msgs,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        return $this->ApplicationObj()->MyMessage_Die($msgs,$info1,$info2,$info3,$info4,$info5);
    }

    //*
    //* function IsLogged, Parameter list: 
    //*
    //* Returns TRUE if we are logged on, false if not.
    //*

    function IsLogged()
    {
        $res=FALSE;
        if ($this->Profile()!="Public")
        {
            $res=TRUE;
        }
    }

    //*
    //* function IsAdmin, Parameter list: 
    //*
    //* Returns TRUE if we are admin, false if not.
    //*

    function IsAdmin()
    {
        $res=FALSE;
        if ($this->Profile()!="Admin")
        {
            $res=TRUE;
        }
    }


    //*
    //* function LoginData, Parameter list: $key=""
    //*
    //* Login acessor, using ApplicationObj.
    //*

    function LoginData($key="")
    {
        if (empty($key)) { return $this->ApplicationObj()->LoginData; }
        elseif (!empty($this->ApplicationObj()->LoginData[ $key ]))
        {
            return $this->ApplicationObj()->LoginData[ $key ];
        }

        return "";
    }

    //*
    //* function Profile, Parameter list: 
    //*
    //* Profile acessor, using ApplicationObj.
    //*

    function Profile()
    {
        $profile=$this->ApplicationObj()->Profile;

        if (empty($profile)) { $profile="Public"; }

        return $profile;
    }

    //*
    //* function Profiles, Parameter list: 
    //*
    //*

    function Profiles()
    {
        return $this->ApplicationObj()->Profiles;
    }

   //*
    //* Returns Logintyppe
    //*

    function LoginType()
    {
        $logintype=$this->ApplicationObj()->LoginType;

        if (empty($logintype)) { $logintype="Public"; }

        return $logintype;
    }


    //*
    //* function ModuleProfiles, Parameter list: $subkey=""
    //*
    //* Reads module profile file, if necesary.
    //*

    function ModuleProfiles($subkey1="",$subkey2="")
    {
        if (empty($this->ModuleProfiles))
        {
            $this->MyMod_Profiles_Read();
        }

        return $this->MyHash_HashHashes_Get($this->ModuleProfiles,$subkey1,$subkey2);
    }

    //*
    //* function Messages, Parameter list: $key="",$skey="Name"
    //*
    //* Dynamic read of module Messages.
    //*

    function Messages($key="",$skey="Name")
    {
        if (empty($this->Messages))
        {
            $this->MyMod_Language_Read();
        }

        if (!empty($key))
        {
            if (!empty($this->Messages[ $key ]))
            {
                return $this->GetRealNameKey($this->Messages[ $key ],$skey);
            }

            return $key;
        }

        return $this->Messages;
    }

    
    //*
    //* function Actions, Parameter list: $action="",$key="",$value=""
    //*
    //* Dynamic read of Actions. If $value defined, sets appropriate $action/$key.
    //*

    function Actions($action="",$key="",$value="")
    {
        if (empty($this->Actions))
        {
            $this->MyActions_Read();
        }

        if (!empty($value))
        {
            $this->MyHash_HashHashes_Set($this->Actions,$value,$action,$key);
        }

        return $this->MyHash_HashHashes_Get($this->Actions,$action,$key);
    }

    //*
    //* function ItemData, Parameter list: $action="",$key=""
    //*
    //* Dynamic read of ItemData.
    //*

    function ItemData($action="",$key="")
    {
        if (empty($this->ItemData))
        {
            $this->MyMod_Data_Read();
        }

        return $this->MyHash_HashHashes_Get($this->ItemData,$action,$key);
    }

    //*
    //* function ItemDataGroups, Parameter list: 
    //*
    //* Dynamic read of Groups.
    //*

    function ItemDataGroups($group="Basic",$key="",$value="")
    {
        if (empty($this->ItemDataGroups))
        {
            $this->MyMod_Data_Groups_Initialize();
        }

        return $this->MyHash_HashHashes_Get($this->ItemDataGroups,$group,$key);
    }

    //*
    //* function ItemDataSGroups, Parameter list: $force=FALS
    //*
    //* Dynamic read of SGroups.
    //*

    function ItemDataSGroups($group="Basic",$key="",$value="")
    {
        if (empty($this->ItemDataGroups))
        {
            $this->MyMod_Data_Groups_Initialize();
        }

        return $this->MyHash_HashHashes_Get($this->ItemDataSGroups,$group,$key);
    }

    
    //*
    //* function ,LatexData Parameter list: $action="",$key=""
    //*
    //* Dynamic read of ItemData.
    //*

    function LatexData($action="",$key="")
    {
        if (empty($this->LatexData))
        {
            $this->MyMod_Latex_Read();
        }

        return $this->MyHash_HashHashes_Get($this->LatexData,$action,$key);
    }

}

?>