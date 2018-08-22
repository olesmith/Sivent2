<?php


trait MyMod_Icons
{
    var $MyApp_Interface_Icon_Sizes=
        array
        (
            '',
            'fa-2x',
            'fa-lg',
            'fa-xs','fa-sm',
            'fa-3x','fa-5x','fa-7x','fa-10x',            
        );
    var $MyApp_Interface_Icon_Size=0;
    
    //*
    //* sub MyApp_Interface_Icon_Size, Parameter list: $icon,$options=array()
    //* 
    //* Inserts icon as I tag.
    //*

    function MyMod_Interface_Icon_Size($icon,$size=0)
    {
        if ($size==0) { $size=$this->MyApp_Interface_Icon_Size; }

        if ($size>0)
        {
            $icon.=" ".$this->MyApp_Interface_Icon_Sizes[ $size ];
        }
        
        return $icon;
    }
    
    //*
    //* sub MyApp_Interface_Icon, Parameter list: $icon,$options=array()
    //* 
    //* Inserts icon as I tag.
    //*

    function MyMod_Interface_Icon($icon,$options=array())
    {
        $options[ "CLASS" ]=$icon;

        return $this->HtmlTags("I","",$options);
    }
    
    //*
    //* sub MyApp_Interface_Icon_Link, Parameter list: 
    //* 
    //* Inserts icon as I tag.
    //*

    function MyMod_Interface_Icon_Link($args,$icon,$title,$class,$options=array(),$iconoptions=array())
    {
        $options[ "CLASS" ]=$class;

        return
            $this->Htmls_HRef
            (
                "?".$this->CGI_Hash2Query($args),
                array(array($this->MyMod_Interface_Icon($icon,$iconoptions))),
                $title,
                $class="",
                $args=array
                (
                ),
                $options
            );
    }
}

?>