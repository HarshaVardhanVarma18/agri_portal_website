<?php
require '../includes/config.php';
require '../includes/auth.php';
$stmt=$pdo->prepare("SELECT * FROM soil_data WHERE farmer_id=? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['farmer_id']]);
$data=$stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>View Recommendations</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header><h1>Your Recommendations</h1></header>
<main class="container">
<?php if(!$data): ?>
  <p>No records yet.</p>
<?php else: ?>
  <table border="1" cellpadding="8" style="margin:auto;background:#fff;">
    <tr><th>State</th><th>District</th><th>Soil</th><th>Crop</th><th>pH</th><th>N</th><th>P</th><th>K</th><th>Rainfall</th><th>Recommendation</th></tr>
    <?php foreach($data as $r): ?>
      <tr>
        <td><?=e($r['state_name'])?></td>
        <td><?=e($r['district_name'])?></td>
        <td><?=e($r['soil_type'])?></td>
        <td><?=e($r['crop'])?></td>
        <td><?=e($r['ph'])?></td>
        <td><?=e($r['n'])?></td>
        <td><?=e($r['p'])?></td>
        <td><?=e($r['k'])?></td>
        <td><?=e($r['rainfall'])?></td>
        <td><?=e($r['recommendation'])?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
<p><a href="dashboard.php">Back</a></p>
</main>
</body>
</html>
