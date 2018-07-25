<?php


trait MyApp_Interface_Icons
{
    //*
    //* sub MyApp_Interface_Icon, Parameter list: $icon,$options=array()
    //* 
    //* Inserts icon as I tag.
    //*

    function MyApp_Interface_Icon($icon,$options=array())
    {
        return $this->MyMod_Interface_Icon($icon,$options);
    }
   
    //*
    //* function MyApp_Icon_IMG, Parameter list: $icon
    //*
    //* Generates icon as a complete html image.
    //*

    function MyApp_Icon_IMG($icon,$size=20)
    {
        return
            $this->IMG
            (
                $this->Icons."/".$icon,
                $icon,
                $size,
                $size
            );        
    }

}

?>