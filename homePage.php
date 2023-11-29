<div class="row my-3">
    
    <div class="col-12">
        <h3>Elections</h3>
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
                $fetchingdata = mysqli_query($db, "SELECT * FROM electiontable where Status = 'Expired'") or die(mysqli_error($db));
                $isanyElectionAdded = mysqli_num_rows($fetchingdata);
                if ($isanyElectionAdded > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_array($fetchingdata))
                    {
                        $election_Id = $row['ElectionID'];
                        ?>
                        <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><?php echo $row['ElectionName'] ?></td>
                            <td><?php echo $row['no_of_candidates'] ?></td>
                            <td><?php echo $row['StartingDate'] ?></td>
                            <td><?php echo $row['EndingDate'] ?></td>
                            <td><?php echo $row['Status'] ?></td>
                            <td>
                                <a href="index.php?viewResults=<?php echo $election_Id ?>" class="btn btn-sm btn-success">View Results</a>
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