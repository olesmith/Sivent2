<?php


trait MyMod_Item_Group_Form
{
    //*
    //* Handles item Group tables form.
    //*

    function MyMod_Item_Group_Tables_Form($edit,$updatekey,$groupdefs,$item,$mayupdate=TRUE,$plural=FALSE,$precgikey="",$buttons="")
    {
        if ($edit==1)
        {
            $edit=$this->MyMod_Item_Group_Edit_Should($groupdefs);
        }
        
        if ($edit==1 && $mayupdate && $this->CGI_POSTint($updatekey)==1)
        {
            $this->MyMod_Item_Groups_Table_Update($updatekey,$groupdefs,$item,$plural,$precgikey);
        }

        $pre="";
        $post="";
        if ($edit==1)
        {
            $pre=
                $this->StartForm().
                "";

            if (!$buttons)
            {
                $buttons=$this->Buttons();
            }
            
            $post=
                $this->MakeHidden($updatekey,1).
                $this->EndForm().
                "";
        }

        return
            $pre.
            $this->MyMod_Item_Group_Tables_Html($groupdefs,$item,$buttons,$plural).
            $post.
            "";
    }
}

?>