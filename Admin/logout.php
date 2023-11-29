<?php
    session_start();
    session_destroy();
    session_unset();
    // header("location: index.php");
?>

<script>location.assign("../index.php")</script>