<?php
// Konfigurasi koneksi ke database
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

// Periksa apakah metode yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirimkan melalui formulir
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $ttl = $_POST['ttl'];
    $email = $_POST['email'];
    $puskesmas = $_POST['puskesmas'];

    // Lakukan validasi sederhana
    if (empty($username) || empty($nama_lengkap) || empty($ttl) || empty($email) || empty($puskesmas)) {
        // Jika ada yang kosong, kembalikan pesan kesalahan
        echo "Harap lengkapi semua field dalam formulir.";
    } else {
        // Menyiapkan nomor antrian
        $sql_count = "SELECT COUNT(*) as total FROM registrasi_antrian";
        $result_count = $conn->query($sql_count);
        $row = $result_count->fetch_assoc();
        $nomor_antrian = $row['total'] + 1;

        // Menyiapkan statement SQL untuk menyimpan data ke dalam database menggunakan prepared statement
        $sql = "INSERT INTO registrasi_antrian (username, nama_lengkap, ttl, email, nomor_antrian, puskesmas) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Persiapan pernyataan SQL gagal: " . $conn->error);
        }
        $stmt->bind_param("ssssis", $username, $nama_lengkap, $ttl, $email, $nomor_antrian, $puskesmas);

        // Eksekusi statement SQL
        if ($stmt->execute()) {
            echo "Registrasi berhasil! Nomor antrian Anda adalah: $nomor_antrian. Terima kasih telah mendaftar.";
            // Redirect ke halaman berhasil
            header("Location: registrasiberhasil.html");
            exit(); // Pastikan tidak ada output setelah header redirect
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    // Jika metode bukan POST, tampilkan pesan kesalahan
    echo "Metode tidak diizinkan.";
}

// Tutup koneksi ke database
$conn->close();
?>
