<?php

trait MyMod_Data_Defaults
{
    //*
    //* function MyMod_Data_DefaultDefs, Parameter list: 
    //*
    //* Returns data default definitions.
    //*

    function MyMod_Data_DefaultDefs()
    {
        return array
        (
            "Name"              => "",
            "Name_UK"           => "",
            "ShortName"         => "",
            "ShortName_UK"      => "",
            "LongName"          => "",
            "LongName_UK"       => "",
            "Title"             => "",
            "Title_UK"          => "",
            "Sql"               => "",
            "Unique"            => FALSE,
            "Compound"          => "",

            "CGIName"           => "",
            "Size"              => FALSE,
            "Type"              => "",
            "MD5"               => FALSE,
            "Hidden"            => FALSE,
            "Password"          => FALSE,
            "TimeType"          => FALSE,
            "Derived"           => FALSE,
            "DerivedFilter"     => "",
            "DerivedNamer"      => "",
            "ConditionalShow"   => "",
            "ReadOnly"          => FALSE,
            "PublicReadOnly"    => FALSE,
            "PersonReadOnly"    => FALSE,
            "AdminReadOnly"     => FALSE,

            "SqlDerivedData"    => array(),
            "SqlData"           => NULL,
            "SqlDerivedNamer"   => "",
            "SqlDisabledMethod" => "",
            "SqlHRefIt"         => FALSE,
            "SqlTextSearch"     => FALSE,
            "SqlObject"         => NULL,
            "SqlClass"          => NULL,
            "SqlMethod"         => NULL,
            "SqlSortReverse"    => FALSE,

            "Admin"             => 1,
            "Public"            => 0,
            "Person"            => 0,

            "Search"            => FALSE,
            "SearchFieldMethod" => "",
            "SearchDefault"     => "",
            "SearchCompound"     => "",
            "SearchCheckBox"     => "",
            "SearchRadioSet"     => "",
            "GETSearchVarName"  => FALSE,
            "NoSearchRow"       => FALSE,
            "NoSearchEmpty"       => FALSE,

            "Default"           => FALSE,
            "Values"            => array(),

            "ValuesMatrix"      => NULL,

            "SortAsDate"        => FALSE,
            "TrimCase"          => FALSE,
            "Iconify"           => FALSE,
            "Compulsory"        => FALSE,
            "FieldMethod"       => "",
            "ShowFieldMethod"   => "",
            "EditFieldMethod"   => "",
            "NoAdd"             => FALSE,
            "NoSort"            => FALSE,
            "NoSelectSort"      => FALSE,
            "SelectOffset"      => 0,
            "SelectCheckBoxes"  => FALSE,
            "EmptyName"         => "",
            "AltTable"          => FALSE,
            "NamerLink"         => FALSE,
            "MaxLength"         => 0,
            "IconColors"        => "",
            "BkIconColors"      => "",
            "CompulsoryText"    => "",
            "TableSize"         => "",
            "LatexCode"         => FALSE,
            "LatexWidth"        => "",
            "LatexFormat"        => FALSE,
            "HRef"              => "",
            "HRefIt"            => FALSE,
            "HRefIcon"          => "",
            "Iconed"            => "",
            "Format"            => FALSE,
            "IsDate"            => FALSE,
            "IsHour"            => FALSE,
            "ToDayIsDefault"    => FALSE,
            "Info"              => FALSE,
            "IsColor"          => FALSE,
            "IsBarcode"          => FALSE,
            "TabIndex"          => "",
        );

    }


    //*
    //* function MyMod_Datas_AddDefaultKeys, Parameter list: 
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Datas_AddDefaultKeys()
    {
        $defaults=$this->MyMod_Data_DefaultDefs();

        foreach (array_keys($this->ItemData) as $data)
        {
            $this->MyMod_Data_AddDefaultKeys($this->ItemData[ $data ],$defaults);
        }
    }

    //*
    //* function MyMod_Data_AddDefaultKeys, Parameter list: &$data,$defaults=array()
    //*
    //* Adds all keys in $this->DefaultActionDef, unless already defined.
    //* Guaranteeing all keys present, prevents warning messages about
    //* accessing nondefined keys in action definitions.
    //*

    function MyMod_Data_AddDefaultKeys(&$data,$defaults=array())
    {
        if (empty($defaults))
        {
            $defaults=$this->MyMod_Data_DefaultDefs();
        }

        $this->MyHash_AddDefaultKeys($data,$defaults);
        $this->MyMod_Profiles_AddDefaultKeys($data);
    }

 }

?>