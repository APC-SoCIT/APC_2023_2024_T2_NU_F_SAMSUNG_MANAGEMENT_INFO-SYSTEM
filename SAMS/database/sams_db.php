<?php
if (!function_exists('OpenCon')) {
    function OpenCon()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "sams_v2";
        $con = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $con->error);

        return $con;
    }
}

if (!function_exists('CloseCon')) {
    function CloseCon($con)
    {
        $con->close();
    }
}
?>
