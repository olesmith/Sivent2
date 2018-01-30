<?php

/* class SearchInit extends SearchTable */
/* { */
/*     //\* */
/*     //\* function InitSearch, Parameter list: $hash=array() */
/*     //\* */
/*     //\* Initializer. */
/*     //\* */

/*     function InitSearch($hash=array()) */
/*     { */
/*         return; */

/*         foreach (array_keys($this->ItemData) as $data) */
/*         { */
/*             if ( */
/*                 ( */
/*                  $this->LoginType=="Admin" */
/*                  && */
/*                  $data=="ID" */
/*                 ) */
/*                 || */
/*                 ( */
/*                  isset($this->ItemData[ $data ][ "Search" ]) */
/*                  && */
/*                  $this->ItemData[ $data ][ "Search" ] */
/*                  &&  */
/*                  $this->MyMod_Data_Access($data)>=1 */
/*                 ) */
/*                ) */
/*             { */
/*                 $this->SearchVars[ $data ]=$this->ItemData[ $data ]; */

/*                 foreach ($this->DefaultSearchData as $key => $value) */
/*                 { */
/*                     if (!isset($this->SearchVars[ $data ][ $key ])) */
/*                     { */
/*                         $this->SearchVars[ $data ][ $key ]=$value; */
/*                     } */
/*                 } */

/*                 if ( */
/*                       isset($this->ItemData[ $data ][ "SearchCompound" ]) */
/*                       && */
/*                       $this->ItemData[ $data ][ "SearchCompound" ] */
/*                    ) */
/*                 { */
/*                     $this->SearchVars[ $data ][ "Compound" ]=TRUE; */
/*                     $this->SearchVars[ $data ][ "Var" ]=$this->ItemData[ $data ][ "SearchVar" ]; */
/*                     $this->SearchVars[ $data ][ "NVars" ]=$this->ItemData[ $data ][ "SearchNVars" ]; */
                    
/*                 } */
/*             } */
/*         } */
/*     } */

/*     //\* */
/*     //\* function PostInitSearch, Parameter list:  */
/*     //\* */
/*     //\* Search post initializer. Adds search vars to cookies. */
/*     //\* */

/*     function PostInitSearch() */
/*     { */
/*         $this->MyApp_Login_Detect(); */
/*         foreach ($this->SearchVars as $var => $def) */
/*         { */
/*             if ($def[ $this->LoginType ]==0) */
/*             { */
/*                 unset($this->SearchVars[ $var ]); */
/*             } */
/*         } */

/*         $this->MyMod_Search_CGI_Vars_2_Cookies(); */
/*         $this->SetCookieVars(); */
/*     } */
/* } */


?>