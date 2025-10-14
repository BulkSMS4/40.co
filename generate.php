<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formTitle = $_POST['formTitle'];
    $description = $_POST['description'];
    $logoURL = $_POST['logoURL'];
    $fields = array_filter(array_map('trim', explode("\n", $_POST['fields'])));

    $formId = uniqid();
    $data = [
        'title' => $formTitle,
        'description' => $description,
        'logo' => $logoURL,
        'fields' => $fields
    ];

    if (!is_dir('forms')) mkdir('forms');
    file_put_contents("forms/$formId.json", json_encode($data));

    $link = "http://yourdomain.com/form.php?id=$formId";
    $message = "✅ New form generated:\n$link";
    // Email
    mail("youremail@example.com", "New Form Generated", $message);

    // Telegram Notification
    $telegramToken = "YOUR_TELEGRAM_BOT_TOKEN";
    $telegramChatID = "YOUR_CHAT_ID";
    file_get_contents("https://api.telegram.org/bot$telegramToken/sendMessage?chat_id=$telegramChatID&text=" . urlencode($message));

    // WhatsApp Notification (optional — using wa.me link)
    $whatsappNumber = "233XXXXXXXXX"; // your WhatsApp number
    $waLink = "https://wa.me/$whatsappNumber?text=" . urlencode($message);

    echo "<p><strong>Form Link:</strong> <a href='$link'>$link</a></p>";
    echo "<p><a href='$waLink' target='_blank'>📲 Send via WhatsApp</a></p>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Generate Form</title>
  <style>
    body{font-family:sans-serif;background:#f5f5f5;padding:20px;}
    .box{background:#fff;padding:20px;max-width:600px;margin:auto;border-radius:10px;}
    input,textarea,button{width:100%;margin:10px 0;padding:10px;border:1px solid #ccc;border-radius:5px;}
  </style>
</head>
<body>
<div class="box">
<h2>🧾 Create a New Form</h2>
<form method="POST">
  <label>Form Title</label>
  <input type="text" name="formTitle" placeholder="Example: Login Page" required>

  <label>Description</label>
  <textarea name="description" placeholder="Enter description..."></textarea>

  <label>Logo URL (optional)</label>
  <input type="text" name="logoURL" placeholder="https://example.com/logo.png">

  <label>Custom Input Fields (one per line)</label>
  <textarea name="fields" placeholder="Name&#10;Email&#10;Password&#10;Phone Number"></textarea>

  <button type="submit">✅ Generate Form</button>
</form>
</div>
</body>
</html>
