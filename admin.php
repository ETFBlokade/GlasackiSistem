<?php


// CHANGE PASSWORD HERE
$valid_username = 'admin'; // Set your desired username
$valid_password = 'admin'; // Set your desired password

// Check if the user has entered the correct credentials
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $valid_username || $_SERVER['PHP_AUTH_PW'] != $valid_password) {
    // If not, ask for credentials
    header('HTTP/1.0 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Restricted"');
    echo 'Access denied. Please provide a valid username and password.';
    exit;
}


if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die("Access denied: You are not allowed to access this page.");
}

include 'db_connection.php';

// Handle reset votes request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_votes'])) {
    // Reset the votes in the database
    $conn->query("DELETE FROM votes");

    // Clear the 'voted' cookie so users can vote again
    setcookie('voted', '', time() - 3600, '/'); // Expire the cookie

    echo "<script>alert('Svi glasovi su resetovani! Sada možete ponovo glasati.');</script>";
}

// Handle update options request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_options'])) {
    $new_options = $_POST['options']; // Get the new options from the form
    $options_str = implode(",", $new_options); // Convert options to a string for storage

    // Update the options in the settings table
    $conn->query("UPDATE settings SET options = '$options_str' WHERE id = 1");
    echo "<script>alert('Opcije glasanja su ažurirane!');</script>";
}

// Fetch current vote options
$result = $conn->query("SELECT options FROM settings WHERE id = 1");
$row = $result->fetch_assoc();
$options = explode(",", $row['options']); // Convert options string back to an array

// Fetch vote counts for display
$vote_counts = $conn->query("SELECT vote_option, COUNT(*) as count FROM votes GROUP BY vote_option");

?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin tabla</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 50%;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        button {
            margin: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #f44336;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #d32f2f;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 14px;
            width: 70%;
            margin: 10px;
        }
    </style>
</head>
<body>
    <h1>Admin tabla</h1>
    
    <!-- Forma za ažuriranje opcija glasanja -->
    <h2>Izmeni opcije glasanja</h2>
    <form method="POST">
        <label for="options">Unesi opcije, odvojene zapetama(da,ne,uzdržan):</label><br>
        <input type="text" name="options[]" value="<?= implode(",", $options) ?>" placeholder="Opcija 1, Opcija 2, Opcija 3" required><br>
        <button type="submit" name="update_options">Ažuriraj opcije</button>
    </form>

    <h2>Broj glasova</h2>
    <table>
        <tr>
            <th>Opcija</th>
            <th>Glasovi</th>
        </tr>
        <?php while ($row = $vote_counts->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['vote_option']) ?></td>
            <td><?= $row['count'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <!-- Dugme za resetovanje glasova -->
    <form method="POST">
        <button type="submit" name="reset_votes">Resetuj glasove</button>
    </form>
</body>
</html>
