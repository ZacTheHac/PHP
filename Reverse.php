<?php
//reverses an input string
function reverseString($input){
    $len = strlen($input);
    for($i=0;$i<(floor($len)/2);$i++){ //only needs to go through the first half of the string. By using floor, if there were an odd number, the center character wouldn't be touched as it would stay the same anyways
        $char = $input[$i];
        $input[$i] = $input[$len-1-$i];// -1 to make sure i'm in the string, then -i to work inwards from the last character
        $input[$len-1-$i] = $char;//take the letter from the buffer and copy it over
    }
    return $input;
}

function test(){
    assert(reverseString("1234567890")=="0987654321","numbers even");
    assert(reverseString("123456789")=="987654321","numbers odd");
    assert(reverseString("hello, this is a test string.")==".gnirts tset a si siht ,olleh","Sentence odd");
    assert(reverseString("hello, this is atest string.")==".gnirts tseta si siht ,olleh","Sentence even");
}

test();
$user_input = readline('Input a string to reverse: ');
print(reverseString($user_input));

?>