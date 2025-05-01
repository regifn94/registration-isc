<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    // Database connection
    $host = 'localhost';
    $dbname = 'conference_registration';
    $username = 'root';
    $password = '';
    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        echo '<div class="alert alert-danger" role="alert">Failed to connect to database: ' . $mysqli->connect_error . '</div>';
    } else {
        $sql = "SELECT * FROM presenters WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $presenter = $result->fetch_assoc();
            echo '<p><strong>Full Name:</strong> ' . htmlspecialchars($presenter['fullname']) . '</p>';
            echo '<p><strong>Title:</strong> ' . htmlspecialchars($presenter['title']) . '</p>';
            echo '<p><strong>Education Degrees:</strong> ' . htmlspecialchars($presenter['education_degrees']) . '</p>';
            echo '<p><strong>Gender:</strong> ' . htmlspecialchars($presenter['gender']) . '</p>';
            echo '<p><strong>Age:</strong> ' . htmlspecialchars($presenter['age']) . '</p>';
            echo '<p><strong>Shirt Size:</strong> ' . htmlspecialchars($presenter['shirt_size']) . '</p>';
            echo '<p><strong>Institution:</strong> ' . htmlspecialchars($presenter['institution_name']) . '</p>';
            echo '<p><strong>Country:</strong> ' . htmlspecialchars($presenter['country']) . '</p>';
            echo '<p><strong>Department:</strong> ' . htmlspecialchars($presenter['department']) . '</p>';
            echo '<p><strong>Job Title:</strong> ' . htmlspecialchars($presenter['job_title']) . '</p>';
            // ... tampilkan semua detail kolom lainnya ...
        } else {
            echo '<p class="text-warning">Presenter not found.</p>';
        }
        $stmt->close();
        $mysqli->close();
    }
} else {
    echo '<p class="text-danger">Invalid presenter ID.</p>';
}
?>