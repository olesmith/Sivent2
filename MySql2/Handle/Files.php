<?php


class HandleFiles extends HandleDownload
{
    var $FilesShowDatas=array("No","Edit","Name");

  //*
  //* function HandleFiles, Parameter list: 
  //*
  //* Handles Module file processing
  //*

  function HandleFiles()
  {
      return $this->ShowTree();

        $this->ReadItems("",$this->GetFileFieldDatas(),FALSE,FALSE,0,TRUE);
        $title="";

        //No processing if ($this->GetPOST("Process")==1)
        if (FALSE)
        {
             $this->DoFiles();
             $title="Processar";
        }

        $datas=array_merge
        (
           $this->ZipShowDatas,
           $this->GetFileFields()
        );

        echo 
            $this->SearchVarsTable
            (
               array("DataGroups"),
               "",
               "Files",
               array(),
               array(),
               "",
               "",
               array
               (
                //No processing $this->Button("submit","Process",array("NAME" => "Process","VALUE" => 1))
               )
            ).
            $this->H(1,$title." Arquivos, ".count($this->ItemHashes)." ".$this->ItemsName).
            $this->PagingHorisontalMenu().
            $this->ItemsHtmlTable
            (
               "",
               0,
               $datas
            ).
            "";
  }
  //*
  //* function DoFiles, Parameter list: 
  //*
  //* Will do the actual file processing on searched items.
  //*

  function DoFiles()
  {
      $this->ProcessFiles();
  }


  //*
  //* function , Parameter list: 
  //*
  //* Will do the actual zipping on searched items.
  //*

  function ProcessFiles()
  {
      foreach ($this->ItemHashes as $id => $item)
      {
          foreach ($this->GetFileFields() as $filefield)
          {
              $file=$item[ $filefield ];

              if (file_exists($file))
              {
                  $fmtime=filemtime($file);
                  $dbmtime=$this->MySqlItemValue("","ID",$item[ "ID" ],$filefield."_Time");
                  if ($fmtime>$dbmtime)
                  {
                      var_dump($file.": f ".$fmtime.": db ".$dbmtime);
                      $this->SaveFileContents2DB($item,$file,$filefield);
                  }

                  $rfilefield=$filefield."_Time";
                  $this->MySqlSetItemValue
                  (
                     "",
                     "ID",
                     $item[ "ID" ],
                     $rfilefield,
                     $fmtime
                  );

                  $rfilefield=$filefield."_Size";
                  $this->MySqlSetItemValue
                  (
                     "",
                     "ID",
                     $item[ "ID" ],
                     $rfilefield,
                     filesize($file)
                  );
              }
          }
      }
  } 

 
    //*
    //* function ShowTree, Parameter list: 
    //*
    //* Shows disc files - for removal
    //*

    function ShowTree()
    {
        $path=$this->GetPOST("Path");
        if (empty($path)) { $path="Uploads"; }
        $buttons=$this->MakeButtons
        (
           array
           (
              array
              (
                 "Type" => "submit",
                 "Title" => "Pesquisar",
              ),
              array
              (
                 "Type" => "submit",
                 "Title" => "DELETAR",
              ),
           )
        );
        echo
            $this->StartForm().
            $this->H(1,"Path: ".$this->MakeInput("Path",$path,25)).
            $this->H(2,"Files in: '".$path."'").
            $buttons.
            $this->Html_Table
            (
               "",
               $this->PadTable
               (
                  $this->TreeTable($path)
               ),
               array(),
               array(),
               array(),
               TRUE,TRUE
            ).
            $buttons.
            $this->MakeHidden("GO",1).
            $this->EndForm().
            "";
        return 1;
    }

    //*
    //* function TreeTable, Parameter list: $path,$table=array(),$prencells=0
    //*
    //* Creates table listing files.
    //*

    function TreeTable($path,$table=array(),$prencells=0)
    {
        array_push($table,$this->SubdirRow($path));
        $this->Subdirs2Table($path,$table,$prencells);
        $this->Files2Table($path,$table,$prencells);
        
        return $table;
    }

    //*
    //* function Subdirs2Table, Parameter list: $path,$table,$prencells=0
    //*
    //* Adds subdirs to $table.
    //*

    function Subdirs2Table($path,&$table,$prencells=0)
    {
        $subdirs=$this->DirSubdirs($path);
        sort($subdirs);

        foreach ($subdirs as $subdir)
        {
            array_push($table,$this->SubdirRow($subdir));


            $includetree=$this->GetPOST("Include_".$subdir);
            if ($includetree==1)
            {
                $table=$this->TreeTable($path."/".basename($subdir),$table,$prencells++);
            }
        }
        

        return $table;
    }

    //*
    //* function Files2Table, Parameter list: $path,$table,$prencells
    //*
    //* Adds files to $table.
    //*

    function Files2Table($path,&$table,$prencells)
    {
        $files=$this->DirFiles($path);
        sort($files);

        if (count($files)==0) { return; }

        array_push
        (
           $table,
           $this->FilesTitleRow($path,$prencells)
        );

        $comps=preg_split('/\//',$path);
        foreach ($files as $file)
        {
            array_push($table,$this->FileRow($file,$prencells));
        }
        

        return $table;
    }


    //*
    //* function SubdirRow, Parameter list: $subdir,$prencells=0
    //*
    //* Creates subdir row of file system info
    //*

