<?php

trait MyMod_Data_Upload
{
    //*
    //* Returns full (relative) upload path: UploadPath/Module.
    //*
    
    function MyMod_Data_Upload_Path()
    {
        $path=preg_replace('/#Module/',$this->ModuleName,$this->UploadPath);

        if ($path=="") { return; }

        $path=$this->FilterObject($path);

        $comps=preg_split('/\/+/',$path);
        if (!preg_grep('/'.$this->ModuleName.'/',$comps))
        {
            array_push($comps,$this->ModuleName);
        }


        $path="";
        for ($n=0;$n<count($comps);$n++)
        {
            if ($path!="")
            {
                $path.="/";
            }

            $path.=$comps[$n];
       }
        
        $this->Dir_Create_AllPaths($path);
        $this->MyFile_Touch($path."/index.php");

        return $path;
    }

    //*
    //* Returns full (relative) name of uploaded file pertaining to $data.
    //*

    function MyMod_Data_Upload_FileName_Get($data,$item,$ext)
    {
        $uploadpath=$this->MyMod_Data_Upload_Path();

        //Make sure we have an index.php, so no-one may list the files
        $index=$uploadpath."/index.php";
        if (!file_exists($index))
        {
            if (is_writable($index))
            {

                $this->MyWriteFile($index,array());
            }
        }

        $uploadpath.="/";
        if ($this->UploadFilesHidden)
        {
            $uploadpath.=".";
        }

        //Make files hidden
        return $uploadpath.$data."_".$item[ "ID" ].".".$ext;
    }
    
}

?>