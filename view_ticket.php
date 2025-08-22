<?php
require("conn.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Ticket ID is required.");
}

$sql = "SELECT * FROM contact WHERE id = $id";
$result = $conn->query($sql);
$ticket = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save reply to the contact table
    $reply = $_POST['reply'];
    $updateSql = "UPDATE contact SET reply = '$reply' WHERE id = $id";
    $conn->query($updateSql);
    header("Location: support_tickets.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .card {
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #34495e;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1abc9c;
        }

        .btn-secondary {
            background-color: #95a5a6;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="support_tickets.php" class="btn btn-secondary mb-4">&larr; Back</a>
        <h1>Ticket Details</h1>
        <div class="card">
            <p><strong>Name:</strong> <?php echo $ticket['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $ticket['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $ticket['phone']; ?></p>
            <p><strong>Subject:</strong> <?php echo $ticket['subject']; ?></p>
            <p><strong>Message:</strong> <?php echo $ticket['message']; ?></p>
            <p><strong>Reply:</strong> <?php echo $ticket['reply'] ?: "No reply yet."; ?></p>

            <!-- Reply Button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal">Reply</button>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reply" class="form-label">Your Reply</label>
                        <textarea class="form-control" id="reply" name="reply" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
