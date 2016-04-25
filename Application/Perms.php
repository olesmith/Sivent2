<?php


class Perms extends TInterface
{
    /* var $Permissions=array(); */
    /* var $PermissionVars=array(); */
    /* var $LoginPermissionVars=array(); */

    /* //\* */
    /* //\* function ReadPermissions, Parameter list:  */
    /* //\* */
    /* //\* Reads permissions for current user, if logintype is Person. */
    /* //\* */

    /* function ReadPermissions() */
    /* { */
    /*     if (!$this->MySqlIsTable("Permissions")) { return; } */
    /*     if ( */
    /*           $this->LoginType=="Public" */
    /*           || */
    /*           $this->LoginType=="Admin" */
    /*           || */
    /*           count($this->Permissions)>0 */
    /*        ) */
    /*     { */
    /*         return; */
    /*     } */

    /*     if ($this->LoginType!="Public") */
    /*     { */
    /*         $perms=$this->SelectHashesFromTable */
    /*         ( */
    /*            "Permissions", */
    /*            "LoginID='".$this->LoginID."'" */
    /*         ); */

    /*         if (count($perms)==0) */
    /*         { */
    /*             $default=array */
    /*             ( */
    /*                "LoginID" => $this->LoginID, */
    /*                "Type" => 4, */
    /*                "CTime" => time(), */
    /*                "ATime" => time(), */
    /*                "MTime" => time(), */
    /*             ); */

    /*             //Take IDs from LoginData (permission specific) */
    /*             foreach ($this->LoginPermissionVars as $src => $dest) */
    /*             { */
    /*                 if (!isset($this->LoginData[ $src ])) */
    /*                 { */
    /*                     $this->LoginData[ $src ]=$this->MySqlItemValue */
    /*                     ( */
    /*                        $this->AuthHash[ "Table" ], */
    /*                        "ID", */
    /*                        $this->LoginData[ "ID" ], */
    /*                        $src */
    /*                     ); */
    /*                 } */
    /*                 $default[ $dest ]=$this->LoginData[ $src ]; */
    /*             } */

    /*             $this->MySqlInsertItem("Permissions",$default); */
    /*             $perms=array($default); */
    /*         } */

    /*         $vars=$this->PermissionVars[ "Vars" ]; */
    /*         foreach ($perms as $pid => $perm) */
    /*         { */
    /*             $rperm=array("Type" => $perm[ "Type" ]); */
    /*             foreach ($vars as $vid => $var) */
    /*             { */
    /*                 if ($var!="" && isset($perm[ $var ])) */
    /*                 { */
    /*                     $rperm[ $var ]=$perm[ $var ]; */
    /*                 } */
    /*             } */

    /*             $this->Permissions[ $pid ]=$rperm; */
    /*         } */
    /*     } */

    /* } */


    //*
    //* function SetModulePermsSqlWhere, Parameter list: $module,$object
    //*
    //* If logintype is Person, returns and sets sqlwhere to preaccess
    //* all dbs. Otherwise returns empty string.
    //* Value obtained is stored in $this->SqlWhere,
    //* as well as in $object->SqlWhere, supposedly the subobject.
    //*

    function SetModulePermsSqlWhere($module,$object)
    {
        if ($this->LoginType!="Person")
        {
            return;
        }

        if ($module=="") { $module=$this->ModuleName; }

        if (empty($this->PermissionVars[ $module ][ $this->Profile ])) { return; }
        if (!is_array($this->PermissionVars[ $module ][ $this->Profile ])) { return; }
        $permvars=$this->PermissionVars[ $module ][ $this->Profile ];

        $wheres=array();
        foreach ($this->Permissions as $pid => $perm)
        {
            $rwheres=array();

            foreach ($perm as $key => $value)
            {
                if ($value>0)
                {
                    if (isset($permvars[ $key ]))
                    {
                        array_push($rwheres,$permvars[ $key ]."='".$value."'");
                    }
                }

            }

            foreach ($permvars as $vid => $rperm)
            {
                if (isset($this->LoginData[ $vid ]))
                {
                    array_push($rwheres,$rperm."='".$this->LoginData[ $vid ]."'");
                }
                else
                {
                    $method=$rperm;
                    if (method_exists($object,$method))
                    {
                        array_push($rwheres,$object->$method());
                    }
                    elseif (!isset($object->ItemData[ $rperm ]))
                    {
                        print
                            $object->ModuleName." - ".$module.
                            ", Perms, $pid/$vid: Access data/method '$method' ($rperm) does not exist";
                        //var_dump($permvars);
                        //var_dump(array_keys($object->ItemData));
                        exit();
                    }
                }
            }

            $rwhere=join(" AND ",$rwheres);
            if (count($rwheres)>1)
            {
                $rwhere="(".$rwhere.")";
            }

            if ($rwhere!="")
            {
                array_push($wheres,$rwhere);
            }
        }

        $object->SqlWhere=join(" OR ",$wheres);
        return $object->SqlWhere;
    }
}

?>