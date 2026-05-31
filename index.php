<?php
require_once 'db.php';

// Proses hapus data
if (isset($_GET['delete'])) {
    $id  = intval($_GET['delete']);
    $sql = "DELETE FROM equipment WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=deleted");
        exit;
    } else {
        die("Error hapus data: " . mysqli_error($conn));
    }
}

// Ambil data
$sql    = "SELECT * FROM equipment ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error query: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Peralatan Industri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Data Peralatan Industri</h1>
    <a href="create.php" class="btn btn-add">+ Tambah Peralatan</a>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert success">Data berhasil dihapus.</div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
        <div class="alert success">Data berhasil ditambahkan.</div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
        <div class="alert success">Data berhasil diperbarui.</div>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Equipment</th>
            <th>Tipe</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Terakhir Maintenance</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['equipment_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td>
                        <span class="badge <?php echo $row['status']; ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($row['last_maintenance']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>"
                           class="btn btn-delete"
                           onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>