<?php


trait MyMod_Handle_Import_Detect
{
    //*
    //* function MyMod_Handle_Detect_Items, Parameter list: 
    //*
    //* Detetect items in uploaded file or in CGI.
    //*

    function MyMod_Handle_Import_Detect_Items()
    {
        $items=array();
        if ($this->CGI_POSTint("Detect")==1)
        {
            $items=$this->MyMod_Handle_Import_Read_Items_From_File();
        }
        elseif ($this->CGI_POSTint("Save")==1)
        {
            $items=$this->MyMod_Handle_Import_Read_Items_From_CGI();
            $items=$this->MyMod_Handle_Import_Items_Update($items);
        }

        return $items;
    }
    
    //*
    //* function MyMod_Handle_Detect_Items, Parameter list: 
    //*
    //* Detetect items in uploaded file.
    //*

    function MyMod_Handle_Import_Read_Items_From_CGI()
    {
        $keys=array_keys($_POST);
        $keys=preg_grep('/_Email$/',$keys);

        $ns=array();
        foreach ($keys as $id => $key)
        {
            $key=preg_replace('/_Email$/',"",$key);
            array_push($ns,$key);
        }

        $items=array();
        foreach ($ns as $n)
        {
            $item=
                array
                (
                    "Email" => $this->CGI_POST($n."_Email"),
                    "Name" =>  $this->CGI_POST($n."_Name"),
                    "N" => $n,
                );

            foreach (array("Register","Inscribe","Certificate") as $key)
            {
                $item[ $key ]=0;
                if (!empty($_POST[ $n."_".$key ]))
                {
                    $item[ $key ]=1;
                }
            }
            
            $item=$this->MyMod_Handle_Detect_Item_Status($item);
            
            $items[ $item[ "Email" ] ]=array($item);
        }

        return $items;
    }

    //*
    //* function MyMod_Handle_Detect_Item_Status, Parameter list: 
    //*
    //* Detetect status for $item.
    //*

    function MyMod_Handle_Detect_Item_Status($item)
    {
        $item[ "Mail_Status" ]=0;
        $item[ "Mail_Status_Message" ]=0;
        if (
              !empty($item[ "Email" ])
              &&
              $this->ApplicationObj()->IsValidEmail($item[ "Email" ])
           )
        {
            $item[ "Mail_Status" ]=1;
            $item[ "Mail_Status_Message" ]="Valid Email";
        }

        return $item;
    }
    
    //*
    //* function MyMod_Handle_Import_Read_Items_From_File, Parameter list: 
    //*
    //* Detetect items in uploaded file.
    //*

    function MyMod_Handle_Import_Read_Items_From_File()
    {
        $cginame="File";
        $lines=$this->MakeCGI_Upload_File($cginame);
        if (empty($lines)) { return array(); }
        
        $lines=join("",$lines);
        $lines=preg_replace('/},{/',"},\n{",$lines);
       
        $lines=preg_split('/\n/',$lines);

        $items=array();
        foreach ($lines as $id => $line)
        {
            $line=preg_replace('/[\[\]"\'{}\n]+/',"",$line);

            $comps=preg_split('/\s*[,;]\s*/',$line);

            $hash=array();
            foreach ($this->Import_Datas as $data)
            {
                $hash[ strtolower($data) ]="";
            }

            foreach ($comps as $comp)
            {
                $rcomps=preg_split('/\s*[:|]\s*/',$comp);
                if (count($rcomps)>=2)
                {
                    $hash[ strtolower($rcomps[0]) ]=$rcomps[1];
                }
                elseif (count($rcomps)>=1)
                {
                    if (preg_match('/@/',$rcomps[0]))
                    {
                        $hash[ "email" ]=$rcomps[0];
                    }
                    elseif (empty($hash[ "name" ]))
                    {
                        $hash[ "name" ]=$rcomps[0];
                    }
                }
            }

            foreach ($this->Import_Datas as $data)
            {
                $rdata=strtolower($data);
                $hash[ $data ]=htmlentities($hash[ $rdata ]);
                unset($hash[ $rdata ]);
            }
            $hash[ "Name" ]=$this->TrimCase($hash[ "Name" ]);
            
            $hash[ "Status_Message" ]=0;
            $hash[ "Mail_Status" ]=0;
            $hash[ "Status" ]=0;
            $hash[ "Mail_Status_Message" ]=0;
            if (
                  !empty($hash[ "Email" ])
                  &&
                  $this->ApplicationObj()->IsValidEmail($hash[ "Email" ])
               )
            {
                $hash[ "Mail_Status" ]=1;
                $hash[ "Mail_Status_Message" ]="Valid Email";
            }

            if (!isset( $items[ $hash[ "Email" ] ]))
            {
                $items[ $hash[ "Email" ] ]=array($hash);
            }
            else
            {
                array_push($items[ $hash[ "Email" ] ],$hash);
                
                $hash[ "Status" ]=-1;
                $hash[ "Status_Message" ]="Repeated Email";
            }
        }

        return $items;
    }

}
?>