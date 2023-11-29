<?php
$election_Id = $_GET['viewResults'];
?>
<style>
    /* Add some styling for the winner row */
    .winner-row {
        background-color: #dff0d8;
        margin-top: 50px;
        /* Light green background for the winner row */
    }

    /* Center the winner message */
    .winner-container {
        /* display: inline-block;
        justify-content: center;
        text-align: center;
        margin: 10px;
        padding-left: 100px;
        padding-right: 100px; */
        display: inline-block;
        padding: 5px 25px;
        /* background-color: #ffffff; */
        /* Button background color */
        color: #121e27;
        border: none;
        text-align: center;
        font-size: 20px;
    }

    .winner-message {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        padding: 5px 10px;
        margin-top: 10px;
        /* margin-left: -100px; */
        /* Adjust as needed */
    }

    /* Style the checkmark icon */
    .winner-icon {
        color: #5cb85c;
        /* Green color for the checkmark */
        /* margin-right: 10px; */
        font-weight: bold;
        padding-right: 10px;
        /* Make the icon bold */
    }
</style>
<div class="row my-3">
    <div class="col-12">
        <h3>Election results</h3>
        <?php
        $fetchingActiveElections = mysqli_query($db, "SELECT * FROM electiontable WHERE ElectionID = '" . $election_Id . "'") or die(mysqli_error($db));

        $totalActiveElections = mysqli_num_rows($fetchingActiveElections);
        //echo $totalActiveElections;
        if ($totalActiveElections > 0) {
            while ($data = mysqli_fetch_assoc($fetchingActiveElections)) {
                $electionId = $data['ElectionID'];
                $electionName = $data['ElectionName'];
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="4" class="bg-green text-white">
                                <h5>ELECTION NAME:
                                    <?php echo strtoupper($electionName) ?>
                                </h5>
                            </th>
                        </tr>
                        <tr>
                            <th>Picture</th>
                            <th>Candidate Details</th>
                            <th>Party Affiliation</th>
                            <th># of Votes</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate WHERE ElectionID = '" . $electionId . "' ") or die(mysqli_error($db));
                        $winnerId = null;
                        $maxVotes = -1; // Initialize to -1 to ensure any candidate with votes is considered
                
                        while ($data = mysqli_fetch_assoc($fetchingCandidates)) {
                            $candidateId = $data['CandidateID'];
                            $candidatephoto = $data['CandidatePic'];
                            $candidateName = $data['CandidateName'];
                            $party_id = $data['PartyID'];

                            // Fetching Vote count
                            $fetchingVotes = mysqli_query($db, "SELECT * FROM voting WHERE CandidateID = '" . $candidateId . "' ") or die(mysqli_error($db));
                            $totalVotes = mysqli_num_rows($fetchingVotes);


                            // Check for a tie
                            if ($totalVotes > $maxVotes) {
                                $maxVotes = $totalVotes;
                                $winnerId = $candidateId;
                            }

                            // fetching party name
                            $fetchingParty = mysqli_query($db, "SELECT * FROM party WHERE PartyID = '" . $party_id . "' ") or die(mysqli_error($db));
                            $partydata = mysqli_fetch_assoc($fetchingParty);
                            $partyName = $partydata["PartyName"];
                            ?>
                            <tr>
                                <td><img src="<?php echo $candidatephoto ?>" class="candidate_photo"></td>
                                <td>
                                    <?php echo "<b>" . $data['CandidateName'] . "</b><br />" . $data['CandidateDetails'] ?>
                                </td>
                                <td>
                                    <?php echo $partyName ?>
                                </td>
                                <td>
                                    <?php echo $totalVotes ?>
                                </td>

                            </tr>
                            <?php
                        }
                        ?>
                        <div class="winner-container">
                            <?php
                            if ($winnerId !== null) {
                                echo "<div class='winner-message'>Winner is Candidate: " . $candidateName . "<i class='fas fa-check winner-icon'></i></div>";
                            } else {
                                echo "<div class='winner-message'>No clear winner (Tie)</div>";
                            }
                            ?>
                        </div>

                    </tbody>
                </table>


                <?php
            }
        } else {
            echo "No any active Election";
        }
        ?>
        <hr>
        <h3>Voting Details</h3>

        <?php
        $fetchingVoteDetails = mysqli_query($db, "SELECT * FROM voting WHERE ElectionID = '" . $election_Id . "'") or die(mysqli_error($db));
        $number_of_Votes = mysqli_num_rows($fetchingVoteDetails);

        if ($number_of_Votes > 0) {
            ?>
            <table class="table">
                <tr>
                    <th>S.No</th>
                    <th>Voter Name</th>
                    <th>Email</th>
                    <th>Voted To</th>
                    <th>Date </th>
                    <th>Time</th>
                </tr>
                <?php
                $sno = 1;
                while ($data = mysqli_fetch_assoc($fetchingVoteDetails)) {
                    $voterId = $data["VoterID"];
                    $candidateId = $data["CandidateID"];

                    $fetchingUsername = mysqli_query($db, "SELECT * FROM user WHERE ID = '" . $voterId . "'") or die(mysqli_error($db));
                    $isDataAvailable = mysqli_num_rows($fetchingUsername);
                    $userData = mysqli_fetch_assoc($fetchingUsername);
                    if ($isDataAvailable > 0) {
                        $username = $userData['Username'];
                        $email = $userData['Email'];
                    } else {
                        $username = 'No Data';
                    }

                    $fetchingCandidateName = mysqli_query($db, "SELECT * FROM candidate WHERE CandidateID = '" . $candidateId . "'") or die(mysqli_error($db));
                    $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                    $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                    if ($isDataAvailable > 0) {
                        $candidateName = $candidateData['CandidateName'];
                    } else {
                        $candidateName = 'No Data';
                    }

                    ?>
                    <tr>
                        <td>
                            <?php echo $sno++; ?>
                        </td>
                        <td>
                            <?php echo $username ?>
                            </< /td>
                        <td>
                            <?php echo $email ?>
                        </td>
                        <td>
                            <?php echo $candidateName ?>
                        </td>
                        <td>
                            <?php echo $data['VoteDate'] ?>
                        </td>
                        <td>
                            <?php echo $data['VoteTime'] ?>
                        </td>
                    </tr>
                    <?php
                }
                echo "</table>";
        } else {
            echo "No any vote details is available";
        }
        ?>
        </table>
    </div>
</div>