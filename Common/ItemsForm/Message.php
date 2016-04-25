<?php


trait ItemsFormMessage
{
    var $ItemsForm_Messages=array();
    var $ItemsForm_FromUpdated=FALSE;

    //*
    //* function ItemsForm_AddMessage, Parameter list: $msg
    //*
    //* Generates emtpy item add row.
    //* 
    //*

    function ItemsForm_AddMessage($msg)
    {
        array_push($this->ItemsForm_Messages,$msg);
    }


    //*
    //* function ItemsForm_ShowMessages, Parameter list: $sucessmessage,$failuremessage
    //*
    //* Generates emtpy item add row.
    //* 
    //*

    function ItemsForm_ShowMessages($sucessmessage,$failuremessage)
    {
        if (!$this->ItemsForm_FromUpdated) { return ""; }

        $msg="";
        if (count($this->ItemsForm_Messages)>0)
        {
            $msg.=$this->Div($failuremessage,array("CLASS" => 'error'));
        }
        else
        {
            $msg.=$this->Div($sucessmessage,array("CLASS" => 'success'));            
        }

        $msg.=$this->BR();            
        if (count($this->ItemsForm_Messages)>0)
        {
            $msg.=
                $this->HtmlList($this->ItemsForm_Messages).
                $this->BR().
                "";
        }

        return $msg;
    }
}

?>