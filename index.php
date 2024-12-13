<?php
// Connect to the database
include 'db_connection.php';

// Fetch the voting options
$result = $conn->query("SELECT options FROM settings WHERE id = 1");
$row = $result->fetch_assoc();
$options = explode(",", $row['options']); // Convert options to an array
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #333;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #4CAF50;
        }
        .voting-container {
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            width: 90%;
            max-width: 500px;
        }
        button {
            display: block;
            width: 80%;
            margin: 10px auto;
            padding: 15px;
            font-size: 1.2em;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        #message {
            margin-top: 20px;
            font-size: 1.2em;
            color: #d9534f; /* Red for errors */
        }
        @media (max-width: 600px) {
            button {
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <h1>Glasanje je počelo</h1>
    <div class="voting-container">
        <?php foreach ($options as $option): ?>
            <button class="vote-button" data-vote="<?= $option ?>"><?= htmlspecialchars($option) ?></button>
        <?php endforeach; ?>
        <div id="message"></div>
    </div>

    <script>
        document.querySelectorAll('.vote-button').forEach(button => {
            button.addEventListener('click', async () => {
                const vote = button.getAttribute('data-vote');
                const response = await fetch('submit_vote.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ vote })
                });
                const result = await response.json();
                const messageDiv = document.getElementById('message');
                messageDiv.textContent = result.message;
                messageDiv.style.color = result.message.includes('successfully') ? 'green' : 'red';
            });
        });
    </script>
</body>
</html>
