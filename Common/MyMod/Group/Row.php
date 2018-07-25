<?php

trait MyMod_Group_Row
{
    //*
    //* function MyMod_Group_Row_Item, Parameter list: ($edit,$item,$nn,$datas,$even=TRUE)
    //*
    //* Generate group row, as list.
    //* Specific class may override MyMod_Group_Rows_Item (returns matrix) or
    //* MyMod_Group_Row_Item, return list.
    //* 
    
    function MyMod_Group_Row_Item($edit,$item,$nn,$datas,$even=TRUE)
    {
        //Test if we have individual access to Edit $item
        if (!$this->MyAction_Allowed("Edit",$item))
        {
            $edit=0;
        }

        $item[ "_RID_" ]="";
        if (isset($item[ "ID" ])) { $item[ "_RID_" ]=sprintf("%03d",$item[ "ID" ]); }
        $nn=sprintf("%03d",$nn);

        $tabindex=1;
        $row=array();
        $value="";
        foreach ($datas as $data)
        {
            if (empty($data))
            {
                $value="&nbsp;";
            }
            elseif ($data=="No")
            {
                $value=
                    $this->Htmls_SPAN
                    (
                        $nn,
                        array
                        (
                            "ID" => $this->ModuleName."_".$item[ "ID" ],
                            "CLASS" => 'Bold',
                        )
                    );
            }
            elseif (preg_match('/newline\((\d+)\)/',$data,$matches))
            {
                array_push($row,$this->MultiCell("",$matches[1]));
                continue;
            }
            elseif (preg_match('/newline\((\d*)\)\((\d*)\)/',$data,$matches))
            {
                $preempties=0;
                if (isset($matches[1])) { $preempties=$matches[1]; }
                
                $postempties=0;
                if (isset($matches[2])) { $postempties=$matches[2]; }
                for ($n=1;$n<=$postempties;$n++)
                {
                    array_push($row,"");
                }

                array_push($tbl,$row);

                $row=array();
                for ($n=1;$n<=$preempties;$n++)
                {
                    array_push($row,"");
                }
                $value="";
            }
            else
            {
                if ($this->MyMod_Data_Languaged_Is($data))
                {
                    $value=
                        $this->MyMod_Group_Row_Item_Languaged_Data_Field
                        (
                            $edit,
                            $item,
                            $data,
                            $even
                        );
                }
                else
                {
                    $value=
                        $this->MyMod_Data_Fields
                        (
                            $edit,
                            $item,
                            $data,
                            $plural=True,
                            $tabindex="",
                            $rdata="",
                            $even
                        );
                }
            }
            
            array_push($row,array($value));

            $tabindex++;
        }

        return $row;
    }
    
    //*
    //* function MyMod_Group_Row_Item_Languaged_Data_Table, Parameter list: ($edit,$item,$nn,$datas,$even=TRUE)
    //*
    //* Generates languaged field as a table.
    //* 
    
    function MyMod_Group_Row_Item_Languaged_Data_Field($edit,$item,$data,$even=True)
    {
        if ($this->MyMod_Language_Data_Tabled())
        {
            return
                $this->MyMod_Data_Fields
                (
                    $edit,
                    $item,
                    $data.$this->MyLanguage_GetLanguageKey(),
                    $plural=True
                );
        }
        
        $table=array();
        foreach ($this->LanguageKeys() as $language_key)
        {
            array_push
            (
                $table,
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_Name($language_key).":"
                    ),
                    $this->MyMod_Data_Fields
                    (
                        $edit,
                        $item,
                        $data.$language_key,
                        $plural=True
                    )
                )
            );
        }

        return
            $this->Htmls_Table
            (
                "",
                $table,
                array
                (
                    "CLASS" => 'left',
                ),
                array
                (
                    "CLASS" => $this->MyMod_EvenOdd_Class($even),
                ),
                array
                (
                ),
                False,False
            );
     }
}

?>