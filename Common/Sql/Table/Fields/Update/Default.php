<?php

trait Sql_Table_Fields_Update_Default
{
    //*
    //* function Sql_Table_Field_Default_Set_Query, Parameter list: $data,$datadef,$table=""
    //*
    //* Adds column $data to $table.
    //* 

    function Sql_Table_Field_Default_Set_Query($data,$value,$table="")
    {
        /* $type=$this->DB_Dialect(); */
        
        /* $query=""; */
        /* if ($type=="mysql") */
        /* { */
        /*     $query= */
        /*         "ALTER TABLE ". */
        /*         $this->Sql_Table_Name_Qualify($table). */
        /*         " CHANGE ". */
        /*         $this->Sql_Table_Column_Name_Qualify($data). */
        /*         " ". */
        /*         $this->Sql_Table_Column_Name_Qualify($data). */
        /*         " ". */
        /*         $datadef[ "Sql" ]; */
        /* } */
        /* elseif ($type=="pgsql") */
        /* { */
        /*     $query= */
        /*         "ALTER TABLE ". */
        /*         $this->Sql_Table_Name_Qualify($table). */
        /*         " ALTER COLUMN ". */
        /*         $this->Sql_Table_Column_Name_Qualify($data). */
        /*         " SET DEFAULT ". */
        /*         $this->Sql_Table_Column_Value_Qualify($value); */
        /* } */

            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " ALTER COLUMN ".
                $this->Sql_Table_Column_Name_Qualify($data).
                " SET DEFAULT ".
                $this->Sql_Table_Column_Value_Qualify($value);
        return $query;
    }
    
    //*
    //* function Sql_Table_Field_Default_Set, Parameter list: $data,$value,$table=""
    //*
    //* Sets column default to $value.
    //* 

    function Sql_Table_Field_Default_Set($data,$value,$table="")
    {        
        //if (empty($value) || $value=="0 ")    { return; }

        $query=
            $this->Sql_Table_Field_Default_Set_Query($data,$value,$table);
        
        $this->QueryDB($query);

        $msg=
            $query."<BR>".
            "Alter ".$table.": ".$data." default => ".$value;
      
        $this->ApplicationObj()->AddPostMessage($msg,1,TRUE);
        $this->ApplicationObj->LogMessage(5,$msg);  
    }
}


?>