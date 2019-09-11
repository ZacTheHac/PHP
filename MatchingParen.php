<?php

function isBalanced($input){ //verifies parenthesis are balanced and appear in a sensible order
    $length = strlen($input);
    $open_parentheses = 0; //counts the currently open groups of parenthesis
    for($i=0; $i<$length; $i++){
        $char = $input[$i]; //extracts the current character
        if($char == '('){   
            $open_parentheses++;
        } elseif($char == ')'){
            $open_parentheses--;
        } //only care if it was a ( or )

        //Debug dumps:
        /*var_dump($i);
        var_dump($char);
        var_dump($open_parentheses);
        */
        if($open_parentheses < 0){ //if there were more groups closed than were open at any given time, then the order isn't sensible
            return FALSE;
        } 
    }
    if($open_parentheses == 0){ //if this is zero, then all groups were closed
        return TRUE;
    } else{ //nonzero indicates an open group, as excessive closed groups is already checked
        return FALSE;
    }
}


$user_input = readline('Insert a string containing mixed parenthesis: ');
var_dump($user_input); //sanity check on the input
var_dump(isBalanced($user_input)); //dumps the returned value to console
?>