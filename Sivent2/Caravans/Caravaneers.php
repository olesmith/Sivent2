<?php

class Caravans_Caravaneers extends Caravans_Emails
{
    //*
    //* function Caravan_Info_Data, Parameter list: $edit,$caravan
    //*
    //* Caravan info show data.
    //*

    function Caravan_Info_Data()
    {
        $datas=$this->MyMod_Data_Group_Datas_Get("Basic");
        if ($this->LatexMode())
        {
            $datas=$this->MyMod_Datas_Actions_Remove($datas);
        }
        
        return $datas;
    }

    //*
    //* function Caravan_Update_Data, Parameter list: $edit,$caravan
    //*
    //* Caravan info show data.
    //*

    function Caravan_Update_Data()
    {
         return $this->MyMod_Data_Group_Datas_Get("Basic");

         return
            array
            (
               "Name","City","Status",
            );
    }

    //*
    //* function Caravan_Info_Friend_Data, Parameter list: $edit,$caravan
    //*
    //* Caravan info friend show data.
    //*

    function Caravan_Info_Friend_Data()
    {
        return
            array
            (
               "Name","Email","Phone","Cell",
            );
    }
    //*
    //* function Caravan_Info_Update, Parameter list: $edit,&$caravan
    //*
    //* Updates caravans info.
    //*

    function Caravan_Info_Update($edit,&$caravan)
    {
        $datas=
            $this->MyMod_Item_Datas_CGI2Item
            (
               $this->Caravan_Update_Data(),
               $caravan
            );

        if (count($datas)>0)
        {
            $this->Sql_Update_Item_Values_Set($datas,$caravan);
        }
    }

    
    //*
    //* function Caravan_Info_Print_Row, Parameter list: $caravan
    //*
    //* Generates caravan print row, with link.
    //*

    function Caravan_Info_Print_Row($caravan)
    {

        $action1=$this->MyActions_Entry("Print_List",$caravan,$noicons=0,$class="",$rargs=array("Latex" => 1));

        $action2=$this->MyActions_Entry("Print_Credencial",$caravan,$noicons=0,$class="",$rargs=array("Latex" => 1));
        return
            array
            (
               $this->B($this->Language_Message("Printable_Versions").":"),
               "[ ".$action1." | ".$action2." ]"
            );
    }

    
    //*
    //* function Caravan_Info_Table, Parameter list: $edit,$caravan,$friend
    //*
    //* Prints caravans info.
    //*

    function Caravan_Info_Table($edit,$caravan,$friend)
    {
        $this->FriendsObj()->ItemData();

        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Caravan_Info_Update($edit,$caravan);
        }

        $table=
            array_merge
            (
               $this->Friendsobj()->MyMod_Item_Table
               (
                  0,
                  $friend,
                  $this->Caravan_Info_Friend_Data()
               ),
               array($this->HR()),
               $this->MyMod_Item_Table
               (
                  $edit,
                  $caravan,
                  $this->Caravan_Info_Data()
               )
            );


        if (!$this->LatexMode())
        {
            array_push($table,$this->Caravan_Info_Print_Row($caravan));
        }
        
        if ($edit==1)
        {
            array_push($table,array($this->Buttons()));
        }
        
        $method="Html_Table";
        if ($this->LatexMode()) { $method="Latex_Table"; }

        return 
            $this->H(1,$this->MyLanguage_GetMessage("Caravans_Table_Title")).
            $this->$method("",$table).
            "";
    }

    //*
    //* function Caravan_Friend_Read, Parameter list: $caravan
    //*
    //* Prints caravaneers info for current item.
    //*

    function Caravan_Friend_Read($caravan)
    {
        if (empty($caravan[ "Friend" ])) { $this->DoDie("No such caravan with owner: ",$friend); }

        $friend=
            $this->FriendsObj()->Sql_Select_Hash
            (
               array("ID" => $caravan[ "Friend" ])
            );

        if (empty($friend[ "ID" ])) { $this->DoDie("No such friend: ",$friendid); }

        return $friend;
    }

    
    //*
    //* function Caravan_Caravaneers_Latex_File, Parameter list: $caravan
    //*
    //* Prints caravaneers info for current item.
    //*

    function Caravan_Caravaneers_Latex_File($caravan)
    {
        return
            "Caravan.".
            preg_replace('/\s+/',".",$caravan[ "Name" ]).
            ".".
            $this->MyTime_FileName().
            ".tex";
    }
    
    //*
    //* function Caravan_Caravaneers_Handle, Parameter list:
    //*
    //* Prints caravaneers info for current item.
    //*

    function Caravan_Caravaneers_Handle()
    {
        $this->CaravaneersObj()->Sql_Table_Structure_Update();
        $this->CaravaneersObj()->Actions();

        $caravanid=$this->CGI_GETint("ID");
        $where=$this->UnitEventWhere(array("ID" => $caravanid));
        $caravan=$this->Sql_Select_Hash($where);

        $edit=1;
        if (!$this->CheckEditAccess($caravan)) { $edit=0; }
        if ($this->LatexMode()) { $edit=0; }
        
        $friend=$this->Caravan_Friend_Read($caravan);
       
        $formstart="";
        $formend="";

        if ($edit==1)
        {
            $formstart=$this->StartForm();
            $formend=
                $this->MakeHidden("Update",1).
                $this->EndForm();
        }

        $infotable=$this->Caravan_Info_Table($edit,$caravan,$friend);
        $table=$this->CaravaneersObj()->Caravaneers_Table_Show($edit,$caravan,$infotable);

        if ($this->LatexMode())
        {
            $latex=
                $this->GetLatexSkel("Head.tex").
                $table.
                $this->GetLatexSkel("Tail.tex").
                "";

            //$this->ShowLatexCode($latex);exit();
            $this->Latex_PDF
            (
               $this->Caravan_Caravaneers_Latex_File($caravan),
               $latex
             );
            exit();
        }

        
        echo $this->FrameIt
        (    
            $formstart.
            $table.
            $formend.
            ""
         );
            
    }
}

?>