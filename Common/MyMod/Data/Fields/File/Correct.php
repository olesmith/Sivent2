<?php


trait MyMod_Data_Fields_File_Correct
{
    //*
    //* function MyMod_Data_Fields_File_Correct, Parameter list: $item
    //*
    //* Corrects File field (ie moves file)
    //*

    function MyMod_Data_Fields_File_Correct($item)
    {
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->ItemData[ $data ][ "Sql" ]=="FILE" && empty($this->ItemData[ $data ][ "Iconify" ]))
            {
                $contents=$this->Sql_Select_Hash_Value($item[ "ID" ],$data."_Contents");

                if (!empty($contents))
                {
                    $contents=$this->MyMod_Data_Fields_File_DB_2Contents($contents);
                    
                    $file=$this->Sql_Select_Hash_Value($item[ "ID" ],$data);
                    $file=$this->MyMod_Data_Upload_Path()."/".basename($file);

                    $this->MyFile_Write($file,$contents);

                    $item[ $data ]=$file;
                    $item[ $data."_Contents" ]="";
                    $this->Sql_Update_Item_Values_Set(array($data,$data."_Contents"),$item);
                    var_dump("Item ".$item[ $data ]." moved to file system");
                }
               
            }
        }
    }
}

?>