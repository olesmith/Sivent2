<?php



global $ClassList;
$ClassList=array("Base","Time");

global $Months_Pt;
$Months_Pt=array("","Jan","Fev","Mar","Abr","Jun","Jul","Ago","Set","Out","Nov","Dez");

global $WDays_Pt;
$WDays_Pt=array
(
    "Dom","Seg","Ter","Qua","Qui","Sex","Sab"
);

global $ToUpperTable;
$ToUpperTable=array
(
        'á'=>'Á', 'é'=>'É', 'í'=>'Í', 'ó'=>'Ó', 'ú'=>'Ú', 
        'à'=>'À', 'è'=>'È', 'ì'=>'Ì', 'ò'=>'Ò', 'ù'=>'Ù',
        'â'=>'Â', 'ê'=>'Ê', 'î'=>'Î', 'ô'=>'Ô', 'û'=>'Û',
        'ã'=>'Ã', 'ë'=>'Ë', 'ï'=>'Ï', 'õ'=>'Õ',
        'ä'=>'Ä', 'ö'=>'Ö', 'ü' => 'Ü',
        'ç'=>'Ç',
        'ý'=>'Ý', 'ý'=>'Ý','ñ'=>'Ñ', 
        'æ'=>'Æ',  'ø'=>'Ø',
        'å'=>'Å',
);

global $ToLowerTable;
$ToLowerTable=array();
foreach ($ToUpperTable as $key => $value)
{
    $ToLowerTable[ $value ]=$key;
}

global $Echo;
$Echo=TRUE;


include_once("../Common/MyCommon.php");



class Base extends Filters
{
    use MyCommon;

    var $ModuleName,$ApplicationName;
    var $Latins=array("","I","II","III","IV","V","VI","VII","VIII","IX","X");

    function Base()
    {
    }

    function InitBase($hash=array())
    {
        if (is_array($hash))
        {
            foreach ($hash as $key => $value)
            {
                //print "Init: $key<BR>";
                $this->$key=$value;
            }
        }
    }

    //*
    //* Initializes whole inheritance chain.
    //* This class, Base, is the bottom class.
    //* Each class inheriting, has the chance to define
    //* and Init.$class function, to be called with
    //* $initdata[ $class ] array.
    //* Init calls each class Init, looping over 
    //* $ClassList (global var).
    //*

    function Init($initdata,$db="")
    {
        global $ClassList;
        foreach ($ClassList as $class)
        {
            if ($class=="MySql" && $db!="")
            {
                $this->DBHash[ "DB" ]=$db;
            }
            $this->DoClassInit($class,$initdata);
        }
    }


    //*
    //* Initializes one class in the inheritance chain.

    function DoClassInit($class,$initdata)
    {
        $initname="Init".$class;
        if (method_exists($this,$initname))
        {
            if (isset($initdata[ $class ]))
            {
                $rhash=$initdata[ $class ];
                if (!is_array($rhash))
                {
                    $rhash=$this->ReadPHPArray($rhash);
                }
                $this->$initname($rhash);
            }
            else
            {
                $this->$initname();
            }
        }
        else { print "Class $class has no initializer<BR>"; }
    }

    //*
    //* Converts hash to php.
    //*

    function Hash2Php($hash)
    {
        $text=array
        (
         '<?php',
         'global $hash;',
         '$hash=array();',
        );
        foreach ($hash as $key => $value)
        {
            array_push($text,"   \$hash[ '".$key."' ]='".$value."';");
        }

        array_push($text,"?>\n");

        $text=join("\n",$text);

        return $text;
    }

    //*
    //* Converts hash to object variables (attributes).
    //*

    function Hash2Object($hash,$obj=NULL)
    {
        if (!$obj) { $obj=$this; }

        foreach ($hash as $key => $value)
        {
            $obj->$key=$value;
        }

        return $obj;
    }


    //*
    //* Adds $item to $list, if $item unique in $list.
    //*

    function AddUniquely2List(&$list,$item)
    {
        if (!preg_grep('/^'.$item.'$/',$list))
        {
            array_push($list,$item);
        }
    }    

  function Text2Sort($text)
  {
    $table = array(
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü' => 'u',
        'ý'=>'y', 'ý'=>'y', 'þ'=>'b','ÿ'=>'y',
        'º'=>'o','ª'=>'a'
    );

    return strtr($text, $table);
  }

