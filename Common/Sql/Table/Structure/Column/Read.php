<?php


trait Sql_Table_Structure_Column_Read
{     
    //*
    //* function Sql_Table_Columns_Read, Parameter list: $table=""
    //*
    //* Read table columns, store in $this->ApplicationObj()->TablesColumns[ $table ].
    //* 

    function Sql_Table_Columns_Read($table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if (empty($this->ApplicationObj()->TablesColumns[ $table ]))
        {
            $this->ApplicationObj()->TablesColumns[ $table ]=array();
            foreach ($this->Sql_Table_Columns_Names($table) as $field)
            {
                $this->ApplicationObj()->TablesColumns[ $table ][ $field ]=TRUE;
            }
        }

        return $this->ApplicationObj()->TablesColumns[ $table ];
    }
}
?>