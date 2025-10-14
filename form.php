<?php
if (!isset($_GET['id'])) die("Form not found");
$formId = $_GET['id'];
$file = "forms/$formId.json";
if (!file_exists($file)) die("Form not found");

$form = json_decode(file_get_contents($file), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = $_POST;

    if (!is_dir('submissions')) mkdir('submissions');
    file_put_contents("submissions/$formId-".time().".json", json_encode($submitted));

    // Build message
    $message = "📩 New submission for {$form['title']}:\n";
    foreach ($submitted as $k => $v) {
        $message .= "$k: $v\n";
    }

    // Email
    mail("youremail@example.com", "New Submission - {$form['title']}", $message);

    // Telegram
    $telegramToken = "YOUR_TELEGRAM_BOT_TOKEN";
    $telegramChatID = "YOUR_CHAT_ID";
    file_get_contents("https://api.telegram.org/bot$telegramToken/sendMessage?chat_id=$telegramChatID&text=" . urlencode($message));

    // WhatsApp link (you can open this manually if you want to send)
    $whatsappNumber = "233XXXXXXXXX";
    $waLink = "https://wa.me/$whatsappNumber?text=" . urlencode($message);

    echo "<p>✅ Form submitted successfully!</p>";
    echo "<p><a href='$waLink' target='_blank'>📲 Share submission on WhatsApp</a></p>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo htmlspecialchars($form['title']); ?></title>
  <style>
    body{font-family:sans-serif;background:#f0f0f0;padding:20px;}
    .form-box{background:#fff;padding:20px;max-width:600px;margin:auto;border-radius:10px;}
    input,button{width:100%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:5px;}
    img.logo{display:block;margin:auto 0 20px;width:120px;}
  </style>
</head>
<body>
<div class="form-box">
  <?php if(!empty($form['logo'])): ?>
    <img src="<?php echo htmlspecialchars($form['logo']); ?>" class="logo" alt="Logo">
  <?php endif; ?>
  <h2><?php echo htmlspecialchars($form['title']); ?></h2>
  <p><?php echo htmlspecialchars($form['description']); ?></p>
  <form method="POST">
    <?php foreach ($form['fields'] as $field): ?>
      <label><?php echo htmlspecialchars($field); ?></label>
      <input type="text" name="<?php echo htmlspecialchars($field); ?>" placeholder="<?php echo htmlspecialchars($field); ?>" required>
    <?php endforeach; ?>
    <button type="submit">Submit</button>
  </form>
</div>
</body>
</html>
