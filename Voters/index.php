<?php
require_once("inc/header.php");
require_once("inc/navigation.php");

if (isset($_GET['HomePage'])) {
    require_once("index.php");
} elseif (isset($_GET['logoutPage'])) {
    require_once("../admin/logout.php");
}

?>

<div class="row my-3">
    <div class="col-12">
        <h3>Voters Panel</h3>
        <?php
        $fetchingActiveElections = mysqli_query($db, "SELECT * FROM electiontable WHERE Status = 'Active'") or die(mysqli_error($db));
        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);
        if ($totalActiveElections > 0) {
            while ($data = mysqli_fetch_assoc($fetchingActiveElections)) {
                $electionId = $data['ElectionID'];
                $electionName = $data['ElectionName'];
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="4" class="bg-green text-white">
                                <h5>ELECTION NAME: <?php echo strtoupper($electionName) ?></h5>
                            </th>
                        </tr>
                        <tr>
                            <th>Picture</th>
                            <th>Candidate Details</th>
                            <th># of Votes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $fetchingCandidates = mysqli_query($db,"SELECT * FROM candidate WHERE ElectionID = '".$electionId."' ") or die(mysqli_error($db));
                            while ($data = mysqli_fetch_assoc($fetchingCandidates)) 
                            {
                                $candidateId = $data['CandidateID'];
                                $candidatephoto = $data['CandidatePic'];

                                $fetchingVotes = mysqli_query($db,"SELECT * FROM voting WHERE CandidateID = '". $candidateId ."' ") or die(mysqli_error($db));
                                $totalVotes = mysqli_num_rows($fetchingVotes);
                                ?>
                                <tr>
                                    <td><img src="<?php echo $candidatephoto ?>" class="candidate_photo"></td>
                                    <td><?php echo "<b>" . $data['CandidateName'] . "</b><br />". $data['CandidateDetails'] ?></td>
                                    <td><?php echo $totalVotes?></td>
                                    <td> 
                                        <?php
                                        $checkIfVoteCasted= mysqli_query($db,"SELECT * FROM voting WHERE VoterID = '". $_SESSION['user_id'] ."' AND ElectionID = '".$electionId."'") or die(mysqli_error($db));
                                        $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);
                                        if($isVoteCasted >0)
                                        {
                                            $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                            $voteCastedToCandidate = $voteCastedData['CandidateID'];
                                            if($voteCastedToCandidate == $candidateId)
                                            {
                                                ?>
                                                <img src="../assets/images/vote.png" width="70px">

                                            <?php
                                            }
                                            
                                        }
                                        else
                                        {?>
                                             <button class="btn btn-md btn-success"
                                            onclick="CastVote(<?php echo $electionId; ?>, <?php echo $candidateId; ?>, <?php echo $_SESSION['user_id']; ?>)">
                                            Vote </button>
                                        <?php 
                                        }
                                        ?>
                                       
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
            }
        } else {
            echo "No any active Election";
        }
        ?>
    </div>
</div>

<script>
    const CastVote = (election_Id,candidate_Id,voter_Id) =>
    {
        $.ajax({
            type: "POST",
            url: "inc/ajexCalls.php",
            data: "e_id=" + election_Id + "&c_id=" + candidate_Id + "&v_id=" + voter_Id, 
            success: function(response) {
                if(response == "success")
                {
                    location.assign("index.php?VoteCaste=1");
                }
                else
                {
                    location.assign("index.php?VoteNotCaste=1");
                }
            }
        });
    }
</script>

<?php
    require_once("inc/footer.php");
?>