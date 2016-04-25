<?php


class MySqlTable extends MySqlJoins
{
    //*
    //* function SqlTableName, Parameter list: $table=""
    //*
    //* Returns fully qualified and filtered name of table.
    //* Uses default value if $table is not given.
    //*

    function SqlTableName($table="")
    {
        $module=$this->ModuleName;

        if ($table=="") { $table=$this->SqlTable; }
        if ($table=="" && isset($this->DBHash[ "Table" ])) { $table=$this->DBHash[ "Table" ]; }

        foreach ($this->SqlTableVars as $id => $key)
        {
            if (isset($this->$key))
            {
                $value=$this->$key;
                if (is_array($value))
                {
                    foreach ($this->$key as $rkey => $rvalue)
                    {
                        if (!is_array($rvalue))
                        {
                            $table=preg_replace('/#'.$rkey.'/',$rvalue,$table);
                        }
                    }
                }
                else
                {
                    $table=preg_replace('/#'.$key.'/',$value,$table);
                }
            }
        }
        
        $table=preg_replace('/\./',"_",$table);
        $table=preg_replace('/#Module/',$module,$table);

        return $table;
    }





    /* //\* */
    /* //\* function MySqlIsTable, Parameter list: $table="" */
    /* //\* */
    /* //\* Checks whether table $table exists. */
    /* //\* */
    /* //\*  */

    /* function MySqlIsTable($table="") */
    /* { */
    /*     return $this->Sql_Table_Exists($table); */
    /* } */

    /* //\* */
    /* //\* function CreateTable, Parameter list: $table="" */
    /* //\* */
    /* //\* Creates Table according to SQL specification in $vars, */
    /* //\* if it does not exist already. */
    /* //\* */
    /* //\*  */

    /* function CreateTable($table="") */
    /* { */
    /*     $this->Sql_Table_Create($table); */
    /* } */

    /* //\* */
    /* //\* function CreateTableWithVars, Parameter list: $table,$vars */
    /* //\* */
    /* //\* Creates Table, according to SQL specification in $vars, */
    /* //\* if it does not exist already. */
    /* //\* */
    /* //\*  */

    /* function CreateTableWithVars_removeme($table,$vars) */
    /* { */
    /*     if ($table=="") { return; } */

    /*     $table=$this->SqlTableName($table); */
    /*     $tablenames=$this->Sql_Table_Names($table); */
    /*     $rtables=preg_grep("/^$table$/",$tablenames); */

    /*     if (count($rtables)>0) */
    /*     { */
    /*         $this->AddMsg("Table $table already exists"); */
    /*         return; */
    /*     } */

    /*     $query="CREATE TABLE $table ("; */
    /*     $first=0; */
    /*     foreach ($vars as $key => $sqltype) */
    /*     { */
    /*         if (preg_match('/^FILE$/',$sqltype)) { $sqltype="VARCHAR(255)"; } */
        
    /*         if (preg_match('/^ENUM/',$sqltype)) */
    /*         { */
    /*             $sqltype=$this->Sql_Table_Field_Enum_Spec($sqltype); */
    /*         } */

    /*         if ($first!=0) { $query.=","; } */
    /*         $query.=" $key $sqltype"; */
    /*         $first=1; */
    /*     } */
    /*     $query.=");"; */
    
