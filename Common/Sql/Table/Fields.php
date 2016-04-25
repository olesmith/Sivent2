<?php

include_once("Fields/Exists.php");
include_once("Fields/Enum.php");
include_once("Fields/File.php");
include_once("Fields/Add.php");
include_once("Fields/Update.php");

trait Sql_Table_Fields
{
    use
        Sql_Table_Fields_Exists,
        Sql_Table_Fields_Enum,
        Sql_Table_Fields_File,
        Sql_Table_Fields_Add,
        Sql_Table_Fields_Update;
   
    //var $TableFields=array();
  
    //*
    //* function Sql_Table_Fields_Matrix, Parameter list: $datalist,$wherespec,$table=""
    //*
    //* Returns matrix of the data fields in table $table in current DB, as a list.
    //* 
    //* 

    function Sql_Table_Fields_Matrix($datalist,$wherespec,$table="")
    {
        $table=$this->SqlTableName($table);
        
        $items=array();
        if (! preg_match("/\S/",$table)) { return $items; }

        if (preg_match("/\S/",$where))
        {
            $where=" WHERE ".$where; 
        }

        
        $data="*";
        if (count($datalist)>0) { $data=$this->Sql_Table_Column_Names_Qualify($datalist); }

        $query=
            "SELECT ".
            $data.
            " FROM ".
            $this->Sql_Table_Name_Qualify($table).
            $where;
        
        $result=$this->DB_Query($query);

        $res=$this->DB_Fetch_Assoc_List($result);

        $this->DB_FreeResult($result);

        return $res;

    }

    
    //*
    //* function Sql_Table_Fields_Show, Parameter list: $wherespec,$datalist,$table=""
    //*
    //* Returns html table of the data fields in table $table in current DB, as a list.
    //* 
    //* 

    function Sql_Table_Fields_Show($wherespec,$datalist,$table="")
    {
        if (count($datalist)==0) { $datalist=$this->Sql_Table_Fields_Get($table); }

        echo $this->HTML_Table
        (
           $datalist,
           $this->Sql_Table_Fields_Matrix($datalist,$wherespec,$table)
        );
    }
    //*
    //* function Sql_Table_Fields_Is, Parameter list: $fieldnames=array(),$table=""
    //*
    //* Returns list of fields in $fieldnames, that are actually fields in $table. 
    //*
    //* 

    function Sql_Table_Fields_Is($fieldnames=array(),$table="")
    {
        $sqldata=$this->Sql_Table_Structure_Columns_Get($table);

        $rfieldnames="*";
        if (is_array($fieldnames) && count($fieldnames)>0)
        {
            $done=array();;
            $rfieldnames=array();
            foreach ($fieldnames as $data)
            {
                if (!empty($done[ $data ])) { continue; }

                if (preg_grep('/^'.$data.'$/',$sqldata))
                {
                    array_push($rfieldnames,$data);
                    $done[ $data ]=1;
                }
            }

            $rfieldnames=preg_grep('/^No$/',$rfieldnames,PREG_GREP_INVERT);
        }
        elseif (isset($this->ItemData))
        {
            $rfieldnames=$sqldata;
        }

        if (is_array($rfieldnames) && !preg_grep('/^ID$/',$rfieldnames,PREG_GREP_INVERT))
        {
            array_push($rfieldnames,"ID");
        }

        return $rfieldnames;
    }
}


?>