  function Swap(&$val1,&$val2)
  {
      $tmp=$val1;
      $val1=$val2;
      $val2=$tmp;
  }

  function Max($n1,$n2)
  {
      if ($n1>=$n2) { return $n1; }
      else          { return $n2; }
  }

  function Min($n1,$n2)
  {
      if ($n1>=$n2) { return $n2; }
      else          { return $n1; }
  }

  function String2Upper($text)
  {
      global $ToUpperTable;
      $text=strtoupper($text);
      return strtr($text,$ToUpperTable);
  }
  function String2Lower($text)
  {
      global $ToLowerTable;
      $text=strtolower($text);
      return strtr($text,$ToLowerTable);
  }

  function Text2Tex($text)
  {
    $table = array(
        'À'=>'\`A',   'Á'=>"\\'A",   'Â'=>'\^A', 'Ã'=>'\~A', 'Ä'=>'\"A', 'Å'=>'{\AA}', 'Æ'=>'{\AE}', 
        'à'=>'\`a',   'á'=>"\\'a",   'â'=>'\^a', 'ã'=>'\~a', 'ä'=>'\"a', 'å'=>'{\aa}', 'æ'=>'{\ae}',

        'Ç'=>'\c{C}', 'È'=>'\`E',    'É'=>"\\'E", 'Ñ'=>'\~N',
        'ç'=>'\c{c}', 'è'=>'\`e',    'é'=>"\\'e", 'ñ'=>'\~n', 

        'Ê'=>'\^E',   'Ë'=>'\"E',    'Ì'=>'\`I', 'Í'=>'I', 'Î'=>'\^I',  'Ï'=>'\"I',
        'ê'=>'\^e',   'ë'=>'\"e',    'ì'=>'\`i', 'í'=>'\\\'{\i}', 'î'=>'\^i',  'ï'=>'\"i',

        'Ò'=>'\`O',   'Ó'=>"\\'O",   'Ô'=>'\^O', 'Õ'=>'\~O',    'Ö'=>'\"O',  'Ø'=>'\O',
        'ò'=>'\`o',   'ó'=>"\\'o",   'ô'=>'\^o', 'õ'=>'\~o',    'ö'=>'\"o',  'ø'=>'\o',

        'Ù'=>'\`U',   'Ú'=>"\\'U",   'Û'=>'\^U', 'Ü'=>'\"U',
        'ù'=>'\`u',   'ú'=>"\\'u",   'û'=>'\^u', 'ü'=>'\"u',
       
        'Ý'=>'\'Y',   'Ỳ'=>"\\'Y",   'Ÿ'=>'\"Y',
        'ý'=>'\`y',   'ỳ'=>"\\'y",   'ÿ'=>'\"y',

        'º'=>'$^o$',  'ª'=>'$^a$', '&#39;' => '\''
    );

    return strtr($text, $table);
  }

