<?php


trait DB_Fetch
{
    //*
    //* function DB_Fetch_Array, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function DB_Fetch_Array($result)
    {
        return $this->DB_Method_Call("Fetch_Array",$result);
    }

    //*
    //* function DB_Fetch_Assoc, Parameter list: $result
    //*
    //* Performs MySql Queries, $query. Returns the raw results.
    //* 
    //* 

    function DB_Fetch_Assoc($result)
    {
        return $this->DB_Method_Call("Fetch_Assoc",$result);
    }

    //*
    //* function DB_Fetch_Assoc_List, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as assoc. arrays.
    //* 
    //* 

    function DB_Fetch_Assoc_List($result,$byid=FALSE,$lowercasekeys=FALSE)
    {
         return $this->DB_Method_Call("Fetch_Assoc_List",$result,$byid,$lowercasekeys);
    }

    //*
    //* function DB_Fetch_Array_List, Parameter list: $result,$byid=FALSE
    //*
    //* Fetches rows from $result - as assoc. arrays.
    //* 

    function DB_Fetch_Array_List($result,$byid=FALSE)
    {
        return $this->DB_Method_Call("Fetch_Array_List",$result);
    }

    
    //*
    //* function DB_Fetch_Num_Rows, Parameter list: $result
    //*
    //* Fetches number of rows.
    //* 

    function DB_Fetch_Num_Rows($result)
    {
        return $this->DB_Method_Call("Fetch_Num_Rows",$result);
    }

    //*
    //* function DB_Fetch_Num_Fields, Parameter list: $result
    //*
    //* Fetches number of rows.
    //* 

    function DB_Fetch_Num_Fields($result)
    {
        return $this->DB_Method_Call("Fetch_Num_Fields",$result);
    }

    //*
    //* function DB_Fetch_FirstEntry, Parameter list: $result
    //*
    //* Returns first entry in $result.
    //* 
 
    function DB_Fetch_FirstEntry($result)
    {
        return $this->DB_Method_Call("Fetch_FirstEntry",$result);
    }

    
    //*
    //* function DB_Fetch_Field, Parameter list: $result,$i
    //*
    //* Returns filed info.
    //* 
    //* 

    function DB_Fetch_Field($result,$i)
    {
        return $this->DB_Method_Call("Fetch_Field",$result,$i);
    }

    //*
    //* function DB_Fetch_Update_NChanges, Parameter list: 
    //*
    //* Returns filed info.
    //* 
    //* 

    function DB_Fetch_Update_NChanges()
    {
        return $this->DB_Method_Call("Update_NChanges");
    }

}
?>