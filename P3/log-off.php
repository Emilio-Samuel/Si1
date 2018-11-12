<?php

if(isset($_POST["logoff"])) {
    session_unset();
    session_destroy();
}

?>
