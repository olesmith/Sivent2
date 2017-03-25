<?php


trait Sql_Table_Fields_Enum
{
    //*
    //* function Sql_Table_Field_Enum_Spec, Parameter list: $data,$datadef=array(),$table
    //*
    //* Returns appropriate enum spec.
    //* 
    //*

    function Sql_Table_Field_Enum_Spec($datadef)
    {
        if (!is_array($datadef))
        {
            $datadef=$this->ItemData[ $datadef ];
        }

        $sqltype=$datadef[ "Sql" ];
        if (preg_match('/ENUM/',$sqltype))
        {
            $values=$sqltype;
            $defs=preg_replace('/^\s*ENUM\s*\(/',"",$sqltype);
            $defs=preg_replace('/\s*\)\s*/',"",$defs);
            $values=preg_split('/\s*,\s*/',$defs);
            $values=$datadef[ "Values" ];

            $rvalues=array();
            for ($nn=0;$nn<=count($values);$nn++)
            {
                $rvalues[$nn]=$nn;
            }

            return "ENUM ('".join("', '",$rvalues)."')";
        }

        $this->ApplicationObj()->AddPostMessage("$data is not of type ENUM");

        return "";
    }
    
    //*
    //* function Sql_Table_Field_Enum_Update, Parameter list: $data,$datadef=array(),$table
    //*
    //* Updates enum values according to specs.
    //* 
    //*

    function Sql_Table_Field_Enum_Update($data,$datadef=array(),$columninfo=array(),$table="")
    {
        if (empty($table)) { $table=$this->SqlTableName($table); }
        
        if (empty($columninfo)) { $columninfo=$this->Sql_Table_Column_Info($data,$table); }

        if (preg_match('/^pgsql$/',$this->DBHash("ServType"))) { return; }
        
        if (
              !empty($datadef)
              &&
              preg_match('/^enum/i',$datadef[ "Sql" ])
            )
         {
             $nvalues=0;
             if (
                   isset($datadef[ "ValuesMatrix" ])
                   &&
                   is_array($datadef[ "ValuesMatrix" ])
                )
             {
                 foreach ($datadef[ "ValuesMatrix" ] as $id => $values)
                 {
                     if (count($values)>$nvalues) { $nvalues=count($values); }
                 }
             }
             else
             {
                 $values=$datadef[ "Values" ];
                 $nvalues=count($values);
             }
             //add values, if number of enums in table insufficient
             $cnvalues=$this->Sql_Table_Column_Enum_Values($data);
             
             if (count($cnvalues)<=$nvalues)
             {
                 $def=array();
                 for ($k=0;$k<=$nvalues;$k++) { array_push($def,"'".$k."'"); }
                 $def=join(",",$def);

                 $query=
                     "ALTER TABLE ".
                     $this->Sql_Table_Name_Qualify($table).
                     " MODIFY COLUMN ".
                     $this->Sql_Table_Column_Name_Qualify($data).
                     " ENUM(".$def.")";
                 
                 $this->DB_Query($query);
                 $this->ApplicationObj()->AddPostMessage("Mod Column ".$data.": $query");
                 $this->ApplicationObj->LogMessage(5,"Mod Column ".$data.": ".$query);

                 return TRUE;
             }
         }

        return FALSE;
  }


  //*
  //* function Sql_Table_Fields_Enum_Update, Parameter list: $datas,$table
  //*
  //* Updates enum values according to $this->TableFields specs.
  //* 
  //*

  function Sql_Table_Fields_Enum_Update($datas,$table)
  {
      $updateds=array();
      foreach ($datas as  $data)
      {
          if (!isset($this->ApplicationObj()->TablesColumns[ $table ][ $data ])) { continue; }

          $datadef=$this->ItemData($data);

          $field=$this->ApplicationObj()->TablesColumns[ $table ][ $data ][ "Values" ];
          if ($field[ "Type" ]=="enum")
          {
              //if (!isset($datadef)) { continue; }
          }

          if ($this->Sql_Table_Field_Enum_Update($data,$datadef,array(),$table))
          {
              array_push($updateds,$data);
          }
      }

      return $updateds;
  }
}


?>