    function SubdirRow($subdir,$prencells=0)
    {
        $row=array($this->MultiCell("",$prencells),$subdir);
        
        $row=array_merge($row,$this->NodeInfoRow($subdir));

        array_push($row,$this->DirIncludeBox($subdir));
        array_push($row,$this->DirChooseAllBox($subdir));

        return $row;
    }

    //*
    //* function FilesTitleRow, Parameter list: $file,$prencells=0
    //*
    //* Creates file row of file system info
    //*

    function FilesTitleRow($file,$prencells=0)
    {
        $row=array($this->MultiCell("",$prencells),"","File Name");

        $row=array_merge($row,$this->NodeInfoTitleRow($file));

        array_push($row,"Deletar");

        return $this->B($row);
    }
    //*
    //* function FileRow, Parameter list: $file,$prencells=0
    //*
    //* Creates file row of file system info
    //*

    function FileRow($file,$prencells=0)
    {
        $row=array($this->MultiCell("",$prencells),"",basename($file));

        $row=array_merge($row,$this->NodeInfoRow($file));

        array_push($row,$this->NodeDeleteBox($file));

        return $row;
    }

    //*
    //* function NodeInfoRow, Parameter list: $node
    //*
    //* Creates $node cells of file system info
    //*

    function NodeInfoRow($node)
    {
        $bool=array("N","Y");
        return array
        (
           date("d/m/Y H:i:s.",filectime($node)),
           date("d/m/Y H:i:s.",filemtime($node)),
           $this->NodePerms($node),
           posix_getpwuid(fileowner($node))[ "name" ],
           posix_getgrgid(filegroup($node))[ "name" ],
           $bool[ is_writable($node) ]
        );
    }

    //*
    //* function NodeInfoTitleRow, Parameter list: 
    //*
    //* Creates $node title row of file system info
    //*

    function NodeInfoTitleRow($node)
    {
        return
            $this->B
            (
               array
               (
                  "Created",
                  "Modified",
                  "Perms",
                  "User",
                  "Group",
                  "Writeable"
               )
            );
    }

    //*
    //* function NodePerms, Parameter list: $node
    //*
    //* Returns readable permissions info (UNIX format)
    //*

    function NodePerms($node)
    {
        $perms=fileperms($node);

        if (($perms & 0xC000) == 0xC000)
        {
            // Socket
            $info = 's';
        }
        elseif (($perms & 0xA000) == 0xA000) 
        {
            // Link simbólico
            $info = 'l';
        }
        elseif (($perms & 0x8000) == 0x8000) 
        {
            // Regular
            $info = '-';
        }
        elseif (($perms & 0x6000) == 0x6000) 
        {
            // Bloco especial
            $info = 'b';
        }
        elseif (($perms & 0x4000) == 0x4000) 
        {
            // Diretório
            $info = 'd';
        }
        elseif (($perms & 0x2000) == 0x2000) 
        {
            // Caractere especial
            $info = 'c';
        }
        elseif (($perms & 0x1000) == 0x1000) 
        {
            // FIFO pipe
            $info = 'p';
        }
        else
        {
            // Desconhecido
            $info = 'u';
        }

        // Proprietário
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ?
                    (($perms & 0x0800) ? 's' : 'x' ) :
                    (($perms & 0x0800) ? 'S' : '-'));

        // Grupo
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ?
                    (($perms & 0x0400) ? 's' : 'x' ) :
                    (($perms & 0x0400) ? 'S' : '-'));

        // Outros
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ?
                    (($perms & 0x0200) ? 't' : 'x' ) :
                    (($perms & 0x0200) ? 'T' : '-'));

        return $info;
    }

    //*
    //* function DirIncludeBox, Parameter list: $node
    //*
    //* Creates node delete check box.
    //*

    function DirIncludeBox($node)
    {
        $checked=FALSE;
        $includetree=$this->GetPOST("Include_".$node);
        if ($includetree==1)
        {
            $checked=TRUE;
        }
        
        return
            $this->MakeCheckBox("Include_".$node,1,$checked);
    }

    //*
    //* function DirChooseAllBox, Parameter list: $node
    //*
    //* Creates node choose all (files) check box.
    //*

    function DirChooseAllBox($node)
    {
        $checked=FALSE;
        $includetree=$this->GetPOST("Choose_".$node);
        if ($includetree==1)
        {
            $checked=TRUE;
        }
        
        return
            $this->MakeCheckBox("Choose_".$node,1,$checked);
    }

    //*
    //* function NodeDeleteBox, Parameter list: $node
    //*
    //* Creates node delete check box.
    //*

    function NodeDeleteBox($node)
    {
        $dir=preg_replace('/\/[^\/]+$/',"",$node);

        $dirchecked=FALSE;
        $includetree=$this->GetPOST("Choose_".$dir);

        if ($includetree==1)
        {
            $dirchecked=TRUE;
        }

        $update=$this->GetPOST("GO");
        $key="Delete_".preg_replace('/\./',"_",$node);
        $delete=$this->GetPOST($key);


        if ($update && $dirchecked && $delete && !empty($_POST[ $key ]))
        {
            unlink($node);
            return "Deleted";
        }

        return
            $this->MakeCheckBox("Delete_".$node,1,$dirchecked);
    }
}

?>