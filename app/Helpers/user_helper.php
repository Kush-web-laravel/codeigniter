<?php 

if(!function_exists("get_users")){
    
    function get_users(){
        $db = \Config\Database::connect();
        $users = $db->query("SELECT * from tbi_users")->getResultArray();
        echo"<pre>";
        print_r($users);
    }
}

if(!function_exists("print_my_message")){

    function print_my_message($message){
        echo $message;
    }
}

if(!function_exists("find_my_length")){

    function find_my_length($string){
        return strlen($string);
    }
}