<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id']; // Get the ID from the URL parameter
    $qry = $conn->query("SELECT * FROM users WHERE id = $id"); // Query to fetch user data based on the ID
    $row = $qry->fetch_assoc(); // Fetch the row as an associative array
    if($row) {
        // Extract the values from the row
        extract($row);
?>
<style type="text/css">
    .avatar {
        max-width: calc(100%);
        max-height: 27vh;
        align-items: center;
        justify-content: center;
        padding: 5px;
    }
    .avatar img {
        max-width: calc(100%);
        max-height: 27vh;
    }
    p {
        margin: unset;
    }
    #uni_modal .modal-footer {
        display: none
    }
    #uni_modal .modal-footer.display {
        display: block
    }
</style>
<div class="container-field">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-6">
                <p>Name: <b><?php echo ucwords($row['firstname'].' '.$row['lastname']); ?></b></p>
                <p>Email: <b><?php echo $row['email']; ?></b></p>
                <p>Contact: <b><?php echo $row['contact']; ?></b></p>
                <p>Address: <b><?php echo $row['address']; ?></b></p>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer display">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<?php
    } else {
        echo "User not found"; // Display message if user with the provided ID is not found
    }
}
?>
