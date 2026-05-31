<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = $_POST['equipment_name'];
    $type   = $_POST['type'];
    $loc    = $_POST['location'];
    $status = $_POST['status'];
    $maint  = $_POST['last_maintenance'];

    // Prepared statement untuk INSERT
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO equipment (equipment_name, type, location, status, last_maintenance)
         VALUES (?, ?, ?, ?, ?)"
    );
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sssss", $name, $type, $loc, $status, $maint);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php?msg=added");
        exit;
    } else {
        die("Execute failed: " . mysqli_stmt_error($stmt));
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peralatan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Tambah Peralatan Baru</h1>
    <form method="POST" action="">
        <label>Nama Equipment</label>
        <input type="text" name="equipment_name" required>

        <label>Tipe</label>
        <input type="text" name="type" required>

        <label>Lokasi</label>
        <input type="text" name="location" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Operasional">Operasional</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Standby">Standby</option>
            <option value="Rusak">Rusak</option>
        </select>

        <label>Terakhir Maintenance</label>
        <input type="date" name="last_maintenance" required>

        <button type="submit" class="btn btn-add">Simpan</button>
        <a href="index.php" class="btn btn-cancel">Batal</a>
    </form>
</div>
</body>
</html>