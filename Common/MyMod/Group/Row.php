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
        foreach ($datas as $data)
        {
            if (empty($data))
            {
                $value="&nbsp;";
            }
            elseif ($data=="No")
            {
                $value=$this->B($nn);
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
                $value=$this->MyMod_Group_Cell_Data($edit,$item,$data,$value,$even,$tabindex);
            }
            
            array_push($row,$value);

            $tabindex++;
        }

        if (count($row)>0 && isset($item[ "ID" ]) && !$this->LatexMode)
        {
            if (!is_array($row[0]))
            {
                $row[0].=$this->HtmlTags("A","",array("NAME" => "#".$this->ModuleName."_".$item[ "ID" ]));
            }
        }

        return $row;
    }
}

?>