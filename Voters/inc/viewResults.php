<div class="row my-3">
    <div class="col-4">
        <h3>View Results</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select class="form-control" name="election_id" required>
                    <option value=""> Select Election </option>
                    <?php
                    $fetchingelections = mysqli_query($db, "SELECT * FROM electiontable where Status = 'Expired' ") or die(mysqli_error($db));
                    $isanyElectionAdded = mysqli_num_rows($fetchingelections);
                    if ($isanyElectionAdded > 0) {
                        while ($row = mysqli_fetch_assoc($fetchingelections)) {
                            $election_Id = $row['ElectionID'];
                            $election_name = $row['ElectionName'];
                            
                                ?>
                                <option value="">
                                    <?php echo $election_name ?>
                                </option>
                                <?php
                        }
                    } else {
                        ?>
                        <option value="">Please add election First!</option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Show Result" name="showResultbtn" class="btn btn-success">
        </form>
    </div>
    <div class="col-8">
        <h3>Election results</h3>
        <?php
        $fetchingActiveElections = mysqli_query($db, "SELECT * FROM electiontable WHERE ElectionID = '".$election_Id."'") or die(mysqli_error($db));
        
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
                                <h5>ELECTION NAME: <?php echo strtoupper($electionName) ?></h5>
                            </th>
                        </tr>
                        <tr>
                            <th>Picture</th>
                            <th>Candidate Details</th>
                            <th># of Votes</th>
                            <!-- <th>Action</th> -->
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
        <hr>
        <h3>Voting Details</h3>
        
        <?php
            $fetchingVoteDetails = mysqli_query($db,"SELECT * FROM voting WHERE ElectionID = '".$election_Id."'") or die(mysqli_error($db));
            $number_of_Votes = mysqli_num_rows($fetchingVoteDetails);

            if($number_of_Votes > 0)
            {
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
                while($data = mysqli_fetch_assoc($fetchingVoteDetails))
                {
                    $voterId = $data["VoterID"];
                    $candidateId = $data["CandidateID"];

                    $fetchingUsername = mysqli_query($db,"SELECT * FROM user WHERE ID = '".$voterId."'") or die(mysqli_error($db));
                    $isDataAvailable = mysqli_num_rows($fetchingUsername);
                    $userData = mysqli_fetch_assoc($fetchingUsername);
                    if($isDataAvailable > 0)
                    {
                        $username = $userData['Username'];
                        $email = $userData['Email'];
                    }
                    else
                    {
                        $username = 'No Data';
                    }

                    $fetchingCandidateName = mysqli_query($db,"SELECT * FROM candidate WHERE CandidateID = '".$candidateId."'") or die(mysqli_error($db));
                    $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                    $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                    if($isDataAvailable > 0)
                    {
                        $candidateName = $candidateData['CandidateName'];
                    }
                    else
                    {
                        $candidateName = 'No Data';
                    }

                    ?>
                    <tr>
                        <td><?php echo $sno++; ?></td>
                        <td><?php echo $username ?></</td>
                        <td><?php echo $email ?></td>
                        <td><?php echo $candidateName ?></td>
                        <td><?php echo $data['VoteDate'] ?></td>
                        <td><?php echo $data['VoteTime'] ?></td>
                    </tr>
                    <?php
                }
                echo "</table>";
            }
            else
            {
                echo "No any vote details is available";
            }
        ?>
        </table>
    </div>
</div>