<?php

class InscriptionsPayments extends InscriptionsAccess
{
    //*
    //* function PostProcess_Type, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription type: tries to find suitable default:
    //*
    //* Most expensive in current Lot.
    //*

    function PostProcess_Type(&$item,&$updatedatas,$clot=array())
    {
        if (empty($clot)) { $clot=$this->LotsObj()->Lot_Current_Get();}

        if (empty($item[ "Type" ]) && !empty($clot))
        {
            $type=$this->LotsObj()->Lot_Default_Type_Get($clot);
            if ($type>0)
            {
                $item[ "Type" ]=$type;
                array_push($updatedatas,"Type");
            }            
        }
     }

    //*
    //* function Inscription_Payment_Lot, Parameter list: $item,$lot=array()
    //*
    //* Returns suitable lot.
    //*

    function Inscription_Payment_Lot($item)
    {
        $lotid=0;
        if (empty($item[ "Lot" ])) { $lotid=$item[ "Lot" ]; }
        
        $lot=array();
        if ($item[ "Has_Paid" ]!=3)
        {
           $lot=$this->LotsObj()->Lot($lotid);
        }
       
        return $lot;
    }

    //*
    //* function Inscription_Payment_Nominal, Parameter list: $item,$lot=array()
    //*
    //* Calulates Inscription nominal value.
    //*

    function Inscription_Payment_Nominal($item,$lot=array())
    {        
        if (is_int($lot)) { $lot=array("ID" => $lot); }

        $lot=$this->Inscription_Payment_Lot($item);

        $value=0.0;
        if (!empty($lot) && !empty($item[ "Type" ]))
        {
            $key="Value_".$item[ "Type" ];
            $value=$lot[ $key ];
        }
        
                    
        return $value;      
    }

    
    //*
    //* function PostProcess_Payment, Parameter list: &$item,&$updatedatas
    //*
    //* Postprocesses inscription certificate.
    //*

    function PostProcess_Payment(&$item,&$updatedatas)
    {
        if (!$this->EventsObj()->Event_Payments_Has()) { return ; }
        $datas=$this->ItemDataSGroups("Payments","Data");
        $this->Sql_Select_Hash_Datas_Read($item,$datas);
        
        $this->PostProcess_Type($item,$updatedatas);
        $type=$item[ "Type" ];

        $lot=$this->Inscription_Payment_Lot($item);
        $value=$this->Inscription_Payment_Nominal($item,$lot);

        if ($value!=$item[ "Value_Nominal" ] && $item[ "Has_Paid" ]<=1)
        {
            //Set and update
            $item[ "Value_Nominal" ]=$value;
            array_push($updatedatas,"Value_Nominal");
        }
    }

    //*
    //* function Inscriptions_Payment_Data_Access, Parameter list: $data,$item
    //*
    //* Determines if we have access to edit $eidt
    //*

    function Inscriptions_Payment_Data_Access($data,$item)
    {
        if (empty($item)) { return 1; }
        
        $datas=array("Has_Paid");
        $this->Sql_Select_Hash_Datas_Read($item,$datas);

        $res=$this->ItemData[ $data ][ $this->Profile() ];
        if ($res>0 && $item[ "Has_Paid" ]!=2)
        {
            $res=1;
        }
        
        return $res;
    }
    //*
    //* function Inscription_Payment_Update_Register, Parameter list: 
    //*
    //* Processes newvalue of Has_Paid field.
    //*

    function Inscription_Payment_Update_Register($item,$data,$newvalue)
    {
        $oldvalue=1;
        if (!empty($item[ $data ]))
        {
            $oldvalue=$item[ $data ];
        }

        if ($newvalue!=$oldvalue)
        {
            $item[ $data ]=$newvalue;
        }
        
        if ($newvalue==1)
        {
            $this->Inscription_Payment_UnRegister($item);
        }
        elseif ($newvalue>=2)
        {
            $this->Inscription_Payment_Register($item,$newvalue);
        }
        
        

        return $item;
    }

    //*
    //* function Inscription_Payment_Register_CGI2Value, Parameter list: 
    //*
    //* Detects value to register: CGI or defaults. 
    //*

