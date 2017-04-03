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
        $datas=array();
        if ($this->LatexMode())
        {
            $cred=$this->CGI_GET("Cred");
            if ($cred==1)
            {
                $datas=$this->GetGroupDatas("Latex_Cred");
            }
            else
            {
                $datas=$this->GetGroupDatas("Latex");
            }

            $datas=$this->MyMod_Datas_Actions_Remove($datas);
        }
        else
        {
            $datas=$this->GetGroupDatas("Inscription");
        }

        return $datas;
    }

}

?>