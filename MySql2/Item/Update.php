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
}
?>