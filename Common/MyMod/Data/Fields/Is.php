<?php


trait MyMod_Data_Fields_Is
{
    //*
    //* Returns true if $data is a search var.
    //*

    function MyMod_Data_Field_Is_Search($data)
    {
        $this->ItemData($data);

        $res=FALSE;
        if (!empty($this->ItemData[ $data ][ "Search" ]))
        {
            if ($this->MyMod_Data_Access($data)>=1)
            {
                $res=TRUE;
            }
        }

        return $res;
    }

    //*
    //* Returns true if $data is compulsory.
    //*

    function MyMod_Data_Field_Is_Compulsory($data)
    {
        $this->ItemData($data);

        $res=FALSE;
        if (!empty($this->ItemData[ $data ][ "Compulsory" ]))
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* Returns true if $data is an SQL class type.
    //*

    function MyMod_Data_Field_Is_Sql($data)
    {
        $this->ItemData($data);
        
        $res=FALSE;
        if (!empty($this->ItemData[ $data ][ "SqlClass" ]))
        {
            $res=$this->ItemData[ $data ][ "SqlClass" ];
        }

        return $res;
    }

    //*
    //* Returns true if $data is File type.
    //*

    function MyMod_Data_Field_Is_File($data)
    {
        $res=FALSE;
        if (
              isset($this->ItemData[ $data ])
              &&
              preg_match('/FILE/i',$this->ItemData[ $data ][ "Sql" ])
           )
        {
            $res=TRUE;
        }

        return $res;
    }

    //*
    //* Returns true if $data is Date type.
    //*

    function MyMod_Data_Field_Is_Date($data)
    {
        $this->ItemData($data);

        $res=FALSE;
        if (
              isset($this->ItemData[ $data ])
              &&
              $this->ItemData[ $data ][ "Sql" ]=="INT"
              &&
              $this->ItemData[ $data ][ "IsDate" ]
           )
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* Returns true if $data is Time type.
    //*

    function MyMod_Data_Field_Is_Time($data)
    {
        $this->ItemData($data);

        $res=FALSE;
        if (
              isset($this->ItemData[ $data ])
              &&
              $this->ItemData[ $data ][ "Sql" ]=="INT"
              &&
              $this->ItemData[ $data ][ "TimeType" ]
           )
        {
            $res=TRUE;
        }

        return $res;
    }
    
    //*
    //* Returns true if $data is an ENUM.
    //*

    function MyMod_Data_Field_Is_Enum($data)
    {
        $this->ItemData($data);

        $res=FALSE;
        if (
              isset($this->ItemData[ $data ])
              &&
              !empty($this->ItemData[ $data ][ "Sql" ])
              &&
              preg_match('/ENUM/',$this->ItemData[ $data ][ "Sql" ])
              &&
              empty($this->ItemData[ $data ][ "AltTable" ]) //??? 20150715
           )
        {
            $res=TRUE;
        }

        return $res;
    }

      //*
    //* Returns true if $data is an DERIVED.
    //*

    function MyMod_Data_Field_Is_Derived($data)
    {
        $this->ItemData($data);

        $res=FALSE;
        if (
              isset($this->ItemData[ $data ])
              &&
              (
                 !empty($this->ItemData[ $data ][ "SqlDerivedNamer" ])
                 ||
                 !empty($this->ItemData[ $data ][ "Derived" ])
              )
              &&
              empty($this->ItemData[ $data ][ "AltTable" ])
           )
        {
            $res=TRUE;
        }

        return $res;
    }

     //*
    //* Returns true if $data is of $type.
    //*

    function MyMod_Data_Field_Type_Datas($type)
    {
        $this->ItemData("ID");

        $datas=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            if ($this->MyMod_Data_Field_Is_File($data))
            {
                array_push($datas,$data);
            }
        }

        return $datas;
    }
       
    //*
    //* Returns true if $data is of FILE type.
    //*

    function MyMod_Data_Field_File_Datas()
    {
        return $this->MyMod_Data_Field_Type_Datas($this->ItemData,"File");
    }
       
 
}

?>