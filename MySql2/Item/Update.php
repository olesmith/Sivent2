<?php


class ItemUpdate extends ItemTests
{
    //*
    //* Returns name of Trigger function, if any for $data
    //*

    function TriggerFunction($data)
    {
        return $this->MyMod_Data_Trigger_Function($data);
    }


    //*
    //* Updates item in DB.
    //*

    function UpdateItem($item=array(),$datas=array(),$prepost="",$postprocess=TRUE)
    {
        return $this->MyMod_Item_Update_CGI($item,$datas,$prepost,$postprocess);
    }


}
?>