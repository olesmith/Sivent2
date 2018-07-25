<?php

class ModPerms extends SubModules
{
    //*
    //* function HandleModPerms, Parameter list: 
    //*
    //* Handles interface for viewing modules and permissions.
    //*
    //* 

    function HandleModPerms()
    {
        $this->FriendsObj()->MyMod_Handle_DocHeads();

        $this->ModulesTable();

        $module=$this->GetGET("Module");

        if (!empty($module))
        {
            $this->ModuleTable($module);
        }
    }


    //*
    //* function ModulesTable, Parameter list: 
    //*
    //* Gewnerates table with modules and profiles.
    //*
    //* 

    function ModulesTable()
    {
        $profiles=array_keys($this->Profiles);
        array_push($profiles,"Person");

        $others=FALSE;
        $maxlen=0;

        $table=array();
        foreach ($this->AllowedModules as $module)
        {
            $row=array
            (
               $this->Href("?Action=ModPerms&Module=".$module,$module)
            );

            $pfile=$this->MyMod_Setup_Profiles_File($module);

            $pfile=$this->ReadPHPArray($pfile);
            $rprofiles=array();
            foreach ($profiles as $profile)
            {
                $access="-";
                if (!empty($pfile[ "Access" ][ $profile ]))
                {
                    $access=$pfile[ "Access" ][ $profile ];
                }

                $rprofiles[ $profile ]=1;
                array_push($row,$access);
            }

            foreach ($pfile[ "Access" ] as $profile => $access)
            {
                if (empty($rprofiles[ $profile ]))
                {
                    array_push($row,$profile." ".$access);
                    $others=TRUE;
                }
            }

            $maxlen=$this->Max($maxlen,count($row));
            array_push($table,$row);
        }

        $titles=array("Module");
        foreach ($profiles as $profile)
        {
            $name="";
            if ($profile=="Person") { $name="Person"; }
            else                    { $name=$this->Profiles[ $profile ][ "Name" ]; }
            array_push($titles,$name);
        }

        if ($others)
        {
            array_push($titles,$this->MultiCell("Others",$maxlen-count($titles)));
        }
        
        
        echo
            $this->H(2,"Modules & Permissions").
            $this->Html_Table
            (
               $titles,
               $table
            ).
            "";
    }

    //*
    //* function ModuleInfoTable, Parameter list: $module
    //*
    //* Generates $module info table.
    //*
    //* 

    function ModuleInfoTable($module)
    {
        $class=$this->SubModulesVars[ $module ][ "SqlClass" ];
        $object=$this->SubModulesVars[ $module ][ "SqlObject" ];
        $this->ModuleLoad($class);

        $accessor=preg_replace('/Object$/',"Obj",$class);

        $acc="No";
        if (method_exists($this,$accessor)) { $acc="Yes"; }
        $macc="No";
        if (method_exists($this->$object,$accessor)) { $macc="Yes"; }


        echo
            $this->H(3,"Module: ".$module).
            $this->HtmlTable
            (
               "",
               array
               (
                  array
                  (
                     $this->B("Object class:"),$class,
                  ),
                  array
                  (
                     $this->B("Object name:"),$object,
                  ),
                  array
                  (
                     $this->B($accessor. " exists:"),$acc,
                  ),
                  array
                  (
                     $this->B("Module ".$accessor. " exists:"),$macc,
                  ),
                )
            ).
            "";
    }

    //*
    //* function ModuleDataPermsTable, Parameter list: $object
    //*
    //* Generates table with modules and profiles.
    //*
    //* 

    function ModuleDataPermsTable($object)
    {
        $profiles=array_keys($this->Profiles);
        array_push($profiles,"Person");

        $datas=array_keys($object->ItemData);
        sort($datas);


        $table=array();
        foreach ($datas as $data)
        {
            $row=array($this->B($data),$object->ItemData[ $data ][ "Sql" ]);

            foreach ($profiles as $profile)
            {
                $access="-";
                if (!empty($object->ItemData[ $data ][ $profile ]))
                {
                    $access=$object->ItemData[ $data ][ $profile ];
                }

                array_push($row,$access);
            }

            array_push($table,$row);
        }

        $titles=array("Data","SQL");
        foreach ($profiles as $profile)
        {
            $name="";
            if ($profile=="Person") { $name="Person"; }
            else                    { $name=$this->Profiles[ $profile ][ "Name" ]; }
            array_push($titles,$name);
        }
        
        
         echo
            $this->H(3,"Data Permissions: ".$object->ModuleName).
            $this->HtmlTable
            (
               $titles,
               $table
            ).
            "";
    }
    //*
    //* function ModuleTable, Parameter list: $module
    //*
    //* Generates table with modules and profiles.
    //*
    //* 

    function ModuleTable($module)
    {
        $class=$this->SubModulesVars[ $module ][ "SqlClass" ];
        $object=$this->SubModulesVars[ $module ][ "SqlObject" ];

        $accessor=$class."Obj";
        $object=$this->$accessor();

        //$this->ModuleLoad($class);
        $this->ModuleInfoTable($module);
        $this->ModuleDataPermsTable($object);

        $profiles=array_keys($this->Profiles);
        array_push($profiles,"Person");

        $object->InitActions();

        $table=array();

        $datas=array_keys($object->Actions);
        sort($datas);

        foreach ($datas as $data)
        {
            $row=array($this->B($data));

            foreach ($profiles as $profile)
            {
                $access="-";
                if (!empty($object->Actions[ $data ][ $profile ]))
                {
                    $access=$object->Actions[ $data ][ $profile ];
                }

                array_push($row,$access);
            }

            array_push($table,$row);
        }

        $titles=array("Action");
        foreach ($profiles as $profile)
        {
            $name="";
            if ($profile=="Person") { $name="Person"; }
            else                    { $name=$this->Profiles[ $profile ][ "Name" ]; }
            array_push($titles,$name);
        }
        
        
         echo
            $this->H(3,"Action Permissions: ".$module).
            $this->HtmlTable
            (
               $titles,
               $table
            ).
            "";
    }

}

?>