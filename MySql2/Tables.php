<?php

include_once("Table.php");

class Tables extends Table
{
    //* Class being a table, containing sub table objects.
    // ID being the key common between table.
    //*
    //* Variables of Tables class:

    var $OtherObjects=array();
    var $OtherObjectsTransferData=array();
    
    //*
    //* function Table, Parameter list: 
    //*
    //* Table constructor.
    //*

    function Tables($hash=array())
    {
        $this->InitBase($hash);
    }

    //*
    //* function AddOtherTable, Parameter list: $class,$transferdata=array())
    //*
    //* Creates an additional table-object, adding it to $this->OtherObjects.
    //* Data in $transferdata, if any, are stored in $this->OtherObjectsTransferData.
    //*

    function AddOtherTable($class,$transferdata=array())
    {
       //Load as submodule, return name
        $object=$this->ApplicationObj->MyMod_SubModule_Load($class,TRUE);

        //Retrieve object
        $object=$this->ApplicationObj->$object;
        $object->MyMod_Data_Init(TRUE);

        //Transfer login info, necessary for permissions to work alright
        $object->LoginType=$this->ApplicationObj->LoginType;
        $object->Profile=$this->ApplicationObj->Profile;
        $object->LoginData=$this->ApplicationObj->LoginData;

        //Store object, and do some modifications for funcionality
        $this->OtherObjects[ $class ]=$object;

        $this->OtherObjectsTransferData[ $class ]=$transferdata;
        foreach ($transferdata as $data)
        {
            $object->ItemData[ $data ]=$this->ItemData[ $data ];

            //Make base table data read only
            $object->ItemData[ $data ][ $this->LoginType ]=1;
            $object->ItemData[ $data ][ $this->Profile ]=1;
            $object->ItemData[ $data ][ "Derived" ]=1;
        }

        //Make tab moves down work
        $object->TabMovesDownKey=
            $this->ModuleName.
            preg_replace('/[^_]+_/',"_",$this->TabMovesDownKey);

        //Make some Actions point to base class module

        $query=$this->ScriptQueryHash();
        $query[ "ModuleName" ]=$this->ModuleName;
        $query[ "ID" ]="#ID";
        $object->InitActions();

        foreach (array_keys($object->Actions) as $action)
        {
            if (!empty($object->Actions[ $action ]))
            {
                $object->Actions[ $action ]=$this->Actions[ $action ];

                $query[ "Action" ]=$action;
                $object->Actions[ $action ][ "Href" ]="?".$this->Hash2Query($query);
            }
        }

        //Data groups of other class data: suppres printing of titles row in HandleList.
        foreach (array_keys($this->ItemDataGroups) as $group)
        {
            if (
                  $this->ItemDataGroups[ $group ][ "OtherClass" ]
                  &&
                  $this->ItemDataGroups[ $group ][ "OtherGroup" ]
               )
            {
                $this->ItemDataGroups[ $group ][ "NoTitleRow" ]=TRUE;
            }
        }


        $object->InitLatexData();
        foreach (array_keys($object->LatexData[ "SingularLatexDocs" ]) as $doc)
        {
            $this->LatexData[ "SingularLatexDocs" ][ $doc ]=$object->LatexData[ "SingularLatexDocs" ][ $doc ];
        }

        foreach (array_keys($object->LatexData[ "PluralLatexDocs" ]) as $doc)
        {
            $this->LatexData[ "PluralLatexDocs" ][ $doc ]=$object->LatexData[ "PluralLatexDocs" ][ $doc ];
        }

        return $object;
    }

    //*
    //* function ItemReadOtherData, Parameter list: $item
    //*
    //* Override read item from Table. Call parent::ReadItem,
    //* then check if ID exists in other table. If not, create
    //* it!
    //* Checked existence, read the item.
    //*

    function ItemReadOtherData($item)
    {
        if (!isset($item[ "ID" ])) { return; }

        foreach ($this->OtherObjects as $class => $object)
        {
            //if (!isset($item[ "ID" ])) { var_dump($item); }
            $otheritem=$object->SelectUniqueHash
            (
               "",
               array("ID" => $item[ "ID" ]),
               TRUE
            );

            if (empty($otheritem))
            {
                $msg="";
                $otheritem=array("ID" => $item[ "ID" ]);
                $object->Add($msg,$otheritem);

                foreach (array_keys($object->ItemData) as $data)
                {
                    $otheritem[ $data ]="";
                    if ($object->ItemData[ $data ][ "Default" ])
                    {
                        $otheritem[ $data ]=$object->ItemData[ $data ][ "Default" ];
                    }
                }
            }

            foreach ($this->OtherObjectsTransferData[ $class ] as $data)
            {
                if (isset($item[ $data ]))
                {
                    $otheritem[ $data ]=$item[ $data ];
                }
            }

            $object->ItemHash=$object->PostProcessItem($otheritem);
        }
    }


