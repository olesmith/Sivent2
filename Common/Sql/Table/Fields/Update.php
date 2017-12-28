<?php

include_once("Update/Default.php");
include_once("Update/Length.php");

trait Sql_Table_Fields_Update
{
    use
        Sql_Table_Fields_Update_Default,
        Sql_Table_Fields_Update_Length;
    //*
    //* function Sql_Table_Fields_Update, Parameter list: $data,$datadef=array(),$table=""
    //*
    //* Updates fields in $datas.
    //* 

    function Sql_Table_Fields_Update($datas,$datadefs,$table="")
    {
        $columninfo=$this-> Sql_Table_Columns_Info($table);

        
        $addlist=array();
        $enums=array();
        $addeds=array();
        $updateds=array();
        foreach ($datas as $data)
        {
            if (!$this->MyMod_Data_Field_Is_Derived($data))
            {
                if ($this->Sql_Table_Field_Exists($data,$table))
                {
                    $this->Sql_Table_Field_Update($data,$columninfo[ $data ],array(),$table);
                    array_push($updateds,$data);
                }
                else
                {
                    $this->Sql_Table_Field_Add($data,$datadefs[ $data ],$table);
                    array_push($addeds,$data);
                }
            }
        }

        if (method_exists($this,"PostCreateTable"))
        {
            $this->PostCreateTable();
        }

        return array($addeds,$updateds);
     }
    
    //*
    //* function Sql_Table_Field_Update, Parameter list: $data,$datadef=array(),$table=""
    //*
    //* Update filed $data.
    //* 

    function Sql_Table_Field_Update($data,$columninfo,$datadef=array(),$table="")
    {
        if (empty($datadef) && !empty($this->ItemData[ $data ])) { $datadef=$this->ItemData[ $data ]; }
        if (empty($datadef)) { return; }

        //28/06/2016: Read column info in one bite. $info=$this->Sql_Table_Column_Info($data,$table);
        if (!empty($columninfo))
        {
            if ($datadef[ "Sql" ]=="ENUM")
            {
                $this->Sql_Table_Field_Enum_Update($data,$datadef,$columninfo,$table);
            }

            #$datadef[ "Default" ]=preg_replace('/\s+/'," ",$datadef[ "Default" ]);

            $default=preg_replace('/\s+/'," ",$this->Sql_Table_Column_Info_2_Default($columninfo));
            if (
                  $this->Sql_Table_Field_Default_Should($data,$datadef)
                  &&
                  $default!=$datadef[ "Default" ]
               )
            {
                $this->Sql_Table_Field_Default_Set($data,$datadef[ "Default" ],$table);
            }
        }
        
        if (preg_match('/^FILE$/',$datadef[ "Sql" ]))
        {
            $this->Sql_Table_Field_Add_File($data,$datadef,$table);
        }

        if (preg_match('/\((\d+)\)/',$datadef[ "Sql" ],$matches))
        {
            $oldlen=$matches[1];
            if (preg_match('/^\d+$/',$oldlen,$matches))
            {
                $newlen=$this->Sql_Table_Column_Info_2_Length($columninfo);
                if ($oldlen!=$newlen)
                {
                    $len=$this->Sql_Table_Field_Length_Alter($data,$datadef,$table);
                }
            }
        }
    }
}


?>