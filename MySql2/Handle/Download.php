<?php


class HandleDownload extends Menues
{
  //*
  //* function HandleDownLoad, Parameter list: $echo=TRUE
  //*
  //* Handles arquive download.
  //*

  function HandleDownLoad($echo=TRUE)
  {
      $id=$this->GetGET("ID");
      $data=$this->GetGET("Data");
      $access=$this->MyMod_Data_Access($data,$this->ItemHash);

      if ($access>=1 && $this->ItemData[ $data ][ "Sql" ]=="FILE")
      {
          if ($id!="") { $this->ReadItem($id,array($data)); }

          $file=$this->ItemHash[ $data ];
          if (empty($file))
          {
              $file=$this->MySqlItemValue("","ID",$this->ItemHash[ "ID" ],$data."_OrigName");
          }
          
          $origname=$file;
          if (empty($this->ItemHash[$data."_OrigName"]))
          {
              $origname=$this->MySqlItemValue("","ID",$this->ItemHash[ "ID" ],$data."_OrigName");
          }

          
          $content=join("",$this->MyReadFile($file));
 
          $matches=array();
          $ext="pdf";
          if (preg_match('/\.(\S{3})$/',$file,$matches))
          {
              $ext=$matches[1];
          }

          $comps=preg_split('/\./',$origname);
          $ext=array_pop($comps);
          $ext=strtolower($ext);
          array_push($comps,$ext);
          
          $this->SendDocHeader
          (
             $ext,
             preg_replace('/^\./',"",basename(join(".",$comps)))
          );

          echo $content;
      }
      else
      {
          echo "Access denied";
      }

  }
}

?>