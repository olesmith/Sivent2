<?php

trait MyMod_Data_Fields_Sql
{
    //*
    //* Returns sql where clause associated with $data.
    //*

    function MyMod_Data_Fields_Sql_Where($data)
    {
        $where=array();
        if (!empty($this->ItemData[ $data ][ "SqlWhere" ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere" ];
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlWhere".$this->Profile ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere".$this->Profile ];
        }
        elseif (!empty($this->ItemData[ $data ][ "SqlWhere".$this->LoginType ]))
        {
            $where=$this->ItemData[ $data ][ "SqlWhere".$this->LoginType ];
        }

        return $this->SqlWhere;
    }

    //*
    //* Generates search field for SQL object.
    //*

    function MyMod_Data_Fields_Sql_Search_Select($data,$rdata,$value)
    {
        if ($this->ItemData[ $data ][ "GETSearchVarName" ])
        {
            $getvalue=$this->CGI_GETint($this->ItemData[ $data ][ "GETSearchVarName" ]);
            if (!empty($getvalue))
            {
                if (empty($value))
                {
                    $value=$getvalue;
                }
            }
        }

        //Get values present in table.
        $colvalues=$this->MySqlUniqueColValues
        (
           "",
           $data,
           $this->MyMod_Data_Fields_Sql_Where($data)
        );

        if (empty($colvalues)) { return "-"; }
        

        //Where clause in module sql table
        $where=$this->Module2Object($data)->MyMod_Data_Fields_Sql_Where($data);
        
        if (!is_array($where)) { $where=$this->Hash2SqlWhere($where); }
        
        $where[ "ID" ]=$this->Sql_Where_IN($colvalues);

        $datas=$this->MyMod_Data_Fields_Module_Datas($data);
        $datas=preg_grep('/^ID$/',$datas,PREG_GREP_INVERT);
        array_push($datas,"ID");
        
        $rvalue=$this->Html_Select_Hashes2Field
        (
           $this->GetSearchVarCGIName($data),
           $this->MyMod_Data_Fields_Module_SubItems_2Options
           (
              $data,
              $this->SortList
              (
                 $this->Module2Object($data)->Sql_Select_Hashes
                 (
                    $where,
                    $datas
                 ),
                 $datas
              )
           ),
           $value
        );

        if ($this->ItemData[ $data ][ "SqlTextSearch" ] && ($value=="" || $value==0))
        {
            $rvalue=array($value,$this->TextSearchField($data));
        }
        else
        {
            $rvalue==preg_replace
            (
               '/NAME=\''.$data.'\'/',
               "NAME='".$rdata."'",
               $rvalue
            );
        }

        return $rvalue;
    }    
}

?>