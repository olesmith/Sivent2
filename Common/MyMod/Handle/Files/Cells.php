<?php

trait MyMod_Handle_Files_Cells
{
    //*
    //* function NodePerms, Parameter list: $node
    //*
    //* Returns readable permissions info (UNIX format)
    //*

    function MyMod_Handle_File_Info_Perms($node)
    {
        $perms=fileperms($node);

        if (($perms & 0xC000) == 0xC000)
        {
            // Socket
            $info = 's';
        }
        elseif (($perms & 0xA000) == 0xA000) 
        {
            // Link simbólico
            $info = 'l';
        }
        elseif (($perms & 0x8000) == 0x8000) 
        {
            // Regular
            $info = '-';
        }
        elseif (($perms & 0x6000) == 0x6000) 
        {
            // Bloco especial
            $info = 'b';
        }
        elseif (($perms & 0x4000) == 0x4000) 
        {
            // Diretório
            $info = 'd';
        }
        elseif (($perms & 0x2000) == 0x2000) 
        {
            // Caractere especial
            $info = 'c';
        }
        elseif (($perms & 0x1000) == 0x1000) 
        {
            // FIFO pipe
            $info = 'p';
        }
        else
        {
            // Desconhecido
            $info = 'u';
        }

        // Proprietário
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ?
                    (($perms & 0x0800) ? 's' : 'x' ) :
                    (($perms & 0x0800) ? 'S' : '-'));

        // Grupo
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ?
                    (($perms & 0x0400) ? 's' : 'x' ) :
                    (($perms & 0x0400) ? 'S' : '-'));

        // Outros
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ?
                    (($perms & 0x0200) ? 't' : 'x' ) :
                    (($perms & 0x0200) ? 'T' : '-'));

        return $info;
    }

    //*
    //* function MyMod_Handle_File_Dir_Include_Box, Parameter list: $node
    //*
    //* Creates node delete check box.
    //*

    function MyMod_Handle_File_Dir_Include_Box($node)
    {
        $checked=FALSE;
        $includetree=$this->GetPOST("Include_".$node);
        if ($includetree==1)
        {
            $checked=TRUE;
        }
        
        return
            $this->MakeCheckBox("Include_".$node,1,$checked);
    }

    //*
    //* function MyMod_Handle_File_Dir_Choose_All_Box, Parameter list: $node
    //*
    //* Creates node choose all (files) check box.
    //*

    function MyMod_Handle_File_Dir_Choose_All_Box($node)
    {
        $checked=FALSE;
        $includetree=$this->GetPOST("Choose_".$node);
        if ($includetree==1)
        {
            $checked=TRUE;
        }
        
        return
            $this->MakeCheckBox("Choose_".$node,1,$checked);
    }

    //*
    //* function MyMod_Handle_File_Delete_Box, Parameter list: $node
    //*
    //* Creates node delete check box.
    //*

    function MyMod_Handle_File_Delete_Box($node)
    {
        $dir=preg_replace('/\/[^\/]+$/',"",$node);

        $dirchecked=FALSE;
        $includetree=$this->GetPOST("Choose_".$dir);

        if ($includetree==1)
        {
            $dirchecked=TRUE;
        }

        $update=$this->GetPOST("GO");
        $key="Delete_".preg_replace('/\./',"_",$node);
        $delete=$this->GetPOST($key);


        if ($update && $dirchecked && $delete && !empty($_POST[ $key ]))
        {
            unlink($node);
            return "Deleted";
        }

        return
            $this->MakeCheckBox("Delete_".$node,1,$dirchecked);
    }
}

?>