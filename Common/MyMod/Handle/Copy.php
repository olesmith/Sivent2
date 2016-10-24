<?php

trait MyMod_Handle_Copy
{
    //*
    //* function MyMod_Handle_Copy, Parameter list: 
    //*
    //* 
    //*

    function MyMod_Handle_Copy()
    {
        $title=$this->GetRealNameKey($this->Actions[ "Copy" ]);
        $ptitle=$this->GetRealNameKey($this->Actions[ "Copy" ],"PName");

        $this->CopyForm($title,$ptitle);
    }  
}

?>