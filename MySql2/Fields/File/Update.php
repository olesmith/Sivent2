<?php

class FileFieldsUpdate extends FileFieldsStructure
{
    //*
    //* function CorrectFileData, Parameter list: $item
    //*
    //* Update fields Type, Campus and Shift, from disc $item[ "Discipline_Pref" ].
    //*

    function CorrectFileData($item)
    {
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->ItemData[ $data ][ "Sql" ]=="FILE" && empty($this->ItemData[ $data ][ "Iconify" ]))
            {
                $contents=$this->Sql_Select_Hash_Value($item[ "ID" ],$data."_Contents");

                if (!empty($contents))
                {
                    $contents=$this->DB2FileContents($contents);
                    
                    $file=$this->Sql_Select_Hash_Value($item[ "ID" ],$data);
                    $file=$this->GetUploadPath()."/".basename($file);

                    $this->MyFile_Write($file,$contents);

                    $item[ $data ]=$file;
                    $item[ $data."_Contents" ]="";
                    $this->Sql_Update_Item_Values_Set(array($data,$data."_Contents"),$item);
                    var_dump("Item ".$item[ $data ]." moved to file system");
                }
               
            }
        }
    }
    
    //*
    //* Returns file field allowed extensions.
    //*

    function FileFieldExtensions($data)
    {
        $extensions=$this->ItemData[ $data ][ "Extensions" ];
        if (!is_array($extensions)) { $extensions=array($extensions); }

        return $extensions;
    }
        

  //*
  //* function FileContents2DB, Parameter list: $file
  //*
  //* Returns properly formatted version of file contents.
  //*

  function FileContents2DB($file)
  {
      $fp      = fopen($file, 'r');
      $content = fread($fp, filesize($file));
      fclose($fp);

      if (empty($content)) { return $content; }
      
      return 
          strtr
          (
             base64_encode
             (
                addslashes
                (
                   gzcompress( serialize($content) , 9)
                )
             ),
             '+/=',
             '-_,'
           );
  }

  //*
  //* function DB2FileContents, Parameter list: $content
  //*
  //* Reverses db file content encodings.
  //*

  function DB2FileContents($content)
  {
      if (empty($content)) { return $content; }
      
      return unserialize
      (
         gzuncompress
         (
            stripslashes
            (
               base64_decode
               (
                  strtr($content,'-_,', '+/=')
               )
            )
         )
      );
  }

  //*
  //* function SaveFileContents2DB, Parameter list: &$item,$file,$filefield
  //*
  //* Returns properly formatted version of file contents.
  //*

  function SaveFileContents2DB(&$item,$file,$filefield)
  {
      $rfilefield=$filefield."_Contents";
      $this->MySqlSetItemValue
      (
         "",
         "ID",
         $item[ "ID" ],
         $rfilefield,
         $this->FileContents2DB($file)
      );

      $rfilefield=$filefield."_Time";
      $item[ $rfilefield ]=time();
      $this->MySqlSetItemValue
      (
         "",
         "ID",
         $item[ "ID" ],
         $rfilefield,
         $item[ $rfilefield ]
      );

      $rfilefield=$filefield."_Size";
      $item[ $rfilefield ]=filesize($file);
      $this->MySqlSetItemValue
      (
         "",
         "ID",
         $item[ "ID" ],
         $rfilefield,
         $item[ $rfilefield ]
      );
  }
}

?>