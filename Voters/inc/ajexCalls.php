<?php
    require_once("../../admin/inc/config.php");

    if(isset($_POST['e_id']) && isset($_POST['c_id']) && isset( $_POST['v_id']))
    {
        $vote_date = date("Y-m-d");
        $vote_time = date("h:i:s a");
        mysqli_query($db,"INSERT INTO voting(ElectionID,VoterID,CandidateID,VoteDate,VoteTime) VALUES ('". $_POST['e_id'] ."','". $_POST['v_id']."','".$_POST['c_id'] ."','". $vote_date."','". $vote_time."')") or die(mysqli_error($db));

        echo "success";
    }
    
?>