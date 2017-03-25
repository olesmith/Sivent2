<?php

class Submissions_Authors_Data extends Submissions_Certificate
{
    var $Friends=array();
    
    //*
    //* function Author_Datas_File, Parameter list:
    //*
    //* Returns data for each author: Friend,Author, but detect from file.
    //*

    function Author_Datas_File()
    {
        return "System/Submissions/Data.Authors.php";
    }
    
    //*
    //* function Author_Data_File_MTime, Parameter list:
    //*
    //* Returns mtime for authors data file.
    //*

    function Author_Datas_File_MTime()
    {
        $this->DataFilesMTime=$this->Max($this->DataFilesMTime,filemtime($this->Author_Datas_File()));
        
        return $this->DataFilesMTime;
    }
    
    //*
    //* function Author_Data_Read, Parameter list:
    //*
    //* Reads author datas from file, if necessary.
    //* Stored in Author_Datas attribute.
    //* Reaturns attribute.
    //*

    function Author_Datas_Read()
    {
        if (empty($this->Author_Datas))
        {
            $defs=$this->ReadPHPArray($this->Author_Datas_File());
            $this->Author_Datas=array_keys($defs);
        }

        return $this->Author_Datas;
    }
    
    //*
    //* function Author_Data_Get, Parameter list:
    //*
    //* Returns data for each author.
    //*

    function Author_Data_Get($n,$data)
    {
        if ($n>1)
        {
            $data.=$n;
        }

        return $data;
    }
    //*
    //* function Author_Datas_Get, Parameter list:
    //*
    //* Returns data for each author.
    //*

    function Author_Datas_Get($n)
    {
        $datas=$this->Author_Datas_Read();
        if ($n>1)
        {
            foreach (array_keys($datas) as $id)
            {
                $datas[ $id ]=$this->Author_Data_Get($n,$datas[ $id ]);
            }
        }

        return $datas;
    }
    
    //*
    //* function Author_Data_Defs, Parameter list:
    //*
    //* Returns data defs for each author.
    //*

    function Author_Datas_Defs()
    {
        $defs=$this->ReadPHPArray($this->Author_Datas_File());
        $this->Author_Datas=array_keys($defs);

        return $defs;
    }
    
    //*
    //* function Authors_Data, Parameter list: $keys=array()
    //*
    //* Return list of datas for authors. If not given,
    //* $keys is what is returned by AuthorData.
    //*

    function Authors_Datas($keys=array(),$datas=array())
    {
        if (empty($keys)) { $keys=$this->Author_Datas_Read(); }
        if (!is_array($keys)) { $keys=array($keys); }

        $datas=array_merge($datas,$keys); //first author
        for ($n=2;$n<=$this->EventsObj()->Event_Submissions_NAuthors();$n++)
        {
            foreach ($keys as $data)
            {
                array_push($datas,$data.$n);
            }
        }
        
        return $datas;
    }

    //*
    //* function Author_Data_2_No, Parameter list: $data
    //*
    //* Return number of the author associated with data: last \d's.
    //*

    function Authors_Data_2_No($data)
    {
        $n=1;
        if (preg_match('/(\d+)$/',$data,$matches))
        {
            $n=intval($matches[1]);
        }

        return $n;
    }

    
    //*
    //* function Authors_Data_Skew, Parameter list: $keys=array()
    //*
    //* Return list authors data skew hash.
    //*

    function Authors_Datas_Skew()
    {
        $hash=array
        (
           "Friend"  => "Author",
        );

        for ($n=2;$n<=$this->EventsObj()->Event_Submissions_NAuthors();$n++)
        {
            $hash[ "Friend".$n ]="Author".$n;
        }

        return $hash;
    }

    
    //*
    //* function Authors_Data_PostProcess, Parameter list:
    //*
    //* Post process author data. That is adds Event => Submissions_NAuthors copies of
    //* AuthorN and FriendN data. Data for each, is defined in System/Submissions/Authors Data.
    //*

    function Authors_Data_PostProcess()
    {
        $this->Sql_Table_Column_Rename("Author1","Author");

        $this->Author_Datas_File_MTime();
        
        $defs=$this->Author_Datas_Defs();
        
        for ($n=2;$n<=$this->EventsObj()->Event_Submissions_NAuthors();$n++)
        {
            foreach ($defs as $data => $def)
            {
                $keys=array_keys($def);
                foreach (array_keys($def) as $key)
                {
                    if (is_string($def[ $key ]))
                    {
                        $def[ $key ]=preg_replace('/#n/i',$n,$def[ $key ]);
                    }
                }

                $rdata=$data.$n;
                if (!$this->Sql_Table_Field_Exists($rdata))
                {
                    //Should force sql table structure update
                    $this->DataFilesMTime=time();
                }

                //Add to ItemData
                $this->ItemData[ $rdata ]=$def;
            }
        }

        $this->Author_Datas=array_keys($defs);
    }

    
    //*
    //* function Author_Friend_Select, Parameter list: $data,$item,$edit=0,$rdata=$data
    //*
    //* Protected generation of author friend selects.
    //* Ensures that we well
    //*

    function Author_Friend_Select($data,$item,$edit=0,$rdata="")
    {
        if (empty($this->Friends))
        {
            $this->Friends=$this->FriendsObj()->Friends_Active_Read();
        }

        return 
            $this->Html_SelectField
            (
                $this->Friends,
                $rdata,
                "ID",
                "#Name",
                "#Name, #Email (#ID)",
                $item[ $data ]
            );
        
    }
    
}
?>