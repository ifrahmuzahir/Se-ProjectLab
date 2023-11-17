<div class="row my-3">
    <div class="col-4">
        <h3>Add Election</h3>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="election_topic" placeholder="Election Topic" class="form-control"required />
            </div>
            <div class="form-group">
                <input type="number" name="number_of_candidate" placeholder="No. of Candidate" class="form-control"required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type = 'Date'" name="starting_date" placeholder="Starting Date" class="form-control"required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type = 'Date'" name="ending_date" placeholder="Ending Date" class="form-control"required />
            </div>
            <input type="submit" value="Add Election" name="addELectionbtn" class="btn btn-success">
        </form>
    </div>
    <div class="col-8">
        <h3>Upcoming Election</h3>
    </div>
</div>