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
                    $this->Sql_Table_Field_Update($data,array(),$table);
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

    function Sql_Table_Field_Update($data,$datadef=array(),$table="")
    {
        if (empty($datadef) && !empty($this->ItemData[ $data ])) { $datadef=$this->ItemData[ $data ]; }
        if (empty($datadef)) { return; }
        

        $info=$this->Sql_Table_Column_Info($data,$table);
        if (!empty($info))
        {
            if ($datadef[ "Sql" ]=="ENUM")
            {
                $this->Sql_Table_Field_Enum_Update($data,$datadef,$info,$table);
            }

            $datadef[ "Default" ]=preg_replace('/\s+/'," ",$datadef[ "Default" ]);

            $default=$this->Sql_Table_Column_Info_2_Default($info);
            if (
                  !empty($datadef[ "Default" ])
                  &&
                  $default!=$datadef[ "Default" ]
                  &&
                  !preg_match('/^(TEXT)$/i',$datadef[ "Sql" ])
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
                $newlen=$this->Sql_Table_Column_Info_2_Length($info);
                if ($oldlen!=$newlen)
                {
                    $len=$this->Sql_Table_Field_Length_Alter($data,$datadef,$table);
                }
            }
        }
    }
}


?>