    //*
    //* function ReadItem, Parameter list: $id,$datas=array(),$noderiveds=FALSE
    //*
    //* Override read item from Table. Call parent::ReadItem,
    //* then check if ID exists in other table. If not, create
    //* it!
    //* Checked existence, read the item.
    //*

    function ReadItem($id,$datas=array(),$noderiveds=FALSE,$updatesitemhashes=TRUE)
    {
        $item=parent::ReadItem($id,$datas,$noderiveds,$updatesitemhashes);
        $this->ItemReadOtherData($item);

        return $item;
    }


    //*
    //* function ReadItems, Parameter list: $where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=1
    //*
    //* Override read items from Table. Call parent::ReadItems,
    //* Then calls routine above to read other tables data.
    //*

    function ReadItems($where="",$datas=array(),$nosearches=FALSE,$nopaging=FALSE,$includeall=1)
    {
        parent::ReadItems($where,$datas,$nosearches,$nopaging,$includeall);
        foreach ($this->ItemHashes as $id => $item)
        {
            $this->ItemReadOtherData($item);
            foreach ($this->OtherObjects as $object)
            {
                $object->ItemHashes[ $id ]=$object->ItemHash;
            }
        }
    }

    //*
    //* function ItemsTableDataGroup, Parameter list: $title,$edit=0,$group="",$items=array(),$cgiupdatevar = 'Update'
    //*
    //* Overrides ItemsTableDataGroup from Table. Checks if Group is a Other object group,
    //* if so, calls data group on subobject, otherwise passes on to parent.
    //*

    function ItemsTableDataGroup($title,$edit=0,$group="",$items=array(),$titles=array(),$cgiupdatevar = 'Update')
    {
        if ($group=="") { $group=$this->GetActualDataGroup(); }

        if (
              $this->ItemDataGroups[ $group ][ "OtherClass" ]
              &&
              $this->ItemDataGroups[ $group ][ "OtherGroup" ]
           )
        {
            if (!empty($this->OtherObjects[ $this->ItemDataGroups[ $group ][ "OtherClass" ] ]))
            {
                $object=$this->OtherObjects[ $this->ItemDataGroups[ $group ][ "OtherClass" ] ];
                return $object->ItemsTableDataGroup
                (
                   $title,
                   $edit,
                   $this->ItemDataGroups[ $group ][ "OtherGroup" ]
                );
            }
        }

        return parent::ItemsTableDataGroup
        (
           $title,
           $edit,
           $group,
           $items,
           $titles
        );
    }


    //*
    //* function ItemsTableDataSGroup, Parameter list: $edit,$item,$group,$datas=array()
    //*
    //* Overrides ItemsTableDataGroup from Table. Checks if Group is a Other object group,
    //* if so, calls data group on subobject, otherwise passes on to parent.
    //*

    function ItemTableDataSGroup($edit,$item,$group,$datas=array())
    {
        if ($group=="") { $group=$this->GetActualDataGroup(); }

        if (
              $this->ItemDataSGroups[ $group ][ "OtherClass" ]
              &&
              $this->ItemDataSGroups[ $group ][ "OtherGroup" ]
           )
        {
            $class=$this->ItemDataSGroups[ $group ][ "OtherClass" ];
            if (!empty($this->OtherObjects[ $class ]))
            {
                $object=$this->OtherObjects[ $this->ItemDataSGroups[ $group ][ "OtherClass" ] ];

                return $object->ItemTableDataSGroup
                (
                   $edit,
                   $object->ItemHash,
                   $this->ItemDataSGroups[ $group ][ "OtherGroup" ]
                );
            }
            else { return array(); }
        }

        return parent::ItemTableDataSGroup($edit,$item,$group,$datas);
    }

    //*
    //* function UpdateItem, Parameter list: $item=array(),$datas=array(),$prepost=""
    //*
    //* Overrides UpdateItem from Table.
    //*

    function UpdateItem($item=array(),$datas=array(),$prepost="")
    {
        $item=parent::UpdateItem($item,$datas,$prepost);
        foreach ($this->OtherObjects as $object)
        {
            $object->ItemHash=$object->UpdateItem($object->ItemHash);
        }

        return $item;
    }


}

?>