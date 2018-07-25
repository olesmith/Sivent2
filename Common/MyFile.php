<?php

trait MyFile
{
    var $Files_Incomplete=array();
    var $Files_Logging=0;
    
    //**
    //** function MyFile_Exists, Parameter list: $file
    //**
    //** Returns true if file exists, false otherwise.
    //** 
    //**

    function MyFile_Exists($file)
    {
        return file_exists($file);
    }

    //**
    //** function MyFile_Read, Parameter list: $file,$regex=""
    //**
    //** Reads file $file, returns array with lines read.
    //** 
    //**

    function MyFile_Read($file,$regex="")
    {
        if (!$this->MyFile_Exists($file))
        {
            var_dump("MyFile_Read: File ".$file." noninexistent");
            return array();
        }
        
        $lines=file($file);

        if (!empty($regex))
        {
            $lines=preg_grep('/'.$regex.'/',$lines);
        }

        return $lines;
    }

    //**
    //** function MyFiles_Read, Parameter list: $files,$regex=""
    //**
    //** Reads file $file, returns array with lines read.
    //** 
    //**

    function MyFiles_Read($files,$regex="")
    {
        $text="";
        foreach ($files as $file)
        {
            if (is_file($file))
            {
                $text.=join("",$this->MyReadFile($file,$regex));
            }
        }

        return $text;
    }

    //**
    //** function MyFiles_Read, Parameter list: $files,$regex=""
    //**
    //** Reads file $file, returns array with lines read.
    //** 
    //**

    function MyFiles_Read_Lines($files,$regex="")
    {
        $lines=array();
        foreach ($files as $file)
        {
            if (is_file($file))
            {
                $lines=array_merge($lines,file($file));
            }
        }

        foreach (array_keys($lines) as $id)
        {
            $lines[ $id ]=preg_replace('/\n$/',"",$lines[ $id ]);
        }
        
        return preg_grep('/\S/',$lines);
    }


    //**
    //** function ReadPHPArray, Parameter list: $file,&$rhash=array()
    //**
    //** Read array from file. Read as a php var, and use eval to create hash.
    //** 
    //**

    function ReadPHPArray($file,&$rhash=array(),$includes=TRUE)
    {
        if (!file_exists($file))
        {
            $this->DoDie("No such file: $file");
        }

        $text=$this->MyFile_Read($file);
        #$text=preg_grep('/\S/',$text);
        $text=preg_grep('/<\?php/',$text,PREG_GREP_INVERT);
        $text=preg_grep('/\?>/',$text,PREG_GREP_INVERT);
        $text=preg_grep('/(<<<<<|>>>>>|======)/',$text,PREG_GREP_INVERT);

        
        if ($includes )
        {
            $rtext=$text;
            $text=array();
            foreach ($rtext as $id => $line)
            {
                array_push($text,$line);
            }

            for ($n=0;$n<count($text);$n++)
            {
                if (preg_match('/^\s+\"include_file\" => \"(\S+)\"/',$text[ $n ],$matches))
                {
                    $rfile=$matches[1];
                    $rtext=$this->MyFile_Read($rfile);
                    array_splice($text,$n,1,$rtext);
                }
            }
        }


        $text=preg_replace('/<\?php/',"",$text);
        $text=preg_replace('/\?>/',"",$text);

        if (
              !preg_match('/^\s*(array|\.php)/',$text[0])
              &&
              !preg_grep('/\$hash/',$text)
           )
        {
            array_unshift($text,"array","(\n");
            array_push($text,");");
            $this->Files_Incomplete[ $file ]=TRUE;
        }

        if (!eval('$hash='.join("",$text).";\nreturn 1;"))
        {
            $text=preg_replace('/\n/',"<BR>",$text);
            for ($n=0;$n<count($text);$n++)
            {
                $text[ $n ]=
                    sprintf("Line %03d: ",$n).
                    $text[ $n ];
            }
        

            echo
                "Error from eval of file: ".$file.
                $this->BR().
                $this->MyFile_Date_Time(filectime($file)).
                $this->BR().
                join("",preg_replace('/\s/',"&nbsp;",$text));
            exit();
            //$this->DoDie("Error from eval of file:",$file,$this->ModuleName,$text);
        }

        if (is_array($rhash))
        {
            foreach ($rhash as $key => $value)
            {
                if (empty($hash[ $key ])) { $hash[ $key ]=$value; }
            }
        }


        if ($this->Files_Logging>0)
        {
            echo $file.": ".count($text)." bytes<BR>";
        }
        
        return $hash;
    }

    //**
    //** function WritePHPArray, Parameter list: $file,$hash=array()
    //**
    //** Writes array to file. Use print_r to dump.
    //** 
    //**

    function WritePHPArray($file,$hash=array())
    {
        $text=print_r($hash,TRUE);
        $this->MyFile_Write($file,$text);

        return $file;
    }

    
    //**
    //** function ExistentPathsFiles, Parameter list: $paths,$files
    //**
    //** Returns combinations of $paths and $files, that exists.
    //** 
    //**

    function ExistentPathsFiles($paths,$files,$debug=FALSE)
    {
        $rfiles=array();
        foreach ($paths as $path)
        {
            foreach ($files as $file)
            {
                if ($debug) { echo $path."/".$file; $res="no"; }

                $rfile=$path."/".$file;
                if (file_exists($rfile) && is_file($rfile))
                {
                    $rfiles[ $rfile ]=1;
                
                    if ($debug) { $res="yes"; }
                }
                
                if ($debug) { echo " ".$res."<BR>"; }
            }
        }

        return array_keys($rfiles);
    }
    
