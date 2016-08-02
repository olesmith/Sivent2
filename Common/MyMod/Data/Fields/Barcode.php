<?php


trait MyMod_Data_Fields_Barcode
{
    //*
    //* Generates color edit field.
    //*

    function MyMod_Data_Fields_Barcode_Field($data,$item,$edit,$rdata="")
    {
        if ($edit==1)
        {
            if (empty($rdata)) { $rdata=$data; }
           
            return
                $this->Html_Input
                (
                   "TEXT",
                   $rdata,
                   $item[ $data ]//,
                   //array("SIZE" => $this->ItemData[ $data ][ "Size" ])
                );
        }
        else
        {
            $img=$this->BarCode_Generate($item);
        
            return
                $this->A
                (
                   $this->BarCode_URL($item),
                   "<IMG SRC='".$this->BarCode_URL($item)."'>".
                   $this->BR().
                   $this->Div($item[ "Code" ],array("CLASS" => 'barcodetext',"ALIGN" => 'center'))
                ).
                "";
        }
    }
}

?>