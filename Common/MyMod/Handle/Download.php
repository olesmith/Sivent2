<?php

trait MyMod_Handle_Download
{
    //*
    //* function MyMod_Handle_Download, Parameter list: 
    //*
    //* Handles module object file data Download.
    //*

   function MyMod_Handle_Download($echo=TRUE)
   {
       $id=$this->GetGET("ID");
       $data=$this->GetGET("Data");
       $access=$this->MyMod_Data_Access($data,$this->ItemHash);

       if ($access>=1 && $this->ItemData[ $data ][ "Sql" ]=="FILE")
       {
           if ($id!="") { $this->MyMod_Item_Read($id,array($data)); }

           $file=$this->ItemHash[ $data ];
           if (empty($file))
           {
               $file=
                   $this->Sql_Select_Hash_Value
                   (
                       $this->ItemHash[ "ID" ],
                       $data."_OrigName"
                   );
           }
          
           $origname=$file;
           if (empty($this->ItemHash[$data."_OrigName"]))
           {
               $origname=
                   $this->Sql_Select_Hash_Value
                   (
                       $this->ItemHash[ "ID" ],
                       $data."_OrigName"
                   );
           }

           if (empty($file) || !file_exists($file))
           {
               echo "MyMod_Handle_Download: No such file: '".$file."'";
               exit();
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
          
           $this->MyMod_Doc_Header_Send
           (
               $ext,
               preg_replace('/^\./',"",basename(join(".",$comps))),
               "",
               100*24*60*60, //expires in one day, should be reasonable
               filemtime($file)
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