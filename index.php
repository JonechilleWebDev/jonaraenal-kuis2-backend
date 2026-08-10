<?php
require_once './classes/User.php';

$user = new User();

// Tambah data (jika form disubmit)
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($user->tambah($nama, $email, $password)) {
        echo "<p>Data berhasil ditambahkan!</p>";
    } else {
        echo "<p>Gagal menambahkan data.</p>";
    }
}

// Update data (jika input berubah data)
if (isset($_POST['ubah'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    if ($user->ubah($id, $nama, $email)) {
        echo "<p>Data berhasil diubah!</p>";
    } else {
        echo "<p>Gagal megubah data.</p>";
    }

    header("Location: index.php");
    exit;
}

// Hapus data (jika link hapus diklik)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    if ($user->hapus($id)) {
        echo "<p>Data berhasil dihapus!</p>";
    } else {
        echo "<p>Gagal menghapus data.</p>";
    }
    
    header("Location: index.php");
    exit;
}
?>
<h2>Tambah Pengguna</h2>
<form method="POST" action="">
    <input type="text" name="nama" placeholder="Nama" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="tambah">Tambah</button>
</form>

<hr>

<h2>Daftar Pengguna</h2>
<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>

    <?php
    $data = $user->bacaSemua();
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_assoc()) {
            echo "
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>
                    <a href='?edit={$row['id']}'>Edit</a>
                    <a href='?hapus={$row['id']}'>Hapus</a>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Belum ada data</td></tr>";
    }
    ?>
</table>

<hr>
<?php
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $editUser = $user->bacaOlehId($id);

    echo "<h2>Edit Pengguna</h2>
            <form method='POST'>
                <input type='hidden' name='id' value='{$editUser['id']}'>
                <input type='text' name='nama' value='{$editUser['nama']}' required><br><br>
                <input type='email' name='email' value='{$editUser['email']}' required><br><br>
                <button type='submit' name='ubah'>Simpan</button>
            </form>";
}
?>