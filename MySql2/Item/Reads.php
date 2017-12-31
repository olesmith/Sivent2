<?php

class ItemReads extends ItemPrints
{
   //*
   //* Reads item from POST.
   //* Data values for data in $this->ItemData[ $data ],
   //* are taken directly from POST.
   //* Returns the item.
   //*

   function ReadPostItem()
   {
       $item=array();
       foreach ($this->ItemData as $data => $value)
       {
           $rdata=$data;
           if (!empty($this->ItemData[ $data ][ "CGIName" ]))
           {
               $rdata=$this->ItemData[ $data ][ "CGIName" ];
           }

           if (!isset($_POST[ $rdata ])) { continue; }
           
           $newvalue=$this->GetPOST($rdata);
           if (!empty($newvalue))
           {
               if ($this->MyMod_Data_Field_Is_Crypted($data) && !empty($newvalue))
               {
                   $newvalue=$this->MyMod_Data_Field_Crypt($data,$newvalue);
               }
           }

           if (!empty($this->ItemData[ $data ][ "IsDate" ]) && !empty($newvalue))
           {
               if (preg_match('/\//',$newvalue))
               {
                   $newvalue=$this->Date2Sort($newvalue);
               }
           }

           $item[ $data ]=$newvalue;
       }

       $this->ItemHash=$item;

       return $item;
   }

}
?>