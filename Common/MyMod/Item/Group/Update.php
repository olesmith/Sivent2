<?php


trait MyMod_Item_Group_Update
{
    //*
    //* Update item Group tables form.
    //*

    function MyMod_Item_Groups_Table_Update($updatekey,$groupdefs,&$item,$plural=FALSE,$precgikey="")
    {
        if ($this->CGI_POSTint($updatekey)!=1) { return 0; }

        $groups=$this->MyMod_Item_Group_Defs2Groups($groupdefs);

        $updatedatas=$this->MyMod_Item_Groups_CGI2Item($groups,$item,$plural,$precgikey);

        $this->Sql_Update_Item($item,array("ID" => $item[ "ID" ]),$updatedatas);
        
        $item=$this->MyMod_Item_PostProcess($item);
        
        return 0;
    }
    
    //*
    //* Update item Group tables form.
    //*

    function MyMod_Item_Group_Table_Update($updatekey,$groupdef,&$item,$plural=FALSE,$precgikey="")
    {
        return
            $this->MyMod_Item_Groups_Table_Update
            (
                $updatekey,
                array($groupdef),
                $item,
                $plural,
                $precgikey
            );
        
    }
}

?>