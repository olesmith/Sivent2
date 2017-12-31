<?php


trait MyMod_Items_Update
{
        //*
    //* function MyMod_Items_Update, Parameter list: $items=array(),$postprocess=TRUE
    //*
    //* Update all items in $items (or $this->ItemHashes if empty).
    //* First, detects IDs foreach item. Next, retrieves POST vars
    //* from ItemTable form, using TestUpdateItem to test
    //* whether each value has changed.
    //* If a var changes and this var has a TriggerFunction,
    //* this function is called on item.
    //* Increments HtmlStatus on change.
    //*

    function MyMod_Items_Update($items=array(),$udatas=array(),$postprocess=TRUE)
    {
        if (count($items)==0) { $items=$this->ItemHashes; }

        $this->ApplicationObj->LogMessage("UpdateItems",count($items)." items");

        //Time that form was loaded
        $formmtime=$this->GetPOST("__MTime__");

        $ritems=array();
        $origids=array();
        $n=0;
        foreach ($items as $i => $item)
        {
            $item[ "N" ]=$n;
            $ritems[ $item[ "ID" ] ]=$item;
            $origids[ $item[ "ID" ] ]=$i;
            $n++;
        }

        $ids=array_keys($ritems);
        $keys=array_keys($_POST);
        $fkeys=array_keys($_FILES);

        if (!is_array($this->HtmlStatus))
        {
            $this->HtmlStatus=array($this->HtmlStatus);
        }

        if (empty($udatas))
        {
            foreach ($keys as $key)
            {
                if (preg_match('/^\d+_(\S+)$/',$key,$matches))
                {
                    $udatas[ $matches[1] ]=1;
                }
            }

            $udatas=array_keys($udatas);
        }
        
        $udatas=$this->Datas2Datas($udatas);

        foreach ($ids as $id)
        {
            //Test if we have individual access to Edit $item
            if (!$this->MyAction_Allowed("Edit",$ritems[ $id ]))
            {
                continue;
            }

            $rkeys=preg_grep("/^".$id."\_/",$keys);
            $rfkeys=preg_grep("/^".$id."\_/",$fkeys);
            foreach ($rfkeys as $fkey) { array_push($rkeys,$fkey); }

            //Time that form was loaded

            $rupdate=0;
            $update=0;
            $datas=array();
            $olditem=$ritems[ $id ];

            foreach ($udatas as $key)
            {
                //$key=preg_replace("/^$id\_/","",$rkey);
                $rkey=$id."_".$key;
                if (!isset($this->ItemData[ $key ])) { continue; }

                $access=$this->MyMod_Data_Access($key,$olditem);
                if ($access<2)
                {
                   //Not allowed to edit - ignore
                    continue;
                }
                elseif (preg_match('/^FILE$/',$this->ItemData[ $key ][ "Sql" ]))
                {
                    $res=$this->MyMod_Data_Fields_File_Update($key,$ritems[ $id ],$rkey);
                    if (is_array($res) && $res[ "__Res__" ])
                    {
                        $ritems[ $id ]=$res;
                        $rupdate++;
                        array_push($datas,$key);

                        if ($this->MyMod_Data_Trigger_Function($key))
                        { 
                            $ritems[ $id ]=$this->MyMod_Data_Trigger_Apply
                            (
                               $key,
                               $ritems[ $id ],
                               $ritems[$id][ "ID" ]."_" //prekey to POST fields
                            );
                        }

                        $update++;
                    }
                }
                elseif (
                          empty($this->ItemData[ $key  ][ "Derived" ])
                          &&
                          empty($this->ItemData[ $key ][ "TimeType" ])
                       )
                {
                    $newvalue=$this->TestUpdateItem($key,$ritems[ $id ],TRUE);

                   if (
                          !isset($ritems[ $id ][ $key ])
                          ||
                          $newvalue!=$ritems[ $id ][ $key ]
                       )
                    {
                        if ($this->MyMod_Data_Trigger_Function($key))
                        { 
                            $ritems[ $id ]=$this->MyMod_Data_Trigger_Apply
                            (
                               $key,
                               $ritems[ $id ],
                               $ritems[$id][ "ID" ]."_", //prekey to POST fields
                               TRUE
                            );
                        }
                        else
                        {
                            $ritems[ $id ][ $key ]=$newvalue;
                        }

                        $update++;
                        array_push($datas,$key);
                    }
                }
            }

            $itemname=$this->MyMod_Item_Name_Get($ritems[$id]);
            if ($update>0)
            {
                $this->Sql_Update_Item
                (
                    $ritems[$id],
                    $this->Sql_Table_Column_Name_Qualify("ID").
                    "=".
                    $this->Sql_Table_Column_Value_Qualify($ritems[$id][ "ID" ]),
                    $datas,
                    $this->SqlTableName()
                );

                if ($postprocess)
                {
                    //Unset, so that post pŕocessing will recur
                    unset($this->PostProcessed[ $ritems[$id][ "ID" ] ]);
                    $ritems[$id]=$this->MyMod_Item_PostProcess($ritems[$id]);
                }

                $n=$ritems[$id][ "N" ];
                unset($ritems[$id][ "N" ]);
                $this->ApplicationObj->LogMessage
                (
                   "UpdateItem(s)",
                   $ritems[$id][ "ID" ].": ".
                   $this->MyMod_Item_Name_Get($ritems[$id])
                );

                $ritems[$id]=$this->SetItemTime("ATime",$ritems[$id]);
                $ritems[$id]=$this->SetItemTime("MTime",$ritems[$id]);

                if (method_exists($this,"PostUpdateActions"))
                {
                    $this->PostUpdateActions($olditem,$ritems[$id]);
                }                
            }

            $origid=$origids[ $ritems[$id][ "ID" ] ];

            $items[ $origid ]=$ritems[$id];
        }



        return $items;
    }

}

?>