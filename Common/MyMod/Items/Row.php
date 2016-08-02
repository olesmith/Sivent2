<?php


trait MyMod_Items_Row
{
    //*
    //* Creates items table datas row.
    //* Plural default,as we generate $date => $value row.
    //*

    function MyMod_Items_Table_Row($edit,$n,$item,$datas,$plural=TRUE,$pre="")
    {
        if (!is_array($datas)) { $datas=array($datas); }

        $row=array();
        foreach ($datas as $rdata)
        {
            //Trick to be able to have one level sublists
            if (!is_array($rdata)) { $rdata=array($rdata); }

            foreach ($rdata as $data)
            {
                $cell="";

                if ($data=="No") { $cell=$this->B($n); }
                elseif (!empty($this->ItemData[ $data ]))
                {
                    $access=$this->MyMod_Data_Access($data,$item);
 
                    $redit=$edit;

                    if ($access<=1) { $redit=0; }
                    if ($access>=1)
                    {
                        $rdata=$pre.$data;
                        $cell=$this->MyMod_Item_Data_Cell($redit,$item,$data,$plural,$rdata);
                    }
                 }
                elseif (!empty($this->Actions[ $data ]))
                {
                    if ($this->MyAction_Access_Has($data))
                    {
                        $cell=$this->MyActions_Entry($data,$item);
                    }
                }
                elseif (!empty($this->CellMethods[ $data ]))
                {
                    $cell=$this->$data($edit,$item,$data);
                }

                array_push($row,$cell);
            }
        }

        return $row;
    }
}

?>