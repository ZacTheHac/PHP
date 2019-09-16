<?php
//fair warning that unicode doesn't REALLY support unicode, so if the input contains multiple unicode characters, it wil flag them as duplicates.
function UniqueString($input){
    //only runs through the string once, but uses a fair amount of extra memory
    $found_chars = []; //can also use array() but [] was added in 5.4
    $fc_index = 0;
    $input_arr = str_split($input,1);//splits the string into an array with 1 char for each element
    foreach($input_arr as $char){
        if(array_search($char,$found_chars,TRUE) !== FALSE){ //must be a strict/identical comparison, otherwise php will equate 0 to FALSE
            //print($char . "=" . $found_chars[array_search($char,$found_chars,TRUE)] . "\n");
            return FALSE; //if it already exists in the array, then it's a duplicate and we immediately fail the string
        }
        else{
            $found_chars[$fc_index++] = $char; //add the character to the array and increment the index counter.
        }
    }
    //if the code reaches here, there were no duplicates found
    return TRUE;
}

function UniqueStringNoData($input){
    //this does the same as the previous funcion but without additional structs. accesses characters (n^2+n)/2 times maximum
    $len = strlen($input);
    for($i = 0;$i<$len - 1;$i++){ //iterate through every single item in the array, except the last. if we reach the last one, we already know it's unique
        $char = $input[$i]; //store the char we're looking for
        for($j = $i+1;$j<$len;$j++){ //iterate through every character AFTER the one we're checking. We already know all previous chars are unique
            if($input[$j]===$char){ 
                return FALSE; //eject after first duplicate is found
            }
        }
    }
    return TRUE; //if the code reaches here, no duplicates were found.
}

function UniqueStringStrPos($input){
    //this does the same as the previous funcion but in a different way. only goes through the string once maximum, and uses no extra storage. Seems to be the fastest in my testing.
    $len = strlen($input);
    for($i = 0;$i<$len - 1;$i++){
        if(strpos($input,$input[$i],$i+1) !== FALSE){ //check if strpos can find it later in the string
            return FALSE;
        }
    }
    return TRUE;
}



function test(){
    assert_options(ASSERT_BAIL,1); //I don't want the code to continue if a test fails

    assert(UniqueString("abcdefghijklmnopqrstuvwxyz1234567890~ABCDEFGHIJKLMNOPQRSTUVWXYZ"),"Alphanumeric no duplicates");
    assert(UniqueString(""),"empty string");
    assert(UniqueString("\n\\"),"control chars no duplicates");
    assert(UniqueString("abcdea") == FALSE,"first char is duplicate");
    assert(UniqueString("alshjkdfe23467895#$%^&*()@&^(#&*!@$^wui9fhojnlsdk")==FALSE,"alphanumeric + symbols with duplicates");
    assert(UniqueString(' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~'),"All ASCII no duplicates");

    assert(UniqueStringNoData("abcdefghijklmnopqrstuvwxyz1234567890~ABCDEFGHIJKLMNOPQRSTUVWXYZ"),"[No Data] Alphanumeric no duplicates");
    assert(UniqueStringNoData(""),"[No Data] empty string");
    assert(UniqueStringNoData("\n\\"),"[No Data] control chars no duplicates");
    assert(UniqueStringNoData("abcdea") == FALSE,"[No Data] first char is duplicate");
    assert(UniqueStringNoData("alshjkdfe23467895#$%^&*()@&^(#&*!@$^wui9fhojnlsdk")==FALSE,"[No Data] alphanumeric + symbols with duplicates");
    assert(UniqueStringNoData(' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~'),"[No Data] All ASCII no duplicates");

    assert(UniqueStringStrPos("abcdefghijklmnopqrstuvwxyz1234567890~ABCDEFGHIJKLMNOPQRSTUVWXYZ"),"[StrPos] Alphanumeric no duplicates");
    assert(UniqueStringStrPos(""),"[StrPos] empty string");
    assert(UniqueStringStrPos("\n\\"),"[StrPos] control chars no duplicates");
    assert(UniqueStringStrPos("abcdea") == FALSE,"[StrPos] first char is duplicate");
    assert(UniqueStringStrPos("alshjkdfe23467895#$%^&*()@&^(#&*!@$^wui9fhojnlsdk")==FALSE,"[StrPos] alphanumeric + symbols with duplicates");
    assert(UniqueStringStrPos(' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~'),"[StrPos] All ASCII no duplicates");
    
}

test();
$user_input = readline('Insert a string with all unique characters: ');
$startTime = microtime(TRUE); //used to time each method's execution time
if(UniqueString($user_input)){
    print "all unique\n";
}else{
    print "not all unique\n";
}
print("Time Elapsed: " . (microtime(TRUE)-$startTime)*1000 . "ms\n");

$startTime = microtime(TRUE);
if(UniqueStringNoData($user_input)){
    print "[No Data] all unique\n";
}else{
    print "[No Data] not all unique\n";
}
print("Time Elapsed: " . (microtime(TRUE)-$startTime)*1000 . "ms\n");

$startTime = microtime(TRUE);
if(UniqueStringStrPos($user_input)){
    print "[StrPos] all unique\n";
}else{
    print "[StrPos] not all unique\n";
}
print("Time Elapsed: " . (microtime(TRUE)-$startTime)*1000 . "ms\n");

?>