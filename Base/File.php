<?php

class File
{

//**
//** function MyReadFile, Parameter list: $file
//**
//** Reads file $file, returns array with lines read.
//** 
//** Eliminate!!

function MyReadFile($file)
{
    return $this->MyFile_Read($file);
}


//**
//** function MyWriteFile, Parameter list: $file,$lines
//**
//** Writes array $lines back out to file $file.
//** 
//**

function MyWriteFile($file,$lines)
{
    if (!$handle = fopen($file, 'w'))
    {
        echo "Cannot rewrite file ($file)";
        exit;
    }

    if (is_array($lines))
    {
       for ($n=0;$n<count($lines);$n++)
       {
          if (fwrite($handle, $lines[$n]) === FALSE) 
	      {
	          echo "Cannot write to file ($filename)";
	          exit;
	      }
       }
    }
    else
    {
        if (fwrite($handle, $lines) === FALSE) 
    	{
	       echo "Cannot write to file ($filename)";
	       exit;
	    }
    }
  fclose($handle);
}


//**
//** function ReadHash, Parameter list: $file,
//**
//** Reads hash from file $file. Format is:
//**    key: value
//** 
//**

function ReadHash($file)
{
  $lines=$this->MyReadFile($file);

  $hash=array();
  for ($n=0;$n<count($lines);$n++)
  {
      $comps=preg_split('/:/',$lines[$n]);

      if (is_array($comps) && count($comps)>=2)
      {
          $key=array_shift($comps);
          $key=preg_replace('/^\s+/',"",$key);
          $key=preg_replace('/\s+$/',"",$key);

          $comp=join(":",$comps);
          $comp=preg_replace('/^\s+/',"",$comp);
          $comp=preg_replace('/\s+$/',"",$comp);
          $hash[ $key ]=$comp;
      }
  }

  return $hash;
}

//**
//** function WriteHash, Parameter list: $file,$hash
//**
//** Reads hash from file $file. Format is:
//**    key: value
//** 
//**

function WriteHash($file,$hash)
{
  $lines=array();
  foreach ($hash as $var => $value)
  {
      $var=preg_replace('/^\s+/',"",$var);
      $var=preg_replace('/\s+$/',"",$var);

      $value=preg_replace('/^\s+/',"",$value);
      $value=preg_replace('/\s+$/',"",$value);
      $line=$var.": ".$value."\n";
      array_push($lines,$line);
  }

  $this->MyWriteFile($file,$lines);
}

//**
//** function AddHash, Parameter list: $file,$hash
//**
//** Reads hash from file $file. Format is:
//**    key: value
//** 
//**

function AddHash($file,$hash)
{
  $lines=$this->MyReadFile($file);

  for ($n=0;$n<count($lines);$n++)
  {
      $comps=preg_split('/\s*:\s*/',$lines[$n]);
      $comps[1]=preg_replace('/^\s+/',"",$comps[1]);
      $comps[1]=preg_replace('/\s+$/',"",$comps[1]);
      $hash[ $comps[0] ]=$comps[1];
  }

  return $hash;
}

//**
//** function PrintFile, Parameter list: $file,
//**
//** Prints (echo) content of file $file.
//** 
//**

function PrintFile($file,$hash=array())
{
  $lines=$this->MyReadFile($file);


  for ($n=0;$n<count($lines);$n++)
  {
      foreach ($hash as $key => $value)
      {  
          $lines[$n]=preg_replace('/#'.$key.'/',$value,$lines[$n]);
      }
      echo $lines[$n];
  }
}


//**
//** function TransferHashKeys, Parameter list: $source,&$dest
//**
//** Transfers hash keys from one array to another, recursively calling itself,
//** if keys values are hashes. Modifies $dest, returns nothing (void).
//** 
//**

function TransferHashKeys($source,&$dest)
{
    //Check if we are simple array
    if (isset($source[0]))
    {
        //If we are simple array, transfer contents by array_push
        //and return
        if (!is_array($dest)) { $dest=array(); }

        for ($n=0;$n<count($source);$n++)
        {
            array_push($dest,$source[$n]);
        }

        return;
    }

    foreach ($source as $key => $value)
    {
        if (is_array($source[ $key ]))
        {
            if (!isset($dest[ $key ]))
            {
                $dest[ $key ]=array();
            }

            $this->TransferHashKeys($source[ $key ],$dest[ $key ]);
        }
        else
        {
            $dest[ $key ]=$source[ $key ];
        }
    }
}



//**
//** function ReadPHPArrayKeys, Parameter list: $file,&$rhash=array()
//**
//** Read array from file. Read as a php var, and use eval to create hash.
//** 
//**

function ReadPHPArrayKeys($file,&$rhash=array())
{
    return array_keys($this->ReadPHPArray($file,$rhash));
}

//**
//** function ReadPHPText, Parameter list: $file
//**
//** Read array from file. Read as a php var, and use eval to create value to return.
//** 
//**

function ReadPHPText($file)
{
    if (!file_exists($file))
    {
        die("No such file: $file");
    }

    $text=$this->MyReadFile($file);

    $text=preg_grep('/(<<<<<|>>>>>|======)/',$text,PREG_GREP_INVERT);

    $text=preg_replace('/<\?php/',"",$text);
    $text=preg_replace('/\?>/',"",$text);

    $res=eval('$line='.join("",$text).";\nreturn 1;");

    if (!$res)
    {
        $text=preg_replace('/\n/',"<BR>",$text);
        print "Error from eval of file: $file<BR>".join("",$text);

        //var_dump(error_get_last());

        exit();
    }

    return $line;
}

//**
//** function Hash2XML, Parameter list: $hash
//**
//** Converts a hash to XML.
//** 
//**

//Needs to be tested.

function Hash2XML($hash,$pre="")
{
    $text="";
    foreach ($hash as $key => $value)
    {
        $text.=$pre."<".$key.">\n";
        if (!is_array($value))
        {
            $text.=$value;
        }
        $text.=$pre."</".$key.">\n";
    }

    return $text;
}

//**
//** function SearchForFile, Parameter list: $file,
//**
//** Search through search paths comps, trying to locate file $file 
//** 
//**
function SearchForFile($file,$paths=array())
    {
        if (count($paths)==0)
        {
            $paths=get_include_path();
            $paths=explode(":",$paths);
        }

        foreach ($paths as $id => $path)
        {
            $rfile=join("/",array($path,$file));

            if (file_exists($rfile))
            {
                return $rfile;
            }
        }

        $this->AddMsg("Unable to find: $file, ",2,TRUE);
        return FALSE;;
    }

//**
//** function UnlinkFiles, Parameter list: $files,$path=""
//**
//** Unlinks existing and writables files in $files 
//** 
//**
    function UnlinkFiles($files,$path="")
    {
        if ($path!="") { $path.="/"; }

        foreach ($files as $id => $file)
        {
            $rfile=$path.$file;
            if (is_file($rfile) &&
                is_writeable($rfile))
            {
                unlink($rfile);
            }
        }
    }

