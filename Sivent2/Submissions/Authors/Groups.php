<?php


class Submissions_Authors_Groups extends Submissions_Authors_SGroups
{
    //*
    //* function Submission_Author_Inscribe_Cell, Parameter list: $n,$edit,$item,$plural
    //*
    //* Returns link to quickly inscribe author.

    function Submission_Author_Inscribe_Cell($n,$edit,$item,$plural)
    {
        return "liiiiiink";
    }
    
    //*
    //* function Submissions_Authors_Group_Gen, Parameter list: $edit
    //*
    //* Generates the authors Group table.

    function Submissions_Authors_Group_Gen($edit)
    {
        $predatas=$this->ItemDataGroups[ "Authors" ][ "Data" ];
        $empties=array();
        for ($n=1;$n<=$this->ItemDataGroups[ "Authors" ][ "NIndent" ];$n++)
        {
            array_push($empties,"&nbsp;");
        }

        if ($this->CGI_POSTint("Update")==1)
        {
            $this->ItemHashes=$this->MyMod_Items_Update($this->ItemHashes);
        }

        
        $titles=$this->GetDataTitles($predatas);
        $titles=$this->Html_Table_Head_Row($titles);
        
        $atitles=
        $table=array($titles);

        $n=1;
        foreach (array_keys($this->ItemHashes) as $id)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Submission_Authors_Rows($n,$edit,$this->ItemHashes[ $id ])
                );
        }
        
        return $table;
    }    
}

?>