<?php

class MyInscriptionsInscriptionMessages extends MyInscriptionsInscriptionRead
{
    //*
    //* function InscriptionMessageRow, Parameter list: $inscription=array()
    //*
    //* Creates Inscription message, based on $inscription
    //*

    function InscriptionMessageRow($inscription=array())
    {
        if (empty($inscription)) { $inscription=$this->Inscription; }
        
        $msg="";
        if (empty($inscription[ "ID" ]))
        {
            $msg=
                $this->Span($this->Messages("Inscription_Not_Inscribed"),array("CLASS" => 'errors'));
        }
        else
        {
            $msg=$this->Span($this->Messages("Inscription_Inscribed"),array("CLASS" => 'success'));
         
        }

        return array($this->B($this->MyLanguage_GetMessage("Friend_Data_Status_Title").":"),$msg);
    }

    //*
    //* function InscriptionDataMessageRow, Parameter list:
    //*
    //* Creates Inscription message, based on $inscription
    //*

    function InscriptionDataMessageRow()
    {
        $msg1="";
        $msg2="";
        $datas=$this->UndefinedCompulsorySGroupsDatas();

        if (count($datas)>0)
        {
            $msg1=$this->B($this->Messages("Friend_Data_Diag_Error").":");     
            $msg2=join("<BR>",$this->GetDataTitles($datas));
        }
        else
        {
            $msg1=$this->B($this->Messages("Friend_Data_Diag_OK").".");     
        }

        return array($msg1,$msg2);
    }

}

?>