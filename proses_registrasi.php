<?php
// Ambil data dari formulir
$username = $_POST['username'];
$nama_lengkap = $_POST['nama_lengkap'];
$nik = $_POST['nik'];
$ttl = $_POST['ttl'];
$email = $_POST['email'];
$password = $_POST['password'];

// Buat koneksi ke database
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "databaselogin";

// Buat koneksi
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat query untuk menyimpan data ke database
$sql = "INSERT INTO anggota (username, nama_lengkap, nik, ttl, email, password) 
        VALUES ('$username', '$nama_lengkap', '$nik', '$ttl', '$email', '$password')";

// Jalankan query
if ($conn->query($sql) === TRUE) {
    // Setelah pendaftaran berhasil, arahkan pengguna ke halaman index.html
    echo "<script>alert('Registrasi berhasil!');</script>";
    header("Location: registrasiberhasil.html");
    exit(); // Penting untuk keluar dari skrip PHP setelah melakukan pengalihan header
} else {
    // Jika terjadi kesalahan, arahkan kembali ke halaman form registrasi
    echo "<script>alert('Registrasi Gagal!');</script>";
    header("Location: register_failed.html?reason=Username%20sudah%20digunakan");
    exit();
}

// Tutup koneksi ke database
$conn->close();
?>
