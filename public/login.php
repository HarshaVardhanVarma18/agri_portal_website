<?php
require '../includes/config.php';
$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $stmt = $pdo->prepare("SELECT * FROM farmers WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    if($user && password_verify($pass, $user['password_hash'])){
        $_SESSION['farmer_id'] = $user['id'];
        $_SESSION['farmer_name'] = $user['name'];
        header("Location: dashboard.php");
        exit;
    } else {
        $msg = "❌ Invalid credentials! Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🌾 Farmer Login | Agri Portal</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #c8e6c9, #f1f8e9, #fffde7);
      background-size: 400% 400%;
      animation: gradientMove 10s infinite alternate;
    }

    @keyframes gradientMove {
      from { background-position: left; }
      to { background-position: right; }
    }

    .container {
      width: 90%;
      max-width: 950px;
      display: flex;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 24px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      overflow: hidden;
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: scale(0.9);}
      to {opacity: 1; transform: scale(1);}
    }

    .left {
      flex: 1.2;
      position: relative;
      background: url('https://images.unsplash.com/photo-1586784336249-31c9ef8d1d94?auto=format&fit=crop&w=1000&q=80') center/cover no-repeat;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    /* Add overlay for better text visibility */
    .left::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.45);
      z-index: 0;
    }

    .left-content {
      position: relative;
      z-index: 1;
      color: #fff;
      text-align: center;
    }

    .left-content h1 {
      font-size: 38px;
      font-weight: 700;
      margin: 10px 0;
      color: #ffeb3b;
      text-shadow: 0 3px 8px rgba(0,0,0,0.5);
    }

    .left-content p {
      font-size: 18px;
      font-weight: 400;
      max-width: 320px;
      line-height: 1.4;
    }

    .icon {
      font-size: 45px;
      margin-bottom: 10px;
      animation: bounce 2s infinite ease-in-out;
    }

    @keyframes bounce {
      0%, 100% {transform: translateY(0);}
      50% {transform: translateY(-6px);}
    }

    .right {
      flex: 1;
      background: rgba(255,255,255,0.96);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
      flex-direction: column;
    }

    .form-box {
      width: 100%;
      max-width: 360px;
    }

    h2 {
      color: #2e7d32;
      text-align: center;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .highlight {
      color: #fbc02d;
    }

    input {
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border-radius: 10px;
      border: 2px solid #c8e6c9;
      transition: all 0.3s;
      font-size: 15px;
    }

    input:focus {
      border-color: #81c784;
      box-shadow: 0 0 8px rgba(76,175,80,0.3);
      outline: none;
    }

    button {
      width: 100%;
      background: linear-gradient(45deg, #4caf50, #81c784, #fbc02d);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      letter-spacing: 0.5px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(76,175,80,0.4);
    }

    .error {
      color: #e53935;
      font-size: 14px;
      text-align: center;
      margin-top: 8px;
    }

    p {
      text-align: center;
      margin-top: 14px;
      color: #444;
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
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <div class="left-content">
        <div class="icon">🌾</div>
        <h1>Agri Portal</h1>
        <p>Empowering farmers with <br> smart insights & sustainable solutions 🌱</p>
      </div>
    </div>

    <div class="right">
      <div class="form-box">
        <h2><span class="highlight">Farmer</span> Login</h2>
        <?php if($msg): ?><p class="error"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
        <form method="post">
          <input name="email" type="email" placeholder="📧 Enter your Email" required>
          <input name="password" type="password" placeholder="🔒 Enter Password" required>
          <button type="submit">Login</button>
          <p>Don’t have an account? <a href="register.php">Register Here</a></p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
