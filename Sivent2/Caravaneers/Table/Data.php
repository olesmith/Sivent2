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
                $datas=$this->MyMod_Data_Group_Datas_Get("Latex_Cred");
            }
            else
            {
                $datas=$this->MyMod_Data_Group_Datas_Get("Latex");
            }

            $datas=$this->MyMod_Datas_Actions_Remove($datas);
        }
        else
        {
            $datas=$this->MyMod_Data_Group_Datas_Get("Inscription");
        }

        return $datas;
    }

}

?>