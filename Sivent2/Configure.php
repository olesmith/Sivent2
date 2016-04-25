<?php

global $Access;
$Access="312ba9fc90866c31f0f233582601e801";

global $DBDatas;
$DBDatas=array("Host","DB","User","Password","Type","Debug","Mod","ServType");

###*
###* function MyWriteFile, Parameter list: $file,$lines
###*
###* Writes array $lines back out to file $file.
###* 
###*

function MyWriteFile($file,$lines)
{
  if (!$handle = fopen($file, 'w'))
    {
      echo "Cannot rewrite file ($file)";
      return;
    }

  for ($n=0;$n<count($lines);$n++)
    {
      if (fwrite($handle, $lines[$n]) === FALSE) 
	{
	  echo "Cannot write to file ($filename)";
	  exit;
	}
    }

  echo count($lines)." lines written to file: $file<BR>";
  fclose($handle);
}


###*
###* function ConfigForm, Parameter list: $dir
###*
###* Creates form for updating config file.
###* 
###*

function ConfigForm()
{
    $text=file(".DB.php");

    $text=preg_grep('/(<<<<<|>>>>>|======)/',$text,PREG_GREP_INVERT);

    $text=preg_replace('/<\?php/',"",$text);
    $text=preg_replace('/\?>/',"",$text);

    eval('$hash='.join("",$text).";\nreturn 1;");
    
    global $DBDatas;

    $rows=array();
    foreach ($DBDatas as $data)
    {
        if (!empty($_POST[ $data ]))
        {
            $hash[ $data ]=$_POST[ $data ];
        }

        array_push
        (
           $rows,
           "   <TR>\n".
           "      <TD><B>".$data.":</B></TD>\n".
           "      <TD>\n".
           "      <INPUT TYPE='text' NAME='".$data."' VALUE='".$hash[ $data ]."'>\n".
           "      </TD>\n".
           "   </TR>\n"
        );
    }

    if (!empty($_POST[ "Update" ]) && $_POST[ "Update" ]==1)
    {
       GenConfig($hash);
    }

    echo
        "<H2>Preenche os campos:</H2>\n".
        "<FORM METHOD='post' ACTION='Configure.php'>\n".
        "<TABLE>\n".
        
        join("",$rows).
        "   <TR>\n".
        "      <TD><B>Update Password (wessel):</B></TD>\n".
        "      <TD>\n".
        "      <INPUT TYPE='password' NAME='Power' VALUE=''>\n".
        "      </TD>\n".
        "   </TR>\n".
        
        "</TABLE>\n".
        "<INPUT TYPE='hidden' NAME='Update' VALUE='1'>\n".
        "<BUTTON TYPE='submit'>Enviar</BUTTON>\n".
        "<BUTTON TYPE='reset'>Resetar</BUTTON>\n".
        "<FORM>\n";
}


###*
###* function GenConfig , Parameter list: $hash
###*
###* Generates config file: Config.php.
###* 
###*

function GenConfig($hash)
{
    global $Access;

    if (md5($_POST[ "Power" ])==$Access)
    {

        $lines=array
        (
          "<?php\n",
          '$'."hash=array();\n",
        );
        
        global $DBDatas;
        foreach ($DBDatas as $data)
        {
            array_push
            (
               $lines,
              '   $'."hash[ '".$data."' ]='".$hash[ $data ]."';\n"
            );
        }
        
        array_push
        (
           $lines,
          "?>"
        );
       
        echo join("",$lines);

        MyWriteFile(".DB.php",$lines);
    }
    else { echo "BUUUH ".md5($_POST[ "Power" ]). " - ".$Access; }
}

ConfigForm();

?>