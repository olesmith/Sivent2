<?php

class DBDataCells extends DBDataPertains
{
    //*
    //* function SqlKeyField, Parameter list: $data,$item,$edit,$rdata
    //*
    //* Returns sql key field, appends ok/not ok icon.
    //*

    function SqlKeyField($data,$item,$edit,$rdata)
    {
        $icon="";
        $value="";

        if ($edit==1)
        {
            $value=
                $this->MyMod_Data_Fields_Edit($data,$item,$item[ $data ],"",TRUE,TRUE,FALSE,$rdata);
        }
        else
        {
            $value= 
                $this->MyMod_Data_Fields_Show($data,$item,FALSE,TRUE,FALSE);
        }

        $inscriptiontable=$this->DBDataObj()->SqlTableName();
        if ($this->DBDataObj()->Sql_Table_Exists())
        {
            if ($this->DBDataObj()->Sql_Table_Field_Exists($item[ $data ]))
            {
                $icon=$this->IMG("icons/ok.png",$item[ $data ]." Exists in SQL Table",15);
            }
            else
            {
                $icon=$this->IMG("icons/notok.png",$item[ $data ]." Nonexistent in SQL Table",15);
            }
        }
        return $value.$icon;
    }

    //*
    //* function SqlDefField, Parameter list: $data,$item,$edit,$rdata
    //*
    //* Creates SqlDef field. Adds in table type, for debugging.
    //*

    function SqlDefField($data,$item,$edit,$rdata)
    {
        if (empty($item[ $data ]))
        {
            $item[ $data ]="";
        }

        if ($edit==1)
        {
            $value= 
                $this->MyMod_Data_Fields_Edit($data,$item,$item[ $data ],"",TRUE,TRUE,FALSE,$rdata);
        }
        else
        {
            $value= 
                $this->MyMod_Data_Fields_Show($data,$item,FALSE,TRUE,FALSE);
        }

        if (!empty($item[ $data ]))
        {
            $inscriptiontable=$this->DBDataObj()->SqlTableName();
            if ($this->DBDataObj()->Sql_Table_Exists())
            {
                if ($this->DBDataObj()->Sql_Table_Field_Exists($item[ "SqlKey" ]))
                {
                    $type=$this->DBDataObj()->Sql_Table_Column_Type($item[ "SqlKey" ]);

                    $sqldef=strtolower($item[ "SqlDef" ]);
                    $sqldef=preg_replace('/\)/',"\)",preg_replace('/\(/',"\(",$sqldef));

                    //$sqldef=preg_match('/enum/',"int",$sqldef);
                    
                    if ($item[ "SqlDef" ]=="FILE")
                    {
                        if (preg_match('/^VARCHAR\(\d+\)\(\d+\)$/i',$type))
                        {
                            $value.=
                                "<BR>".
                                $this->IMG("icons/ok.png",$item[ $data ]." Identical in SQL Table",15).
                                $type;
                        }
                        else
                        {
                            $value.=
                                "<BR>".
                                $this->IMG("icons/notok.png",$item[ $data ]." Review!",15).
                                $type;
                        }
                    }
                    elseif (
                              preg_match('/^'.$sqldef.'/',$type)
                              ||
                              ($sqldef=='enum' && $type=='int')
                           )
                    {
                        $value.=
                            "<BR>".
                            $this->IMG("icons/ok.png",$item[ $data ]." Identical in SQL Table",15).
                            $type;
                    }
                    else
                    {
                        $value.=
                            "<BR>".
                            $this->IMG
                            (
                               "icons/notok.png",
                               $item[ $data ]." Different in SQL Table",
                               15
                            ).
                            $type." vs. ".$sqldef;
                    }
                 }
                else
                {
                    $value.=
                        $this->IMG("icons/notok.png",$item[ $data ]." Nonexistent in SQL Table",15);
                }
            }
        }
        
        return $value;
    }

    //*
    //* function DBDataFormDetailsCell, Parameter list: $edit,$item
    //*
    //* Details cell.
    //*

    function DBDataFormDetailsCell($edit,$item)
    {
        return $this->ItemsForm_ItemDetailsCell($edit,$item);
         
    }

    //*
    //* function GetDetailsSGroups, Parameter list: $edit,$item
    //*
    //* Returns matrix of SGroups to include for detailed $item.
    //*

    function GetDetailsSGroups($edit,$item)
    {
        $groupsm=array
        (
            array
            (
               "Basic" => $edit,
               "SQL" => $edit,
            ),
            array
            (
               "Permissions" => $edit,
            ),
        );

        $type=$this->GetEnumValue("Type",$item);
        if (!empty($this->ItemDataSGroups[ $type ]))
        {
            array_push
            (
               $groupsm,
               array
               (
                  $type => $edit,
               )
            );
        }

        return $groupsm;
    }
}


?>