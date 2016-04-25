<?php

class MyEventsInfo extends MyEventsDataGroups
{
    //*
    //* function EventDatasInfoTable, Parameter list:
    //*
    //* Handle EventDatas edit.
    //*

    function EventDatasInfoTable()
    {
        $msg=$this->CreateUpdateTable();

        $table=
            array
            (
               array
               (
                $this->MultiCell($this->H(3,$this->Event("Name")),2)
               ),
               array
               (
                $this->MultiCell("Inscrições:",2)
               ),
               array
               (
                  $this->B("Tabela SQL:"),
                  $this->ApplicationObj->SqlEventTableName("Inscriptions"),
               ),
               array
               (
                  $this->B("Existe:"),
                  $this->InscriptionTableExistsCell(),
               ),
               array
               (
                  $this->B("No. de Entradas:"),
                  $this->NoOfInscriptionsCell(),
               ),
               array
               (
                  $this->B("Atualizar Tabela:"),
                  $this->InscriptionTableUpdateLink("Quest"),
               ),
            );

        array_unshift($table,array($this->H(6,"SQL Info")));

        echo
            $this->H(1,"Questionário").
            $msg.
            $this->Center
            (
               $this->Html_Table("",$table)
            ).
            "";
    }  
}

?>