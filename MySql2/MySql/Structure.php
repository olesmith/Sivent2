<?php


class MySqlStructure extends MySqlDelete
{
  //*
  //* function UpdateDBFields, Parameter list: $table="",$datas=array()
  //*
  //* Update data base fields: adding new fields
  //* and modifies existing according to $datas and 
  //* $sqltypes specifications.
  //* 
  //*

  function UpdateDBFields($table="",$datas=array(),$datadefs=array(),$maycreate=TRUE)
  {
      if (method_exists($this,"Sql_Table_Structure_Update"))
      {
          $this->Sql_Table_Structure_Update($datas,$datadefs,$maycreate,$table);
      }
  }

  //*
  //* function UnusedFields, Parameter list:
  //*
  //* Returns the list of fields unused in table.
  //* 
  //*

  function UnusedFields()
  {
      $unuseds=array();
      foreach (array_keys($this->TableFields) as $data)
      {
          if (!isset($this->ItemData[ $data ]))
          {
              array_push($unuseds,$data);
          }
      }

      return $unuseds;
  }
  //*
  //* function UnusedSql, Parameter list:
  //*
  //* Returns the list of sql commands eliminating all fields unused in table.
  //* 
  //*

  function UnusedSqls($table)
  {
      $unuseds=$this->UnusedFields();

      $runuseds=array();
      foreach ($unuseds as $unused)
      {
          $runuseds[ $unused ]="ALTER TABLE ".$table." DROP COLUMN ".$unused.";";
      }

      return $runuseds;
  }

  //*
  //* function DropUnusedFields, Parameter list: $table=""
  //*
  //* Drops unused fields in $table.
  //* 
  //*

  function DropUnusedFields($table)
  {
      if ($this->GetPOST("Clean")==1)
      {
          $queries=$this->UnusedSqls($table);

          $dropped=array();
          foreach ($queries as $data => $query)
          {
              if ($this->GetPOST("Drop_".$data)==1)
              {
                  $this->QueryDB($query);
                  array_push($dropped,$data);
              }
          }

          if (count($dropped)>0)
          {
              print $this->H(5,"Dropped: ".join(", ",$dropped));
          }

          //Force reread
          $this->TableFields=array();
          $this->Sql_Table_Fields_Get($table);
      }
  }

  //*
  //* function HandleSysInfo, Parameter list:
  //*
  //* Shows Table structural Info.
  //* 
  //*

  function HandleSysInfo($table="")
  {
      $table=$this->SqlTableName($table);

      if ($this->GetPOST("Clean")==1)
      {
          $this->DropUnusedFields($table);
      }

      $unused=$this->UnusedSqls($table);

      $datas=array();
      foreach (array_keys($this->TableFields) as $data)
      {
          $datas[ $data ]=1;
      }

      foreach (array_keys($this->ItemData) as $data)
      {
          $datas[ $data ]=1;
      }

      $datas=array_keys($datas);
      sort($datas);

      $titles=$this->B(array("","Details","In DB:","Type","NULL","Default","In Object:","Name","Default","DROP"));
      $rtable=array($titles);
      foreach ($datas as $data)
      {
          $row=array
          (
             $this->B($data.":"),
             $this->Href
             (
                "?ModuleName=".$this->ModuleName."&Action=SysInfo&Data=".$data,
                $this->IMG("../icons/show.gif")
             )
          );

          if (isset($this->TableFields[ $data ]))
          {
              array_push
              (
                 $row,
                 "Y",
                 $this->TableFields[ $data ][ 'type' ],
                 $this->TableFields[ $data ][ 'Null' ],
                 $this->TableFields[ $data ][ 'Default' ]
              );
          }
          else
          {
              array_push($row,"N","","","");
          }

          if (isset($this->ItemData[ $data ]))
          {
              array_push
              (
                 $row,
                 "Y",
                 $this->ItemData[ $data ][ "Name" ],
                 $this->ItemData[ $data ][ "Default" ],
                 ""
              );
          }
          else
          {
              array_push
              (
                 $row,
                 "N",
                 "",
                 "",
                 $this->MakeCheckBox("Drop_".$data,1).$unused[ $data ]
              );
          }

          array_push($rtable,$row);
      }

      $this->SystemMenu();

      print
          $this->H(2,"Table Data Info:").
          $this->H(3,"DB vs. Object");

      if (count($unused)>0)
      {
          print 
              $this->StartForm().
              $this->H(4,"Operação Irreversível!!").
              $this->Center($this->Button("submit","Remover Colunas Selecionadas")).
              $this->MakeHidden("Clean",1);
      }

      $data=$this->GetGET("Data");
      if ($data!="")
      {
          $dtable="";
          $otable="";

          if (isset($this->TableFields[ $data ]))
          {
              $dtable=
                  $this->H(5,"DB").
                  $this->HtmlTable
                  (
                     "",
                     $this->Hash2Table($this->TableFields[ $data ])
                  );
          }
          if (isset($this->ItemData[ $data ]))
          {
              $otable=
                  $this->H(5,"Object").
                  $this->HtmlTable
                  (
                     "",
                     $this->Hash2Table($this->ItemData[ $data ])
                  );
          }

          array_push
          (
             $rtable,
             "<TABLE><TR>\n".
             "  <TD COLSPAN='2'>".$this->H(3,$data.":")."</TD>\n".
             "<TR></TR>\n".
             "  <TD WIDTH='50%'>".$dtable."</TD>\n".
             "  <TD WIDTH='50%'>".$otable."</TD>\n".
             "</TR></TABLE>\n"
          );
      }


      print $this->HtmlTable("",$rtable);

      if (count($unused)>0)
      {
          print 
              $this->EndForm();
      }



  }

    //*
    //* function MysqlTableIndices, Parameter list: $table="",$dbname=""
    //*
    //* Returns lists of Indexes in table.
    //* 
    //* 

    function MysqlTableIndices($table="",$dbname="")
    {
        $table=$this->SqlTableName($table);
        if (empty($dbname)) { $dbname=$this->DBHash[ "DB" ]; }

        $results=$this->QueryDB("SHOW INDEX FROM `".$table."`");
        $nfields=$this->FetchNumFields($results);

        $indices=array();
        for ($i=0;$i<$nfields;$i++)
        {
            $meta=$this->FetchField($results,$i);

            $name=$meta->Key_name;
            $indices[ $name ]=$meta;
        }

        return $indices;
    }
}

?>