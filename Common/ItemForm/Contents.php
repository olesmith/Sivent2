<?php

trait ItemForm_Contents
{
    //*
    //* function ItemForm_Contents, Parameter list: $edit,$buttons=TRUE
    //*
    //* Creates ItemForm_ edit table as html.
    //*

    function ItemForm_Contents($edit)
    {
        $table=$this->ItemForm_Table($edit);

        $key="Middle";
        if (!empty($this->Args[ $key ]))
        {
            $method=$this->Args[ $key ];
                                            
            $table=array_merge
            (
               $this->$method(),
               $table
            );
        }

        $titles="";
        if (!empty($this->Args[ "Title" ]))
        {
            $titles.=
               $this->H
               (
                  1,
                  $this->GetRealNameKey($this->Args,"Title")
               );
        }
        
        if (!empty($this->Args[ "Titles" ]))
        {
            $n=1;
            foreach ($this->Args[ "Titles" ] as $title)
            {
                $titles.=$this->H($n++,$title);
            }
        }
        
        array_unshift
        (
           $table,
           $titles
        );
        
       $key="Leading";
        if (!empty($this->Args[ $key ]))
        {
            $method=$this->Args[ $key ];
                                            
            $table=array_merge
            (
               $this->$method(),
               $table
            );
        }
        
        $key="Trailing";
        if (!empty($this->Args[ $key ]))
        {
            $method=$this->Args[ $key ];
                                            
            $table=array_merge
            (
               $table,
               $this->$method()
            );
        }
        
        return $this->Html_Table("",$table);
    }
}

?>