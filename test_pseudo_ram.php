<?php
//$cond_exp_disp=array('A');
//$first_ele=array('B');

//$cond_exp_pos=array_diff($cond_exp_disp, $first_ele);
//print_r($cond_exp_pos);

#call codigo


function first_tuple($vect_cond_exp,$num_pages)
{   $tupla_final=array();
    $intento_1=array();
    $start=$vect_cond_exp;
    for ($i=0; $i <$num_pages/3 ; $i++) { 
        $tuple_1=array();
        foreach ($start as $value) {
            array_push($tuple_1, $value);
        }
        //echo "<pre>"; print_r($tuple_1);
        shuffle($tuple_1);
        array_push($intento_1, $tuple_1);
        unset($tuple_1);
        //array_push($tuple_1, $start[$i]);
    }
    //ççecho "<pre>"; print_r($intento_1);
    
        foreach ($intento_1 as $value) {
            foreach ($value as $valor) 
            {   
              array_push($tupla_final,$valor);
            }
        

    }
    return $tupla_final;
    
}

function pseudo_ram($cond_1,$cond_2,$cond_3,$num_pages)
{   
    while (true) {
        # code...
    if ($num_pages % 3 !=0) {
        return array("error");
    }
    $arr_cond_exp=array($cond_1,$cond_2,$cond_3);
    $start=first_tuple($arr_cond_exp,$num_pages);
    //print_r($start);
    //print_r(array_count_values($start));
    //print "<br>";
    $intento_2=array();
  
      for ($i=0; $i<sizeof($start); $i++)
   {    
        #get 1 elemento
        $first_ele=array($start[$i]);
        
        
        
        if ($i==0)
            {   
                # get los elementos restantes entre cond_exp_actual y los cond_exp all
                $result=array_diff($arr_cond_exp, $first_ele); #return me , the cond_exp remaining
                $cond_exp_picked=array_rand($result,1);
                $cond_exp=$result[$cond_exp_picked];
                array_push($intento_2,$cond_exp);
            }
        else 
            {
                
                
                $count_elements=array_count_values($intento_2);
                $vec_count=balance($count_elements,$arr_cond_exp);
                //print_r($vec_count);
                $cond_exp_disp=pseudo_random($vec_count[$cond_1],$vec_count[$cond_2],$vec_count[$cond_3],$cond_1,$cond_2,$cond_3);
                //print_r($cond_exp_disp);

                //
                //print_r("diff entre ".$cond_exp_disp." ".$first_ele); 
                $cond_exp_pos=array_diff($cond_exp_disp, $first_ele);
                //print_r($cond_exp_pos);
                if (empty($cond_exp_pos)) {
                    //echo "iguales ".$cond_exp_disp." ".$first_ele;
                    $cond_exp_pos=array_diff($arr_cond_exp, $cond_exp_disp);
                }
                $cond_exp_picked=array_rand($cond_exp_pos,1);
                $cond_exp=$cond_exp_pos[$cond_exp_picked];
                array_push($intento_2,$cond_exp);
                //echo $cond_exp;
                



            


        }
        
    
       
        //print_r($intento_2);    

   }
   //print_r($intento_2);
   //print_r(array_count_values($intento_2));
   //print "<br>";
   
   $count_intento_2=array_count_values($intento_2);
   if ($count_intento_2[$cond_1]==$count_intento_2[$cond_2] and $count_intento_2[$cond_3]==$count_intento_2[$cond_2])
   {
    //print_r(array_count_values($intento_2));
    //echo "valido";
    $intento_3=intento_3($start,$intento_2,$arr_cond_exp);
    //print_r($intento_3);
    //print_r(array_count_values($intento_3));
    //print "<br>";
    //print "<br>";
    return array($start,$intento_2,$intento_3);
   }
   }
    
}
function intento_3($intento_1,$intento_2,$arr_cond_exp)
{   $intento_3=array();
    
    for ($i=0; $i <sizeof($intento_1); $i++) { 
        $L1=$intento_1[$i];
        $L2=$intento_2[$i];
        //echo $L1;
        $cond_exp_exist=array($L1,$L2);
        $cond_exp_pos=array_diff($arr_cond_exp,$cond_exp_exist);
        foreach ($cond_exp_pos as $key => $value) {
            array_push($intento_3,$value);
        }
        

    }
    return $intento_3;

    
}
function balance($arr_count_cond_exp,$vect_cond_exp)
{   $result=array();
    //print_r($arr_count_cond_exp);
    foreach ($vect_cond_exp as $key => $cond) {
        if (is_null($arr_count_cond_exp[$cond]))
        {
           $result[$cond]=0;

        }
        else
        {
              $result[$cond]=$arr_count_cond_exp[$cond];
        }
        
    }
    return $result;
   // echo implode($result);
        
        



}

function pseudo_random($x1,$x2,$x3,$cond_1,$cond_2,$cond_3) 
 {  

    if ($x1==$x2 and $x2==$x3 and $x3==$x1)
    {
        return array($cond_1,$cond_2,$cond_3);

    }
    else{
        if ($x1!=$x2 and $x2!=$x3 and $x3!=$x1)
        {

            if ($x1<$x2 and$x1<$x3)
            {

                return  array($cond_1);
            }
            else
            {

                if($x2<$x1 and $x2<$x3)
                {
                    return array($cond_2);


                }
                else
                {

                    if ($x3<$x1 and $x3<$x2)
                    {

                        return array($cond_3);
                    }
                }

            }



        }
        else 
        {
          if ($x1==$x2 and $x3>$x1)
          {
            return array($cond_1,$cond_2);

          }
          else
          { 
            if($x1==$x2 and $x3<$x1)
                {
                    return array($cond_3);
                }
            else
            {
                if($x1==$x3 and $x2>$x1)
            {

                return array($cond_1,$cond_3);
            }
            else
            {

                if($x1==$x3 and $x2<$x1)
                {

                    return array($cond_2);
                }
                else
            {
                if ($x2==$x3 and $x1>$x2)
                {

                    return  array($cond_2,$cond_3);
                }
                else
                {
                   if ($x2==$x3 and $x1<$x2)
                   {
                    return array($cond_1);

                   } 
                }
            } 


            }


            
        }

           


          }

        }


    }
}

?>
