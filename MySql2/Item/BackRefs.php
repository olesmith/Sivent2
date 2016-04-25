<?php


class ItemBackRefs extends ItemLatex
{
    //*
    //* Handles DB back refs. That is: save deletion. If some item in the back ref
    //* references $item (via its "ID"), helps to resolve these dependencies first.
    //*

    function HandleBackRefDBs($item,$name)
    {
        foreach ($this->BackRefDBs as $backref => $backrefdef)
        {
            //Get an object of correct type
            $class=$backrefdef[ "Class" ];
            $obj=new $class(1); //1 for NoHandle


            //Obtain wheres to check for
            $wheres=$backrefdef[ "IDCols" ];
            for ($k=0;$k<count($wheres);$k++)
            {
                $wheres[ $k ].="='".$item[ "ID" ]."'";
            }
            $where=join(" OR ",$wheres);

            //Items referencing our ID
            $backitems=$obj->ReadItems($where);

            //If any items obtained, create informing table, with variables to correct problem
            if (count($backitems)>0)
            {
                $list=array();
                $n=1;
                $ncorrections=0;
                foreach ($backitems as $id => $backitem)
                {
                    //Title table for a description
                    $backitemtitles=array();
                    foreach ($backrefdef[ "Fields" ] as $title => $var)
                    {
                        array_push($backitemtitles,array("<B>".$title."</B>",$backitem[ $var ]));
                    }

                    $title=$this->HTMLTable("",$backitemtitles);
                    $tbl=array(array("<B>".$obj->ItemName." $n</B>: ".$title));

                    //Make input fields, looping over columns
                    $res=0;
                    foreach ($backrefdef[ "IDCols" ] as $col)
                    {
                        if ($backitem[ $col ]==$item[ "ID" ])
                        {
                            $colname=$obj->ItemData[ $col ][ "Name" ];

                            //Check if we need to update
                            $inputvar=$backitem[ "ID" ]."_".$col;
                            $newvalue=$_POST[ $inputvar  ];
                            if ($_POST[ "Update" ]==1 && $newvalue!=$backitem[ $col ])
                            {
                                //Update
                                $this->MySqlSetItemValue($obj->SqlTableName(),"ID",$backitem[ "ID" ],$col,$newvalue);
                                $backitem[ $col ]=$newvalue;
                            }
                            else { $res++; }

                            //Now make the input field (if we have updated, this should disappear at next Update
                            $input=$obj->MyMod_Data_Fields_Edit($col,$backitem,$backitem[ $col ]);
                            $input=preg_replace('/NAME=\'/',"NAME='".$backitem[ "ID" ]."_",$input);
                            array_push($tbl,array($colname,$input));
                        }
                    }

                    //Add to number of corrections, when this i 0, it's OK to delete
                    $ncorrections+=$res;

                    $tbl=$this->HTMLTable("",$tbl,array("WIDTH" => "50%","BORDER" => 1));

                    array_push($list,$tbl);
                    $n++;
                }

                if ($ncorrections>0)
                {
                    print "<H3 align='center'>".$this->ItemName.": ".$name."</H3>";
                    print "<H3 align='center'>Esta ".$this->ItemName." est&aacute; sendo referenciado ".
                        "pelas ".count($backitems)." ".$obj->ItemsName." relacionadas abaixo.<BR>".
                          "Por favor, corrige as seguintes depend&ecirc;ndias antes de deletar!</H3>";

                    $qstring=$this->QueryString();
                    $qstring=preg_replace('/&Discipline=\d+&/',"",$qstring);
                    $script=$qstring;

                    print $this->StartForm($script).
                          "<CENTER>".
                          $this->Buttons().
                          join("<BR>",$list).
                          $this->MakeHidden("Update",1).
                          $this->Buttons().
                          $this->EndForm().
                          "</CENTER>";

                    return $ncorrections;
                }
                else
                {
                    return 0;
                }
            }
        }
    }
}
?>