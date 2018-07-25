<?php

trait MyMod_Data_Fields_Sql
{
    //*
    //* Returns sql where clause associated with $data.
    //*

    function MyMod_Data_Fields_Sql_Where($data,$value)
    {
        $where=array();
        if (!empty($this->SqlWhere[ $data ]))
        {
            $where[ $data ]=$this->SqlWhere[ $data ];
        }
        return $where;
    }

    //*
    //* Generates search field for SQL object.
    //*

    function MyMod_Data_Fields_Sql_Search_Select($data,$rdata,$value)
    {
        if
            (
                $this->ItemData[ $data ][ "GETSearchVarName" ]
                &&
                !preg_match('/^Admin$/',$this->Profile())
            )
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

        //Where clause in module sql table
        $where=$this->MyMod_Data_Fields_Sql_Where($data,$value);

        if (!is_array($where)) { $where=$this->Hash2SqlWhere($where); }

        //Get values present in table.
        $colvalues=$this->Sql_Select_Unique_Col_Values
        (
           $data,
           $where
        );
        $colvalues=preg_grep('/^\d+$/',$colvalues);
        
        if (!empty($colvalues))
        {
            $where[ "ID" ]=$colvalues;
        }

        $datas=$this->MyMod_Data_Fields_Module_Datas($data);
        $datas=preg_grep('/^ID$/',$datas,PREG_GREP_INVERT);
        array_push($datas,"ID");

        $hashes=array();
        if (!empty($this->ItemData[ $data ][ "SqlTables_Regex" ]))
        {
            $class=$this->ItemData[ $data ][ "SqlClass" ];
            
            $hashes=
                $this->Module2Object($data)->Sql_Tables_Select_Hashes
                (
                   $this->ItemData[ $data ][ "SqlTables_Regex" ],
                   $where,
                   $datas
                );
        }
        elseif (!empty($this->ItemData[ $data ][ "Search_Vars" ]))
        {
            $class=$this->ItemData[ $data ][ "SqlClass" ];
            $sqltable=$this->ApplicationObj()->SubModulesVars[ $class ][ "SqlTable" ];

            foreach ($this->ItemData[ $data ][ "Search_Vars" ] as $searchvar)
            {
                $sqltable=
                    preg_replace
                    (
                       '/#'.$searchvar.'/',
                       $this->MyMod_Search_CGI_Value($searchvar),
                       $sqltable
                    );
            }
            $hashes=
                $this->Module2Object($data)->Sql_Select_Hashes
                (
                   $where,
                   $datas,
                   "",FALSE,
                   $sqltable
                );
        }
        else
        {
            if (!empty($where[ $data ]))
            {
                #$where[ "ID" ]=$where[ $data ];
                unset($where[ $data ]);
            }
            $class=$this->ItemData[ $data ][ "SqlClass" ];
            if (
                   !empty($this->ItemData[ $data ][ "SqlClass" ])
                   &&
                   method_exists($this->Module2Object($data),"SqlWhere")
                )
            {
                 if (!is_array($where))
                 {
                     $where=$this->SqlClause2Hash($where);
                 }

                 $where=
                     array_merge
                     (
                         $where,
                         $this->Module2Object($data)->SqlWhere(array($data => $value))
                     );
             }

             $hashes=
                $this->Module2Object($data)->Sql_Select_Hashes
                (
                   $where,
                   $datas,
                   join(",",$this->ApplicationObj()->SubModulesVars[ $class ][ "SqlDerivedData" ])
                );
        }

        $rvalue=$this->Html_Select_Hashes2Field
        (
           $this->MyMod_Search_CGI_Name($data),
           $this->MyMod_Data_Fields_Module_SubItems_2Options
           (
              $data,
              $this->MyMod_Sort_List($hashes,$datas)
           ),
           $value
        );

        if ($this->ItemData[ $data ][ "SqlTextSearch" ] && ($value=="" || $value==0))
        {
            $rvalue=
                array
                (
                    $value,
                    $this->MyMod_Search_Field_Text($data)
                );
        }
        else
        {
            $rvalue=preg_replace
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