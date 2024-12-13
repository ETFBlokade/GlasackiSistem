<?php
header("Content-Type: text/html");

include 'db_connection.php';

// Fetch vote counts
$result = $conn->query("SELECT vote_option, COUNT(*) as count FROM votes GROUP BY vote_option");

// Start building the HTML output
$output = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broj Glasova</title>
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
    </style>
</head>
<body>
    <h1>Broj Glasova</h1>
    <table>
        <tr>
            <th>Option</th>
            <th>Votes</th>
        </tr>';

// Add rows to the table for each vote count
while ($row = $result->fetch_assoc()) {
    $output .= '<tr>
        <td>' . htmlspecialchars($row['vote_option']) . '</td>
        <td>' . $row['count'] . '</td>
    </tr>';
}

$output .= '</table>
</body>
</html>';

echo $output;
?>
