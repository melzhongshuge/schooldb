<?php
require 'config.php';

$courseFilter = isset($_GET['course']) ? $conn->real_escape_string($_GET['course']) : '';
$yearFilter    = isset($_GET['year_level'])    ? (int)$_GET['year_level']                     : 0;

$conditions = [];
if ($courseFilter) $conditions[] = "course = '$courseFilter'";
if ($yearFilter)    $conditions[] = "year_level = $yearFilter";

$whereSQL = $conditions ? "WHERE " . implode(' AND ', $conditions) : "";

$sql = "SELECT * FROM students $whereSQL ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Admissions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Admissions Records</h2>

    <form method="get">
        <input type="text" name="course" placeholder="Filter by course" value="<?php echo $courseFilter; ?>">
        <input type="number" name="year_level" placeholder="Filter by year_level" value="<?php echo $yearFilter; ?>">
        <button type="submit">Filter</button>
        <a href="display.php">Reset</a>
    </form>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>DOB</th><th>Gender</th>
            <th>Course</th><th>Year Level</th><th>Contact Number</th><th>Email</th><th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo $row['dob']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo htmlspecialchars($row['course']); ?></td>
            <td><?php echo $row['year_level']; ?></td>
            <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Delete this record?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php
    $agg = $conn->query("
        SELECT course, COUNT(*) AS total
        FROM students
        GROUP BY course
    ");
    if ($agg->num_rows):
    ?>
    <h3>Enrollment Summary by Course</h3>
    <table>
        <tr><th>course</th><th>Total Students</th></tr>
        <?php while ($r = $agg->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($r['course']); ?></td>
            <td><?php echo $r['total']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php endif; ?>

    <p><a href="form.html">Add New Student</a></p>
</body>
</html>
