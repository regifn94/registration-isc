<?php

// Aktifkan error reporting untuk pengembangan
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Mengakses nilai dari input teks "fullname"
$namaLengkap = $_POST['fullname'];
echo "Nama Lengkap: " . $namaLengkap . "<br>";

// Mengakses nilai dari radio button "gender"
$jenisKelamin = $_POST['gender'];
echo "Jenis Kelamin: " . $jenisKelamin . "<br>";

// Mengakses nilai dari dropdown "title"
$gelar = $_POST['title'];
echo "Gelar: " . $gelar . "<br>";

// Mengakses nilai dari file upload "registration_receipt"
if (isset($_FILES['registration_receipt'])) {
    echo "Nama File Resi Pendaftaran: " . $_FILES['registration_receipt']['name'] . "<br>";
    echo "Tipe File Resi Pendaftaran: " . $_FILES['registration_receipt']['type'] . "<br>";
    echo "Temporary Path File Resi Pendaftaran: " . $_FILES['registration_receipt']['tmp_name'] . "<br>";
    echo "Ukuran File Resi Pendaftaran: " . $_FILES['registration_receipt']['size'] . "<br>";
    echo "Error File Resi Pendaftaran: " . $_FILES['registration_receipt']['error'] . "<br>";
}

// ... dan seterusnya untuk field-field lainnya

?>