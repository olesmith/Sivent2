<?php


trait MyApp_Session_Table
{
    //*
    //* function MyApp_Session_Table_Get, Parameter list: 
    //*
    //* Returns name of Sessions table
    //*

    function MyApp_Session_Table_Get()
    {
        return $this->SqlTableName($this->SessionsTable);
    }


    //*
    //* function MyApp_Session_Table_Init, Parameter list: 
    //*
    //* Returns name of Sessions table
    //*

    function MyApp_Session_Table_Init()
    {
        $this->MyApp_Session_Table_Create();

    }

    //*
    //* function MyApp_Session_Table_Create, Parameter list:
    //*
    //* Creates session table, if non existent.
    //*

    function MyApp_Session_Table_Create()
    {
        $stable=$this->MyApp_Session_Table_Get();
        if (!$this->Sql_Table_Exists($stable))
        {
            if ($this->MayCreateSessionTable)
            {
                $this->Sql_Table_Create($stable);

                //Success?
                if (!$this->Sql_Table_Exists($stable))
                {
                    die("Unable to create session table ".$stable);
                }
            }
            else
            {
                die("No session table, creation not permitted");
            }
        }

        $this->AuthData=$this->MyApp_Session_Data();

        $this->Sql_Table_Structure_Update(array_keys($this->AuthData),$this->AuthData,TRUE,$stable);
        $this->MyApp_Session_Table_Clean();
    }


    //*
    //* function MyApp_Session_Table_Clean, Parameter list:
    //*
    //* Cleans session table, that is delete sessions older than onehour.
    //*

    function MyApp_Session_Table_Clean()
    {
        $time=time()-60*60;
        $this->Sql_Delete_Items
        (
           $this->Sql_Table_Column_Name_Qualify("ATime").
           "<".$time,
           $this->MyApp_Session_Table_Get()
        );
    }
}

?>