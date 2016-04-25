<?php


class MySqlSelectHash extends MySqlSelectHashes
{
    //*
    //* function SelectUniqueHash, Parameter list: $table,$where,$noecho
    //*
    //* Perform a select query on Table $table in the current DB.
    //* Returns each match as a hash of the field names in
    //* in $fieldnames or all data if $filednames is not an array.. 
    //*
    //* 

    function SelectUniqueHash($table,$where,$noecho=FALSE,$sqldata=array())
    {
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if (count($sqldata)==0) { $sqldata="*"; }

        $items=$this->SelectHashesFromTable($table,$where,$sqldata);

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
}


?>