  function Html2TextTable()
  {
    return array
    (
        '&Agrave;' => 'À',   '&Aacute;' => 'Á',   '&Acirc;' => 'Â', '&Atilde;' =>'Ã', '&Auml;'=>'Ä',
        '&agrave;' => 'à',   '&aacute;' => "á",   '&acirc;' => 'â', '&atilde;' =>'ã', '&auml;'=>'ä',

        '&Egrave;' => 'È',   '&Eacute;' => 'É',   '&Ecirc;' => 'Ê', '&Etilde;' =>'Ẽ', '&Euml;'=>'Ë',
        '&egrave;' => 'è',   '&eacute;' => "é",   '&ecirc;' => 'ê', '&etilde;' =>'ẽ', '&euml;'=>'ë',

        '&Igrave;' => 'Ì',   '&Iacute;' => 'Í',   '&Icirc;' => 'Î', '&Itilde;' =>'Ĩ', '&Iuml;'=>'Ï',
        '&igrave;' => 'ì',   '&iacute;' => "í",   '&icirc;' => 'î', '&itilde;' =>'ĩ', '&iuml;'=>'ï',

        '&Ograve;' => 'Ò',   '&Oacute;' => 'Ó',   '&Ocirc;' => 'Ô', '&Otilde;' =>'Õ', '&Ouml;'=>'Ö',
        '&ograve;' => 'ò',   '&oacute;' => "ó",   '&ocirc;' => 'ô', '&otilde;' =>'õ', '&ouml;'=>'ö',

        '&Ugrave;' => 'Ù',   '&Uacute;' => 'Ú',   '&Ucirc;' => 'Û', '&Utilde;' =>'Ũ', '&Uuml;'=>'Ü',
        '&ugrave;' => 'ù',   '&uacute;' => "ú",   '&ucirc;' => 'û', '&utilde;' =>'ũ', '&uuml;'=>'ü',

        '&Ygrave;' => 'Ỳ',   '&Yacute;' => 'Ý',   '&Ycirc;' => 'Ŷ', '&Ytilde;' =>'Ỹ', '&Yuml;'=>'Ÿ',
        '&ygrave;' => 'ỳ',   '&yacute;' => "ý",   '&ycirc;' => 'ŷ', '&ytilde;' =>'ỹ', '&yuml;'=>'ÿ',

        '&Aring;' => 'Å', '&Aelig;' => 'Æ',  '&Oslash;'=>'Ø',
        '&aring;' => 'å', '&aelig;' => 'æ',  '&oslash;'=>'ø',

        '&Ccedil;'=>'Ç', '&Ntilde;'=>'Ñ',
        '&ccedil;'=>'ç', '&ntilde;'=>'ñ', 

        '&ordm;'=>'$^o$',  '&ordf;'=>'$^a$'
    );
  }


  function Html2Text($text)
  {
      return strtr($text, $this->Html2TextTable() );
  }

  function Html2SortTable()
  {
    return array
    (
        '&Agrave;' => 'A',   '&Aacute;' => 'A',   '&Acirc;' => 'A', '&Atilde;' =>'A', '&Auml;'=>'A',
        '&agrave;' => 'a',   '&aacute;' => "a",   '&acirc;' => 'a', '&atilde;' =>'a', '&auml;'=>'a',

        '&Egrave;' => 'E',   '&Eacute;' => 'E',   '&Ecirc;' => 'E', '&Etilde;' =>'E', '&Euml;'=>'E',
        '&egrave;' => 'e',   '&eacute;' => "e",   '&ecirc;' => 'e', '&etilde;' =>'e', '&euml;'=>'e',

        '&Igrave;' => 'I',   '&Iacute;' => 'I',   '&Icirc;' => 'I', '&Itilde;' =>'I', '&Iuml;'=>'I',
        '&igrave;' => 'i',   '&iacute;' => "i",   '&icirc;' => 'i', '&itilde;' =>'i', '&iuml;'=>'i',

        '&Ograve;' => 'O',   '&Oacute;' => 'O',   '&Ocirc;' => 'O', '&Otilde;' =>'O', '&Ouml;'=>'O',
        '&ograve;' => 'o',   '&oacute;' => "o",   '&ocirc;' => 'o', '&otilde;' =>'o', '&ouml;'=>'o',

        '&Ugrave;' => 'U',   '&Uacute;' => 'U',   '&Ucirc;' => 'U', '&Utilde;' =>'U', '&Uuml;'=>'U',
        '&ugrave;' => 'u',   '&uacute;' => "u",   '&ucirc;' => 'u', '&utilde;' =>'u', '&uuml;'=>'u',

        '&Ygrave;' => 'Y',   '&Yacute;' => 'Y',   '&Ycirc;' => 'Y', '&Ytilde;' =>'Y', '&Yuml;'=>'Y',
        '&ygrave;' => 'y',   '&yacute;' => "y",   '&ycirc;' => 'y', '&ytilde;' =>'y', '&yuml;'=>'y',

        '&Aelig;' => '{',    '&Oslash;'=>'|',     '&Aring;' => '}', 
        '&aelig;' => '{',    '&oslash;'=>'|',     '&aring;' => '}', 

        '&Ccedil;'=>'C',     '&Ntilde;'=>'N',
        '&ccedil;'=>'c',     '&ntilde;'=>'n', 

        '&ordm;'=>'',        '&ordf;'=>'',
    );
  }


  function Html2Sort($text)
  {
      $text=preg_replace('/&amp;/',"&",$text);
      return strtr($text, $this->Html2SortTable() );
  }



