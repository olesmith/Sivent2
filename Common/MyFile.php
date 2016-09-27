<?php

trait MyFile
{
    var $Files_Incomplete=array();
    
    //**
    //** function MyFile_Read, Parameter list: $file,$regex=""
    //**
    //** Reads file $file, returns array with lines read.
    //** 
    //**

    function MyFile_Read($file,$regex="")
    {
        $lines=file($file);

        if (!empty($regex))
        {
            $lines=preg_grep('/'.$regex.'/',$lines);
        }

        return $lines;
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
        $text=preg_grep('/\S/',$text);
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
            array_unshift($text,"array","(");
            array_push($text,");");
            $this->Files_Incomplete[ $file ]=TRUE;
        }
        
        if (!eval('$hash='.join("",$text).";\nreturn 1;"))
        {
            $text=preg_replace('/\n/',"<BR>",$text);

            echo "Error from eval of file: ".$file."<BR>".join("",$text);
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
        if (file_exists($file))
        {
            return $this->MyFile_Write($file,$text,'a');
        }
        else
        {
            return $this->MyFile_Write($file,$text,'w');
        }
    }
}

?>