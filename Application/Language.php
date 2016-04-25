<?php


class ApplicationLanguage extends Handlers
{
   //*
    //* function InitModuleLanguage, Parameter list: 
    //*
    //* Initiatilizes module language subsystem.
    //*

    function InitModuleLanguage()
    {
        foreach (array("DataGroups","Item","Latex","Mail","Paging","Search") as $mfile)
        {
            $this->MyLanguage_AddMessageFile("../MySql2/Messages/".$mfile.".php");
        }
    }

    //*
    //* function GetLangDatas, Parameter list: $obj,$lang
    //*
    //* Returns list of datas in Lang.
    //*

    function GetLangDatas($obj,$lang)
    {
        $key=$lang[ "Key" ];
        if (!empty($key)) { $key="_".$key; }

        $datas=array();
        foreach (array_keys($obj->LangData) as $data)
        {
            $rdata=$data;
            if (!empty($key)) { $rdata.=$key; }

            array_push($datas,$rdata);
        }

        return $datas;
    }


    //*
    //* function InitLangItemData, Parameter list: $obj
    //*
    //* Adds Language Sepecific data to ItemData.
    //*

    function InitLangItemData($obj,$file)
    {
        $this->ReadLangData($obj,$file);

        foreach ($this->Langs as $lang)
        {
            $key=$lang[ "Key" ];
            $rkey=$lang[ "Key" ];
            if (!empty($key)) { $key="_".$key; $rkey=", ".$rkey; }

            foreach (array_keys($obj->LangData) as $data)
            {
                $rdata=$data;
                if (!empty($lang[ "Key" ])) { $rdata.="_".$lang[ "Key" ]; }

                $def=$obj->LangData[ $data ];
                $def[ "Name" ].=$rkey;
                $def[ "ShortName" ].=$rkey;
                $def[ "Title" ].=$rkey;

                $obj->ItemData[ $rdata ]=$def;
            }
        } 
    }

     //*
    //* function InitLangItemDataGroups, Parameter list:
    //*
    //* Adds Language Sepecific data to ItemDataGroups.
    //*

    function InitLangItemDataGroups($obj,$file)
    {
        $groups=$this->ReadPHPArray($file);
        foreach ($this->Langs as $lang)
        {
            $key=$lang[ "Key" ];
            $rkey=$lang[ "Key" ];
            if (!empty($key)) { $key="_".$key; $rkey=", ".$rkey; }

            foreach ($groups as $group => $def)
            {
                $rdatas=array();
                foreach ($def[ "Data" ] as $data)
                {
                    array_push($rdatas,$data.$key);
                }

                $def[ "Name" ].=$rkey;
                $def[ "Name_UK" ].=$rkey;
                $def[ "Data" ]=$rdatas;

                $obj->ItemDataSGroups[ $group.$key ]=$def;

                $def[ "Data" ]=array_merge($obj->LangPluralData,$def[ "Data" ]);
                $obj->ItemDataGroups[ $group.$key ]=$def;
            }
        } 
    }

    //*
    //* function PostProcessLanguageData, Parameter list: &$item,$obj
    //*
    //* Postprocesses $item.
    //*

    function PostProcessLanguageData(&$item,$obj)
    {
        $updatedatas=array();
        foreach ($this->Langs as $lang)
        {
            $key=$lang[ "Key" ];
            if (!empty($key))
            {
                foreach (array_keys($obj->LangData) as $data)
                {
                    $rdata=$data."_".$key;
                    if (
                          !empty($item[ $data ])
                          &&
                          (
                             empty($item[ $rdata ])
                             ||
                             !$item[ $data ]
                          )
                       )
                    {
                        $item[ $rdata ]=$item[ $data ];
                        array_push($updatedatas,$rdata);
                    }
                }
               
            }
        }

        return $updatedatas;
    }
}

?>