  function InvertHash($hash)
  {
      $ihash=array();
      foreach ($hash as $key => $value)
      {
          $ihash[ $value ]=$key;
      }

      return $ihash;
  }

  function Text2Html($text)
  {
      $table = $this->Html2TextTable();
      $table=$this->InvertHash($table);

      return strtr($text, $table);
  }

  function TrimCase($value)
  {
      $comps=preg_split('/\s+/',$value);
      for ($n=0;$n<count($comps);$n++)
      {
          if (strlen($comps[$n])>2 && !preg_match('/\./',$comps[$n]))
          {
              $comps[$n]=$this->String2Lower($comps[$n]);
              if (preg_match('/^[iIvV]+$/',$comps[$n]))
              {
                  $comps[$n]=$this->String2Upper($comps[$n]);
              }
              elseif (!preg_match('/^(dD?[aeiouAEIOU]s?|von)$/',$comps[$n]))
              {
                  if (preg_match('/^[a-z]/',$comps[$n]))
                  {
                      $comps[$n]=ucfirst($comps[$n]);
                  }
                  elseif (preg_match('/^[A-Z]/',$comps[$n]))
                  {
                  }
                  else
                  {
                      $frst=substr($comps[$n],0,2);
                      $frst=$this->String2Upper($frst);
                      $comps[$n]=$frst.substr($comps[$n],2);
                  }
              }
          }
          elseif (preg_match('/^[dD]?[aeiouAEIOU][sS]?$/',$comps[$n]))
          {
              $comps[$n]=$this->String2Lower($comps[$n]);
          }
          elseif (preg_match('/^[iIvVxXmM]+$/',$comps[$n]))
          {
              $comps[$n]=$this->String2Upper($comps[$n]);
          }
          elseif (preg_match('/^[aAbBcCdD]$/',$comps[$n]))
          {
              $comps[$n]=$this->String2Upper($comps[$n]);
          }
          elseif (preg_match('/^([dn][aeiou]s?|ao?|á)$/',$comps[$n]))
          {
              $comps[$n]=$this->String2Lower($comps[$n]);
          }
      }

      return join(" ",$comps);
  }


    function HashListMinValue($key,$items)
    {
        $min=100000;
        foreach ($items as $id => $item)
        {
            if ($item[ $key ]<$min)
            {
                $min=$item[ $key ];
            }
        }

        return $min;
    }

    function HashListMaxValue($key,$items)
    {
        $max=-100000;
        foreach ($items as $id => $item)
        {
            if ($item[ $key ]>$max)
            {
                $max=$item[ $key ];
            }
        }

        return $max;
    }

    function SortableYear2Year($datestring)
    {
        $year=substr($datestring,0,4);
        $month=substr($datestring,4,2);
        $date=substr($datestring,6,2);
        return $date."/".$month."/".$year;
    }

    function MergeHashes($hash1,$hash2)
    {
        foreach ($hash2 as $key => $value)
        {
            $hash1[ $key ]=$value;
        }

        return $hash1;
    }

    function MergeLists($list1,$list2)
    {
        foreach ($list2 as $key => $value)
        {
            array_push($list1,$value);
        }

        return $list1;
    }


    function RewritePhoneNumber($phone)
    {
        $phone=preg_replace('/[^\d]/',"",$phone);
        $matches=array();
        if (preg_match('/^0*(\d\d)(\d\d\d\d)(\d\d\d\d)$/',$phone,$matches))
        {
            array_shift($matches);
            $matches[0]="(".$matches[0].")";
            $phone=join(" ",$matches);
        }
        elseif (preg_match('/^0*(\d\d\d\d)(\d\d\d\d)$/',$phone,$matches))
        {
            array_shift($matches);
            $phone=join(" ",$matches);
        }

        return $phone;
    }

    function ListPrepend($pre,$list)
    {
        $rlist=array();
        foreach ($list as $id => $value)
        {
            array_push($rlist,$pre.$value);
        }

        return $rlist;
    }

    function List2Lists($nelements,$list)
    {
        $rlist=array();
        $item=array();
        foreach ($list as $id => $value)
        {
            array_push($item,$value);
            if (count($item)>=$nelements)
            {
                array_push($rlist,$item);
                $item=array();
            }
        }

        if (count($item)>0)
        {
            array_push($rlist,$item);
        }

        return $rlist;
    }

