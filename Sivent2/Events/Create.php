<?php

class EventsCreate extends EventsCells
{
    //*
    //* function CreateUpdateTable, Parameter list:
    //*
    //* Creates and Updates Inscriptions or Assessments table.
    //*

    function CreateUpdateTable()
    {
        $action=$this->CGI_GET("Pertains");

        $this->ApplicationObj()->Pertains=1;
            if (preg_match('/^Quest/',$action))  { $this->ApplicationObj()->Pertains=1; }
        elseif (preg_match('/^Assess/',$action)) { $this->ApplicationObj()->Pertains=2; }

        $type="-";
        $table="-";
        
        $msg="";
        if ($this->CGI_GETint("CreateTable")==1)
        {
            if ($this->ApplicationObj()->Pertains==1)
            {
                $this->InscriptionsObj()->Sql_Table_Structure_Update_Force=TRUE; //force update
                $this->InscriptionsObj()->Sql_Table_Structure_Update();

                $type="Inscrições";
                $table=$this->InscriptionsObj()->SqlTableName();
                
                $msg=$this->H(3,"Tabela de Inscrições Atualizada");
            }
            elseif ($this->ApplicationObj()->Pertains==2)
            {
                $this->AssessmentsObj()->Sql_Table_Structure_Update();
                $type="Avaliações";
                $table=$this->AssessmentsObj()->SqlTableName();
            }
            
            $msg=$this->H(3,"Tabela de ".$type.": ".$table." Atualizada");
        }

        return $msg;
    }
}

?>