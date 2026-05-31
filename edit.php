<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = $_POST['equipment_name'];
    $type   = $_POST['type'];
    $loc    = $_POST['location'];
    $status = $_POST['status'];
    $maint  = $_POST['last_maintenance'];

    // Prepared statement untuk UPDATE
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE equipment
         SET equipment_name=?, type=?, location=?, status=?, last_maintenance=?
         WHERE id=?"
    );
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sssssi", $name, $type, $loc, $status, $maint, $id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php?msg=updated");
        exit;
    } else {
        die("Execute failed: " . mysqli_stmt_error($stmt));
    }
}

// Ambil data lama
$sql    = "SELECT * FROM equipment WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    die("Data tidak ditemukan.");
}
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Peralatan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Peralatan</h1>
    <form method="POST" action="">
        <label>Nama Equipment</label>
        <input type="text" name="equipment_name"
               value="<?php echo htmlspecialchars($data['equipment_name']); ?>" required>

        <label>Tipe</label>
        <input type="text" name="type"
               value="<?php echo htmlspecialchars($data['type']); ?>" required>

        <label>Lokasi</label>
        <input type="text" name="location"
               value="<?php echo htmlspecialchars($data['location']); ?>" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Operasional" <?php if($data['status']=='Operasional') echo 'selected'; ?>>Operasional</option>
            <option value="Maintenance" <?php if($data['status']=='Maintenance') echo 'selected'; ?>>Maintenance</option>
            <option value="Standby"     <?php if($data['status']=='Standby') echo 'selected'; ?>>Standby</option>
            <option value="Rusak"       <?php if($data['status']=='Rusak') echo 'selected'; ?>>Rusak</option>
        </select>

        <label>Terakhir Maintenance</label>
        <input type="date" name="last_maintenance"
               value="<?php echo htmlspecialchars($data['last_maintenance']); ?>" required>

        <button type="submit" class="btn btn-add">Update</button>
        <a href="index.php" class="btn btn-cancel">Batal</a>
    </form>
</div>
</body>
</html>