<?php

class Setup extends Modules
{

    /* //\* */
    /* //\* Read include key from cgi (local/global/..) */
    /* //\* */

    /* function ReadSetupIncludeKey() */
    /* { */
    /*     $global=$this->GetGET("Global"); */
    /*     $includekey="Local"; */
    /*     if ($global==1) */
    /*     { */
    /*         $includekey="Global"; */
    /*     } */

    /*     return $includekey; */
    /* } */


    /* //\* */
    /* //\* Read setup file $fid */
    /* //\* */

    /* function ReadSetupFile($fid,$moduleobj=NULL,$tothis=TRUE) */
    /* { */
    /*     $deffile=$this->MyApp_Setup_DataDef_FileName($fid); */

    /*     $module=""; */
    /*     if ($moduleobj) { $module=$moduleobj->ModuleName; } */

    /*     $file=$this->MyApp_Setup_DataFileName($fid,$module); */

    /*     if (!is_file($deffile)) */
    /*     { */
    /*         print "Setup Definition file: $deffile not found"; */
    /*         var_dump($this->SetupFileDefs[ $fid ]); */
    /*         exit(); */
    /*     } */

    /*     $defhash=$this->ReadPHPArray($deffile); */
    /*     $allowedkeys=array_keys($defhash); */
    /*     $this->SetupFileDefs[ $fid ][ "Def" ]=$defhash; */
    /*     $this->SetupFileDefs[ $fid ][ "Keys" ]=$allowedkeys; */


    /*     $hash=$this->ReadPHPArray($file); */
    /*     foreach ($hash as $key => $value) */
    /*     { */
    /*         if (!preg_grep('/^'.$key.'$/',$allowedkeys)) */
    /*         { */
    /*             unset($hash[ $key ]); */
    /*             $this->AddMsg */
    /*             ( */
    /*                "Unset $fid ($deffile) setup key: $key:<BR>". */
    /*                join(", ",$allowedkeys) */
    /*             ); */
    /*         } */
    /*     } */

    /*     $this->SetupHash2Object($fid,$hash,$moduleobj,$tothis); */
    /* } */











    /* //\* */
    /* //\* Write setup file $fid */
    /* //\* */

    /* function WriteSetupFile($fid) */
    /* { */
    /*     $filedef=$this->SetupFileDefs[ $fid ]; */

    /*     $hash=$this->MyApp_Setup_Object2Hash($fid); */

