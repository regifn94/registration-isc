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
    $stmt = null; // Initialize $stmt outside the try block
    $stmt_update = null; // Initialize $stmt_update outside the try block

    try {
        // Validate required fields
        $requiredFields = [
            'title', 'fullname', 'gender',
            'institution_name', 'country'
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

        // Prepare data
        // Personal Details
        $member_status = $mysqli->real_escape_string($memberStatus);
        $is_affiliated_member = $isMember ? 1 : 0;
        $title = $mysqli->real_escape_string(htmlspecialchars($_POST['title']));
        $fullname = $mysqli->real_escape_string(htmlspecialchars($_POST['fullname']));
        $education_degrees = $mysqli->real_escape_string(htmlspecialchars($_POST['education_degrees'] ?? ''));
        $gender = $mysqli->real_escape_string($_POST['gender']);
        $age = !empty($_POST['age']) ? (int)$_POST['age'] : null;
        $shirt_size = $mysqli->real_escape_string($_POST['shirt_size'] ?? '');

        // Affiliations Details
        $institution_name = $mysqli->real_escape_string(htmlspecialchars($_POST['institution_name']));
        $country = $mysqli->real_escape_string(htmlspecialchars($_POST['country']));
        $department = $mysqli->real_escape_string(htmlspecialchars($_POST['department'] ?? ''));
        $job_title = $mysqli->real_escape_string(htmlspecialchars($_POST['job_title'] ?? ''));


        // Paper Information
        $strand = $mysqli->real_escape_string(htmlspecialchars($_POST['strand']));
        $paper_code = $mysqli->real_escape_string(htmlspecialchars($_POST['paper_code']));
        $paper_title = $mysqli->real_escape_string(htmlspecialchars($_POST['paper_title']));

        // Travel and Accomodation
        $paper_title = $mysqli->real_escape_string(htmlspecialchars($_POST['paper_title']));
        $airport_pickup = $mysqli->real_escape_string(htmlspecialchars($_POST['airport_pickup']));
        $arrival_date = $mysqli->real_escape_string(htmlspecialchars($_POST['arrival_date']));
        $flight_number_arrival = $mysqli->real_escape_string(htmlspecialchars($_POST['flight_number_arrival']));
        $on_campus_checkin = $mysqli->real_escape_string(htmlspecialchars($_POST['on_campus_checkin']));
        $airport_dropoff = $mysqli->real_escape_string(htmlspecialchars($_POST['airport_dropoff']));
        $departure_date = $mysqli->real_escape_string(htmlspecialchars($_POST['departure_date']));
        $flight_number_departure = $mysqli->real_escape_string(htmlspecialchars($_POST['flight_number_departure']));
        $on_campus_checkout = $mysqli->real_escape_string(htmlspecialchars($_POST['on_campus_checkout']));
        $lodging = $mysqli->real_escape_string(htmlspecialchars($_POST['lodging']));
        $family_members = $mysqli->real_escape_string(htmlspecialchars($_POST['family_members']));

        // Registration Fee
        $registration_receipt = $mysqli->real_escape_string(htmlspecialchars($_POST['registration_receipt']));
        $reg_acc_name = $mysqli->real_escape_string(htmlspecialchars($_POST['reg_acc_name']));
        $reg_acc_number = $mysqli->real_escape_string(htmlspecialchars($_POST['reg_acc_number']));
        $reg_bank_name = $mysqli->real_escape_string(htmlspecialchars($_POST['reg_bank_name']));
        $reg_bank_address = $mysqli->real_escape_string(htmlspecialchars($_POST['reg_bank_address']));
        $reg_bank_swift_code = $mysqli->real_escape_string(htmlspecialchars($_POST['reg_bank_swift_code']));

        // Post Conference Tour
        $post_conference_tour = $mysqli->real_escape_string(htmlspecialchars($_POST['post_conference_tour']));
        $tour_acc_name = $mysqli->real_escape_string(htmlspecialchars($_POST['tour_acc_name']));
        $tour_acc_number = $mysqli->real_escape_string(htmlspecialchars($_POST['tour_acc_number']));
        $tour_bank_name = $mysqli->real_escape_string(htmlspecialchars($_POST['tour_bank_name']));
        $tour_bank_address = $mysqli->real_escape_string(htmlspecialchars($_POST['tour_bank_address']));
        $tour_receipt = $mysqli->real_escape_string(htmlspecialchars($_POST['tour_receipt']));

        $registration_fee_paid = $isMember ? 1 : 0;

        // Begin transaction (MySQLi doesn't have explicit beginTransaction/commit/rollback like PDO)
        $mysqli->autocommit(false);

        // Insert presenter data
        $stmt = $mysqli->prepare("INSERT INTO presenters (
            member_status, is_affiliated_member, title, fullname, education_degrees,
            gender, age, shirt_size, institution_name, country, department,
            job_title, registration_fee_paid
            /* Include other fields as needed */
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("sissssisssssi", $member_status, $is_affiliated_member, $title, $fullname, $education_degrees, $gender, $age, $shirt_size, $institution_name, $country, $department, $job_title, $registration_fee_paid);

            if (!$stmt->execute()) {
                throw new Exception("Failed to save registration data: " . $stmt->error);
            }

            $presenterId = $mysqli->insert_id;

            // Handle file uploads for non-members
            if (!$isMember && !empty($_FILES['registration_receipt']['name'])) {
                $receiptPath = uploadFileMySQLi($_FILES['registration_receipt'], $presenterId, 'registration', $mysqli);
                if (!$receiptPath) {
                    throw new Exception("Failed to upload payment receipt");
                }

                // Update registration fee status
                $stmt_update = $mysqli->prepare("UPDATE presenters SET registration_fee_paid = 1 WHERE id = ?");
                if ($stmt_update) {
                    $stmt_update->bind_param("i", $presenterId);
                    $stmt_update->execute();
                } else {
                    throw new Exception("Failed to prepare update statement: " . $mysqli->error);
                }
            }

            // Handle file upload for tour receipt (if applicable)
            if ($wants_tour && !empty($_FILES['tour_receipt']['name'])) {
                $tourReceiptPath = uploadFileMySQLi($_FILES['tour_receipt'], $presenterId, 'tour', $mysqli);
                if (!$tourReceiptPath) {
                    throw new Exception("Failed to upload tour payment receipt");
                }

                // Update tour receipt path in presenters table
                $stmt_tour_update = $mysqli->prepare("UPDATE presenters SET tour_fee_paid = 1 WHERE id = ?");
                if ($stmt_tour_update) {
                    $stmt_tour_update->bind_param("si", $tourReceiptPath, $presenterId);
                    $stmt_tour_update->execute();
                    $stmt_tour_update->close();
                } else {
                    throw new Exception("Failed to prepare tour update statement: " . $mysqli->error);
                }
            }



            // Commit transaction
            $mysqli->commit();

            // $response['success'] = true;
            // $response['message'] = 'Registration submitted successfully!';
            // $response['presenter_id'] = $presenterId;

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
        // Close statements if they were successfully prepared
        if ($stmt) {
            $stmt->close();
        }
        if ($stmt_update) {
            $stmt_update->close();
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

    // Create upload directory if needed
    $uploadDir = 'uploads/receipts/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = "receipt_{$presenterId}_" . time() . ".$extension";
    $targetPath = $uploadDir . $filename;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("Failed to save uploaded file");
    }

    // Save to database
    $stmt = $mysqli->prepare("INSERT INTO payment_receipts (presenter_id, receipt_type, file_path) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("iss", $presenterId, $type, $targetPath);
        $stmt->execute();
        $stmt->close();
        return $targetPath;
    } else {
        throw new Exception("Failed to prepare file upload statement: " . $mysqli->error);
    }
}
?>