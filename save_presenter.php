<?php
include 'config.php';

$upload_dir = "uploads/";
$filename = null;
$is_member = false;



// Cek apakah ada file yang diupload
if (isset($_FILES["payment_receipt"]) && $_FILES["payment_receipt"]["error"] === UPLOAD_ERR_OK) {
    $filename = basename($_FILES["payment_receipt"]["name"]);
    $tmp_name = $_FILES["payment_receipt"]["tmp_name"];

    // Buat folder jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $target_file = $upload_dir . $filename;

    // Validasi ekstensi file (opsional tapi disarankan)
    $allowed_ext = ['pdf', 'jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) {
        die("File harus berupa PDF, JPG, JPEG, atau PNG.");
    }

    move_uploaded_file($tmp_name, $target_file);
}

$member_institutions = [
    "Adventist International Institute of Advanced Studies",
    "Adventist University of the Philippines",
    "Asia-Pacific International University",
    "Universitas Advent Indonesia"
];

$institution_name = $_POST['institution_name'];
$is_member = in_array($institution_name, $member_institutions) ? 1 : 0;

// SQL Insert
$sql = "INSERT INTO tbl_presenters (
    title, fullname, education_degrees, gender, age, shirt_size,
    institution_name, country, department, job_title,
    strand, code, paper_title,
    pickup_airport, arrival_info, pickup_schedule, checkin_info,
    dropoff_airport, departure_info, checkout_info, lodge_type,
    family_member_names, join_tour, tour_price_details,
    account_name, account_number, bank_number, bank_address,
    swift_code, routing_number, beneficiary_address,
    payment_receipt, is_member
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Cek jika prepare gagal
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssissssssssssssssssssssssssssss",
    $_POST['title'], 
    $_POST['fullname'], 
    $_POST['education_degrees'], 
    $_POST['gender'],
    $_POST['age'], 
    $_POST['shirt_size'], 
    $_POST['institution_name'], 
    $_POST['country'],
    $_POST['department'], 
    $_POST['job_title'], 
    $_POST['strand'], 
    $_POST['code'],
    $_POST['paper_title'], 
    $_POST['pickup_airport'], 
    $_POST['arrival_info'], 
    $_POST['pickup_schedule'],
    $_POST['checkin_info'], 
    $_POST['dropoff_airport'], 
    $_POST['departure_info'], 
    $_POST['checkout_info'],
    $_POST['lodge_type'], 
    $_POST['family_member_names'], 
    $_POST['join_tour'], 
    $_POST['tour_price_details'],
    $_POST['account_name'], 
    $_POST['account_number'], 
    $_POST['bank_number'], 
    $_POST['bank_address'],
    $_POST['swift_code'], 
    $_POST['routing_number'], 
    $_POST['beneficiary_address'],
    $filename,
    $_POST['is_member']
);

if ($stmt->execute()) {
    echo "Data presenter berhasil disimpan.";
} else {
    echo "Gagal menyimpan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
