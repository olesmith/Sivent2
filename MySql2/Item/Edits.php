<?php

class ItemEdits extends ItemForms
{
    var $AddDefaults=array();
    var $AddFixedValues=array();

    //*
    //* Adds item to DB.
    //*

    function Add(&$msg,&$item=array())
    {
        if (empty($item)) { $item=$this->ReadPostItem(); }

        foreach ($this->AddFixedValues as $data => $value)
        {
            $item[ $data ]=$value;
        }

        $msg="";
        if ($this->ItemIsUnique($item))
        {
            foreach ($this->AddDefaults as $data => $value)
            {
                if (!isset($item[ $data ]) || empty($item[ $data ])) { $item[ $data ]=$value; }
            }

            $ritem=$item;
            $item=$this->TestItem($item);
            if (isset($item[ "__Errors__" ]) && $item[ "__Errors__" ]>0)
            {
               $msg=$this->H
                (
                   4,
                   "Campos Inválido(s) - ".$this->ItemName." NÃO adicionado!<BR>".
                   $this->HtmlList($item[ "__Error_Messages__" ])
                );

                $this->ItemHash=$item;
                $this->AddDefaults=$item;

                return FALSE;
            }

            $ritem[ "ATime" ]=time();
            $ritem[ "MTime" ]=$ritem[ "ATime" ];
            $ritem[ "CTime" ]=$ritem[ "ATime" ];

            foreach (array_keys($ritem) as $id => $data)
            {
                if (!isset($this->ItemData[ $data ]) || !empty($this->ItemData[ $data ][ "Derived" ]))
                {
                    unset($ritem[ $data ]);
                }
            }

 
          if (isset($this->ItemData[ $this->CreatorField ]))
            {
                if (!isset($item[ $this->CreatorField ]))
                {
                    $ritem[ $this->CreatorField ]=$this->FindLoggedID();
                }
            }

            $res=$this->MySqlInsertItem($this->SqlTableName(),$ritem);
            $item[ "ID" ]=$ritem[ "ID" ];


            $item=$this->SetItemTimes($item);
            $item=$this->ReadItemDerivedData($item);
            $item=$this->PostProcessItem($item);

            $this->ItemHash=$item;
            $this->ApplicationObj->LogMessage("Item Added");

            return TRUE;
        }

        $this->ItemHash=$item;
        $this->AddDefaults=$item;

        return FALSE;
    }


    //*
    //* Copy item to DB.
    //*


    function Copy($item=array())
    {
        if (empty($item)) { $item=$this->ReadPostItem(); }

        foreach ($this->AddFixedValues as $data => $value)
        {
            $item[ $data ]=$value;
        }

        if ($this->ItemIsUnique($item))
        {
            //$this->ApplicationObj->LogMessage("Copy",$item[ "ID" ].": ".$this->GetItemName($item));

            $item[ "ATime" ]=time();
            $item[ "MTime" ]=time();
            $item[ "CTime" ]=time();

            foreach (array_keys($item) as $id => $data)
            {
                if ($this->ItemData[ $data ][ "Derived" ])
                {
                    unset($item[ $data ]);
                }
            }


            if (isset($this->ItemData[ $this->CreatorField ]))
            {
                $item[ $this->CreatorField ]=$this->LoginData[ "ID" ];
            }

            $item=$this->SetItemTimes($item);
            $res=$this->MySqlInsertItem($this->SqlTableName(),$item);

            unset($item[ "CTime" ]);
            unset($item[ "ATime" ]);
            unset($item[ "MTime" ]);
            $item=$this->ReadItemDerivedData($item);
            $item=$this->PostProcessItem($item);
            $this->ApplicationObj->LogMessage("Item Copied");

            $this->ItemHash=$item;

            return TRUE;
        }
        else
        {
            $this->ItemHash=$item;
            return FALSE;
        }
    }

    //*
    //* Deletes item from DB.
    //*

    function Delete($item=array(),$echo=TRUE)
    {
        if (count($item)>0) {} else { $item=$this->ItemHash; }

        $this->ApplicationObj->LogMessage("Item Deleted",$item[ "ID" ].": ".$this->GetItemName($item));
        
        $this->Sql_Delete_Item($item[ "ID" ],"ID",$this->SqlTableName());

        return $item;
    }

    //*
    //* Creates row for defining new item.
    //*

    function AddRow($prekey,$item=array(),$datas=array(),$takepost,$nempties=0)
    {
        $row=array();
        $empty=array();
        for ($n=1;$n<=$nempties;$n++) { array_push($empty,""); }

        foreach ($datas as $data)
        {
            if (!empty($this->ItemData[ $data ]))
            {
                $value="";
                if (!empty($item[ $data ]))
                {
                    $value=$item[ $data ];
                }

                if (empty($item[ $data ]) && $takepost)
                {
                    $value=$this->GetPOST($prekey.$data);
                }

                if (empty($item[ $data ]) && $this->ItemData[ $data ][ "Default" ])
                {
                    $value=$this->ItemData[ $data ][ "Default" ];
                }

                $item[ $data ]=$value;
                array_push
                (
                   $row,
                   $this->PrependInputNameTag
                   (
                      $this->MakeField(1,$item,$data,TRUE),
                      $prekey,
                      1
                   )
                );
            }
            else
            {
                array_push($empty,"&nbsp;");
            }
        }

        array_unshift
        (
           $row,
           $this->MultiCell
           (
              $this->B("Adicionar:").
              $this->MakeHidden("AddRow",1),
              count($empty)-1
           )
        );


        return $row;
    }

    //*
    //* Creates row for defining new item.
    //*

    function UpdateAddRow($prekey,$item=array(),$datas=array())
    {
        if ($this->GetPOST("AddRow")==1)
        {
            $add=TRUE;

            foreach ($datas as $data)
            {
                if (!empty($this->ItemData[ $data ]))
                {
                    $value="";
                    if (!empty($item[ $data ]))
                    {
                        $value=$item[ $data ];
                    }

                    if (empty($value))
                    {
                        $value=$this->GetPOST($prekey.$data);
                    }

                    if (!empty($value))
                    {
                        $item[ $data ]=$value;
                    }
                    elseif (!$this->ItemData[ $data ][ "Compulsory" ])
                    {
                        $item[ $data ]="";
                    }
                    else
                    {
                        $add=FALSE;
                    }
                }
            }

            if (method_exists($this,"MayAdd"))
            {
                $add=$this->MayAdd($item);
            }

            if ($add)
            {
                $msg="";

                $res=$this->Add($msg,$item);
                print $this->H(4,$this->ItemName." adicionado com exito");

                return $item;
            }
            else
            {
                print $this->H(4,$this->ItemName." invalido(a)");
            }
        }

        return FALSE;
    }
}

?>