    function JoinHashes($hash1,$hash2)
    {
        foreach ($hash2 as $key => $value)
        {
            $hash1[ $key ]=$value;
        }

        return $hash1;
    }

    function Lists2Hash($list1,$list2)
    {
        $hash=array();
        for ($n=0;$n<count($list1);$n++)
        {
            $hash[ $list1[$n] ]=$list2[$n];
        }

        return $hash;
    }

    function GetListKeyValues($key,$list)
    {
        $keys=array();
        foreach (array_keys($list) as $n)
        {
            array_push($keys,$list[$n][$key]);
        }

        return $keys;
    }

    function GetListKeyUniqueValues($key,$list)
    {
        $values=array();
        foreach ($list as $rkey => $value)
        {
            $values[ $value[ $key ] ]=1;
        }

        return array_keys($values);
    }

    function GetListUniqueValues($list)
    {
        $values=array();
        foreach ($list as $key => $value)
        {
            $values[ $value ]=1;
        }


        return array_keys($values);
    }



    function AddToList(&$list,$item)
    {
        if (!$list) { $list=array(); }
        elseif (!is_array($list))
        {
            if ($list!="") { $list=array($list); }
            else           { $list=array(); }
        }

        array_push($list,$item);

        return $list;
    }


    //*
    //* sub ColorCode2Color, Parameter list: $color
    //*
    //* Transforms color in color array.
    //*
    //*

    function ColorCode2Color($color)
    {
        if (!empty($color) && !preg_match('/^#/',$color))
        {
            if (!empty($this->Layout[ $color ]))
            {
                $color=$this->Layout[ $color ];
            }
            elseif (!empty($this->ApplicationObj) && !empty($this->ApplicationObj->Layout[ $color ]))
            {
                $color=$this->ApplicationObj->Layout[ $color ];
            }
        }

        $color=preg_replace('/#/',"",$color);
        $r=hexdec(substr($color,0,2));
        $g=hexdec(substr($color,2,2));
        $b=hexdec(substr($color,4,2));
        return array($r,$g,$b);
    }

    function IconText($file,$text,
                      $textcolor=array(),
                      $backcolor=array(),
                      $fontsize=3)
    {
        if (!is_array($textcolor)) { $textcolor=$this->ColorCode2Color($textcolor); }
        if (!is_array($backcolor)) { $backcolor=$this->ColorCode2Color($backcolor); }

        if (!$textcolor || !is_array($textcolor))
        {
            $textcolor=array(0,0,0);
        }
        if (!$backcolor || !is_array($backcolor))
        {
            $backcolor=array(255,255,255);
        }


        $hgt=imagefontheight($fontsize);
        $wdt=imagefontwidth($fontsize)*strlen($text);
    
        $handle = imagecreate ($wdt+10, $hgt+5);
        if ($handle)
        {
            $bg_color = imagecolorallocate($handle,
                                           $backcolor[0],
                                           $backcolor[1],
                                           $backcolor[2]);

            $txt_color = imageColorallocate($handle,
                                            $textcolor[0],
                                            $textcolor[1],
                                            $textcolor[2]);

            if (!is_array($backcolor) || count($backcolor)==0)
            {
                imagecolortransparent($handle,$bg_color);
            }

            imagestring($handle,$fontsize,5,0,$text,$txt_color);

            $extrapath_pathcorrection=$this->ExtraPathPathCorrection();
            $tmpfile="tmp/".$file;
            imagepng ($handle,$tmpfile);

            if ($extrapath_pathcorrection!="")
            {
                $tmpfile=$extrapath_pathcorrection."/".$tmpfile;
            }

            return "<IMG SRC='".$tmpfile."' ALT='$tmpfile'>";
        }
        else { $this->AddMsg("Unable to create image object"); }

        return $text;
    }

    function OrderByValues($names)
    {
        $rids=array();
        $rnames=array();
        foreach ($names as $id => $name)
        {
            $rname=$this->Text2Sort($name);
            $rids[ $rname.$id ]=$id;
            $rnames[ $rname.$id ]=$name;
        }

        $keys=array_keys($rnames);
        sort($keys,SORT_STRING);

        $ids=array();
        $names=array();
        foreach ($keys as $n => $nameid)
        {
            array_push($ids,$rids[ $nameid ]);
            array_push($names,$rnames[ $nameid ]);
        }

        return array($ids,$names);
    }

