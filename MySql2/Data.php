<?php


class Data extends DataPrint
{
    var $TitleKeyShortName="ShortName";
    var $TitleKeyName="Name";
    var $TitleKeyTitle="Title";

    //*
    //* Variables of Data class:

    var $Masculine;
    var $ItemName,$ItemsName,$ItemNamer,$ItemName_UK,$ItemsName_UK,$ItemNamer_UK;
    var $SqlData,$SqlDerivers;
    var $ItemFieldMethods=array();
 

    var $ItemDataMode="Php";
    var $TabMovesDownKey="_TabMovesDown";
    var $StringVars=array("Sql","Name","LongName");
    var $BoolVars=array("Compulsory","Visible","Admin","Person","Public","NoSort","ShowOnly","TimeType");
    var $ListVars=array("Values","ShowIDCols","EditIDCols");
    var $AlwaysReadData=array();
    var $DatasRead=array();

     //*
    //* function GetDefaultItemData, Parameter list: $data,&$datadef
    //*
    //* Makes sure ItemData entries has all necessary keys.
    //*

    function GetDefaultItemData($data,&$datadef)
    {
        foreach ($this->DefaultItemData as $key => $value)
        {
            if (!isset($datadef[ $key ]))
            {
                $datadef[ $key ]=$value;
            }
        }

        foreach ($this->ApplicationObj->ValidProfiles as $profile)
        {
            if (!isset($datadef[ $profile ]))
            {
                $datadef[ $profile ]=0;
            }
        }
    }

    //*
    //* function InitDataPermissions, Parameter list:
    //*
    //* Updates data permissions from Profile.
    //*

    function InitDataPermissions()
    {
        $alldatas=array_keys($this->ItemData);

        //Take directly defined data permissions, via $this->ProfileHash[ "Data" ][ "Access" ]
        if (isset($this->ProfileHash[ "Data" ][ "Access" ]))
        {
            foreach ($this->ProfileHash[ "Data" ][ "Access" ] as $data => $value)
            {
                $rdatas=preg_grep('/^'.$data.'$/',$alldatas);
                foreach ($rdatas as $rdata)
                {
                    if (is_array($this->ItemData[ $rdata ]))
                    {
                        $this->ItemData[ $rdata ][ $this->LoginType ]=$value;
                        $this->ItemData[ $rdata ][ $this->Profile ]=$value;
                    }
                }

                if (!isset($this->ItemData[ $rdata ][ $this->Profile ]))
                {
                    $this->ItemData[ $rdata ][ $this->Profile ]=0;
                }
                if (!isset($this->ItemData[ $rdata ][ $this->LoginType ]))
                {
                    $this->ItemData[ $rdata ][ $this->LoginType ]=0;
                }
            }
        }

        //Take data read permissions (1) defined via $this->ProfileHash[ "Data" ][ "Read" ]
        if (
            isset($this->ProfileHash[ "Data" ][ "Read" ])
            &&
            is_array($this->ProfileHash[ "Data" ][ "Read" ])
           )
        {
            foreach ($this->ProfileHash[ "Data" ][ "Read" ] as $id => $data)
            {
                $rdatas=preg_grep('/^'.$data.'$/',$alldatas);
                foreach ($rdatas as $rdata)
                {
                    if (is_array($this->ItemData[ $rdata ]))
                    {
                        $this->ItemData[ $rdata ][ $this->LoginType ]=1;
                        $this->ItemData[ $rdata ][ $this->Profile ]=1;
                    }
                }
            }
        }

        //Take data write permissions (2) defined via $this->ProfileHash[ "Data" ][ "Write" ]

        if (
            isset($this->ProfileHash[ "Data" ][ "Write" ])
            &&
            is_array($this->ProfileHash[ "Data" ][ "Write" ])
           )
        {
            foreach ($this->ProfileHash[ "Data" ][ "Write" ] as $id => $data)
            {
                $rdatas=preg_grep('/^'.$data.'$/',$alldatas);
                foreach ($rdatas as $rdata)
                {
                    if (is_array($this->ItemData[ $rdata ]))
                    {
                        $this->ItemData[ $rdata ][ $this->LoginType ]=2;
                        $this->ItemData[ $rdata ][ $this->Profile ]=2;
                    }
                }
            }
        }
  }

