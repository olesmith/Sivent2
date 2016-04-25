<?php


trait MyMod_Items_Ors
{
    //*
    //* Create search $where, with ORs between $searchdatas,
    //* and ANDs components of $search.
    //*

    function MyMod_Items_Ors_Where($search,$searchdatas)
    {
        $likes=preg_split('/\s+/',$search);

        $wheres=array();
        foreach ($searchdatas as $data)
        {
            $ands=array();
            foreach ($likes as $like)
            {
                array_push($ands,$data." LIKE '%".$like."%'");
            }

            array_push($wheres,"(".join(" AND ",$ands).")");
        }

        return array("__All" => join(" OR ",$wheres));
    }
}

?>