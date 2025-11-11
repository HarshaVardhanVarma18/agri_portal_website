<?php
require '../includes/config.php';
$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    if($name && $email && $pass){
        $stmt = $pdo->prepare("SELECT id FROM farmers WHERE email=?");
        $stmt->execute([$email]);
        if($stmt->fetch()){
            $msg = "❌ Email already exists!";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO farmers(name, email, password_hash) VALUES(?,?,?)")
                ->execute([$name, $email, $hash]);
            $msg = "✅ Registration successful! You can now login.";
        }
    } else {
        $msg = "⚠️ All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🌾 Farmer Registration | Agri Portal</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background:
        url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1600&q=80')
        center/cover no-repeat;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #1b5e20;
    }

    .form-card {
      background: rgba(255, 255, 255, 0.85);
      border-radius: 20px;
      padding: 40px 35px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      text-align: center;
      backdrop-filter: blur(10px);
      animation: fadeIn 0.8s ease;
    }

    .form-card h2 {
      color: #33691e;
      font-size: 26px;
      margin-bottom: 15px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 10px;
      border: 1px solid #a5d6a7;
      font-size: 15px;
      transition: 0.3s;
    }

    input:focus {
      border-color: #4caf50;
      box-shadow: 0 0 6px rgba(76,175,80,0.4);
      outline: none;
    }

    button {
      background: linear-gradient(45deg, #8bc34a, #cddc39);
      border: none;
      color: #000;
      font-weight: 600;
      font-size: 16px;
      padding: 12px;
      width: 100%;
      border-radius: 10px;
      cursor: pointer;
      margin-top: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      transition: all 0.3s;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 18px rgba(124,179,66,0.5);
    }

    p {
      margin-top: 12px;
      font-size: 14px;
    }

    a {
      color: #2e7d32;
      font-weight: 600;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .msg {
      font-weight: 600;
      margin-bottom: 10px;
      color: #2e7d32;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <form method="post" class="form-card">
    <h2>👨‍🌾 Farmer Registration</h2>
    <?php if($msg): ?>
      <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>
    <input name="name" placeholder="Full Name" required>
    <input name="email" type="email" placeholder="Email Address" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">🌱 Register</button>
    <p>Already have an account? <a href="login.php">Login Here</a></p>
  </form>

</body>
</html>
