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

   

}

?>