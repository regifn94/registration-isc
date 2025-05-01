<?php
// Pastikan tidak ada output sebelum ini
header('Content-Type: application/json');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$dbname = 'conference_registration';
$username = 'root';
$password = '';

// Establish MySQLi connection
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($mysqli->connect_errno) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $mysqli->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    $stmt_presenter = null;
    $stmt_receipt = null;
    $stmt_tour_receipt = null;
    $stmt_update = null;
    $stmt_tour_update = null;

    try {
        // Validate required fields
        $requiredFields = [
            'title', 'fullname', 'gender',
            'institution_name', 'country',
            'strand', 'paper_code', 'paper_title'
        ];

        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Required field '$field' is missing");
            }
        }

        // Determine if institution is a member
        $memberInstitutions = [
            'Adventist International Institute of Advanced Studies',
            'Adventist University of the Philippines',
            'Asia-Pacific International University',
            'Universitas Advent Indonesia'
        ];

        $isMember = in_array($_POST['institution_name'], $memberInstitutions);
        $memberStatus = $isMember ? 'member' : 'non_member';
        $wants_tour = isset($_POST['post_conference_tour']) && $_POST['post_conference_tour'] === 'yes' ? 1 : 0;

        // Prepare data for presenters table
        $member_status = $mysqli->real_escape_string($memberStatus);
        $is_affiliated_member = $isMember ? 1 : 0;
        $title = $mysqli->real_escape_string(htmlspecialchars($_POST['title']));
        $fullname = $mysqli->real_escape_string(htmlspecialchars($_POST['fullname']));
        $education_degrees = $mysqli->real_escape_string(htmlspecialchars($_POST['education_degrees'] ?? ''));
        $gender = $mysqli->real_escape_string($_POST['gender']);
        $age = !empty($_POST['age']) ? (int)$_POST['age'] : null;
        $shirt_size = $mysqli->real_escape_string($_POST['shirt_size'] ?? '');
        $institution_name = $mysqli->real_escape_string(htmlspecialchars($_POST['institution_name']));
        $country = $mysqli->real_escape_string(htmlspecialchars($_POST['country']));
        $department = $mysqli->real_escape_string(htmlspecialchars($_POST['department'] ?? ''));
        $job_title = $mysqli->real_escape_string(htmlspecialchars($_POST['job_title'] ?? ''));
        $strand = $mysqli->real_escape_string(htmlspecialchars($_POST['strand']));
        $paper_code = $mysqli->real_escape_string(htmlspecialchars($_POST['paper_code']));
        $paper_title = $mysqli->real_escape_string(htmlspecialchars($_POST['paper_title']));
        $airport_pickup = $mysqli->real_escape_string(htmlspecialchars($_POST['airport_pickup'] ?? 'no'));
        $arrival_date = !empty($_POST['arrival_date']) ? $mysqli->real_escape_string(htmlspecialchars($_POST['arrival_date'])) : null;
        $flight_number_arrival = $mysqli->real_escape_string(htmlspecialchars($_POST['flight_number_arrival'] ?? ''));
        $on_campus_checkin = !empty($_POST['on_campus_checkin']) ? $mysqli->real_escape_string(htmlspecialchars($_POST['on_campus_checkin'])) : null;
        $airport_dropoff = $mysqli->real_escape_string(htmlspecialchars($_POST['airport_dropoff'] ?? 'no'));
        $departure_date = !empty($_POST['departure_date']) ? $mysqli->real_escape_string(htmlspecialchars($_POST['departure_date'])) : null;
        $flight_number_departure = $mysqli->real_escape_string(htmlspecialchars($_POST['flight_number_departure'] ?? ''));
        $on_campus_checkout = !empty($_POST['on_campus_checkout']) ? $mysqli->real_escape_string(htmlspecialchars($_POST['on_campus_checkout'])) : null;
        $lodging = $mysqli->real_escape_string(htmlspecialchars($_POST['lodging'] ?? ''));
        $family_members = !empty($_POST['family_members']) ? (int)$_POST['family_members'] : 0;
        $registration_fee_paid = $isMember ? 1 : 0;

        // Begin transaction
        $mysqli->autocommit(false);

        // Insert presenter data
        $stmt_presenter = $mysqli->prepare("INSERT INTO tbl_presenters (
            member_status, is_affiliated_member, title, fullname, education_degrees,
            gender, age, shirt_size, institution_name, country, department,
            job_title, strand, paper_code, paper_title, airport_pickup,
            arrival_date, flight_number_arrival, on_campus_checkin, airport_dropoff,
            departure_date, flight_number_departure, on_campus_checkout, lodging,
            family_members, registration_fee_paid
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt_presenter) {
            $stmt_presenter->bind_param("sissssisssssssssssssssssss",
                $member_status, $is_affiliated_member, $title, $fullname, $education_degrees,
                $gender, $age, $shirt_size, $institution_name, $country, $department,
                $job_title, $strand, $paper_code, $paper_title, $airport_pickup,
                $arrival_date, $flight_number_arrival, $on_campus_checkin, $airport_dropoff,
                $departure_date, $flight_number_departure, $on_campus_checkout, $lodging,
                $family_members, $registration_fee_paid
            );

            if (!$stmt_presenter->execute()) {
                throw new Exception("Failed to save registration data: " . $stmt_presenter->error);
            }

            $presenterId = $mysqli->insert_id;
            $tourReceiptPath = null;

            // Handle file uploads for non-members (registration receipt)
            if (!$isMember && !empty($_FILES['registration_receipt']['name'])) {
                $receiptPath = uploadFileMySQLi($_FILES['registration_receipt'], $presenterId, 'registration', $mysqli);
                if (!$receiptPath) {
                    throw new Exception("Failed to upload payment receipt");
                }
                // Save registration receipt path to payment_receipts table
                $stmt_receipt = $mysqli->prepare("INSERT INTO tbl_payment_receipts_presenter (presenter_id, receipt_type, file_path) VALUES (?, ?, ?)");
                if ($stmt_receipt) {
                    $typeOfReceipt = "registration";
                    $stmt_receipt->bind_param("iss", $presenterId, $typeOfReceipt, $receiptPath);
                    if (!$stmt_receipt->execute()) {
                        throw new Exception("Failed to save registration receipt path: " . $stmt_receipt->error);
                    }
                    $stmt_receipt->close();
                    $stmt_receipt = null;
                    // Update registration fee status in presenters table
                    $stmt_update = $mysqli->prepare("UPDATE tbl_presenters SET registration_fee_paid = 1 WHERE id = ?");
                    if ($stmt_update) {
                        $stmt_update->bind_param("i", $presenterId);
                        $stmt_update->execute();
                        $stmt_update->close();
                        $stmt_update = null;
                    } else {
                        throw new Exception("Failed to prepare update statement: " . $mysqli->error);
                    }
                } else {
                    throw new Exception("Failed to prepare receipt insert statement: " . $mysqli->error);
                }
            }

            // Handle file upload for tour receipt (if applicable)
            if ($wants_tour && !empty($_FILES['tour_receipt']['name'])) {
                $tourReceiptPath = uploadFileMySQLi($_FILES['tour_receipt'], $presenterId, 'tour', $mysqli);
                if (!$tourReceiptPath) {
                    throw new Exception("Failed to upload tour payment receipt");
                }
                // Save tour receipt path to payment_receipts table
                $stmt_tour_receipt = $mysqli->prepare("INSERT INTO tbl_payment_receipts_presenter (presenter_id, receipt_type, file_path) VALUES (?, ?, ?)");
                if ($stmt_tour_receipt) {
                    $typeOfReceipt = "tour";
                    $stmt_tour_receipt->bind_param("iss", $presenterId, $typeOfReceipt, $tourReceiptPath);
                    if (!$stmt_tour_receipt->execute()) {
                        throw new Exception("Failed to save tour receipt path: " . $stmt_tour_receipt->error);
                    }
                    $stmt_tour_receipt->close();
                    $stmt_tour_receipt = null;
                    // Update tour_receipt_path in presenters table
                    $stmt_tour_update = $mysqli->prepare("UPDATE tbl_presenters SET tour_receipt_path = ? WHERE id = ?");
                    if ($stmt_tour_update) {
                        $stmt_tour_update->bind_param("si", $tourReceiptPath, $presenterId);
                        $stmt_tour_update->execute();
                        $stmt_tour_update->close();
                        $stmt_tour_update = null;
                    } else {
                        throw new Exception("Failed to prepare tour update statement: " . $mysqli->error);
                    }
                } else {
                    throw new Exception("Failed to prepare tour receipt insert statement: " . $mysqli->error);
                }
            }

            // Commit transaction
            $mysqli->commit();

            header("Location: presenter_list.php?registration_status=success&message=" . urlencode("Pendaftaran berhasil!"));
            exit();

        } else {
            throw new Exception("Failed to prepare insert statement: " . $mysqli->error);
        }

    } catch (Exception $e) {
        $mysqli->rollback();
        $response['message'] = 'Registration failed: ' . $e->getMessage();
        error_log("Registration Error: " . $e->getMessage());
    } finally {
        if ($stmt_presenter) {
            $stmt_presenter->close();
        }
        if ($stmt_receipt) {
            $stmt_receipt->close();
        }
        if ($stmt_tour_receipt) {
            $stmt_tour_receipt->close();
        }
        if ($stmt_update) {
            $stmt_update->close();
        }
        if ($stmt_tour_update) {
            $stmt_tour_update->close();
        }
        $mysqli->close();
    }

    echo json_encode($response);
    exit;
}

function uploadFileMySQLi($file, $presenterId, $type, $mysqli) {
    // Validate file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload error: " . $file['error']);
    }

    // Validate file type
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedTypes)) {
        throw new Exception("Invalid file type. Only PDF, JPEG, and PNG are allowed.");
    }

    // Validate file size (2MB max)
    if ($file['size'] > 2097152) {
        throw new Exception("File too large. Maximum size is 2MB.");
    }

    // Create upload directory based on type
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $subDir = $uploadDir . ($type === 'registration' ? 'receipts/' : 'tour_receipts/');
    if (!file_exists($subDir)) {
        mkdir($subDir, 0755, true);
    }

    // Generate unique filename based on type
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = ($type === 'registration' ? "receipt_{$presenterId}_" : "tour_receipt_{$presenterId}_") . time() . ".$extension";
    $targetPath = $subDir . $filename;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("Failed to save uploaded file");
    }

    return $targetPath;
}
?>