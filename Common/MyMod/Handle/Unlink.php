<?php

trait MyMod_Handle_Unlink
{
    //*
    //* function MyMod_Handle_Download, Parameter list: 
    //*
    //* Handles module object file data Download.
    //*

   function MyMod_Handle_Unlink($echo=TRUE)
   {
       $id=$this->GetGET("ID");
       $data=$this->GetGET("Data");
       $access=$this->MyMod_Data_Access($data,$this->ItemHash);

       if ($access>=2 && $this->ItemData[ $data ][ "Sql" ]=="FILE")
       {
           if ($id!="") { $this->ReadItem($id,array($data)); }

           $file=$this->ItemHash[ $data ];
         
           if (file_exists($file))
           {
               $fields=array($data,$data."_OrigName",$data."_Time",$data."_Size");
               foreach ($fields as $field)
               {
                   $this->ItemHash[ $field ]="";
               }

               unlink($file);
               $this->Sql_Update_Item_Values_Set($fields,$this->ItemHash);
           }

           $args=$this->CGI_URI2Hash($_SERVER[ "HTTP_REFERER" ]);
           $this->CGI_Redirect("?".$this->CGI_Hash2URI($args)."#HorMenu");

       }
       else
       {
           echo "Access denied";
       }
   }
}

?>