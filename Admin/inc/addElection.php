<?php
if (isset($_GET["added"])) {
    ?>
    <div class="alert alert-success my-3" role="alert">
        Election has been added successfully!
    </div>
    <?php
}
?>


<div class="row my-3">
    <div class="col-4">
        <h3>Add Election</h3>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="election_topic" placeholder="Election Topic" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="number" name="number_of_candidate" placeholder="No. of Candidate" class="form-control"
                    required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type = 'Date'" name="starting_date" placeholder="Starting Date"
                    class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type = 'Date'" name="ending_date" placeholder="Ending Date"
                    class="form-control" required />
            </div>
            <input type="submit" value="Add Election" name="addELectionbtn" class="btn btn-success">
        </form>
    </div>
    <div class="col-8">
        <h3>Upcoming Election</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Election Name</th>
                    <th scope="col"># Candidates</th>
                    <th scope="col">Starting Date</th>
                    <th scope="col">Ending Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchingdata = mysqli_query($db, "SELECT * FROM electiontable WHERE StartingDate >= CURDATE()") or die(mysqli_error($db));
                $isanyElectionAdded = mysqli_num_rows($fetchingdata);
                if ($isanyElectionAdded > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_array($fetchingdata))
                    {

                        ?>
                        <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><?php echo $row['ElectionName'] ?></td>
                            <td><?php echo $row['no_of_candidates'] ?></td>
                            <td><?php echo $row['StartingDate'] ?></td>
                            <td><?php echo $row['EndingDate'] ?></td>
                            <td><?php echo $row['Status'] ?></td>
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
                        <td colspan="7">No any Election is added yet. </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST['addELectionbtn'])) {
    $election_topic = mysqli_real_escape_string($db, $_POST['election_topic']);
    $number_of_candidate = mysqli_real_escape_string($db, $_POST['number_of_candidate']);
    $starting_date = mysqli_real_escape_string($db, $_POST['starting_date']);
    $ending_date = mysqli_real_escape_string($db, $_POST['ending_date']);
    $inserted_by = $_SESSION['username'];
    $inserted_on = date("Y-m-d");

    $date1 = date_create($inserted_on);
    $date2 = date_create($starting_date);
    $diff = date_diff($date1, $date2);

    if ($diff->format("%R%a") > 0) {
        $status = "Inactive";
    } else {
        $status = "Active";
    }

    //insert data into DB
    mysqli_query($db, "INSERT INTO electiontable(ElectionName,no_of_candidates,StartingDate,EndingDate,Status,inserted_by,inserted_on) VALUES('" . $election_topic . "', '" . $number_of_candidate . "', '" . $starting_date . "', '" . $ending_date . "', '" . $status . "', '" . $inserted_by . "', '" . $inserted_on . "')") or die(mysqli_error($db));
    ?>
    <script>location.assign("index.php?addElectionPage=1&added=1")</script>
    <?php

}
?>