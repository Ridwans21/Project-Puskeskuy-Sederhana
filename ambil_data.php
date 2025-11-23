<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "databaselogin"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mengambil data dari tabel registrasi_antrian
$sql = "SELECT * FROM registrasi_antrian";
$result = $conn->query($sql);

// Membuat array untuk menampung data
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Mengembalikan data dalam format JSON
echo json_encode($data);

// Menutup koneksi ke database
$conn->close();
?>
