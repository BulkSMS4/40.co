<?php
$files = glob("submissions/*.json");
?>
<!DOCTYPE html>
<html>
<head>
  <title>📊 Submissions Dashboard</title>
  <style>
    body{font-family:sans-serif;background:#f5f5f5;padding:20px;}
    .card{background:#fff;padding:15px;margin-bottom:15px;border-radius:10px;}
    h2{margin-top:0;}
  </style>
</head>
<body>
<h2>📊 Submissions</h2>
<?php foreach ($files as $file): 
    $data = json_decode(file_get_contents($file), true);
?>
<div class="card">
  <?php foreach ($data as $key => $value): ?>
    <p><strong><?php echo htmlspecialchars($key); ?>:</strong> <?php echo htmlspecialchars($value); ?></p>
  <?php endforeach; ?>
</div>
<?php endforeach; ?>
</body>
</html>