    //**
    //** function HashIsList, Parameter list: $hash
    //**
    //** Returns TRUE if all keys of $hash contain only the numbers
    //** from 1 to count($hash). Otherwise returns FALSE.
    //** 
    //**

    function HashIsList($hash)
    {
        $keys=array_keys($hash);
        sort($keys,SORT_NUMERIC);

        $res=TRUE;
        for ($i=0;$i<count($keys);$i++)
        {
            if ($i!=$keys[ $i ]) { $res=FALSE; }
        }

        return $res;
    }

    //**
    //** function PHPArray2Text, Parameter list: $hash,$indent=""
    //**
    //** Exports hash as text. Recursively calls itself
    //** feoreach key-value that is again a hash.
    //** 
    //**

    function PHPArray2Text($hash,$indent="")
    {
        $text=
            "array\n".
            $indent."(\n";

        //All keys
        $keys=array_keys($hash);

        //non-Numeric valued keys
        $rkeys=preg_grep('/[^\d]/',$keys);

        foreach ($hash as $key => $value)
        {
            $keyvalue="";
            if (is_array($value))
            {
                $keyvalue=$this->PHPArray2Text($value,$indent."   ").",";
            }
            else
            {
                $keyvalue=$value.',';
            }

            if (count($rkeys)==0)
            {
                $text.=
                    $indent."   ".$keyvalue.
                    "\n";
            }
            else
            {
                $text.=
                    $indent."   '".$key."'".
                    " => ".
                    $keyvalue.
                    "\n";
            }
        }
        $text.=$indent.")";

        return $text;
    }

     //**
    //** function WritePHPArray, Parameter list: $file,
    //**
    //** Read array from file, as a php var.
    //** 
    //**

    function WritePHPArray($file,$hash=array())
    {
        $text=$this->PHPArray2Text($hash).";\n";

        $rtext=preg_replace('/\n/',"<BR>",$text);
        $rtext=preg_replace('/\s/',"&nbsp;",$rtext);
        //print $rtext;

        $text=
            "<?php\n".
            $text.
            //var_export ($hash,TRUE).
            "?>";

        $this->MyWriteFile($file,$text);
    }


    //**
    //** function TrimFileName, Parameter list: $file
    //**
    //** Trims file name, substituting accented chars by plain ones.
    //**

    function TrimFileName($file)
    {
        if (is_array($file)) { $file=join(".",$file); }

        $file=$this->Text2Sort($file);
        $file=$this->Html2Sort($file);

        return preg_replace('/\s+/',"_",$file);
    }
}
?>