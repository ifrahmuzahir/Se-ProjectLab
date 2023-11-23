<?php
if (isset($_GET["added"])) {
    ?>
    <div class="alert alert-success my-3" role="alert">
        Candidate has been added successfully!
    </div>
    <?php
}
else if (isset($_GET["largeFiles"])) {
    ?>
    <div class="alert alert-danger my-3" role="alert">
        Candidate image is too large. Please uplaod small file(upto 2mbs).
    </div>
    <?php
}
else if (isset($_GET["InvalidFile"])) {
    ?>
    <div class="alert alert-danger my-3" role="alert">
        Invalid image type(Only jpg, png, jpeg file are allowed)
    </div>
    <?php
}
else if (isset($_GET["failed"])) {
    ?>
    <div class="alert alert-danger my-3" role="alert">
        Image uploading failed, please try again
    </div>
    <?php
}
?>


<div class="row my-3">
    <div class="col-4">
        <h3>Add Candidate</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select class="form-control" name="election_id" required>
                    <option value=""> Select Election </option>
                    <?php 
                        $fetchingelections = mysqli_query($db,"SELECT * FROM electiontable") or die(mysqli_error($db));
                        $isanyElectionAdded = mysqli_num_rows($fetchingelections);
                        if ($isanyElectionAdded > 0) 
                        {
                            while($row = mysqli_fetch_assoc($fetchingelections))
                            {
                                $election_Id = $row['ElectionID'];
                                $election_name = $row['ElectionName'];
                                $allowed_candidate = $row['no_of_candidates'];

                                $fetchingcandidate=mysqli_query($db,"SELECT * FROM candidate where ElectionID = '". $election_Id ."'") or die(mysqli_error($db));
                                $addedCandidate = mysqli_num_rows($fetchingcandidate);
                                if($addedCandidate < $allowed_candidate)
                                {
                                   
                        ?>
                                <option value=""><?php echo $election_name?></option>
                        <?php
                                }
                            }
                        } 
                        else 
                        { 
                            ?>
                            <option value="">Please add election First!</option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control"
                    required />
            </div>
            <div class="form-group">
                <input type="file" name="candidate_pic" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" name="candidate_details" placeholder="Candidate Details" class="form-control" required />
            </div>
            <input type="submit" value="Add Candidate" name="addCandidatebtn" class="btn btn-success">
        </form>
    </div>
    <div class="col-8">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">ElectionName</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchingdata = mysqli_query($db, "SELECT * FROM candidate") or die(mysqli_error($db));
                $isanyCandidateAdded = mysqli_num_rows($fetchingdata);
                if ($isanyElectionAdded > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_array($fetchingdata))
                    {
                        $ElectionId = $row['ElectionID'];
                        $fetchingelectiondata= mysqli_query($db,"SELECT * FROM electiontable WHERE ElectionID = '". $ElectionId ."'") or die(mysqli_error($db));
                        $exeFetchingquery = mysqli_fetch_assoc($fetchingelectiondata);
                        $electionName = $exeFetchingquery['ElectionName'];
                        $candidate_photo = $row['CandidatePic'];

                        ?>
                        <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><img src="<?php echo $candidate_photo ?>" class="candidate_photo"/></td>
                            <td><?php echo $row['CandidateName'] ?></td>
                            <td><?php echo $row['CandidateDetails'] ?></td>
                            <td><?php echo $electionName ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">No any Candidate is added yet. </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST['addCandidatebtn'])) {
    $election_id = mysqli_real_escape_string($db, $_POST['election_id']);
    $candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
    $candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
    $inserted_by = $_SESSION['username'];
    $inserted_on = date("Y-m-d");

    // Photograph Logic Start  
    $targeted_folder = "../assets/images/candidate_photos/";
    $candidate_pic = $targeted_folder . rand(111111111,99999999999) . "_" . $_FILES['candidate_pic']['name'];
    $cand_temp_pic_name = $_FILES['candidate_pic']['tmp_name'];
    $candidate_pic_type = strtolower(pathinfo($candidate_pic, PATHINFO_EXTENSION));
    $allowed_type = array('jpg','png','jpeg');

    $image_size = $_FILES['candidate_photo']['size'];
    if($image_size < 20000000)
    {
        if(in_array($candidate_pic_type, $allowed_type))
        {
            if(move_uploaded_file($cand_temp_pic_name, $candidate_pic))
            {
                    //insert data into DB
                    mysqli_query($db, "INSERT INTO candidate(ElectionID,CandidateName,CandidateDetails,CandidatePic,inserted_by,inserted_on) VALUES('" . $election_Id . "', '" . $candidate_name . "', '" . $candidate_details . "', '" . $candidate_pic . "','" . $inserted_by . "', '" . $inserted_on . "')") or die(mysqli_error($db));
                    ?>
                    <script>location.assign("index.php?addCandidatePage=1&added=1")</script>
                    <?php
            }
            else
            {
                echo "<script>location.assign('index.php?addCandidatePage=1&failed=1')</script>";
            }
        }
        else{
            echo "<script>location.assign('index.php?addCandidatePage=1&largeFiles=1')</script>";
        }
    }
    else
    {
        echo "<script>location.assign('index.php?addCandidatePage=1&InvalidFile=1')</script>";
    }

}
?>