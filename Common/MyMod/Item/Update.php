<?php


trait MyMod_Item_Update
{
    //*
    //* Updates item according to CGI.
    //*

    function MyMod_Item_Update_SGroup($item,$group,$prepost="",$postprocess=TRUE)
    {
        return $this->MyMod_Item_Update_CGI
        (
           $item,
           $this->GetGroupDatas($group,TRUE),
           $prepost,
           $postprocess
        );
    }
    
    //*
    //* Updates item according to CGI.
    //*

    function MyMod_Item_Update_CGI($item=array(),$datas=array(),$prepost="",$postprocess=TRUE)
    {
        if (count($item)==0) { $item=$this->ItemHash; }
        if (isset($this->PostProcessed[ $item[ "ID" ] ]))
        {
            unset($this->PostProcessed[ $item[ "ID" ] ]);
        }

        $olditem=$item;

        if (count($datas)==0) { $datas=array_keys($this->ItemData); }


        $rupdate=0;
        $update=0;
        $updatedatas=array(); //datas that are actually updated
        foreach ($datas as $id => $rrdata)
        {
            $rrdatas=$rrdata;
            if (!is_array($rrdata)) { $rrdatas=array($rrdata); }
            
            foreach ($rrdatas as $data)
            {
                $access=$this->MyMod_Data_Access($data,$item);
                if ($access<2)
                {
                     //Not allowed to edit - ignore
                    continue;
                }
                elseif (preg_match('/^FILE$/',$this->ItemData[ $data ][ "Sql" ]))
                {
                    $res=$this->MyMod_Data_Fields_File_Update($data,$item);
                    if (is_array($res) && $res[ "__Res__" ])
                    {
                        $item=$res;
                        $rupdate++;
                        array_push($updatedatas,$data);

                        if ($this->MyMod_Data_Trigger_Function($data))
                        { 
                            $item=$this->MyMod_Data_Trigger_Apply($data,$item,$prepost);
                        }
                        
                        $update++;
                    }
                }
                elseif (
                          empty($this->ItemData[ $data ][ "Derived" ])
                          && 
                          empty($this->ItemData[ $data ][ "TimeType" ])
                       )
                {                    
                    $newvalue=$this->TestUpdateItem($data,$item,FALSE,$prepost);
                    $default=$this->ItemData($data,"Default");
                   
                    if (empty($newvalue) && !empty($default))
                    {
                        $newvalue=htmlentities($default);
                        $newvalue=preg_replace('/\\\\/',"&#92;",$newvalue);
                    }

                    $oldvalue="";
                    if (!empty($item[ $data ])) { $oldvalue=$item[ $data ]; }

                    if ($this->MyMod_Data_Trigger_Function($data))
                    {
                        $item=$this->MyMod_Data_Trigger_Apply($data,$item,$prepost);
                    }
                    else
                    {
                        $item[ $data ]=$newvalue;
                    }

                    if ($item[ $data ]!=$oldvalue)
                    {
                        //var_dump("$data: $oldvalue => $newvalue") ;
                        $update++;
                        array_push($updatedatas,$data);
                    }
                    
                }
            }
        }

        $this->FormWasUpdated=FALSE;
        if ($update>0)
        {
            $this->ApplicationObj->LogMessage
            (
               "UpdateItem",
               $item[ "ID" ].": ".
               $this->GetItemName($item)
            );

            $this->Sql_Update_Item
            (
                $item,
                array("ID" => $item[ "ID" ]),
                $updatedatas
            );

            $item=$this->ReadItemDerivedData($item);
            $item=$this->SetItemTime("MTime",$item);
            $item=$this->SetItemTime("ATime",$item);

            $rdatanames=array();
            foreach ($updatedatas as $rdata)
            {
                array_push($rdatanames,$this->GetDataTitle($rdata));
            }

            $this->ApplicationObj()->AddHtmlStatusMessage
            (
               $this->B($this->MyLanguage_GetMessage("Altered").": ").
               $this->HtmlList($rdatanames)
            );

            $this->ApplicationObj()->AddHtmlStatusMessage
            (
               $this->GetMessage
               (
                  $this->ItemDataMessages,
                  "DataChanged"
               )
            );

            $this->FormWasUpdated=TRUE;
            if (method_exists($this,"PostUpdateActions"))
            {
                $this->PostUpdateActions($olditem,$item);
            }
        }
        else
        {
            $this->ApplicationObj()->AddHtmlStatusMessage
            (
               $this->GetMessage
               (
                  $this->ItemDataMessages,
                  "DataUnchanged"
               )
            );
        }

        if ($this->FormWasUpdated && $postprocess)
        {
            $item=$this->PostProcessItem($item);
        }

        return $item;
    }

}

?>