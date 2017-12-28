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


}

?>