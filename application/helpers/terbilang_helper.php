<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Terbilang Helper
 *


 */

 

if ( ! function_exists('number_to_words'))

{

    function number_to_words($number)

    {

        $before_comma = trim(to_word($number));

        $after_comma = trim(comma($number));
        
        if (substr($number,4,2)=='00'){
            $results = $before_comma;
       }else{
            $results = $before_comma.' koma '.$after_comma; 
        }

        return $results;

    }

 

    function to_word($number)

    {

        $words = "";

        $arr_number = array(

        "",

        "satu",

        "dua",

        "tiga",

        "empat",

        "lima",

        "enam",

        "tujuh",

        "delapan",

        "sembilan",

        "sepuluh",

        "sebelas");

 

        if($number<12)

        {

            $words = " ".$arr_number[$number];

        }

        else if($number<20)

        {

            $words = to_word($number-10)." belas";

        }

        else if($number<100)

        {

            $words = to_word($number/10)." puluh ".to_word($number%10);

        }

        else if($number<200)

        {

            $words = "seratus ".to_word($number-100);

        }

        else if($number<1000)

        {

            $words = to_word($number/100)." ratus ".to_word($number%100);

        }

        else if($number<2000)

        {

            $words = "seribu ".to_word($number-1000);

        }

        else if($number<1000000)

        {

            $words = to_word($number/1000)." ribu ".to_word($number%1000);

        }

        else if($number<1000000000)

        {

            $words = to_word($number/1000000)." juta ".to_word($number%1000000);

        }

        else

        {

            $words = "undefined";

        }

        return $words;

    }

 

    function comma($number)

    {
        $after_comma=substr($number,4,2);
        $cekdigit=substr($after_comma,0,1);
        if($cekdigit<1){
            $arr_number = array(
                
                        "nol",
                
                        "satu",
                
                        "dua",
                
                        "tiga",
                
                        "empat",
                
                        "lima",
                
                        "enam",
                
                        "tujuh",
                
                        "delapan",
                
                        "sembilan");
                
                
                        $results = "";
                
                        $length = strlen($after_comma);
                
                        $i = 0;
                
                        while($i<$length)
                
                        {
                
                            $get = substr($after_comma,$i,1);
                
                            $results .= " ".$arr_number[$get];
                
                            $i++;
                
                        }
                
        }else{

        
        $results = "";

        $arr_number = array(

        "",

        "satu",

        "dua",

        "tiga",

        "empat",

        "lima",

        "enam",

        "tujuh",

        "delapan",

        "sembilan",

        "sepuluh",

        "sebelas");

       
       

        if($after_comma<12)

        {

            $results = " ".$arr_number[$after_comma];

        }

        else if($after_comma<20)

        {

            $results = to_word($after_comma-10)." belas";

        }

        else 

        {

            $results = to_word($after_comma/10)." puluh ".to_word($after_comma%10);

        }
    }


        return $results;

    }

}