    //**
    //** function MyFile_Write, Parameter list: $file,$text,$mode='w'
    //**
    //** Writes $text to file. Rewrites if called withoud $mode.
    //** 
    //**

    function MyFile_Write($file,$text,$mode='w')
    {
        if (!is_array($text)) { $text=array($text); }

        $FH = fopen($file,$mode);
        if ($FH)
        {
            foreach ($text as $id => $line)
            {
                chop($line);
                fwrite($FH,$line."\n");
            }

            fclose($FH);

            return TRUE;
        }
        else
        {
            $this->DoDie("Error writing (".$mode.") to file: ".$file);
        }
        
        return FALSE;
    }
    
    //**
    //** function MyFile_Append, Parameter list: $file,$text
    //**
    //** Appends $text to file. Calls MyFile_Write with $mode 'a'.
    //** 
    //**

    function MyFile_Append($file,$text)
    {
        if ($this->MyFile_Exists($file))
        {
            return $this->MyFile_Write($file,$text,'a');
        }
        else
        {
            return $this->MyFile_Write($file,$text,'w');
        }
    }
    
    
    //**
    //** function MyFiles_Title_Row, Parameter list: 
    //**
    //** Creates file table title row (list).
    //** 
    //**

    function MyFiles_Title_Row()
    {
        return
            array
            (
                "File",
                "Size (bytes)",
                "Created",
                "Modified",
                "Owner",
                "Group",
                "Permissions",
                "Select File",
            );
    }
    //**
    //** function MyFiles_Title_Rows, Parameter list: 
    //**
    //** Creates file table title rows (matrix).
    //** 
    //**

    function MyFiles_Title_Rows()
    {
        return
            array
            (
                $this->MyFiles_Title_Row(),
            );
    }
    
    //**
    //** function MyFile_CheckBox, Parameter list: $file
    //**
    //** Creates checkbox for file
    //** 
    //**

    function MyFile_CheckBox($file)
    {
        return
            $this->Html_Input_CheckBox_Field
            (
                preg_replace('/\//',"_",$file),
                1,
                True,  #should be false, when select all is funcional again
                False,
                $options=array
                (
                    "CLASS" => "checkbox_1",
                )
            );
    }

    
    //**
    //** function MyFile_Date_Time, Parameter list: 
    //**
    //** Formats date
    //** 
    //**

    function MyFile_Date_Time($date)
    {
        return date("d/m/Y H:i:s",$date);
    }

    
    //**
    //** function MyFile_Row, Parameter list: $file
    //**
    //** Creates row of file info.
    //** 
    //**

    function MyFile_Row($file)
    {
        $userinfo=posix_getpwuid(fileowner($file));
        $groupinfo=posix_getgrgid(filegroup($file));

        return
            array
            (
                basename($file),
                filesize($file),
                $this->MyFile_Date_Time(filectime($file)),
                $this->MyFile_Date_Time(filemtime($file)),
                $userinfo[ "name" ],
                $groupinfo[ "name" ],
                substr(sprintf('%o', fileperms($file)), -4),
                $this->MyFile_CheckBox($file),
            );
    }

    //**
    //** function MyFile_Rows, Parameter list: $file
    //**
    //** Creates rows of file info.
    //** 
    //**

    function MyFile_Rows($file)
    {
        return
            array
            (
                $this->MyFile_Row($file),
            );
    }
    
    //**
    //** function MyFiles_Rows, Parameter list: $files
    //**
    //** Creates table of files info as matrix.
    //** 
    //**

    function MyFiles_Rows($files,$table=array())
    {        
        foreach ($files as $file)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->MyFile_Rows($file)
                );
        }

        return $table;
    }
    
    //**
    //** function MyFiles_Table, Parameter list: $files
    //**
    //** Creates table of file info.
    //** 
    //**

    function MyFiles_Table($files,$table=array())
    {
        if (empty($files))
        {
            return array();
        }
        
        $table=
            array_merge
            (
                $table,
                $this->Html_Table_Head_Rows
                (
                    $this->MyFiles_Title_Rows()
                )
            );
        
        foreach ($files as $file)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->MyFile_Rows($file)
                );
        }

        return $table;
    }

    //**
    //** function MyFiles_Table, Parameter list: $files
    //**
    //** Creates table of file info.
    //** 
    //**

    function MyFiles_HTML($files,$table=array())
    {
        return
            $this->HTML_Table
            (
                $this->MyFiles_Title_Rows(),
                $this->MyFiles_Table($files,$table)
            );
    }

    //**
    //** function MyFile_Writeable, Parameter list: $file
    //**
    //** +Returns true if $file is writeable.
    //** 
    //**

    function MyFile_Writeable($file)
    {
        return is_writeable($file);
    }
    
    //**
    //** function MyFile_Readable, Parameter list: $file
    //**
    //** +Returns true if $file is writeable.
    //** 
    //**

    function MyFile_Readable($file)
    {
        return is_readable($file);
    }
    
    
    //**
    //** function MyFile_Touch, Parameter list: $file
    //**
    //** Creates dir, if createable.
    //** 
    //**

    function MyFile_Touch($file,$tell=False)
    {
        if (!$this->MyFile_Exists($file))
        {
            $path=dirname($file);
            if (!$this->MyFile_Exists($path))
            {
                $this->Dir_Create_AllPaths($path);
            }
            
            if ($this->MyFile_Writeable($path))
            {
                $res=touch($file);
                if ($tell)
                {
                    var_dump
                    (
                        "File ".$file." created: ".$res
                    );
                }
            }
            else
            {
                if ($tell)
                {
                    var_dump
                    (
                        "File ".$file." exists, but is unwritable",
                        "Please run: touch ".$file
                    );
                }
                
                return -1;
            }
        }
        
        return 0;
    }
}

?>