    //*
    //* function InitLatexData, Parameter list: 
    //*
    //* Reads Latex setups for module.
    //*

    function InitLatexData()
    {
        return $this->LatexData();
    }

    //*
    //* function DisableFileData, Parameter list: $value=0
    //*
    //* Disables FILE data, setting ItemData's [ $this->Profile() ] to $value, default 0.
    //*

  function DisableFileData($value=0)
  {
      foreach (array_keys($this->ItemData) as $data)
      {
          if ($this->ItemData[ $data ][ "Sql" ]=="FILE")
          {
              $this->ItemData[ $data ][ $this->Profile() ]=0;
          }
      }
  }

  function RealFieldName($field)
  {
      $rfield=$field;
      if ($this->Reserved[ $field ]!="") { $rfield=$this->Reserved[ $field ]; }

      return $rfield;
  }

  function OriginalFieldName($field)
  {
      $hash=$this->Reserved;
      $rhash=array();
      foreach ($hash as $key => $value) { $rhash[ $value ]=$key; }

      $rfield=$field;
      if ($rhash[ $field ]!="") { $rfield=$rhash[ $field ]; }

      return $rfield;
  }

  function TransFieldNamesHash($hash,$type)
  {
      $specs=$this->DataSpecs[ $type ];

      $rhash=array();
      foreach ($hash as $field => $value)
      {
          $rfield=$this->RealFieldName($field);
          $res=preg_grep("/^$field$/",$specs);
          if (count($res)>0)
          {
              $rhash[ $rfield ]=$hash[ $field ];
              $rhash[ $rfield ]=preg_replace("/'/","''",$rhash[ $rfield ]);
          }
      }

      return $rhash;
  }

  function OriginalFieldNamesHash($hash)
  {
      $rhash=array();
      foreach ($hash as $field => $value)
      {
          $rfield=$this->OriginalFieldName($field);
          $rhash[ $rfield ]=$hash[ $field ];
      }

      return $rhash;
  }

  function GetRealSqlWhereClause()
  {
      $this->MyApp_Login_Detect();

      $where="";
      if ($this->LoginType=="Admin")
      {
          if (isset($this->ItemData[ $data ][ "SqlAdminWhere" ]))
          {
              $where=$this->ItemData[ $data ][ "SqlAdminWhere" ];
          }
      }
      elseif ($this->LoginType=="Person")
      {
          if (isset($this->ItemData[ $data ][ "SqlPersonWhere" ]))
          {
              $where=$this->ItemData[ $data ][ "SqlPersonWhere" ];
          }
      }
      elseif ($this->LoginType=="Public")
      {
          if (isset($this->ItemData[ $data ][ "SqlPublicWhere" ]))
          {
              $where=$this->ItemData[ $data ][ "SqlPublicWhere" ];
          }
      }

      if ($where=="")
      {
          $where=$this->ItemData[ $data ][ "SqlWhere" ];
      }

      $loginid=(int)$this->LoginID;
      $where=preg_replace('/#LoginID/',$loginid,$where);

      return $where;
  }

  function SetSqlObjectDataDefs($data)
  {
      if ($this->ItemData[ $data ][ "SqlObject" ]!="")
      {
          $object=$this->ItemData[ $data ][ "SqlObject" ];
          foreach ($object->Object->ItemData as $id => $rdata)
          {
              $this->ItemData[ $data."_".$data ]=$object->ItemData[ $rdata ];
          }
      }
  }


  function InitSqlObject($data)
  {
      $class=$this->ItemData[ $data ][ "SqlClass" ];

      return $this->LoadSubModuleVars($data,$class);
  }