    /*     $text=array("array\n","(\n"); */
    /*     foreach ($hash as $key => $value) */
    /*     { */
    /*         if ($filedef[ "Def" ][ $key ][ "Type" ]=="scalar") */
    /*         { */
    /*             //scalar */
    /*             array_push($text,"   '".$key."' => '".$value."',\n"); */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="list") */
    /*         { */
    /*             //list */
    /*             array_push($text,"   '".$key."' => array\n","   (\n"); */

    /*             $max=$filedef[ "Def" ][ $key ][ "Length" ]; */
    /*             if ($max=="") { $max=count($hash[ $key ]); } */

    /*             for ($n=0;$n<$max;$n++) */
    /*             { */
    /*                 array_push($text,"      '".$hash[ $key ][ $n ]."',\n");                     */
    /*             } */
    /*             array_push($text,"   ),\n"); */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="hash") */
    /*         { */
    /*             //Hashes */
    /*             array_push($text,"   '".$key."' => array\n","   (\n"); */

    /*             foreach ($value as $id => $val) */
    /*             { */
    /*                 $hash[ $key ][ $id ]=preg_replace('/\s+$/',"",$hash[ $key ][ $id ]); */

    /*                 array_push($text,"      '".$id."' => '".$hash[ $key ][ $id ]."',\n");                     */
    /*             } */
    /*             array_push($text,"   ),\n"); */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="hash2") */
    /*         { */
    /*             //2 level hashes (hash of hashes) */
    /*             $keys=$filedef[ "Def" ][ $key ][ "Keys" ]; */
    /*             array_push($text,"   '".$key."' => array\n","   (\n"); */

    /*             if (!is_array($value)) { $value=array(); } */

    /*             foreach ($value as $id => $val) */
    /*             { */
    /*                 array_push($text,"      '".$id."' => array\n","      (\n"); */


    /*                 foreach ($val as $rid => $rval) */
    /*                 { */
    /*                     if (!is_array($keys) || preg_grep('/^'.$rid.'$/',$keys)) */
    /*                     { */
    /*                         $rval=$hash[ $key ][ $id ][ $rid ]; */
    /*                         array_push($text,"            '".$rid."' => '".$rval."',\n"); */
    /*                     } */
    /*                 } */


    /*                 array_push($text,"      ),\n");                     */
    /*             } */
    /*             array_push($text,"   ),\n"); */
    /*         } */
    /*     } */

    /*     $file=$this->MyApp_Setup_DataFileName($fid); */
    /*     array_push($text,");\n"); */

    /*     $this->MyWriteFile($file,$text); */
    /* } */


    /* //\* */
    /* //\* Create setup files menu */
    /* //\* */

    /* function SetupFilesMenu($global=FALSE) */
    /* { */
    /*     $includekey=$this->ReadSetupIncludeKey(); */

    /*     $hrefs=array(); */
    /*     $titles=array(); */
    /*     $btitles=array(); */
    /*     foreach ($this->SetupFileDefs as $fid => $filedef) */
    /*     { */
    /*         if ($filedef[ $includekey ]==1) */
    /*         { */
    /*             $args="Action=Setup&".$includekey."=1"; */

    /*             array_push */
    /*             ( */
    /*              $hrefs, */
    /*              "?".$args."&FID=".$fid */
    /*             ); */
    /*             array_push */
    /*             ( */
    /*              $titles, */
    /*              $filedef[ "Name" ] */
    /*             ); */
    /*             array_push */
    /*             ( */
    /*              $btitles, */
    /*              $filedef[ "Title" ] */
    /*             ); */
    /*         } */
    /*     } */

        
    /*     return $this->HrefMenu("Parâmetros",$hrefs,$titles,$btitles,4); */
    /* } */

 
    /* //\* */
    /* //\* Runs through setup files and figures out which one to edit. */
    /* //\* Call SetupFileForm for the selected one. */
    /* //\* */

    /* function SetupFilesForm() */
    /* { */
    /*     $includekey=$this->ReadSetupIncludeKey(); */

    /*     $fids=array_keys($this->SetupFileDefs); */

    /*     $rfid=$this->GetGETOrPOST("FID"); */
    /*     if ($rfid=="") */
    /*     { */
    /*          foreach ($fids as $id => $fid) */
    /*          { */
    /*              if ($rfid=="" && $this->SetupFileDefs[ $fid ][ $includekey ]==1) */
    /*              { */
    /*                  $rfid=$fid; */
    /*              } */
    /*          } */
    /*     } */

    /*     foreach ($fids as $id => $fid) */
    /*     { */
    /*         if ($fid==$rfid && $this->SetupFileDefs[ $fid ][ $includekey ]==1) */
    /*         { */
    /*             $this->SetupFileForm($fid); */
    /*         } */
    /*     } */
    /* } */

    /* //\* */
    /* //\* Edit all setup file $fid */
    /* //\* */

    /* function SetupFileForm($fid) */
    /* { */
    /*     if ($this->GetGET("DumpSetup")==1) */
    /*     { */
    /*         $this->DumpSetupFile($fid); */
    /*         exit(); */
    /*     } */

    /*     if ($this->GetPOST("Update")==1) */
    /*     { */
    /*         $this->UpdateSetupFile($fid); */
    /*     } */

    /*     $filedef=$this->SetupFileDefs[ $fid ]; */

    /*     $hash=$this->MyApp_Setup_Object2Hash($fid); */
    /*     $table=array(); */
    /*     foreach ($hash as $key => $value) */
    /*     { */
    /*         $title= */
    /*             "<B>".$filedef[ "Def" ][ $key ][ "Name" ]. */
    /*             " ['".$key."']:</B>"; */

    /*         $len=$filedef[ "Def" ][ $key ][ "Size" ]; */
    /*         if ($len=="") */
    /*         { */
    /*             $len=strlen($value); */
    /*         } */

    /*         if ($filedef[ "Def" ][ $key ][ "Type" ]=="scalar") */
    /*         { */
    /*             $input=$this->MakeInput($fid."_".$key,$value,$len); */
    /*             array_push */
    /*             ( */
    /*                $table, */
    /*                array($title,$input) */
    /*             ); */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="list") */
    /*         { */
    /*             $max=$filedef[ "Def" ][ $key ][ "Length" ]; */
    /*             if ($filedef[ "Def" ][ $key ][ "Length" ]=="") */
    /*             { */
    /*                 $max=count($hash[ $key ]); */
    /*             } */

    /*             $len=$filedef[ "Def" ][ $key ][ "Size" ]; */
    /*             if ($len=="") */
    /*             { */
    /*                 $len=0; */
    /*                 for ($n=0;$n<$max;$n++) */
    /*                 { */
    /*                     if (strlen($value[$n])>$len) { $len=strlen($value[$n]); } */
    /*                 } */
    /*             } */

    /*             $convert=FALSE; */
    /*             if ($filedef[ "Def" ][ $key ][ "Sort" ]==1) */
    /*             { */
    /*                 $sorthash=array(); */
    /*                 for ($n=0;$n<count($value);$n++) */
    /*                 { */
    /*                     $sorthash[ $value[ $n ] ]=$n; */
    /*                 } */

    /*                 $keys=array_keys($sorthash); */
    /*                 sort($keys); */

    /*                 $n=0; */
    /*                 foreach ($keys as $rkey) */
    /*                 { */
    /*                     $val=$sorthash[ $rkey ]; */
    /*                     $convert[ $n ]=$val; */
    /*                     $n++; */
    /*                 } */
    /*             } */

    /*             if ($filedef[ "Def" ][ $key ][ "Length" ]=="") */
    /*             { */
    /*                 $max=count($hash[ $key ])+1; */
    /*             } */

    /*             for ($n=0;$n<$max;$n++) */
    /*             { */
    /*                 $nn=$n; */
    /*                 if (is_array($convert)) */
    /*                 { */
    /*                     $nn=$convert[$n]; */
    /*                 } */

    /*                 array_push */
    /*                 ( */
    /*                     $table, */
    /*                     array */
    /*                     ( */
    /*                        $title, */
    /*                        "<B>".($n+1).":</B>", */
    /*                        $this->MakeInput($fid."_".$key."_".$nn,$value[$nn],$len) */
    /*                     ) */
    /*                 ); */

    /*                 $title=""; */
    /*             } */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="hash") */
    /*         { */
    /*             $len=$filedef[ "Def" ][ $key ][ "Size" ]; */
    /*             if ($len=="") */
    /*             { */
    /*                 $len=0; */
    /*                 foreach ($value as $id => $val) */
    /*                 { */
    /*                     if (strlen($val)>$len) { $len=strlen($val); } */
    /*                 } */
    /*             } */

    /*             foreach ($value as $id => $val) */
    /*             { */
    /*                 $field=""; */
    /*                 if ($filedef[ "Def" ][ $key ][ "AreaField" ]!="") */
    /*                 { */
    /*                     $field=$this->MakeTextArea($fid."_".$key."_".$id, */
    /*                                                      $filedef[ "Def" ][ $key ][ "Height" ], */
    /*                                                      $filedef[ "Def" ][ $key ][ "Width" ], */
    /*                                                      $val); */
    /*                 } */
    /*                 else */
    /*                 { */
    /*                     $field=$this->MakeInput($fid."_".$key."_".$id,$val,$len); */
    /*                 } */

    /*                 array_push */
    /*                 ( */
    /*                     $table, */
    /*                     array */
    /*                     ( */
    /*                        $title, */
    /*                        "<B>".$id.":</B>", */
    /*                        $field */
    /*                     ) */
    /*                 ); */

    /*                 $title=""; */
    /*             } */

    /*             array_push */
    /*             ( */
    /*                $table, */
    /*                array */
    /*                ( */
    /*                   $title, */
    /*                   $this->MakeInput($fid."_".$key."_".$id."__Name__","",10), */
    /*                   $this->MakeInput($fid."_".$key."_".$id."__Value__","",$len), */
    /*                ) */
    /*             ); */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="hash2") */
    /*         { */
    /*             $len=$filedef[ "Def" ][ $key ][ "Size" ]; */
    /*             if ($len=="") */
    /*             { */
    /*                 $len=0; */
    /*                 foreach ($value as $id => $val) */
    /*                 { */
    /*                     foreach ($val as $rid => $rval) */
    /*                     { */
    /*                         if (strlen($rval)>$len) { $len=strlen($rval); } */
    /*                     } */
    /*                 } */
    /*             } */

    /*             if (!is_array($value)) { $value=array(); } */
    /*             foreach ($value as $id => $val) */
    /*             { */
    /*                 $keys=$filedef[ "Def" ][ $key ][ "Keys" ]; */

    /*                 $rtitle="<B>".$id.":</B>"; */
    /*                 foreach ($val as $rid => $rval) */
    /*                 { */
    /*                     if (!is_array($keys) || preg_grep('/^'.$rid.'$/',$keys)) */
    /*                     { */
    /*                         $rkey=$fid."_".$key."_".$id."_".$rid; */
    /*                         array_push */
    /*                         ( */
    /*                          $table, */
    /*                          array */
    /*                          ( */
    /*                           $title, */
    /*                           $rtitle, */
    /*                           "<B>".$rid.":</B>", */
    /*                           $this->MakeInput($rkey,$rval,$len) */
    /*                          ) */
    /*                         ); */

    /*                         $rtitle=""; */
    /*                         $title=""; */

    /*                         $keys=preg_grep('/^'.$rid.'$/',$keys,PREG_GREP_INVERT); */
    /*                     } */
    /*                 } */

    /*                 if (count($keys)>0) */
    /*                 { */
    /*                     $var=$fid."_".$key."_".$id; */
    /*                     $varname=$var."__Name__"; */

    /*                     if (is_array($keys)) */
    /*                     { */
    /*                         array_unshift($keys,""); */
    /*                         $select=$this->MakeSelectField($varname,$keys,$keys,""); */
    /*                     } */
    /*                     else */
    /*                     { */
    /*                         $select=$this->$this->MakeInput($varname,"",10); */
    /*                     } */

    /*                     array_push */
    /*                     ( */
    /*                      $table, */
    /*                      array */
    /*                      ( */
    /*                       $title, */
    /*                       $rtitle, */
    /*                       $select, */
    /*                       $this->MakeInput($var,"",$len), */
    /*                      ) */
    /*                     ); */
    /*                 } */

    /*             } */
    /*                     array_push */
    /*                     ( */
    /*                      $table, */
    /*                      array */
    /*                      ( */
    /*                       $title, */
    /*                       $this->MakeInput($fid."_".$key,"",$len), */
    /*                      ) */
    /*                     ); */
    /*         } */
           
    /*     }  */

    /*     print */
    /*         $this->H(4, */
    /*                  "&gt;&gt; Altere aqui se - <U>E SOMENTE SE</U> - ". */
    /*                  "você sabe o que está fazendo!! &lt;&lt"). */
    /*         $this->SetupFilesMenu(). */
    /*         $this->UploadSetupFileForm($fid,FALSE). */
    /*         $this->H(2,"Editar: ".$filedef[ "Title" ]). */
    /*         $this->StartForm(). */
    /*         $this->Buttons(). */
    /*         $this->HtmlTable("",$table). */
    /*         $this->MakeHidden("Update",1). */
    /*         $this->MakeHidden("FID",$fid). */
    /*         $this->Buttons(). */
    /*         $this->EndForm(); */
    /* } */

    /* //\* */
    /* //\* Update setup file $fid */
    /* //\* */

    /* function UpdateSetupFile($fid) */
    /* { */
    /*     $filedef=$this->SetupFileDefs[ $fid ]; */

    /*     $hash=$this->MyApp_Setup_Object2Hash($fid); */

    /*     $rhash=array(); */
    /*     foreach ($hash as $key => $value) */
    /*     { */
    /*         $regex=$filedef[ "Def" ][ $key ][ "Regex" ]; */
    /*         if ($filedef[ "Def" ][ $key ][ "Type" ]=="scalar") */
    /*         { */
    /*             $newvalue=$this->GetPOST($fid."_".$key); */
    /*             if ($regex!="") */
    /*             { */
    /*                 if (!preg_match('/'.$regex.'/',$newvalue)) */
    /*                 { */
    /*                     $this->HtmlStatus.=$newvalue." não conforma ao regexp. ".$regex."<BR>"; */
    /*                     $newvalue=$value; */
    /*                 } */
    /*             } */

    /*             $rhash[ $key ]=$newvalue; */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="list") */
    /*         { */
    /*             $max=$filedef[ "Def" ][ $key ][ "Length" ]; */
    /*             if ($filedef[ "Def" ][ $key ][ "Length" ]=="") */
    /*             { */
    /*                 $max=count($hash[ $key ]); */
    /*             } */

    /*             for ($n=0;$n<=$max;$n++) */
    /*             { */
    /*                 $rkey=$fid."_".$key."_".$n; */
    /*                 $value=$this->GetPOST($rkey); */
    /*                 if ($value!="") */
    /*                 { */
    /*                     $rhash[ $key ][ $n ]=$this->GetPOST($rkey); */
    /*                 } */
    /*             } */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="hash") */
    /*         { */
    /*             foreach ($value as $id => $val) */
    /*             { */
    /*                 $rkey=$fid."_".$key."_".$id; */
    /*                 $rhash[ $key ][ $id ]=$this->GetPOST($rkey);   */
    /*             } */
    /*         } */
    /*         elseif ($filedef[ "Def" ][ $key ][ "Type" ]=="hash2") */
    /*         { */
    /*             if (!is_array($value)) { $value=array(); } */
    /*             foreach ($value as $id => $val) */
    /*             { */
    /*                 $keys=$filedef[ "Def" ][ $key ][ "Keys" ]; */

    /*                 foreach ($val as $rid => $rval) */
    /*                 { */
    /*                     $rkey=$fid."_".$key."_".$id."_".$rid; */
    /*                     if (!is_array($keys) || preg_grep('/^'.$rid.'$/',$keys)) */
    /*                     { */
    /*                         if (!is_array($rhash[ $key ])) */
    /*                         { */
    /*                             $rhash[ $key ]=array(); */
    /*                         } */

    /*                         if (!is_array($rhash[ $key ][ $id ])) */
    /*                         { */
    /*                             $rhash[ $key ][ $id ]=array(); */
    /*                         } */

    /*                         $newvalue=$this->GetPOST($rkey); */
    /*                         $rhash[ $key ][ $id ][ $rid ]=$this->GetPOST($rkey); */
    /*                     } */
    /*                     else */
    /*                     { */
    /*                         $this->AddMsg("Invalid field: $rid, not in: ".join(", ",$keys)); */
    /*                     } */
    /*                 } */

    /*                 $var=$this->GetPOST($fid."_".$key."_".$id); */
    /*                 $varname=$this->GetPOST($fid."_".$key."_".$id."__Name__"); */
    /*                 if ($varname!="") */
    /*                 { */
    /*                     $rhash[ $key ][ $id ][ $varname ]=$var; */
    /*                 } */
    /*             } */

    /*             $var=$this->GetPOST($fid."_".$key); */
    /*             if ($var!="") */
    /*             { */
    /*                 $rhash[ $key ][ $var ]=array(); */
    /*             } */

    /*         } */
    /*     }  */

    /*     $this->SetupHash2Object($fid,$rhash); */

    /*     $this->WriteSetupFile($fid); */

    /*     return $rhash; */
    /* } */

    /* //\* */
    /* //\* Upload setup file $fid */
    /* //\* */

    /* function UploadSetupFileForm($fid,$return=TRUE) */
    /* { */
    /*     if ($this->GetPOST("Upload")==1) */
    /*     { */
    /*         $this->UploadSetupFile($fid); */
    /*     } */

    /*     $includekey=$this->ReadSetupIncludeKey(); */

    /*     $html= */
    /*         "<CENTER>". */
    /*         $this->H(2,"Upload do Arquivo:<BR>".$this->SetupFileDefs[ $fid ][ "File" ]). */
    /*         $this->StartForm("","post",1). */
    /*         $this->MakeFileField("File_".$fid). */
    /*         $this->MakeHidden("Upload",1). */
    /*         $this->MakeHidden($includekey,1). */
    /*         $this->MakeHidden("FID",$fid). */
    /*         $this->Button("submit","Enviar"). */
    /*         $this->Href("?Setup=1&DumpSetup=1&".$includekey."=1&FID=".$fid,"Download")."<BR><BR>". */
    /*         $this->EndForm(); */

    /*     if ($return) */
    /*     { */
    /*         $html.=$this->Href("?Search=1","Retornar");             */
    /*     } */

    /*     $html.="</CENTER>"; */

    /*     return $html; */
    /* } */

    /* //\* */
    /* //\* Upload setup file $fid */
    /* //\* */

    /* function UploadSetupFile($fid) */
    /* { */
    /*     $uploadinfo=$_FILES[ "File_".$fid ]; */
    /*     $extensions=array("php"); */

    /*     if (is_array($uploadinfo)) */
    /*     { */
    /*         $tmpname=$uploadinfo['tmp_name']; */
    /*         $name=$uploadinfo['name']; */
    /*         $error=$uploadinfo['error']; */

    /*         $comps=preg_split('/\./',$name); */
    /*         $ext=array_pop($comps); */

    /*         if (preg_grep('/^'.$ext.'$/',$extensions)) */
    /*         { */
    /*             $destfile=$this->SetupFileDefs[ $fid ][ "File" ]; */
    /*             $res=move_uploaded_file($tmpname,$destfile); */

    /*             $this->ReadSetupFile($fid); */
    /*             print $tmpname." --> ".$destfile.": ".$res."<BR>"; */
    /*         } */
    /*         else */
    /*         { */
    /*             print "Error: Invalid extension $ext<BR>"; */
    /*         } */
    /*     } */

    /* } */

    /* //\* */
    /* //\* Dump (export) setup file $fid */
    /* //\* */

    /* function DumpSetupFile($fid) */
    /* { */
    /*     $file=$this->MyApp_Setup_DataFileName($fid); */
    /*     $php=$this->MyReadFile($file); */

    /*     print "OI"; */
    /*     $this->SendDocHeader("php",$file); */
    /*     print join("",$php); */
    /* } */
}


?>