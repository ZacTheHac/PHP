<?php
//this function will attempt to compress a string using the pattern aaabcccc => a3b1c4
//if the resulting string would be the same length or longer than the original, or if it contains a number, it will return the original string

//for processing of large files, it would be possible to make an edit to stream in the files, and even multi-thread it.
//the only thing to verify would be that the first and last characters of each compressed chunk weren't the same as the previous, and if they were to sum them together.
//then verify that each chunk was written in the correct order.
//this could be easily handled by an extra thread whose job is to oversee the other threads, stitch their outputs together, and write to the compressed file.
function CompressString($str){
    $strLen = strlen($str);
    if(preg_match('~[0-9]~', $str)===1 or $strLen <= 2){
        return $str;
    }//reject strings containing numbers, and strings smaller than 2 characters (which would be impossible to make any smaller)

    //print "Basic check passed\n";

    $output = "";
    $CurrChar = $str[0];
    $CharCount = 1;
    
    for($i=1;$i<$strLen;$i++){
        if($str[$i] == $CurrChar){
            $CharCount++;
            //print $CurrChar." repeated ".$CharCount." times\n";
        }
        else{
            $output .= $CurrChar;
            $output .= $CharCount; //add the previous character and count onto the string
            //print $CurrChar." repeated ".$CharCount." time(s) in total\n";

            $CurrChar = $str[$i];
            $CharCount = 1; //set the new values

        }
    }
    $output .= $CurrChar;
    $output .= $CharCount;//tack on the final character we were checking

    if(strlen($output)>=$strLen){
        //no compression achieved
        return $str;
    }
    else{
        return $output;
    }

}

function test(){
    assert(CompressString("aabcccccaaa")=="a2b1c5a3","Base expectation");
    assert(CompressString("aabcc1cccaaa")=="aabcc1cccaaa","Don't compress strings with numbers");
    assert(CompressString("abcde")=="abcde","Return original if no compression is achieved");
    assert(CompressString("aabbccdd")=="aabbccdd","compressed is the same size");
    assert(CompressString("")=="","Empty string");
    assert(CompressString("a")=="a","single character string");
    assert(CompressString(str_repeat("a",10000))=="a10000","very long string of single character");
}

print("Warning: This function cannot compress numbers.\n");//if numbers were allowed, it'd make a555 into a153 which expands to 153 a's
test();
$user_input = readline("Insert a string to be compressed: ");
print CompressString($user_input);
?>