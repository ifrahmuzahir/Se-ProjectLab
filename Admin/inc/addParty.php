<?php
if (isset($_GET["added"])) {
    ?>
    <div class="alert alert-success my-3" role="alert">
        Party has been added successfully!
    </div>
    <?php
}
else if(isset($_GET["delete_id"])) 
{
    $d_id = $_GET['delete_id'];
    $status = 0;
    mysqli_query($db,"UPDATE party SET Status = '". $status ."' WHERE PartyID = '". $d_id ."' ") or die(mysqli_error($db));

?>
    <div class="alert alert-danger my-3" role="alert">
        Party has been Deleted successfully!
    </div>
<?php
}
?>


<div class="row my-3">
    <div class="col-4">
        <h3>Add Party</h3>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="party_name" placeholder="Party Name" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" name="party_sign" placeholder="Party Sign" class="form-control"
                    required />
            </div>
           
            <input type="submit" value="Add Party" name="addPartybtn" class="btn btn-success">
        </form>
    </div>
    <div class="col-8">
        <h3>Party Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Party Name</th>
                    <th scope="col">Party Sign</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchingdata = mysqli_query($db, "SELECT * FROM party WHERE Status = 1") or die(mysqli_error($db));
                $isanyPartyAdded = mysqli_num_rows($fetchingdata);
                if ($isanyPartyAdded > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_array($fetchingdata))
                    {
                        $party_Id = $row['PartyID'];
                        ?>
                        <tr>
                            <td><?php echo $sno++ ?></td>
                            <td><?php echo $row['PartyName'] ?></td>
                            <td><?php echo $row['PartySign'] ?></td>
                            <td><?php echo $row['CreatedAt'] ?></td>
                            <td><?php echo $row['UpdatedAt'] ?></td>
                            <td><?php echo $row['Status'] ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $party_Id ;?>)">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">No any Party is added yet. </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const DeleteData = (p_id) =>
    {
        let c =confirm("Are you really want to Delete it?");
        if(c == true)
        {
            location.assign("index.php?addPartyPage=1&delete_id=" + p_id);
        }

    }
</script>

<?php
if (isset($_POST['addPartybtn'])) {
    $party_name = mysqli_real_escape_string($db, $_POST['party_name']);
    $party_sign = mysqli_real_escape_string($db, $_POST['party_sign']);
    $status = true;

    //insert data into DB
    mysqli_query($db, "INSERT INTO party(PartyName,PartySign,Status) VALUES('" . $party_name . "', '" . $party_sign . "', '" . $status . "')") or die(mysqli_error($db));
    ?>
    <script>location.assign("index.php?addPartyPage=1&added=1")</script>
    <?php

}
?>