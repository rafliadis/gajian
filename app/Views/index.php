<!DOCTYPE html>
<html>
<head>
    <title>Data Jabatan</title>
</head>
<body>
    <h1>Daftar Jabatan</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Jabatan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
        </tr>
        <?php foreach ($jabatan as $row): ?>
        <tr>
            <td><?= $row['id_jabatan']; ?></td>
            <td><?= $row['nama_jabatan']; ?></td>
            <td><?= $row['gaji_pokok']; ?></td>
            <td><?= $row['tunjangan']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>