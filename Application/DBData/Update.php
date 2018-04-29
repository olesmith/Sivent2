<?php

class DBDataUpdate extends DBDataQuest
{
    //*
    //* function UpdateSqlKeyField, Parameter list: $item,$data,$newvalue
    //*
    //* Updates SqlKey field - that is changes name in Inscriptions table.
    //*

    function UpdateSqlKeyField($item,$data,$newvalue)
    {
        $value=$item[ $data ];
        
        $newvalue=$this->Html2Sort($newvalue);
        $newvalue=$this->Text2Sort($newvalue);

        //Remove invalid characters. Allow only letters and numbers.
        $newvalue=preg_replace('/[^a-z0-9]/i',"",$newvalue);

        if ($value!=$newvalue)
        {
            if ($this->DBDataObj()->Sql_Table_Field_Exists($value))
            {
                if (!$this->DBDataObj()->Sql_Table_Field_Exists($newvalue))
                {
                    $this->DBDataObj()->Sql_Table_Column_Rename($value,$newvalue);
                    
                    $item[ $data ]=$newvalue;

                    if ($item[ "SqlDef" ]=="FILE")
                    {
                        foreach (array_keys($this->Sql_Table_Fields_File_Datas()) as $key)
                        {
                            if ($key=="Empty") { continue; }

                            $rvalue=$value."_".$key;
                            $rnewvalue=$newvalue."_".$key;
                            
                            $this->DBDataObj()->Sql_Table_Column_Rename($rvalue,$rnewvalue);
                        }
                    }
                }
            }
            else
            {
                $item[ $data ]=$newvalue;
            }
        }

        return $item;
    }
}

?>