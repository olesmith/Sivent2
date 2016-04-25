<?php
    //*
    //* sub Accessor_Code, Parameter list: $accessor,$def
    //*
    //* Returns $key in $this->$accessor hash.
    //*
    //*

    function Accessor_Code($accessor,$def)
    {
        $accessorname=$accessor;
        if (!empty($def[ "Name" ])) { $accessorname=$def[ "Name" ]; }

        $method="Accessor_Code_".$def[ "Type" ];
        return $method($accessorname,$accessor,$def);
    }

    //*
    //* sub Accessor_Create, Parameter list: $accessors
    //*
    //* Returns $key in $this->$accessor hash.
    //*
    //*

    function Accessor_Create($accessors)
    {
        $code=
            "trait _accessor_\n".
            "{\n".
            "";
        foreach ($accessors as $accessor => $def)
        {
            $code.=Accessor_Code($accessor,$def);
                
        }

        $code.=Accessor_Code_Modules();

        $code.=
            "}\n".
            "";
        $res=eval($code);
        //echo preg_replace('/\n/',"<BR>",preg_replace('/ /',"&nbsp;",$code));exit();

        return $res;
    }

    //*
    //* sub Accessor_Code_HashList, Parameter list: $accessorname,$accessor,$def
    //*
    //* Creates hash list accessor. Always work on $this->ApplicationObj():
    //* All modules has accessor method, but always calls on Application Obj.
    //*
    //*

    function Accessor_Code_Hash($accessorname,$accessor,$def)
    {
        $functionargs="\$key=''";
        $callargs=  "'".$accessor."'".   ",\$key";

        return
            "   function ".$accessorname."(".$functionargs.")\n".
            "   {\n".
            "      return \$this->ApplicationObj()->Accessor_Key(".$callargs.");\n".
            "   }\n".
            "   function ".$accessorname."_Set(".$functionargs.",\$value='')\n".
            "   {\n".
            "      return \$this->ApplicationObj()->Accessor_Key_Set(".$callargs.",\$value);\n".
            "   }\n".
            "";
    }

    //*
    //* sub Accessor_Code_HashList, Parameter list: $accessorname,$accessor,$def
    //*
    //* Creates hash list accessor. Always works on $this->ApplicationObj().
    //*
    //*

    function Accessor_Code_HashList($accessorname,$accessor,$def)
    {
        return
            "   function ".$accessorname."(\$id=0,\$key='',\$value='')\n".
            "   {\n".
            "      return \$this->ApplicationObj()->Accessors_Item('".$accessor."',\$id,\$key,\$value);\n".
            "   }\n".
            "";
    }


    //* sub Accessor_Code_Modules, Parameter list: $accessorname,$accessor,$def
    //*
    //* Creates module obj accessor. Always works on $this->ApplicationObj().
    //*
    //*

    function Accessor_Code_Modules()
    {
        $lines=file("System/Setup.php");
        $lines=preg_replace('/<\?php/',"",$lines);
        $lines=preg_replace('/\?>/',"",$lines);

        $res=eval('$modules='.join("",$lines).";\nreturn 1;");
        $modules=$modules[ "AllowedModules" ];

        $code="";
        foreach ($modules
                 as $module)
        {
            $code.=Accessor_Code_Module($module);
        }

        return $code;
    }

    //* sub Accessor_Code_Module, Parameter list: $accessorname,$accessor,$def
    //*
    //* Creates module obj accessor. Always works on $this->ApplicationObj().
    //*
    //*

    function Accessor_Code_Module($module)
    {
        $accessorname=$module."Obj";
        $accessorobj=$module."Object";

        return
            "   function ".$accessorname."(\$updatestructure=FALSE)\n".
            "   {\n".
            "      \$this->ApplicationObj()->MyMod_SubModule_Load('".$module."',\$updatestructure);\n".
            "      return \$this->ApplicationObj()->".$accessorobj.";\n".

            "   }\n".
            "";
    }

?>