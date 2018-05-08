<?php

class EventsPayments extends EventsCaravans
{
    //*
    //* function Event_Payments_Has, Parameter list: $item=array()
    //*
    //* Returns TRUE if event is paid.
    //*

    function Event_Payments_Has($item=array())
    {
        if (empty($item)) { $item=$this->Event(); }

        $res=FALSE;
        if (!empty($item[ "Payments" ]) && $item[ "Payments" ]==2)
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* function Event_Payments_Table, Parameter list: $group
    //*
    //* Generates Event Payments Group table
    //*

    function Event_Payments_Datas($group,$item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }
        
        $commondata=
            array
            (
                "Payments_Info",
                "Payments_URL",
                "Payments_Type",
            );


        $datas=array();
        if ($item[ "Payments_Type" ]==1)
        {
            $datas=
                array
                (
                    "Payments_Login",
                    "Payments_Agency",                    
                    "Payments_Name",
                    "Payments_Operation",
                    "Payments_Account",
                    "Payments_Variation",
                );
        }
        elseif ($item[ "Payments_Type" ]==2)
        {
            $datas=
                array
                (
                    "Payments_PagSeguro_Login",
                    "Payments_PagSeguro_Code",
                );
        }

        $datas=
            array_merge
            (
                $commondata,
                $datas
            );

        return $this->FindAllowedData($edit=0,$datas);
    }
}

?>