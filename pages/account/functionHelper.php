<?php
    function recheckPassword($pwd, $pwd1)
    {
        return strcmp($pwd, $pwd1) == 0;
    }
?>