    //*
    //* function HashIntersection, Parameter list: $hash1,$hash2
    //*
    //* Returns intersection of two hashes. That is, takes
    //* the keys in $hash2 and returns a hash
    //* of all the keys that are keys of $hash1 as well.
    //*

    function HashIntersection($hash1,$hash2)
    {
        $keys1=array_keys($hash1);

        $hash=array();
        foreach ($hash2 as $key => $value)
        {
            if (preg_grep('/^'.$key.'$/',$keys1))
            {
                $hash[ $key ]=$value;
            }
        }

        return $hash;
    }

    //*
    //* function GetHashKeyValue, Parameter list: $hash,$key
    //*
    //* Checks, if key $key is set.
    //*

    function GetHashKeyValue($hash,$key)
    {
        if (isset($hash[ $key ]))
        {
            return $hash[ $key ];
        }

        return FALSE;
    }

    //*
    //* function CheckHashKeySet, Parameter list: $hash,$key
    //*
    //* Checks, if key $key is set.
    //*

    function CheckHashKeySet($hash,$key)
    {
        if (isset($hash[ $key ]))
        {
            return TRUE;
        }

        return FALSE;
    }

    //*
    //* function CheckHashKeyArray, Parameter list: $hash,$key
    //*
    //* Checks, if key $key is set.
    //*

    function CheckHashKeysArray($hash,$keys)
    {
        foreach ($keys as $key)
        {
            if (
                  isset($hash[ $key ])
                  &&
                  is_array($hash[ $key ])
               )
            {
                return $hash[ $key ];
            }
        }

        return FALSE;
    }


    //*
    //* function CheckHashKeyValue, Parameter list: $hash,$key,$isvalue
    //*
    //* Checks, if key $key is set in $hash, and has value $isvalue.
    //*

