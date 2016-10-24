<?php


trait Sql_Table_Structure_Update
{
    var $Sql_Table_Structure_Update_Force=FALSE;
    //*
    //* function Sql_Table_Structure_Update, Parameter list: 
    //*
    //* Updates structure of $table, satisfying $regexp. Take care!!
    //* 
    //* 

    function Sql_Table_Structure_Update($datas=array(),$datadefs=array(),$maycreate=TRUE,$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        if ($this->IsMain() && preg_match('/(Logs)$/',$table)) { return; }

        if (count($datadefs)==0){ $datadefs=$this->ItemData(); }
        if (count($datas)==0) {$datas=array_keys($datadefs); }

        $this->Sql_Table_Structure_Update_Prepare($maycreate,$table);

        //Retrieve table info
        $tableinfo=$this->Sql_Tables_Info_Get($table);

        $res=TRUE;
        $mtime=$this->MyMod_Data_Files_MTime();
        
        if (
            $mtime>$tableinfo[ "Time" ]
            ||
            $this->Sql_Table_Structure_Update_Force
           )
        {
           $msg=
               "Update Structure ".$this->ModuleName.": ".
               $this->SqlTableName($table).", ".
                $this->MyMod_Data_Files_MTime();

            $this->ApplicationObj()->AddPostMessage($msg);

            $res=$this->Sql_Table_Fields_Update($datas,$datadefs,$table);

            //Update table info with .
            if ($mtime>$tableinfo[ "Time" ])
            {
                $this->Sql_Tables_Info_Set($table,array("Time" => $mtime));
            }
        }

        return $res;
    }
    
    //*
    //* function Sql_Tables_Structure_Update, Parameter list: $regexp=""
    //*
    //* Updates structured of tables, conforming to $regexp. Take care!!
    //* 
    //* 

    function Sql_Tables_Structure_Update($regexp="",$where=array(),$datas=array())
    {
        if (empty($regexp)) { $regexp=$this->ModuleName.'$'; }
        
        $tables=$this->Sql_Table_Names($regexp);

        $items=array();
        foreach ($tables as $table)
        {
            $this->Sql_Table_Structure_Update(array(),array(),TRUE,$table);
        }
    }
    
    //*
    //* function Sql_Table_Structure_Update_Prepare, Parameter list: 
    //*
    //* Prepares structure of $table, creating empty table if allowed.
    //* 
    //* 

    function Sql_Table_Structure_Update_Prepare($maycreate=TRUE,$table="")
    {
        $this->ApplicationObj()->TablesColumns[ $table ]=array();
    
        if ($maycreate && !$this->Sql_Table_Exists($table))
        {
            $this->Sql_Table_Create($table);
            $this->Sql_Tables_Info_Set($table,array("Time" => 1));//something low, to force update. 0 wont do!
            
        }

        if (!$this->Sql_Table_Exists($table))
        {
            $this->DoDie
            (
               $this->ModuleName.": Cannot create SQL table: '".$this->SqlTableName($table)."'",
               $maycreate,
               $this->ApplicationObj()->DBHash
            );
        }
    }
    

}
?>