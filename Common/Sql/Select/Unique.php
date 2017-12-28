<?php


trait Sql_Select_Unique
{
    //*
    //* function Sql_Select_Unique_Col_Values_Query, Parameter list: $col,$where=array(),$orderby="",$table=""
    //*
    //* Returns list of unique col values resulting from $where.
    //*
    //* 

    function Sql_Select_Unique_Col_Values_Query($cols,$where=array(),$orderby="",$table="")
    {
        if (!is_array($cols)) { $cols=array($cols); }
        
        if (!$this->Sql_Table_Exists($table)) { return ""; }

        if (is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        $type=$this->DB_Dialect();
        $query="SELECT DISTINCT ";
        if (!empty($orderby) && $type=="pgsql")
        {
            $query.=
                " ON (".
                $this->Sql_Table_Column_Names_Qualify($orderby).
                ") ";
        }

        $query.=
            $this->Sql_Table_Column_Names_Qualify($cols).
            " FROM ".
            $this->Sql_Table_Name_Qualify($table);

        if (!empty($where)) { $query.=" WHERE ".$where; }
        
        if (!empty($orderby))
        {
            $query.=
                " ORDER BY ".
                $this->Sql_Table_Column_Names_Qualify($orderby);
        }

        return $query;
    }

    //*
    //* function Sql_Select_Unique_Col_Values, Parameter list: $col,$where=array(),$orderby="",$table=""
    //*
    //* Returns list of unique col values resulting from $where.
    //*
    //* 

    function Sql_Select_Unique_Col_Values($cols,$where=array(),$orderby="",$table="")
    {
        $singlecol=FALSE;
        if (!is_array($cols))
        {
            $singlecol=TRUE;
            $cols=array($cols);
        }
        
        $query=$this->Sql_Select_Unique_Col_Values_Query($cols,$where,$orderby,$table);

        $values=array();
        if (!empty($query))
        {
            foreach ($this->DB_Query_2Assoc_List($query) as $item)
            {
                $keys=array();
                foreach ($cols as $col)
                {
                    $key="";
                    if (isset($item[ $col ]))
                    {
                        $key=$item[ $col ];
                    }
                    
                    array_push($keys,$key);
                }
                
                #if (empty($item[ $col ])) { continue; }
                $values[ join("-",$keys) ]=$item;
            }
        }

        if ($singlecol)
        {
            return array_keys($values);
        }
        else
        {
            return array_values($values);
        }
    }

     //*
    //* function Sql_Select_ID_Items, Parameter list: $idcol="ID",$colids,$datas=array(),$table=""
    //*
    //* Returns ID'ed items in $ids.
    //*
    //* 

    function Sql_Select_ID_Items($colids,$datas=array(),$idcol="ID",$table="")
    {
        $items=array();
        foreach ($colids as $colid)
        {
            $items[ $colid ]=
                $this->Sql_Select_Hash(array($idcol => $colid),$datas,$noecho=TRUE,$table);
        }
        
        return $items;
    }

    
   //*
    //* function Sql_Select_Unique_Items, Parameter list: $idcol="ID",$where=array(),$datas=array(),$orderby="",$table=""
    //*
    //* Returns list of unique items conforming to $where.
    //*
    //* 

    function Sql_Select_Unique_Items($idcol="ID",$where=array(),$datas=array(),$orderby="",$table="")
    {
        return
            $this->Sql_Select_ID_Items
            (
                $this->Sql_Select_Unique_Col_Values($idcol,$where,$orderby,$table),
                $datas,
                $idcol,
                $table
            );
   }

    
    //*
    //* function Sql_Select_Unique_Col_NValues, Parameter list: $col,$where,$table=""
    //*
    //* Returns list of unique col values resulting from $where.
    //*
    //* 

    function Sql_Select_Unique_Col_NValues($col,$where=array(),$table="")
    {
        return count
        (
            $this->Sql_Select_Unique_Col_Values($col,$where,"ID",$table)
        );
    }

    
    //*
    //* function Sql_Select_Unique_Item, Parameter list: $col,$where,
    //*
    //* Reads unique item from SQL table: croaks, if NOT unique!
    //*
    //* 

    function Sql_Select_Unique_Item($where,$datas=array(),$delete=FALSE,$table="")
    {
        $items=$this->Sql_Select_Hashes($where,array("ID"),array("ID"));
        
        $item=array();
        if (count($items)>0)
        {
            $item=array_pop($items);
            $item=$this->Sql_Select_Hash(array("ID" => $item[ "ID" ],$datas,FALSE,$table));
        }
        
        if (count($items)>0)
        {
            $item=array();
            var_dump("non-unique items");
            $this->AddHtmlStatusMessage("Sql_Select_Unique_Item: non-unique items");
           
            foreach ($items as $item)
            {
                var_dump("should delete ".$item[ "ID" ]);
                if ($delete)
                {
                   $this->Sql_Delete_Item($item[ "ID" ]);
                }
            }
        }

        return $item;
        
    }
}
?>