  function LoadSubModuleVars($data,$class)
  {
      if (empty($this->ApplicationObj->SubModulesVars [ $class ])) { return FALSE; }

      foreach ($this->ApplicationObj->SubModulesVars [ $class ] as $key => $value)
      {
          if (empty($this->ItemData[ $data ][ $key ]))
          {
              $this->ItemData[ $data ][ $key ]=$value;
          }
      }

      return TRUE;
  }




  function DataKeyHash($key)
  {
      $list=array();
      foreach ($this->ItemData as $data => $hash)
      {
          $list[ $data ]=$hash[ $key ];
      }

      return $list;
  }

  function DataKeys()
  {
      $list=array();
      foreach ($this->ItemData as $data => $hash)
      {
          array_push($list,$data);
      }

      return $list;
  }

  function Datas2Datas($datas)
  {
      $rdatas=array();
      foreach ($datas as $data)
      {
          if (!empty($this->ItemData[ $data ]))
          {
              array_push($rdatas,$data);
          }
      }

      return $rdatas;
  }

  function GetDataTitle($data,$nohtml=0)
  {
      if (is_array($data)) { $data=array_shift($data); }
      
      $title="";
      if ($data=="No")
      {
          $title="No";
      }
      elseif (preg_match('/^text_/',$data))
      {
          return "";
      }
      elseif (!empty($this->ItemFieldMethods[ $data ]))
      {
          $method=$this->ItemFieldMethods[ $data ];
          return $this->$method();
      }
      elseif (isset($this->ItemDerivedData[ $data ]))
      {
          if ($this->ItemDerivedData[ $data ][ $this->TitleKeyName ]!="")
          {
              $title=$this->GetRealNameKey($this->ItemDerivedData[ $data ],$this->TitleKeyName);
          }
      }
      elseif (isset($this->ItemData[ $data ]))
      {
          $itemdata=$this->ItemData[ $data ];
          if (!empty($itemdata[ $this->TitleKeyShortName ]))
          {
              $title=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyShortName);
          }
          elseif (!empty($itemdata[ $this->TitleKeyName ]))
          {
              $title=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyName);
          }
          elseif (!empty($itemdata[ $this->TitleKeyTitle ]))
          {
              $title=$this->GetRealNameKey($this->ItemData[ $data ],$this->TitleKeyTitle);
          }
      }
      elseif (isset($this->Actions[ $data ]))
      {
          $action=$this->Actions[ $data ];
          return "";
          if (!empty($action[ $this->TitleKeyName ]))
          {
              $title=$this->GetRealNameKey($this->Actions[ $data ],$this->TitleKeyName);
          }
      }
      elseif (method_exists($this,$data))
      {
          $title=$this->$data();

          if (is_array($title)) { $title=""; }
      }
      else
      {
          $comps=preg_split('/_/',$data);
          if (count($comps)>1)
          {
              $pridata=array_shift($comps);
              $secdata=join("_",$comps);

              if (isset($this->ItemData[ $pridata ]) && is_array($this->ItemData[ $pridata ]))
              {
                  if ($this->ItemData[ $pridata ][ "SqlObject" ]!="")
                  {
                      $object=$this->ItemData[ $pridata ][ "SqlObject" ];
                      $title=
                          $this->GetDataTitle($pridata,$nohtml).", ".
                          $this->$object->GetDataTitle($secdata,$nohtml);
                  }
              }
          }
      }

      if ($title=="") { $title=$data; }

      return $title;
  }

  function DecorateDataTitle($name,$title="")
  {
      return $this->Span($name,array("CLASS" => 'datatitlelink',"TITLE" => $title)); 
  }

  function DecoratedDataTitle($data,$includecolon=FALSE)
  {
      $title=$this->GetDataTitle($data);

      if ($includecolon) { $title.=":"; }

      return $this->DecorateDataTitle($title);
    
  }


  function GetDataTitles($datas,$nohtml=0)
  {
      $titles=array();
      for ($n=0;$n<count($datas);$n++)
      {
          $titles[$n]=$this->GetDataTitle($datas[$n],$nohtml);
      }

      return $titles;
  }


  function DataHash2File($itemdata,$file)
  {
      $keys=array();
      foreach ($itemdata as $data => $hash)
      {
          foreach ($hash as $key => $value)
          {
              if (!preg_grep("/^$key$/",$keys)) { array_push($keys,$key); }
          }
      }

      $lines=array();
      foreach ($itemdata as $data => $hash)
      {
          for ($n=0;$n<count($keys);$n++)
          {
              $value=$hash[ $keys[ $n ] ];
              $type="Scalar";
              if (is_array($value))
              {
                  $value='("'.join('","',$value).'")';
                  $type="List";
              }
              array_push($lines,$data."\t".$type."\t".$keys[ $n ]."\t".$value."\n");
          }
      }

      $this->MyWriteFile($file,$lines);
  }

  function WriteDataFiles()
  {
      $this->DataHash2File($this->ItemData,"Data/".$this->ModuleName.".Data.txt");
      $this->DataHash2File($this->ItemDataGroups,"Data/".$this->ModuleName.".Groups.txt");
  }

  function DataFile2Hash($file)
  {
      $lines=$this->MyReadFile($file);

      $itemdata=array();
      for ($n=0;$n<count($lines);$n++)
      {
          $lines[$n]=chop($lines[$n]);
          $comps=preg_split('/\t/',$lines[$n]);
          $data=array_shift($comps);
          $type=array_shift($comps);
          $key=array_shift($comps);
          $value=join("\t",$comps);


          if (!is_array($itemdata[ $data ]))
          {
              $itemdata[ $data ]=array();
          }

          if ($type=="List")
          {
              $value=preg_replace('/^\("/',"",$value);
              $value=preg_replace('/"\)$/',"",$value);
              $value=preg_split('/","/',$value);
          }

          $itemdata[ $data ][ $key ]=$value;
      }

      return $itemdata;
  }
                    
  function ReadDataFiles()
  {
      $this->ItemData=$this->DataFile2Hash("Data/".$this->ModuleName.".Data.txt");
      $this->ItemDataGroups=$this->DataFile2Hash("Data/".$this->ModuleName.".Groups.txt");
  }


  function DefineItemData($itemdata)
  {
      $table=array();
      $keys=array();
      foreach ($itemdata as $data => $hash)
      {
          if (!preg_match('/^[ACM]Time$/',$data))
          {
              array_push($table,array($this->H(3,$data)));
              if (count($keys)==0) { $keys=array_keys($hash); }
              for ($n=0;$n<count($keys);$n++)
              {
                  $fieldname=$data."_".$keys[$n];

                  $value=$hash[ $keys[$n] ];
                  if (preg_grep('/^'.$keys[$n].'$/',$this->StringVars))
                  {
                      $value=$this->MakeInput($fieldname,$value,strlen($value));
                  }
                  elseif (preg_grep('/^'.$keys[$n].'$/',$this->BoolVars))
                  {
                      $bools=array("0","1");
                      $value=$this->MakeSelectField($fieldname,$bools,$bools,$value);
                  }
                  elseif (is_array($value))
                  {
                      $value=join(",",$value);
                  }
                  array_push($table,array($n+1,"<B>".$keys[$n]."</B>",$value));
              }
          }
      }

      print
          $this->H(1,"Dados do ".$this->ItemName).
          $this->HtmlTable("",$table);
  }

  function DefineDataForm()
  {
      $this->DefineItemData($this->ItemData);
  }

    //*
    //* function NonDerivedData, Parameter list: $datas=array()
    //*
    //* Detects which data to actually read.
    //*

    function NonDerivedData($datas=array())
    {
        if (count($datas)==0)
        {
            $datas=array_keys($this->ItemData);
        }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (
                isset($this->ItemData[ $data ])
                &&
                is_array($this->ItemData[ $data ])
                &&
                empty($this->ItemData[ $data ][ "Derived" ])
               )
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }


    //*
    //* function FindDatasToRead, Parameter list: $datas=array(),$nosearches=FALSE,$sep=""
    //*
    //* Detects which data to actually read.
    //*

    function FindDatasToRead($datas=array(),$nosearches=FALSE,$sep="")
    {
        if (count($datas)==0)
        {
            $group=$this->GetActualDataGroup();
            $datas=$this->GetGroupDatas($group);

            if (
                isset($this->ItemDataGroups[ $group ])
                &&
                count($this->ItemDataGroups[ $group ][ "SubTable" ])>0
               )
            {
                $subdatas=$this->CheckHashKeysArray
                (
                   $this->ItemDataGroups[ $group ][ "SubTable" ],
                   array($this->Profile."_Data",$this->LoginType."_Data","Data")
                );

                $count=$this->ItemDataGroups[ $group ][ "SubTable" ][ "Max" ];
                for ($i=1;$i<=$count;$i++)
                {
                    $crow=array();
                    foreach ($subdatas as $data)
                    {
                        array_push($datas,$data.$sep.$i);
                    }
                }
            }
        }

        if (!$nosearches)
        {
            $datas=$this->AddSearchVarsToDataList($datas);
        }

        $this->SortVars2DataList($datas);

        //Always read IDs
        if (!preg_grep('/^ID$/',$datas))
        {
            array_unshift($datas,"ID");
        }

        //Other data that we should always read - to be set by specific module
        foreach ($this->AlwaysReadData as $id => $data)
        {
            if (!preg_grep('/^'.$data.'$/',$datas)) { array_unshift($datas,$data); }
        }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if (
                isset($this->ItemData[ $data ])
                &&
                is_array($this->ItemData[ $data ])
                &&
                empty($this->ItemData[ $data ][ "Derived" ])
               )
            {
                if (empty($this->ItemFieldMethods[ $data ]))
                {
                    array_push($rdatas,$data);
                }
            }
        }

        $this->DatasRead=$rdatas;

        return $rdatas;
    }

    //*
    //* function Hash2ItemData, Parameter list: $hashdata,$datakey
    //*
    //* Adds hash data in $hashdata to $this->ItemData with prekey $datakey.
    //* If $hashdata is a string, tries to read item hashes from this as a file.
    //*

    function Hash2ItemData($hashdata,$datakey,$filterhash=array())
    {
        if (!is_array($hashdata))
        {
            $hashdata=$this->ReadPHPArray($hashdata);
        }

        if (!preg_match('/_$/',$datakey)) { $datakey.="_"; }

        $rdatas=array();
        foreach ($hashdata as $data => $datadef)
        {
            $key=$datakey.$data;
            $this->ItemData[ $key ]=$this->FilterHashKeys($datadef,$filterhash);

            array_push($rdatas,$key);
        }

        return $rdatas;
    }

    //*
    //* function HashList2ItemData, Parameter list: $hashdata,$datakey,$ndata
    //*
    //* Adds $ndata copies of each of the data defined in $hashdata to 
    //* $this->ItemData.
    //* If $hashdata is a string, tries to read item hashes from this as a file.
    //*

    function HashList2ItemData($hashdata,$datakey,$ndata,$filterhash=array(),$newline=0)
    {
        if (!is_array($hashdata))
        {
            $hashdata=$this->ReadPHPArray($hashdata);
        }

        if (!preg_match('/_$/',$datakey)) { $datakey.="_"; }

        $rdatas=array();
        for ($n=1;$n<=$ndata;$n++)
        {
            $rfilterhash=$filterhash;
            foreach ($rfilterhash as $key => $value)
            {
                $rfilterhash[ $key ].=" ".$n;
            }
            $rfilterhash[ "N" ]=$n;

            foreach ($hashdata as $data => $datadef)
            {
                $key=$datakey.$n."_".$data;
                $this->ItemData[ $key ]=$this->FilterHashKeys($datadef,$rfilterhash);
                foreach (array("Title","Name","ShortName") as $rdata)
                {
                    if (empty($this->ItemData[ $key ][ $rdata ])) { continue; }

                    $this->ItemData[ $key ][ $rdata ]=
                        preg_replace('/#N/i',$n,$this->ItemData[ $key ][ $rdata ]);
                }

                array_push($rdatas,$key);
            }

            if ($newline>0)
            {
                array_push($rdatas,"newline(".$newline.")");
            }
        }

        return $rdatas;
    }


    //*
    //* function FindAllowedData, Parameter list: $edit=0,$datas=array(),$item=array()
    //*
    //* Returns list of data allowed to read ($edit=0) or write ($edit=1), in $datas.
    //*
    //* If $datas is empty, uses all data. Calls MyMod_Data_Access.
    //*
    //* $item is transfered when calling MyMod_Data_Access, for item particular permissions.
    //*

    function FindAllowedData($edit=0,$datas=array(),$item=array())
    {
        if (empty($datas)) { $datas=array_keys($this->ItemData()); }

        $item=array();

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            $access=$this->MyMod_Data_Access($data,$item);
            if ($access>$edit)
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }

    //*
    //* Returns data defined in $this->ItemData that are not ReadOnly.
    //*

    function GetNonReadOnlyData()
    {
        //27/01/2012 $this->PostProcessItemData();
        $datas=array_keys($this->ItemData);
        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            if ($this->ItemData[ $data ][ "ReadOnly" ]) {}
            else
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
   }

    //*
    //* function ListOfItemDataWithKeysValues, Parameter list: $valueshash,$datas=NULL
    //*
    //* Returns list of item data keys, where the keys in $valueshash
    //* matches regex in $value. $valueshash is ass. array: $key => $value,...
    //* If $datas is NULL or non-array, $datas is set to all data:
    //* array_keys($this->ItemData).
    //*

    function ListOfItemDataWithKeysValues($valueshash,$datas=NULL,$revert=TRUE)
    {
        if (!$datas || !is_array($datas)) { $datas=array_keys($this->ItemData); }

        $rdatas=array();
        foreach ($datas as $id => $data)
        {
            $include=TRUE;
            foreach ($valueshash as $key => $regex)
            {
                if ($revert)
                {
                    if (!preg_match('/'.$regex.'/',$this->ItemData[ $data ][ $key ]))
                    {
                        $include=FALSE;
                        break;
                    }
                }
                else
                {
                    if (preg_match('/'.$regex.'/',$this->ItemData[ $data ][ $key ]))
                    {
                        $include=FALSE;
                        break;
                    }
                }
            }

            if ($include)
            {
                array_push($rdatas,$data);
            }
        }

        return $rdatas;
    }

    //*
    //* function IntIsDefined, Parameter list: $id
    //*
    //* Tests whether ID is deined and an integer.
    //*

    function IntIsDefined($id)
    {
        $res=FALSE;
        if (!empty($id) && preg_match('/^\d+$/',$id))
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* function GetFileFields, Parameter list: 
    //*
    //* Returns list of data defined as file fields.
    //*

    function GetFileFields()
    {
        $datas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->MyMod_Data_Access($data)>0)
            {
                if ($this->ItemData[ $data ][ "Sql" ]=="FILE")
                {
                    array_push($datas,$data);
                }
            }
        }

        return $datas;
    }
    //*
    //* function GetFileFields, Parameter list: 
    //*
    //* Returns list of data defined as file fields.
    //*

    function GetFileFieldDatas()
    {
        $datas=array();
        foreach ($this->GetFileFields() as $data)
        {
            array_push($datas,$data);
            foreach (array_keys($this->Sql_Table_Fields_File_Datas()) as $key)
            {
                array_push($datas,$data,$data."_".$key);
            }
        }

        return $datas;
    }
}
?>