<?php

trait Sql_Table_Fields_Update_Length
{
    //*
    //* function Sql_Table_Field_Length_Alter_Query, Parameter list: $data,$datadef,$table=""
    //*
    //* Adds column $data to $table.
    //* 

    function Sql_Table_Field_Length_Alter_Query($data,$datadef,$table="")
    {
        $type=$this->DB_Dialect();
        
        $query="";
        if ($type=="mysql")
        {
            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " CHANGE ".
                $this->Sql_Table_Column_Name_Qualify($data).
                " ".
                $this->Sql_Table_Column_Name_Qualify($data).
                " ".
                $datadef[ "Sql" ];
        }
        elseif ($type=="pgsql")
        {
            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " ALTER COLUMN ".
                $this->Sql_Table_Column_Name_Qualify($data).
                " TYPE ".
                $datadef[ "Sql" ];
        }

        return $query;
    }
    
    //*
    //* function Sql_Table_Field_Length_Alter, Parameter list: $data,$datadef,$table=""
    //*
    //* Adds column $data to $table.
    //* 

    function Sql_Table_Field_Length_Alter($data,$datadef,$table="")
    {
        $query=$this->Sql_Table_Field_Length_Alter_Query($data,$datadef,$table);
        $res=$this->QueryDB($query);

        $msg=
            $query."<BR>".
            "Alter ".$table.": ".$data." length => ".$datadef[ "Sql" ];
      
        $this->ApplicationObj()->AddPostMessage($msg,1,TRUE);
        $this->ApplicationObj->LogMessage(5,$msg);

        return $res;
 
    }
    
    
}


?>