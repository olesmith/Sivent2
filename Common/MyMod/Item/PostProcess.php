<?php


trait MyMod_Item_PostProcess
{
    protected $MyMod_Item_PostProcess_Values=array();
    
    //*
    //* Post processes item with respect to $data.
    //*

    function MyMod_Item_PostProcess_Value_Get($item,$data,$destdata)
    {
        if (empty($this->MyMod_Item_PostProcess_Values[ $data ]))
        {
            $this->MyMod_Item_PostProcess_Values[ $data ]=array();
        }
        
        if (empty($this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ]))
        {
            $this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ]=array();
            $this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ][ "Names" ]=array();
        }
        
        if (empty($this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ][ $item[ $data ] ]))
        {
            $mod=$this->ItemData($destdata,"Post_Obj")."Obj";
            $value=$this->$mod()->Sql_Select_Hash_Value($item[ $data ],$destdata);
            
            $this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ][ $item[ $data ] ]=$value;

            $class=$this->ItemData($destdata,"SqlClass");
            if (!empty($class) && empty($this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ][ "Names" ][ $value ]))
            {
                $class.="Obj";
                $name=$this->$class()->Sql_Select_Hash_Value($value,"Name");
                
                $this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ][ "Names" ][ $value ]=$name;
            }
        }
        
        return $this->MyMod_Item_PostProcess_Values[ $data ][ $destdata ][ $item[ $data ] ];
    }
    
    //*
    //* Post processes item with respect to $data.
    //*

    function MyMod_Item_PostProcess_Data(&$item,$destdata,&$updatedatas)
    {
        $data=$this->ItemData($destdata,"Post_Data");
        if (!empty($item[ $data ]))
        {
            $value=$this->MyMod_Item_PostProcess_Value_Get($item,$data,$destdata);
            if (empty($item[ $destdata ]) || $item[ $destdata ]!=$value)
            {
                $item[ $destdata ]=$value;
                array_push($updatedatas,$destdata);
            }
        }
    }

     //*
    //* function MyMod_Item_PostProcess_Trim, Parameter list: $item
    //*
    //* Trims casing for each ItemData definition,
    //* which has TrimCase set.
    //* Returns modified item.
    //*

    function MyMod_Item_PostProcess_Trim($item)
    {
        foreach ($this->DatasRead as $data)
        {
            if (!empty($this->ItemData[ $data ][ "TrimCase" ]))
            {
                $item[ $data ]=$this->TrimCase($item[ $data ]);
            }
            if (!empty($this->ItemData[ $data ][ "ToUpper" ]))
            {
                $item[ $data ]=strtoupper($item[ $data ]);
            }
            if (!empty($this->ItemData[ $data ][ "ToLower" ]))
            {
                $item[ $data ]=strtolower($item[ $data ]);
            }
         }

        return $item;
    }

     //*
    //* function MyMod_Item_PostProcess_Languaged, Parameter list: &$item
    //*
    //* Will take default values for languaged values.
    //*

    function MyMod_Item_PostProcess_Languaged(&$item)
    {
        $updatedatas=array();
        foreach ($this->DatasRead as $data)
        {
            if (!empty($this->ItemData[ $data ][ "Languaged" ]))
            {
                foreach ($this->MyMod_Languaged_Data_Get($data) as $langdata)
                {
                    if (empty($item[ $langdata ]))
                    {
                        $item[ $langdata ]=$item[ $data ];
                        array_push($updatedatas,$langdata);
                    }
                }
            }
        }

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
    }

   
    //*
    //* function MyMod_Item_PostProcess_Files, Parameter list: $item
    //*
    //* Verifyes file path, moving if necessary.
    //*

    function MyMod_Item_PostProcess_Files($item)
    {
        $datas=$this->GetFileFields();
        $uploadpath=$this->MyMod_Data_Upload_Path();
        $this->Sql_Select_Hash_Datas_Read($item,$datas);

        //return $item;
        foreach ($datas as $data)
        {
            if (!empty($item[ $data ]))
            {
                $fname=$uploadpath."/".basename($item[ $data ]);
                
                if ($item[ $data ]!=$fname)
                {
                    if (file_exists($item[ $data ]) && !file_exists($fname))
                    {
                        $res=rename($item[ $data ],$fname);
                        if (file_exists($fname))
                        {
            #var_dump("moving ".$item[ $data ]."  => ".$fname);
                            $item[ $data ]=$fname;
                            $this->Sql_Update_Item_Value_Set
                            (
                                $item[ "ID" ],
                                $data,
                                $item[ $data ],
                                "ID"
                            );
                            
                        }
                    }

                }
            }
        }
        return $item;
    }


    //*
    //* function MyMod_Item_PostProcess, Parameter list: $item
    //*
    //* Post process item. That is: calls TrimCaseItem,
    //* if $this->ItemPostProcessor is set, and is
    //* a method, this method is called for post specialized
    //* post processing.
    //* Finally, call TestItem.
    //* Returns modified item.
    //*

    function MyMod_Item_PostProcess($item)
    {
        if (
            !isset($item[ "ID" ])
            ||
            isset($this->PostProcessed[ $item[ "ID" ] ])
           )
        {
            return $item;
        }

        $ritem=$this->ApplyAllEnums($item);
        $updatedatas=array();

        foreach ($this->DatasRead as $id => $data)
        {
            $hashdef=$this->ItemData($data);
            if (empty($hashdef)) { continue; }
            if (empty($item[ $data ])) { continue; }
            
            $value=preg_replace('/^\s*/',"",$item[ $data ]);
            $value=preg_replace('/\s*$/',"",$value);
            $value=preg_replace('/&#39;/',"'",$value);

            if (!empty($hashdef[ "Format" ]))
            {
                $value=sprintf($hashdef[ "Format" ],$value);
            }

            if ($item[ $data ]!=$value)
            {
                $item[ $data ]!=$value;
                array_push($updatedatas,$data);
            }
            
            $postdata=$this->ItemData($data,"Post_Data");
            if (!empty($postdata))
            {
                $this->MyMod_Item_PostProcess_Data($item,$data,$updatedatas);
            }
        }

        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
        
        $item=$this->MyMod_Item_PostProcess_Trim($item);
        $item=$this->MyMod_Item_PostProcess_Files($item);
        $this->MyMod_Item_PostProcess_Languaged($item);
        $post=$this->ItemPostProcessor;
        if (empty($post))
        {
            $post="PostProcess";
        }

        if (method_exists($this,$post))
        {
            $item=$this->$post($item);
        }
        else
        {
            $this->AddMsg("Warning! No such postprocessor: $post");
        }

        $item=$this->TestItem($item);

        if (isset($item[ "ID" ]))
        {
            $this->PostProcessed[ $item[ "ID" ] ]=TRUE;
        }

        $this->Sql_Table_Index_Set($item);

        return $item;
    }
}

?>