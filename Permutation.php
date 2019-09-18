<?php
//thoughts: could use an array and map a number onto each character that's incremented for every instance of it, then compare the 2
//could sort the strings then compare them
//could have a counter that increments the value of the character for the first string, and decrements that amount on the second string
   //caveat of this: for a long string with lots of high-value characters, we could overflow the counter. But it would likely be the most efficient.
   //this would only work because we know the lengths are equal
   //this also wouldn't work for numbers. as "53" would be a permutation of "80"
/*function isPermutation($Str1,$Str2){
    $StrLen = strlen($Str1);
    if($StrLen != strlen($Str2)){
        return FALSE;//if they're not the same length, they can't possibly be permutations of the other
    }
    $counter = 0;
    for($i=0;$i<$StrLen;$i++){
        $counter+=ord($Str1[$i]); //ord returns the value of the 1st byte, and thus the character we send
        $counter-=ord($Str2[$i]);
    }
    return $counter == 0;


}*/
function isPermutation($Str1,$Str2){
    $StrLen = strlen($Str1);
    if($StrLen != strlen($Str2)){
        return FALSE;//if they're not the same length, they can't possibly be permutations of the other
    }
    $Str1Array = str_split($Str1);
    $Str2Array = str_split($Str2); //split them into arrays
    sort($Str1Array);
    sort($Str2Array); //sort them
    return $Str1Array == $Str2Array; //they should be the same now. if they are not, then they were never permutations of each other
}

function test(){
    assert(isPermutation("ABCDE","ABCD")==FALSE,"Different lengths");
    assert(isPermutation("ABCDE","ABCDE"),"Same String");
    assert(isPermutation("ABCDE","EDCBA"),"Reversed");
    assert(isPermutation("ABCDE","AABCDE")==FALSE,"Repeated char");
    assert(isPermutation("22","d")==FALSE,"same ascii value, different characters");
    assert(isPermutation("53","80")==FALSE,"same summed value, different numbers");
    assert(isPermutation(str_repeat('~',127000),str_repeat("\t",127000))==FALSE,"try to overflow the counter"); //~ has value 126, tab has 9, and are thus the highest and lowest receivable values. also these happen to be about the max length it'll allow
}


test();
$user_input_1 = readline('Insert a string: ');
$user_input_2 = readline('Insert a permutation of '.$user_input_1.': ');
print "\"".$user_input_2."\" is". (isPermutation($user_input_1,$user_input_2) ? "":" not") . " a permutation of \"".$user_input_1."\"";
?>