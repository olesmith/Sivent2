<?php


trait Sql_Select_Hash
{
    //*
    //* function Sql_Select_Hash_Query, Parameter list: $where,$sqldata=array(),$noecho=FALSE,$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $filednames is not an array.. 
    //*
    //* 

    function Sql_Select_Hash_Query($where,$sqldata=array(),$noecho=FALSE,$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($sqldata)) { $sqldata=array_keys($this->ItemData); }

        return $this->Sql_Select_Hashes_Query($where,$sqldata,"",$table);
    }

    
    //*
    //* function Sql_Select_Hash, Parameter list: $where,$sqldata=array(),$noecho=FALSE,$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fields or all data if $filednames is not an array.. 
    //*
    //* 

    function Sql_Select_Hash($where,$sqldata=array(),$noecho=FALSE,$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($table)) { $table=$this->SqlTableName(); }

        if (count($sqldata)==0) { $sqldata=array(); }

        $items=$this->Sql_Select_Hashes($where,$sqldata,"",$postprocess=FALSE,$table);

        $item=NULL;
        if (count($items)==0 && !$noecho)
        { 
            $this->AddMsg
            (
                 $this->ModuleName.
                 ", Sql_Select_Hash: No such item in table: $where'",
                 2
            );
        }
        elseif (count($items)>1 && !$noecho)
        {
            $this->AddMsg
            (
               $this->ModuleName.
               ", Sql_Select_Hash: More than one item in table: '$where'",
               2
            );
        }

        if (count($items)>=1){ $item=$items[0]; }
        
        return $item;
    }

    //*
    //* function Sql_Select_Hash_Unique, Parameter list: $where,$noecho=FALSE,$sqldata=array(),$table=""
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fieldnames or all data if $sqldata is not an array.. 
    //*
    //* 

    function Sql_Select_Hash_Unique($where,$noecho=FALSE,$sqldata=array(),$table="")
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if (count($sqldata)==0) { $sqldata="*"; }

        $items=$this->Sql_Select_Hashes($where,$sqldata,"ID",FALSE,$table);

        $item=NULL;
        if (count($items)==0 && !$noecho)
        { 
            $this->AddMsg
            (
                 $this->ModuleName.
                 ": SelectUniqueHash: No such item in table $table: $where'",
                 2
            );
        }
        elseif (count($items)>1 && !$noecho)
        {
            $this->AddMsg
            (
               $this->ModuleName.
               ", SelectUniqueHash: More than one item in table $table: '$where'",
               2
            );
        }

        if (count($items)>=1){ $item=$items[0]; }

        return $item;
    }
    
    //*
    //* function Sql_Select_Hash_Datas_Read, Parameter list: &$item,$datas,$table=""
    //*
    //* Makes sure that item has read all $datas.
    //*
    //* 

    function Sql_Select_Hash_Datas_Read(&$item,$datas,$table="")
    {
        if (!is_array($datas)) { $datas=array($datas); }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (!isset($item[ $data ]) || empty($item[ $data ]))
            {
                array_push($rdatas,$data);
            }
        }

        if (count($rdatas)>0 && !empty($item[ "ID" ]))
        {
            $ritem=
                $this->Sql_Select_Hash
                (
                   array("ID" => $item[ "ID" ]),
                   $rdatas,
                   FALSE,
                   $table
                );
            
            foreach ($rdatas as $id => $data)
            {
                $item[ $data ]=$ritem[ $data ];
            }
        }
    }
    
}
?>