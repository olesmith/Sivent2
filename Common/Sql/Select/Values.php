<?php


trait Sql_Select_Values
{
    ///*
    //* function Sql_Select_NEntries_Query, Parameter list: $where="",$table=""
    //*
    //* Returns number of entries, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_NEntries_Query($where="",$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }

        if (
              !is_array($table)
              &&
              !$this->Sql_Table_Exists($table)
           )
        { return ""; }
        
        //if (is_array($table)) { $table=join("` `",$table); }
        $table=$this->Sql_Tables_Exists($table);
        
        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $query=
            "SELECT COUNT(*) FROM ".
            $this->Sql_Table_Names_Qualify($table);
         
        if (!empty($where))
        {
            $query.=" WHERE ".$where;
        }

        return $query;
    }
    
    ///*
    //* function Sql_Select_NEntries, Parameter list: $where="",$table=""
    //*
    //* Returns number of entries, conforming to $where, in table $table.
    //*
    //* 

    function Sql_Select_NEntries($where="",$table="")
    {
        $tables=$table;
        if (!is_array($tables)) { $tables=array($tables); }

        $res=0;
        foreach ($tables as $table)
        {
            $query=$this->Sql_Select_NEntries_Query($where,$table);

            if (!empty($query))
            {
                $result = $this->QueryDB($query);

                $res+=$this->DB_Fetch_FirstEntry($result);

                $this->DB_FreeResult($result);
            }
        }
        
        if (empty($res)) { $res=0; }

        return $res;
    }
    
    //*
    //* function Sql_Select_Hash_Value, Parameter list: $id,$var,$idvar="ID",$noecho=FALSE,$table=""
    //*
    //* Reads $id'ed item $var. 
    //*
    //* 

    function Sql_Select_Hash_Value($id,$var,$idvar="ID",$noecho=FALSE,$table="")
    {
        $item=$this->Sql_Select_Hash
        (
           array($idvar => $id),
           array($var),
           FALSE,
           $table
        );

        return $item[ $var ];
    }

    //*
    //* function Sql_Select_Hash_Values, Parameter list: $id,$vars,$idvar="ID",$noecho=FALSE,$table=""
    //*
    //* Read $id'd item $vars, returns as hash.
    //*
    //* 

    function Sql_Select_Hash_Values($id,$vars,$idvar="ID",$noecho=FALSE,$table="")
    {
        $item=$this->Sql_Select_Hash
        (
           array($idvar => $id),
           $vars,
           FALSE,
           $table
        );

        return $item;
    }

    //*
    //* function Sql_Select_Values_Sizes_Query, Parameter list: $cols=array(),$table=""
    //*
    //* Read column data sizes, query.
    //*
    //* 

    function Sql_Select_Values_Sizes_Query($cols=array(),$table="")
    {
        if (empty($cols)) { $cols=$this->Sql_Table_Columns_Names(); }
        
        $cols=$this->Sql_Table_Column_Names_Qualify_List($cols);
        foreach (array_keys($cols) as $vid)
        {
            $cols[ $vid ]="CHAR_LENGTH(".$cols[ $vid ].")";
        }
        
        $query=
            "SELECT ".
            "".join(",",$cols)."".
            " FROM ".
            $this->Sql_Table_Names_Qualify($table);
         
        return $query;
    }

    //*
    //* function Sql_Select_Values_Sizes, Parameter list: $cols,$table=""
    //*
    //* Read column data sizes as list.
    //*
    //* 

    function Sql_Select_Values_Sizes($cols=array(),$table="")
    {
        if (empty($cols)) { $cols=$this->Sql_Table_Columns_Names(); }
        
        $query=$this->Sql_Select_Values_Sizes_Query($cols,$table);

        $sizes=array();
        foreach ($this->DB_Query_2Assoc_List($query) as $result)
        {
       
           foreach ($cols as $col)
            {
                $size=$result[ "CHAR_LENGTH(".$col.")" ];
                if (!empty($size))
                {
                    if (!isset($sizes[ $col ])) { $sizes[ $col ]=0; }
                    $sizes[ $col ]+=$size;
                }
            }
        }

        return $sizes;
    }

    //*
    //* function Sql_Select_Values_Size, Parameter list: $cols,$table=""
    //*
    //* Read column data sizes as list.
    //*
    //* 

    function Sql_Select_Values_Size($cols=array(),$table="")
    {
        $size=0;
        foreach ($this->Sql_Select_Values_Sizes($cols,$table) as $col => $csize)
        {
            $size+=$csize;
        }

        return $size;
    }

}
?>