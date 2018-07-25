<?php


class Perms extends Help
{
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