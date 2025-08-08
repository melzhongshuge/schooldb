<?php
require 'config.php';

// Allows users to edit student records and update them in the database.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $course = $conn->real_escape_string($_POST['course']);
    $year_level = (int)$_POST['year_level'];
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "UPDATE students SET full_name='$full_name', dob='$dob', gender='$gender', course='$course', year_level=$year_level, contact_number='$contact_number', email='$email' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM students WHERE id=$id");
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <h2>Update Student Record</h2>

<form action="update.php" method="POST" onsubmit="return validateUpdateForm()">
    <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
    <label for="full_name">Full Name:</label>
    <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>" required>

    <label for="dob">Date of Birth:</label>
    <input type="date" name="dob" id="dob" value="<?php echo $student['dob']; ?>" required>

    <label for="gender">Gender:</label>
    <select name="gender" id="gender" required>
        <option value="Male" <?php echo $student['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo $student['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
        <option value="Other" <?php echo $student['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
    </select>

    <label for="course">Course or Program:</label>
    <input type="text" name="course" id="course" value="<?php echo htmlspecialchars($student['course']); ?>" required>

    <label for="year_level">Year Level:</label>
    <input type="number" name="year_level" id="year_level" min="1" max="4" value="<?php echo $student['year_level']; ?>" required>

    <label for="contact_number">Contact Number:</label>
    <input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($student['contact_number']); ?>" required>

    <label for="email">Email Address:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>

    <button type="submit">Update</button>
    <button type="reset">Reset</button>
</form>

<script>
    function validateUpdateForm() {
        return validateForm(); // Calls the same validation function form.html lol
    }
</script>

</body>
</html>
