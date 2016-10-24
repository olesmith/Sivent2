<?php


class Caravaneers_Table_Data extends Caravaneers_Access
{
    //*
    //* function Caravaneers_Table_Data, Parameter list: 
    //*
    //* Data to display in caravaneers table..
    //*

    function Caravaneers_Table_Data()
    {
        $datas=$this->GetGroupDatas("Inscription");
        if ($this->LatexMode())
        {
            $datas=$this->GetGroupDatas("Latex");
            $datas=$this->MyMod_Datas_Actions_Remove($datas);
        }

        return $datas;
    }

}

?>