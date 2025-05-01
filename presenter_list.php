<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presenter List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .alert {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0d6efd;
            color: white;
        }
        .action-buttons a {
            margin-right: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Presenter List</h1>

        <?php
        // Tampilkan pesan status pendaftaran jika ada
        if (isset($_GET['registration_status']) && isset($_GET['message'])) {
            $status = $_GET['registration_status'];
            $message = urldecode($_GET['message']);
            $alertClass = $status === 'success' ? 'alert-success' : 'alert-danger';
            echo '<div class="alert ' . $alertClass . '" role="alert">' . $message . '</div>';
        }
        if (isset($_GET['delete_status']) && isset($_GET['message'])) {
            $status = $_GET['delete_status'];
            $message = urldecode($_GET['message']);
            $alertClass = $status === 'success' ? 'alert-success' : 'alert-danger';
            echo '<div class="alert ' . $alertClass . '" role="alert">' . $message . '</div>';
        }
        ?>

        <h2>Registered Presenters</h2>
        <?php
        // Database configuration
        $host = 'localhost';
        $dbname = 'conference_registration';
        $username = 'root';
        $password = '';

        // Establish MySQLi connection
        $mysqli = new mysqli($host, $username, $password, $dbname);

        // Check for connection errors
        if ($mysqli->connect_errno) {
            echo '<div class="alert alert-danger" role="alert">Failed to connect to database: ' . $mysqli->connect_error . '</div>';
        } else {
            $sql = "SELECT id, fullname, title, institution_name, country FROM presenters";
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Full Name</th>';
                echo '<th>Title</th>';
                echo '<th>Institution</th>';
                echo '<th>Country</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['fullname']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['institution_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['country']) . '</td>';
                    echo '<td class="action-buttons">';
                    echo '<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" data-presenter-id="' . $row['id'] . '">Detail</button>';
                    echo '<a href="presenter_delete.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this presenter?\');">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No presenters registered yet.</p>';
            }
            $result->free();
            $mysqli->close();
        }
        ?>

        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Presenter Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="presenterDetails">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const detailModal = document.getElementById('detailModal');
        detailModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const presenterId = button.getAttribute('data-presenter-id');
            const modalBody = document.getElementById('presenterDetails');

            // Fetch presenter details using AJAX
            fetch(`presenter_detail.php?id=${presenterId}`)
                .then(response => response.text())
                .then(data => {
                    modalBody.innerHTML = data;
                })
                .catch(error => {
                    modalBody.innerHTML = '<p class="text-danger">Failed to load presenter details.</p>';
                    console.error('Error fetching details:', error);
                });
        });
    </script>
</body>
</html>