    /*     $this->QueryDB($query); */
    /* } */

/* //\* */
/* //\* function DropTable, Parameter list: $table */
/* //\* */
/* //\* Simply drops the table. */
/* //\* */
/* //\*  */

/* function DropTable($table) */
/* { */
/*     if ($table=="") { return; } */
/*     $tablenames=$this->Sql_Table_Names($table); */
/*     $rtables=preg_grep('/^'.$table.'$/',$tablenames); */

/*     if (count($rtables)>0) */
/*     { */
/*         $query="DROP TABLE $table"; */
/*         $this->QueryDB($query); */
/*         $this->AddMsg("Table $table dropped"); */
/*     } */
/* } */

/* */

/* //\* */
/* //\* function TableHashField, Parameter list: $table */
/* //\* */
/* //\* Returns names of the data fields in table $table in current DB, as a list. */
/* //\*  */
/* //\*  */

/* function TableHashField($table,$field) */
/* { */

/*     $table=$this->SqlTableName($table); */
/*     $fields=$this->GetDBTableFieldNames($table); */
/*     if (preg_grep('/^'.$field.'$/',$fields)) */
/*     { */
/*         return TRUE; */
/*     } */

/*     return FALSE; */
/* } */


/* //\* */
/* //\* function GetDBTableFieldNames, Parameter list: $table */
/* //\* */
/* //\* Returns names of the data fields in table $table in current DB, as a list. */
/* //\*  */
/* //\*  */

/* function GetDBTableFieldNames($table) */
/* { */
/*     if (empty($table)) { $table=$this->SqlTableName($table); } */
    
/*     if ($table=="") { return array(); } */

/*     $result = $this->QueryDB("SHOW COLUMNS FROM `".$table."` # GetDBTableFieldNames"); */

/*     $count=$this->MySqlFetchNumRows($result); */

/*     $fieldnames=array(); */

/*     $m=0; */
/*     while ($row=$this->MySqlFetchAssoc($result)) */
/*     { */
/*         $fieldnames[$m]=$row[ "Field" ]; */
/*         $m++; */
/*     }   */

/*     $this->DB_FreeResult($result); */

/*     return $fieldnames; */
/* } */



//*
//* function GetDBTableNames, Parameter list:$regexp=""
//*
//* Returns list with the names of the Tables in current database.
//* If $regexp given, applies it to list returned.
//* 
//* 

/* function GetDBTableNames($regexp="") */
/* { */
/*     return $this->Sql_Table_Names($regexp); */
    
/*     $query=$this->Sql_Table_Names_Query(); */
/*     $result = $this->QueryDB($query); */

/*     $names=array(); */
/*     $m=0; */
/*     while ($row=$this->MySqlFetchAssoc($result)) */
/*     { */
/*         foreach ($row as $key => $value) */
/* 	    { */
/*             $table=$value; */
/*         } */

/*         $names[$m]=$value; */
/*         $m++; */
/*     } */

/*     $this->DB_FreeResult($result); */

/*     if ($regexp) */
/*     { */
/*         $names=preg_grep('/'.$regexp.'/',$names); */
/*     } */

/*     return $names; */
/* } */

/* //\* */
/* //\* function SqlDataFields, Parameter list: $table,$fieldnames=array() */
/* //\* */
/* //\* Returns list of fields in $fieldnames, that are actually fields in $table.  */
/* //\* */
/* //\*  */

/* function SqlDataFields($table,$fieldnames=array()) */
/* { */
/*     $sqldata=$this->GetDBTableFieldNames($table); */

/*     $rfieldnames="*"; */
/*     if (is_array($fieldnames) && count($fieldnames)>0) */
/*     { */
/*         $done=array();; */
/*         $rfieldnames=array(); */
/*         foreach ($fieldnames as $data) */
/*         { */
/*             if (!empty($done[ $data ])) { continue; } */

/*             if (preg_grep('/^'.$data.'$/',$sqldata)) */
/*             { */
/*                 array_push($rfieldnames,$data); */
/*                 $done[ $data ]=1; */
/*             } */
/*         } */

/*         $rfieldnames=preg_grep('/^No$/',$rfieldnames,PREG_GREP_INVERT); */
/*     } */
/*     elseif (isset($this->ItemData)) */
/*     { */
/*         $rfieldnames=$sqldata; */
/*     } */

/*     if (is_array($rfieldnames) && !preg_grep('/^ID$/',$rfieldnames,PREG_GREP_INVERT)) */
/*     { */
/*         array_push($rfieldnames,"ID"); */
/*     } */


/*     return $rfieldnames; */
/* } */


}

?>