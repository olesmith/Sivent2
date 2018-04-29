<?php


class DBDataObj extends Table
{
    var $DatasData=array();
    var $DatasGroups=array();
    
    //*
    //* function ReadDBGroups, Parameter list: $groups,$commonpdatas=array()
    //*
    //* Reads item data defs from Quest - and adds to $this->ItemData.
    //*

    function ReadDBGroups($groups,$commonpdatas=array())
    {
        $this->ItemDataGroups();

        $skew=array
        (
           "Text" => "Name",
           "Text_UK" => "Name_UK",
        );

        $listvars=array
        (
        );

        $newdef=array
        (
           "Public" => 0,
           "Person" => 0,
           "Admin" => 2,
           "Coordinator" => 2,
           "Data" => 2, //??
        );

        $this->ItemDataGroups[ "Files" ]=array
        (
           "Name" => "Arquivos",
           "Title" => "Arquivos",
           "Name_UK" => "Arquivos",
           "Title_UK" => "Arquivos",
           "Public" => 0,
           "Person" => 0,
           "Admin" => 2,
           "Coordinator" => 2,
           "Data" => $this->DBDataFileDatas(),           
        );

        $this->DatasGroups=array();


        $sgroups=$this->ItemDataSGroups;
        $this->ItemDataSGroups=array();
        
        $n=1;
        foreach ($groups as $group)
        {
            $def=$newdef;
            foreach ($group as $key => $value)
            {
                if ($key=="ID") { continue; }

                $rkey=$key;
                if (!empty($skew[ $key ])) { $rkey=$skew[ $key ]; }

                if (!empty($listvars[ $key ]))
                {
                    $value=preg_split('/\s*,\s*/',$value);
                }

                $def[ $rkey ]=$value;
            }

            $this->MyMod_Data_Group_Defaults_Take($def);

            $def[ "Friend" ]=$group[ "Friend" ]-1;
            if (!empty($def[ "Assessor" ]))
            {
                $def[ "Assessor" ]=$group[ "Assessor" ]-1;
            }

            $def[ "Data" ]=$this->DatasObj()->Sql_Select_Unique_Col_Values
            (
               "SqlKey",
               array("DataGroup" => $group[ "ID" ]),
               array("SortOrder","ID")
            );

            $nn=1;
            foreach ($def[ "Data" ] as $data)
            {
                foreach ($this->LanguageKeys() as $lang)
                {
                    foreach (array("Name","Title") as $key)
                    {
                        if (!empty($this->ItemData[ $data ][ $key.$lang ]))
                        {
                            $this->ItemData[ $data ][ $key.$lang ]=
                                //$nn.": ".
                                $this->ItemData[ $data ][ $key.$lang ];
                        }
                    }
                }

                $nn++;
            }

            if ($group[ "Singular" ]==1)
            {
                $this->ItemDataSGroups[ $group[ "ID" ] ]=$def;
            }

            foreach ($this->LanguageKeys() as $lang)
            {
                foreach (array("Name","Title") as $key)
                {
                    if (!empty($def[ $key.$lang ]))
                    {
                        $def[ $key.$lang ]=$def[ $key.$lang ];
                    }
                }
            }
            
            if ($group[ "Plural" ]==1)
            {
                $def[ "Data" ]=array_merge($commonpdatas,$def[ "Data" ]);
                $this->ItemDataGroups[ $group[ "ID" ] ]=$def;
            }

            array_push($this->DatasGroups,$group[ "ID" ]);
        }

        $this->ItemDataSGroups=array_merge($this->ItemDataSGroups,$sgroups);
    }

    //*
    //* function ReadDBData, Parameter list:
    //*
    //* Reads item data defs from Datas - and adds to $this->ItemData.
    //* Should be called by PostProcessItemData(), before SQL table structure update.
    //*

    function ReadDBData($quests)
    {
        $this->ItemData("ID");
        
        $skew=array
        (
           "SqlDef" => "Sql",
           "SqlDefault" => "Default",
           "Text" => "Name",
           "Text_UK" => "Name_UK",
           "SValues" => "Values",
           "SValues_UK" => "Values_UK",
        );

        $listvars=array
        (
           "SValues"    => 1,
           "SValues_UK" => 1,
           "Extensions" => 1,
        );

        $newdef=array
        (
           "Public" => 0,
           "Person" => 0,
           "Admin" => 2,
           "Coordinator" => 2,
        );

        $this->DatasData=array();

        foreach ($quests as $quest)
        {
            $data=$quest[ "SqlKey" ];

            $this->ItemData[ $data ]=$newdef;
            foreach ($quest as $key => $value)
            {
                if ($key=="ID") { continue; }
                $rkey=$key;
                if (!empty($skew[ $key ])) { $rkey=$skew[ $key ]; }

                if (!empty($listvars[ $key ]))
                {
                    $value=preg_split('/\s*,\s*/',$value);
                }



                $this->ItemData[ $data ][ $rkey ]=$value;
            }

            $this->MyMod_Data_AddDefaultKeys($this->ItemData[ $data ]);

            //AREA
            $size=$quest[ "Width" ];
            if ($quest[ "Type" ]==6) { $size.="x".$this->ItemData[ $data ][ "Height" ]; }
            $this->ItemData[ $data ][ "Size" ]=$size;

            //SELECT
            if ($quest[ "Type" ]==2) { $this->ItemData[ $data ][ "NoSelectSort" ]=TRUE; }

            //File
            if ($quest[ "Type" ]==3)
            {
                $this->ItemData[ $data ][ "Icon" ]=TRUE;
                if (empty($quest[ "Extensions" ])) { $this->ItemData[ $data ][ "Extensions" ]=array("pdf"); }
            }
            
            //Info
            if ($quest[ "Type" ]==8)
            {
                $this->ItemData[ $data ][ "Info" ]=$quest[ "SqlDefault" ];
            }
            
            //Search
            if (intval($quest[ "SqlSearch" ])==2)
            {
                $this->ItemData[ $data ][ "Search" ]=TRUE;
            }
            
            foreach (array("Friend","Assessor","Compulsory") as $key)
            {
                if (!empty($this->ItemData[ $data ][ $key ]))
                {
                    $this->ItemData[ $data ][ $key ]=$this->ItemData[ $data ][ $key ]-1;
                }
            }

            array_push($this->DatasData,$data);
        }
    }

    
    //*
    //* function DBDataFileDatas, Parameter list:
    //*
    //* Returns quest data of file type.
    //*

    function DBDataFileDatas()
    {
        $fdatas=
            array
            (
                "No","Edit","Delete","Zips",
                "CTime",
                "Friend","Status","Complete",
                "Homologated","Result","Selected");
        foreach ($this->DatasData as $data)
        {
            if ($this->MyMod_Data_Field_Is_File($data))
            {
                array_push($fdatas,$data);
            }
        }

        return $fdatas;
    }
        
 }

?>