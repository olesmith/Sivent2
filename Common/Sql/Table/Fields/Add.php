<?php


trait Sql_Table_Fields_Add
{    
    //*
    //* function Sql_Table_Fields_Add_List, Parameter list: $data,$datadef,$table=""
    //*
    //* Adds columns $datas to $table.
    //* 

    function Sql_Table_Fields_Add_List($datas,$datadefs,$table="")
    {
        foreach ($datas as $data)
        {
            $this->Sql_Table_Field_Add($data,$datadefs[ $data ],$table);
        }
    }

    //*
    //* function Sql_Table_Field_Add, Parameter list: $data,$datadef=array(),$table=""
    //*
    //* Adds column $data to $table.
    //* 

    function Sql_Table_Field_Add($data,$datadef=array(),$table="")
    {
        if (empty($datadef[ "Sql" ])) { return; }
        if (empty($table)) { $table=$this->SqlTableName($table); }

        $sqltype=$datadef[ "Sql" ];
        if (count($datadef)==0) { $datadef=$this->ItemData [ $data ]; }

        if ($this->Sql_Table_Field_Exists($data,$table)) { return; }

        if (preg_match('/ENUM/',$sqltype))
        {
            $sqltype=$this->Sql_Table_Field_Enum_Spec($datadef);
        }
        elseif (preg_match('/^FILE$/',$sqltype))
        {
            $this->Sql_Table_Field_Add_File($data,$datadef,$table);

            return;
        }


        if ($data=="Default") { die("Item data (SQL column) named 'Default' unappropriate!"); }

        if (
              !empty($datadef[ "Default" ])
              &&
              !preg_match('/\s+DEFAULT\s+/',$sqltype)
              &&
              !preg_match('/^(TEXT)$/i',$datadef[ "Sql" ])
           )
        {
            $sqltype.=" DEFAULT '".$datadef[ "Default" ]."'";
        }

        if (!empty($sqltype))
        {
            //correct enum type for postgres
            if ($this->DB_PostGres() && preg_match('/^ENUM/i',$sqltype)) { $sqltype="int"; }

            if (preg_match('/\bAUTO_INCREMENT\b/i',$sqltype))
            {
                $sqltype=preg_replace('/\s*AUTO_INCREMENT\s*/i',"",$sqltype);
                $sqltype=preg_replace('/\s*INT\s*/i'," SERIAL ",$sqltype);
            }
            
            $query=
                "ALTER TABLE ".
                $this->Sql_Table_Name_Qualify($table).
                " ADD COLUMN ".
                $this->Sql_Table_Column_Name_Qualify($data)." ".
                $sqltype;
            
            $this->QueryDB($query);

            $msg="Add Column ".$data." in $table: $query<BR>";
            
            $this->ApplicationObj()->AddPostMessage("Add Column ".$data." in $table: $sqltype<BR>");
            
        }
        else
        {
            $this->ApplicationObj()->AddPostMessage("Add Column ".$data." in $table, no SQL type: $sqltype<BR>");
        }
    }

    
    //*
    //* function Sql_Table_Field_Add_File, Parameter list: $data,$datadef,$table=""
    //*
    //* Adds file field of name $data to table.
    //* 
    //*

    function Sql_Table_Field_Add_File($data,$datadef,$table="")
    {
        foreach ($this->Sql_Table_Fields_File_Datas() as $rdata => $def)
        {
            $sqltype=$def[ "Sql" ];
            $rrdata=$data."_".$rdata;
            if ($rdata=="Empty") { $rrdata=$data; }

            if (!$this->Sql_Table_Field_Exists($rrdata,$table))
            {
                $query=
                    "ALTER TABLE ".
                    $this->Sql_Table_Name_Qualify($table).
                    " ADD COLUMN ".
                    $this->Sql_Table_Column_Name_Qualify($rrdata)." ".
                    " ".
                    $sqltype;

                $this->AddMsg("Add Column Original ".$rdata." in $table: $query<BR>");
                $this->DB_Query($query);
            }
        }
    }
}


?>