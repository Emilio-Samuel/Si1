<?php

function get_user_balance($user_email) {
    if(file_exists("./usuarios/".$_POST["email"]."/user.dat")) {
        $user_dat = fopen("./usuarios/".$_POST["email"]."/user.dat","r");
        $line = trim(fgets($user_dat));
        $pw = md5($_POST["password"]);
        if($pw === $line) {
            $_SESSION["logged"]=true;
            $_SESSION["name"]=fgets($user_dat);
            $_SESSION["email"]=fgets($user_dat);
            $_SESSION["cart"] = array();
    }
}

?>