    function Inscription_Payment_Register_CGI2Value($item)
    {
        $skey="Value_Paid";
        $pkey=$item[ "ID" ]."_".$skey;
        $valuepaid=$item[ "Value_Nominal" ];

        if (isset($_POST[ $pkey ]))
        {
            $valuepaid=$this->CGI_POST_Real($pkey); 
        }
        elseif (isset($_POST[ $skey ]))
        {
            $valuepaid=$this->CGI_POST_Real($skey); 
        }

        if ($valuepaid==0.0)
        {
            $valuepaid=$item[ "Value_Nominl" ];
        }

        //Isento
        if ($item[ "Has_Paid" ]==3)
        {
            $valuepaid=0.0;
        }

        return $valuepaid;
    }

    
    //*
    //* function Inscription_Payment_Register_CGI2Date, Parameter list: 
    //*
    //* Detects value to register: CGI or defaults. 
    //*

    function Inscription_Payment_Register_CGI2Date($item)
    {
        $skey="Date_Paid";
        $pkey=$item[ "ID" ]."_".$skey;
        
        $today=$this->MyTime_2Sort();
        
        $datepaid=$today;
        
        if (isset($_POST[ $pkey ]))
        {
            $datepaid=$this->CGI_POST($pkey); 
        }
        elseif (isset($_POST[ $skey ]))
        {
            $datepaid=$this->CGI_POST($skey); 
        }
        
        if (empty($datepaid))
        {
            $datepaid=$today;
        }

        return $datepaid;
    }

    
        
    //*
    //* function Inscription_Payment_Register, Parameter list: 
    //*
    //* Register payment: update fellow fields.
    //*

    function Inscription_Payment_Register(&$item,$newvalue)
    {
        $updatedatas=array();
        $lot=$this->Inscription_Payment_Lot($item);

        if (!empty($lot) && $item[ "Lot" ]!=$lot)
        {
            $lot=$lot[ "ID" ];
        
            $item[ "Lot" ]=$lot;
            array_push($updatedatas,"Lot");
        }

        
        if ($item[ "Type" ]==3)
        {
            $item[ "Lot" ]=0;
            array_push($updatedatas,"Lot");
        }
        
        
        if ($item[ "Has_Paid" ]!=$newvalue)
        {
            $item[ "Has_Paid" ]=$newvalue;
            array_push($updatedatas,"Has_Paid");
        }
        
        $datepaid=$this->Inscription_Payment_Register_CGI2Date($item);
        if ($item[ "Date_Paid" ]!=$datepaid)
        {
            $item[ "Date_Paid" ]=$datepaid;
            array_push($updatedatas,"Date_Paid");
        }

        
        $valuepaid=$this->Inscription_Payment_Register_CGI2Value($item);
        if ($item[ "Value_Paid" ]!=$valuepaid)
        {
            $item[ "Value_Paid" ]=$valuepaid;
            array_push($updatedatas,"Value_Paid");
        }
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
    }

    //*
    //* function Inscription_Payment_UnRegister, Parameter list: 
    //*
    //* UnRegister payment: zero fellow fields.
    //*

    function Inscription_Payment_UnRegister(&$item)
    {
        $today=$this->MyTime_2Sort();
        $updatedatas=array();

        if ($item[ "Has_Paid" ]!=1)
        {
            $item[ "Has_Paid" ]=1;
            array_push($updatedatas,"Has_Paid");
        }
        
        if ($item[ "Date_Paid" ]!=0)
        {
            $item[ "Date_Paid" ]=0;
            array_push($updatedatas,"Date_Paid");
        }
        
        if ($item[ "Value_Paid" ]!=0)
        {
            $item[ "Value_Paid" ]=0.0;
            array_push($updatedatas,"Value_Paid");
        }
        
        if ($item[ "Lot" ]!=0)
        {
            $item[ "Lot" ]=0;
            array_push($updatedatas,"Lot");
        }
        
        if (count($updatedatas)>0)
        {
            $this->Sql_Update_Item_Values_Set($updatedatas,$item);
        }
    }

    
}

?>