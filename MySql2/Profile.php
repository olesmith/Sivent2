<?php

include_once("Profile/Init.php");

class Profile extends ProfileInit
{
    var $Profile="";
    var $ProfileHash=array();

    var $ModuleMenues=array("Singular","Plural","SingularPlural","ActionsPlural");//,"ActionsSingular");
    var $DefaultMenues=array
    (
       "Singular"        => array(),
       "Plural"          => array(),
       "SingularPlural"  => array(),
       "ActionsPlural"   => array(),
       "ActionsSingular" => array(),
    );

    var $PermColors=array("red","green","blue");
   

    //*
    //* function GetListOfProfiles, Parameter list:
    //*
    //* Returns list of Profiles.
    //*

    function GetListOfProfiles()
    {
        return $this->ApplicationObj->GetListOfProfiles();
    }

    //*
    //* function ShowPermission, Parameter list: $val
    //*
    //* Colors $val, according to $this->PermColors.
    //*

    function ShowPermission($val)
    {
        $rval="";
            if ($val==0) { $rval="No"; }
        elseif ($val==1) { $rval="Yes"; }
        elseif ($val==2) { $rval="Exe"; }
        else             { $rval=$val."??"; }

        return $rval;
    }



    //*
    //* function AccessTable, Parameter list: $racsesses
    //*
    //* Returns table with Module Acesses.
    //*

    function AccessTable($raccesses)
    {
        $table=array();
        array_push($table,array($this->H(3,"Module Access: ".$this->ModuleName)));

        foreach ($this->GetListOfProfiles() as $profile)
        {
            $val=0;
            if (!empty($raccesses[ $profile ]))
            {
                $val=$raccesses[ $profile ];
            }

            array_push
            (
               $table,
               array
               (
                  $this->B($profile.":"),
                  $this->ShowPermission($val)
               )
            );
        }

        return $table;
    }

    //*
    //* function ActionsTable, Parameter list: $ractions
    //*
    //* Returns table with Module Actions and access.
    //*

    function ActionsTable($ractions)
    {
        $table=array();
        array_push($table,array($this->H(3,"Module Actions")));

        $row=array("","");
        foreach ($this->GetListOfProfiles() as $profile)
        {
            array_push($row,$this->B($profile));
        }
        array_push($table,$row);

        $actions=array_keys($ractions);
        $actions=array_reverse($actions);
        foreach ($actions as $action)
        {
            $name="";
            if (!empty($this->Actions[ $action ][ "Name" ]))
            {
                $name=$this->Actions[ $action ][ "Name" ];
            }
            $row=array($this->B($action),$name);
            foreach ($this->GetListOfProfiles() as $profile)
            {
                $val=0;
                if (!empty($ractions[ $action ][ $profile ]))
                {
                    $val=$ractions[ $action ][ $profile ];
                }

                array_push
                (
                   $row,
                   $this->ShowPermission($val)
                );
            }

            array_push($table,$row);
        }

        return $table;
    }


    //*
    //* function MenuesTable, Parameter list: $rmenus
    //*
    //* Returns table with Module Menues.
    //*

    function MenuesTable($rmenus)
    {
        $table=array();
        array_push($table,array($this->H(3,"Module Menues")));

        $row=array("");
        foreach ($this->ModuleMenues as $menu)
        {
            array_push($row,$this->B($menu));
        }
        array_push($table,$row);

        foreach ($this->GetListOfProfiles() as $profile)
        {
            $row=array($this->B($profile).":");

            $cell=array();
            foreach ($this->ModuleMenues as $menu)
            {
                $cell=array();
                if (empty($rmenus[ $menu ][ $profile ]))
                {
                    $rmenus[ $menu ][ $profile ]=array();
                }

                foreach ($rmenus[ $menu ][ $profile ] as $action => $value)
                {
                    if ($value>0)
                    {
                        array_push($cell,$action);
                    }
                }

                array_push($row,join("<BR>",$cell));
            }
           

            array_push($table,$row);
        }

        return $table;
    }

    //*
    //* function ItemDatasTable, Parameter list: 
    //*
    //* Returns table with Module ItemData acesses and some more.
    //*

    function ItemDatasTable()
    {
        $table=array();

        array_push($table,array($this->H(3,"Module Data")));
        $row=array("");
        foreach ($this->GetListOfProfiles() as $profile)
        {
            array_push($row,$this->B($profile));
        }


        foreach (array("Search","Default","Compulsory") as $key)
        {
            array_push($row,$this->B($key));
        }
        array_push($table,$row);

        foreach ($this->ItemData as $data => $def)
        {
            if (preg_match('/[AMC]Time/',$data)) { continue; }

            $row=array($this->B($data.":"));
            foreach ($this->GetListOfProfiles() as $profile)
            {
                if (isset($this->ItemData[ $data ][ $profile ]))
                {
                    array_push
                    (
                       $row,
                       $this->ShowPermission($this->ItemData[ $data ][ $profile ])
                    );
                }
                else
                {
                    array_push($row,"undef");
                }
            }

            foreach (array("Search","Default","Compulsory") as $key)
            {
                 array_push($row,$this->ItemData[ $data ][ $key ]);
            }
            
            array_push($table,$row);
        }

        return $table;
    }




    /* //\* */
    /* //\* function ReadModuleProfiles, Parameter list: */
    /* //\* */
    /* //\* Reads all profiles for module. */
    /* //\* */

