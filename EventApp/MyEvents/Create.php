<?php

class MyEventsCreate extends MyEventsTables
{
    //*
    //* function CreateUpdateTable, Parameter list:
    //*
    //* Creates and Updates Inscriptions or Assessments table.
    //*

    function CreateUpdateTable()
    {
        $this->InscriptionsObj()->Sql_Table_Structure_Update();

        $type="Inscrições";
        $table=$this->InscriptionsObj()->SqlTableName();

        return $this->H(3,"Tabela de ".$type.": ".$table." Atualizada");
    }
}

?>