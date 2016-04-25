<?php


class MySqlJoins extends MySqlSelect
{
    //*
    //* function MySqlJoinsObjects, Parameter list: fieldnames
    //*
    //* Returns list of objects for SqlObjects in fieldnames.
    //*
    //* 

    function MySqlJoinsObjects($fieldnames=array(),$objects=array())
    {
        if (!is_array($fieldnames)) { return $objects; }
        if (empty($this->ItemData)) { return $objects; }

        foreach ($fieldnames as $fieldname)
        {
            if (empty($this->ItemData[ $fieldname ])) { continue; }

            if (!empty($this->ItemData[ $fieldname ][ "SqlAccessor" ]))
            {
                $acessor=$this->ItemData[ $fieldname ][ "SqlAccessor" ];
                $objects[ $fieldname ]=$this->$acessor();
                $objects[ $fieldname ]->Parent=$this->ModuleName;

                foreach ($this->ItemData[ $fieldname ][ "SqlDerivedData" ] as $rdata)
                {
                    $key=$fieldname;
                    $key=$rdata;
                    if (!empty($objects[ $key ]->ItemData[ $rdata ][ "SqlAccessor" ]))
                    {
                        $objects=$objects[ $key ]->MySqlJoinsObjects
                        (
                           $this->ItemData[ $key ][ "SqlDerivedData" ],
                           $objects
                        );
                    }
                }
            }
        }

        return $objects;
    }

    //*
    //* function MySqlJoinsDataFields, Parameter list: $parent,$table,$fieldnames
    //*
    //* Returns list of fields in $fieldnames, that are actually fields in $table.
    //* Adds subobject data according to $this->ItemData.
    //*
    //* 

    function MySqlJoinsDataFields($parent,$table,$fieldnames=array())
    {
        if (!empty($parent)) { $parent.="."; }

        $fieldnames=$this->Sql_Table_Fields_Is($fields,$table);
        if (empty($this->ItemData)) { return $fieldnames; }

        $rfieldnames=$this->PreKeyHashValues($fieldnames,$parent);

        foreach ($this->MySqlJoinsObjects($fieldnames) as $fieldname => $object)
        {
            foreach ($this->ApplicationObj->SubModulesVars[ $object->ModuleName ][ "SqlDerivedData" ] as $data)
            {
                array_push
                (
                   $rfieldnames,
                   $object->ModuleName.'.'.$data." AS ".$fieldname."_".$data
                );
            }
        }

        return $rfieldnames;
    }

    //*
    //* function MySqlDataJoins, Parameter list: $parentmodulename,$table,$fieldnames
    //*
    //* Returns list of joins in $fieldnames, that are actually fields in $table. 
    //*
    //* 

    function MySqlDataJoins($parentmodulename,$table,$fieldnames=array())
    {
        $fieldnames=$this->Sql_Table_Fields_Is($fields,$table);

        $joins=array();

        //Prevent reapting including
        $rjoins=array($parentmodulename => 1);
        foreach ($this->MySqlJoinsObjects($fieldnames) as $fieldname => $object)
        {
            if (empty($rjoins[ $object->ModuleName ]))
            {
                array_push
                (
                   $joins,
                   "LEFT JOIN `".
                   $object->SqlTableName().
                   "` ".
                   $object->ModuleName." ".
                   "ON ".$object->Parent.".".$fieldname.
                   "=".
                   $object->ModuleName.".ID"
                );

                $rjoins[ $object->ModuleName ]=1;
            }
        }

        return $joins;
    }

     //*
    //* function MySqlJoinsWhereString, Parameter list: $table="",$string="",$fieldnames=array()
    //*
    //* Substitutes table refs, $fieldname to $this->ModuleName.$fieldname in $string.
    //* Supposedly where claouse or order string.
    //*
    //* 

    function MySqlJoinsSubstString($table="",$string="")
    {
        if (empty($this->ItemData))    { return $string; }
         if (empty($this->ModuleName)) { return $string; }

       $datas=array_keys($this->ItemData);
        sort($datas);
        $datas=array_reverse($datas);

        foreach ($datas as $data)
        {
            $string=preg_replace
            (
               '/\b'.$data.'\b/',
               $this->ModuleName.".".$data,
               $string
            );
        }

        return $string;
    }


   //*
    //* function MySqlJoinsSubstWhere, Parameter list: $table="",$where="",$fieldnames=array()
    //*
    //* Creates where string if $where array, if not calls strings subst MySqlJoinsSubstString.
    //*
    //* 

    function MySqlJoinsSubstWhere($table="",$where="",$fieldnames=array())
    {
        if (!empty($this->ModuleName))
        {
            if (is_array($where))
            {
                $where=$this->Hash2SqlWhere($where,$this->ModuleName.".");
            }
            elseif (!empty($this->ItemData))
            {
                $where=$this->MySqlJoinsSubstString($table,$where,$fieldnames);
             }
        }
        else
        {
            if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        }

        return $where;
    }
}

?>