    /* function ReadModuleProfiles() */
    /* { */
    /*     $file=$this->ApplicationObj->MyMod_Setup_Profiles_File(); */
    /*     if (!file_exists($file)) */
    /*     { */
    /*         print "No Module Profile file: ".$file."<BR>\n"; */
    /*         exit(); */
    /*     } */


    /*     $this->ModuleProfiles=$this->ReadPHPArray($file); */
    /* } */

    //*
    //* function UpdateProfilesActions, Parameter list:
    //*
    //* Does updating.
    //*

    function UpdateProfilesActions()
    {
        //Detect unspecified Module actions, ie: Actions that are Modular, but not system!
        $undefactions=array();
        $moduleactions=array();
        foreach ($this->Actions as $action => $actiondef)
        {
            if (!isset($this->ApplicationObj->Actions[ $action ]))
            {
                if (!isset($this->ModuleProfiles[ "Actions" ][ $action ]))
                {
                    array_push($undefactions,$action);
                }

                array_push($moduleactions,$action);
            }
        }

        //Create unspecified Module actions
        foreach ($undefactions as $action)
        {
            $this->ModuleProfiles[ "Actions" ][ $action ]=array();
        }

        //Now check if all profiles are defined, for all actions.
        //Missing to be created with value 0.
        foreach ($moduleactions as $action)
        {
            foreach ($this->GetListOfProfiles() as $profile)
            {
                if (!isset($this->ModuleProfiles[ "Actions" ][ $action ][ $profile ]))
                {
                    $this->ModuleProfiles[ "Actions" ][ $action ][ $profile ]=0;
                }
            }
        }
    }


    //*
    //* function UpdateProfilesAccess, Parameter list:
    //*
    //* Does updating.
    //*

    function UpdateProfilesAccess()
    {
        //Detect unspecified profiles Accesses
        foreach ($this->GetListOfProfiles() as $profile)
        {
            if (!isset($this->ModuleProfiles[ "Access" ][ $profile ]))
            {
                $this->ModuleProfiles[ "Access" ][ $profile ]=0;
            }
        }
    }

    //*
    //* function UpdateProfilesActions, Parameter list:
    //*
    //* Does updating.
    //*

    function UpdateProfilesMenues()
    {
        //Detect unspecified Module Horisontal Menues
        foreach ($this->HorisontalMenues as $menu)
        {
            if (!isset($this->ModuleProfiles[ "Menues" ][ $menu ]))
            {
                $this->ModuleProfiles[ "Menues" ][ $menu ]=array();
            }

            foreach ($this->GetListOfProfiles() as $profile)
            {
                if (!isset($this->ModuleProfiles[ "Menues" ][ $menu ][ $profile ]))
                {
                    $this->ModuleProfiles[ "Menues" ][ $menu ][ $profile ]=array();
                }
            }
        }
    }

    //*
    //* function UpdateItemData, Parameter list:
    //*
    //* Does updating.
    //*

    function UpdateItemData()
    {

        $ritemdata=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if (preg_match('/[AMC]/',$data)) { continue; }

            foreach ($this->GetListOfProfiles() as $profile)
            {
                if (!isset($this->ItemData[ $data ][ $profile ]))
                {
                    $this->ItemData[ $data ][ $profile ]=0;
                }
            }

            $ritemdata[ $data ]=$this->ItemData[ $data ];
        }

        if (isset($this->DBHash[ "Mod" ]) && $this->DBHash[ "Mod" ])
        {
            $file="System/".$this->ModuleName."/Data.php";
            $this->WritePHPArray($file,$ritemdata);

            print $this->H(4,"ItemData defs written to ".$file);
        }
    }

    //*
    //* function UpdateProfiles, Parameter list:
    //*
    //* Does updating.
    //*

    function UpdateProfiles()
    {
        $this->UpdateProfilesActions();
        $this->UpdateProfilesMenues();
        $this->UpdateProfilesAccess();
        //$this->UpdateItemData();

        if (isset($this->DBHash[ "Mod" ]) && $this->DBHash[ "Mod" ])
        {
            $file=$this->ApplicationObj->MyMod_Setup_Profiles_File();
            $this->WritePHPArray($file,$this->ModuleProfiles);

            print $this->H(4,"Profiles written to ".$file);
        }
    }



    //*
    //* function HandleProfiles, Parameter list:
    //*
    //* Show Profile Access, Action Acesses and Hor. menues.
    //*

    function HandleProfiles()
    {
        $this->MyMod_Profiles_Read();
        if ($this->GetPOST("Update")=='on')
        {
            $this->UpdateProfiles();
        }


        $formtable="";
        if (isset($this->DBHash[ "Mod" ]) && $this->DBHash[ "Mod" ])
        {
            $formtable=
                $this->StartForm().
                $this->H
                (
                   5,
                   "Certeza? Marque e Clique: ".
                   $this->MakeCheckBox("Update").
                   $this->Button("submit","Atualizar")
                ).
                $this->EndForm();
        }

        $this->SystemMenu();


        print
            $this->H(2,"Module Permissions Overview").
            $this->HtmlTable
            (
               "",
               array
               (
                  array($formtable),
                  array
                  (
                     $this->HtmlTable("",$this->AccessTable($this->ModuleProfiles[ "Access" ])),
                     $this->HtmlTable("",$this->MenuesTable($this->ModuleProfiles[ "Menues" ])),
                  ),
                  array
                  (
                     $this->HtmlTable("",$this->ActionsTable($this->ModuleProfiles[ "Actions" ])),
                      $this->HtmlTable("",$this->ItemDatasTable()),
                  ),
               )
            );
    }
}
?>