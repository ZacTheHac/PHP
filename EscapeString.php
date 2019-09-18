<?php

function escapeString($str){
    $search =  array("%"  ," "  ,"&"  ,"<"  ,">"  ,"\"" ,"'"  ,"!"  ,"?"  ,"."  ,"$"); //bare % goes first so it doesn't trigger on previous edits. Would need to be placed at the end if un-escaping
    $replace = array("%25","%20","%26","%3C","%3E","%22","%27","%21","%3F","%2E","%24");
    /*map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
        "'": '&#039;'
    };*///this is taken from a js project aimed more at HTML

    return str_replace($search,$replace,$str);
    
}

function test(){
    assert(escapeString("Mr John Smith")=="Mr%20John%20Smith","3 spaces, nothing tricky");
    assert(escapeString("Mr%20John%20Smith")=="Mr%2520John%2520Smith","Don't allow 'already escaped' text");
    assert(escapeString("<div>")=="%3Cdiv%3E","don't allow HTML");


}



test();
$user_input = readline("Insert a string to be escaped: ");
print escapeString($user_input);

?>