    function CheckHashKeyValue($hash,$key,$isvalues)
    {
        if (!is_array($isvalues)) { $isvalues=array($isvalues); }

        foreach ($isvalues as $isvalue)
        {
            if (isset($hash[ $key ]) && $hash[ $key ]==$isvalue)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    //*
    //* function CheckHashKeyRegexp, Parameter list: $hash,$key, $regexp
    //*
    //* Checks, if key $key is set in $hash, and conforms to regexp $regexp.
    //*

    function CheckHashKeyRegexp($hash,$key,$regexp)
    {
        if (isset($hash[ $key ]) && preg_match('/'.$regexp.'/',$hash[ $key ]))
        {
            return TRUE;
        }

        return FALSE;
    }

    //*
    //* function RegexSubKeysHash, Parameter list: $hash,$regex
    //*
    //* Returns a subhash of $hash, with only the keys matching $regex.
    //*

    function RegexSubKeysHash($hash,$regexp)
    {
        foreach ($hash as $key => $value)
        {
            if (!preg_match('/'.$regexp.'/',$key))
            {
                unset($hash[ $key ]);
            }
        }

        return $hash;
    }

    //*
    //* function CheckSubKeysPositiveOr, Parameter list: $hash,$subkeys
    //*
    //* Check if at least one of the $hash subkeys in $subkeys are positive.
    //*

    function CheckSubKeysPositiveOr($hash,$subkeys)
    {
        foreach ($subkeys as $subkey)
        {
            if (isset($hash[ $subkey ]) && $hash[ $subkey ]>0)
            {
                return TRUE;
            }
        }

        return FALSE;
    }


    //*
    //* function ListOfFirstNs, Parameter list: $n
    //*
    //* Check if at least one of the $hash subkeys in $subkeys are positive.
    //*

    function ListOfFirstNs($n)
    {
        $ns=array();
        for ($i=0;$i<$n;$i++) { array_push($ns,$i); }

        return $ns;
    }

    //*
    //* function SortListWithIDs, Parameter list: &$names,&$values
    //*
    //* Sort $names, but alos rearranges order of $values.
    //*

    function SortListWithIDs(&$names,&$values)
    {
        if (count($names)==count($values))
        {
            $hash=array();
            for ($n=0;$n<count($names);$n++)
            {
                $val=$names[ $n ];
                while (isset($hash[ $val ])) { $val.="a"; }
                $hash[ $val ]=$values[$n ];
            }

            $keys=array_keys($hash);
            sort($keys);

            $names=array();
            $values=array();
            foreach ($keys as $key)
            {
                array_push($names,$key);
                array_push($values,$hash[ $key ]);
            }
        }
    }

    //*
    //* function HashKeySetAndTRUE, Parameter list: $hash,$key
    //*
    //* Returns TRUE, if $hash[ $key ] is set, and evaluates to TRUE -
    //* and FALSE otherwise.
    //*

    function HashKeySetAndTRUE($hash,$key)
    {
        if (isset($hash[ $key ]))
        {
            if ($hash[ $key ])
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    //*
    //* function HashKeySetAndPositive, Parameter list: $hash,$key
    //*
    //* Returns TRUE, if $hash[ $key ] is set, and is a positive integer -
    //* and FALSE otherwise.
    //*

    function HashKeySetAndPositive($hash,$key)
    {
        if (isset($hash[ $key ]))
        {
            if (preg_match('/^\d+$/',$hash[ $key ]))
            {
                if ($hash[ $key ]>0)
                {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    //*
    //* function TransposeHash, Parameter list: $hash
    //*
    //* Transposes array.
    //*

    function TransposeHash($hash)
    {
        $rhash=array();
        foreach ($hash as $row => $cells)
        {
            foreach ($cells as $col => $cell)
            {
                $rhash[ $col ][ $row ]=$cell;
            }
        }

        return $rhash;
    }

    //*
    //* function Hash2Table, Parameter list: $hash
    //*
    //* Returns keyed table array of arrays. Suitable for a call to HtmlTable.
    //*

    function Hash2Table($hash)
    {
        $table=array();
        foreach ($hash as $key => $value)
        {
            if (is_array($value))
            {
                $value=$this->Hash2Table($value);
            }
            array_push
            (
               $table,
               array
               (
                  $this->B($key.":"),
                  $value
               )
            );
        }

        return $table;
    }

    //*
    //* function FormatN, Parameter list: $n,$len=2
    //*
    //* Reads months referenced by DatesObject.
    //*

    function FormatN($n,$len=2)
    {
        if ($n>0)
        {
            return sprintf("%0".$len."d",$n);
        }

        return "-";
    }

   //*
    //* function TrimHourValue, Parameter list: $value
    //*
    //* Trims an hour string.
    //*

    function TrimHourValue($value)
    {
        $rval=$value;
        if (preg_match('/\d\d?/',$rval,$matches))
        {
            $hour=$matches[0];
            $rval=preg_replace('/\d\d?/',"",$rval,1);

            $minute=0;
            if (preg_match('/\d\d?/',$rval,$matches))
            {
                $minute=$matches[0];
            }

            if ($hour>0)
            {
                return sprintf("%02d:%02d",$hour,$minute);
            }
        }
    }

    //*
    //* function TrimDateValue, Parameter list: $value
    //*
    //* Trims a date string.
    //*

    function TrimDateValue($value)
    {
        $rval=$value;
        if (preg_match('/\//',$rval) && preg_match('/\d\d?/',$rval,$matches))
        {
            $date=$matches[0];
            $rval=preg_replace('/\d\d?/',"",$rval,1);

            $mon=0;
            if (preg_match('/\d\d?/',$rval,$matches))
            {
                $mon=$matches[0];
                $rval=preg_replace('/\d\d?/',"",$rval,1);
            }

            $year=0;
            if (preg_match('/\d+/',$rval,$matches))
            {
                $year=$matches[0];

                if ($year<=($this->CurrentYear()-2000)) { $year+=2000; }
                elseif ($year<100) { $year+=1900; }
            }

            $value=sprintf("%04d%02d%02d",$year,$mon,$date);
        }

        return $value;
    }

    //*
    //*
    //* function TestHourOverlap, Parameter list: $hour,$hours
    //*
    //* Tests if $hour overlaps hours in $hours. Hours at the form:
    //* hh:mm-hh:mm
    //*

    function TestHourOverlap($hour1,$hour2)
    {
        $hours1=preg_split('/-/',$hour1);
        $hours2=preg_split('/-/',$hour2);

        $start1=preg_replace('/:/',"",$hours1[0]);
        $end1=preg_replace('/:/',"",$hours1[1]);

        $start2=preg_replace('/:/',"",$hours2[0]);
        $end2=preg_replace('/:/',"",$hours2[1]);

        $res=FALSE; //no overlap
        if ($start2<$start1)
        {
            if ($end2>$start1) { $res=TRUE; }
        }
        if ($start2>=$start1)
        {
            if ($start2<$end1)
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //*
    //* function TestHourOverlap, Parameter list: $hours
    //*
    //* Tests if $hour overlaps hours in $hours. Hours at the form:
    //* hh:mm-hh:mm
    //*

    function TestHoursOverlap($hours)
    {
        $res=array();
        for ($n=0;$n<count($hours);$n++)
        {
            $res[ $hours[$n] ]=FALSE;
        }

        for ($n=0;$n<count($hours);$n++)
        {
            for ($m=$n+1;$m<count($hours);$m++)
            {
                $res[ $hours[$n] ]=$this->TestHourOverlap($hours[$n],$hours[$m]);
                $res[ $hours[$m] ]=$res[ $hours[$n] ];
            }
        }

        return $res;
    }

    //*
    //*
    //* function HourOverlaps, Parameter list: $hour,$hours
    //*
    //* Tests if $hour overlaps any hours in $hours. Hours at the form:
    //* hh:mm-hh:mm
    //*

    function HourOverlaps($hour,$hours)
    {
        for ($n=0;$n<count($hours);$n++)
        {
            if ($this->TestHourOverlap($hour,$hours[$n]))
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    //*
    //*
    //* function HoursOverlaps, Parameter list: $hours
    //*
    //* Tests if $hour overlaps hours in $hours. Hours at the form:
    //* hh:mm-hh:mm
    //*

    function HoursOverlaps($hours)
    {
        for ($n=0;$n<count($hours);$n++)
        {
            for ($m=$n+1;$m<count($hours);$m++)
            {
                if ($this->TestHourOverlap($hours[$n],$hours[$m]))
                {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }


    //*
    //*
    //* function GetTableColumn, Parameter list: $col,$table
    //*
    //* Returns table column $colw as an array.
    //*

    function GetTableRow($col,$table)
    {
        $cols=array();
        foreach ($table as $row)
        {
            $cell="";
            if (isset($row[ $col ])) { $cell=$row[ $col ]; }

            if (count($row)>$col)
            {
                array_push($cols,$cell);
            }
        }

        return $cols;
    }

    //*
    //* function PageItems, Parameter list: $list,$maxnitems,$ditem=1
    //*
    //* Splits a list in sublists, with max of $nlines per item.
    //* Elements in $leadingrows is prepended in each sublists.
    //*

    function PageItems($list,$maxnitems,$ditem=1)
    {
        $items=array();
        $plist=array();
        $nitems=0;
        foreach ($list as $id => $item)
        {
            $nitems+=$ditem;
            if ($nitems<$maxnitems)
            {
                array_push($items,$item);
            }
            else
            {
                array_push($plist,$items);
                $items=array($item);
                $nitems=$ditem;
            }
        }

        if (count($items)>0)
        {
            array_push($plist,$items);
        }

        return $plist;
    }
    //*
    //* function TrimPRN, Parameter list: $prn
    //*
    //* Trims a CPF with . and -'s.
    //*

    function TrimPRN($prn)
    {
        if (!preg_match('/\./',$prn))
        {
            $prn=
                substr($prn,0,3).".".
                substr($prn,3,3).".".
                substr($prn,6,3)."-".
                substr($prn,9,2);
        }

        return $prn;
            
    }
    //*
    //* function TrimCPF, Parameter list: $data,$item
    //*
    //* Trims a CPF with . and -'s.
    //*

    function TrimCPF($data,$item)
    {
        return $this->TrimPRN($item[ $data ]);
    }

    //*
    //* function FormatInt, Parameter list: $n
    //*
    //* Formats int with 2 decimals, leading zeros. If zero, returns -.
    //*

    function FormatInt($n)
    {
        if (empty($n)) { return "-"; }

        return sprintf("%02d",$n);
    }

}
?>