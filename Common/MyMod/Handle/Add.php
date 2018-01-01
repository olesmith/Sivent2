<?php

trait MyMod_Handle_Add
{
    //*
    //* function MyMod_Handle_Add, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Add()
    {
        $title=$this->GetRealNameKey($this->Actions[ "Add" ]);
        $ptitle=$this->GetRealNameKey($this->Actions[ "Add" ],"PName");

        return $this->AddForm($title,$ptitle,$echo);
    }  
}

?>