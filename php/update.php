<?php
include 'connect.php';

// Fetch member details for updating
$member_id = $_GET['updateid'];
$sql = "SELECT * FROM member WHERE member_id='$member_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Initialize variables with fetched data
$old_member_id = $row['member_id'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$birthday = $row['birthday'];
$email = $row['email'];

if(isset($_POST['submit'])){
    // Sanitize and validate input data
    $new_member_id = mysqli_real_escape_string($con, $_POST['new_member_id']);
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $birthday = mysqli_real_escape_string($con, $_POST['birthday']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    if (empty($new_member_id) || empty($first_name) || empty($last_name) || empty($birthday) || empty($email)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Check if the new member ID is already taken
    if ($new_member_id !== $old_member_id) {
        $check_sql = "SELECT COUNT(*) AS count FROM member WHERE member_id='$new_member_id'";
        $check_result = mysqli_query($con, $check_sql);
        $check_row = mysqli_fetch_assoc($check_result);
        if ($check_row['count'] > 0) {
            echo "Member ID already exists!";
            exit();
        }
    }

    // Update member record
    $sql = "UPDATE member SET member_id='$new_member_id', first_name='$first_name', last_name='$last_name', birthday='$birthday', email='$email' WHERE member_id='$old_member_id'";
    $result = mysqli_query($con, $sql);

    if ($result){
        header('location:index.php');
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Member</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <div class="card my-5 p-5">
        <div class="card-body">
            <div class="card-header mb-5 pt-3">
                <h2 class="text-center">Update Member Details</h2>
            </div>
            <form method="post">
                <div class="form-group">
                    <label for="new_member_id">Member ID</label>
                    <input type="text" class="form-control" id="new_member_id" name="new_member_id" placeholder="Enter member ID" value="<?php echo $old_member_id; ?>">
                </div>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo $first_name; ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="<?php echo $last_name; ?>">
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $birthday; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $email; ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Cancel</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
