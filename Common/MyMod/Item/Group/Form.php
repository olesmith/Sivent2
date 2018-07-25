<?php


trait MyMod_Item_Group_Form
{
    //*
    //* Handles item Group tables form.
    //*

    function MyMod_Item_Group_Tables_Form($edit,$updatekey,$groupdefs,$item,$mayupdate=TRUE,$plural=FALSE,$precgikey="",$buttons="")
    {
        ##$config=$this->ReadPHPArray("System/Events/Config.Messages.php");
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
            $this->Htmls_Form
            (
                $edit,
                "Collaborations",
                $action="",
                #Content
                $this->MyMod_Item_Group_Tables_Html($edit,$groupdefs,$item,$buttons,$plural)
            );
    }
    
    //*
    //* Handles item Group tables form.
    //*

    function MyMod_Item_Group_Table_Form($edit,$updatekey,$group,$item,$mayupdate=TRUE,$plural=FALSE,$precgikey="",$buttons="",$title="",$prerows=array(),$postrows=array(),$precols=array(),$postcols=array())
    {
        $groupdef=$this->ItemDataSGroups($group);
        
        $pre="";
        $post="";
        if ($edit==1)
        {
            $edit=$this->MyMod_Item_Group_Allowed($groupdef);
        }

        if ($edit==1)
        {
            $pre=
                $this->StartForm().
                "";
            
            $post=
                $this->MakeHidden($updatekey,1).
                $this->EndForm().
                "";
        }

        if
            (
                $edit==1
                &&
                $mayupdate
                &&
                $this->CGI_POSTint($updatekey)==1
            )
        {
            $this->MyMod_Item_Group_Table_Update($updatekey,$groupdef,$item,$plural,$precgikey);
        }

        $postrows=
            array_merge
            (
                array($this->Buttons()),
                $postrows
            );


        return
            $pre.
            $this->FrameIt
            (
                $this->MyMod_Item_Group_Table_HTML
                (
                    $edit,
                    $group,
                    $item,
                    $plural,
                    $precgikey,
                    $options=array(),
                    $title,
                    $prerows,
                    $postrows,
                    $precols,
                    $postcols
                )
            ).
            $post.
            "";
    }

}

?>
