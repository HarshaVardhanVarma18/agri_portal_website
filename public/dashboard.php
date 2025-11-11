<?php
require '../includes/config.php';
require '../includes/auth.php';
$name = $_SESSION['farmer_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🌿 Agri Portal Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
      background: linear-gradient(135deg, #e8f5e9, #fffde7);
      background-image: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1500&q=80');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: #333;
    }

    header {
      background: linear-gradient(90deg, #388e3c, #66bb6a);
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 28px;
      font-weight: 600;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
      letter-spacing: 1px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .dashboard {
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      backdrop-filter: blur(8px);
    }

    .greeting {
      font-size: 30px;
      color: #1b5e20;
      font-weight: 700;
      margin-bottom: 8px;
      text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .subtext {
      color: #2e7d32;
      font-size: 18px;
      margin-bottom: 5px;
    }

    .time {
      color: #4e4e4e;
      font-size: 16px;
      margin-bottom: 25px;
    }

    /* 🌦️ Weather Card */
    .weather-card {
      background: rgba(255, 255, 255, 0.92);
      border-radius: 20px;
      padding: 25px;
      width: 320px;
      margin: 20px auto;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
      transition: all 0.4s;
      position: relative;
      overflow: hidden;
    }

    .weather-card:hover {
      transform: scale(1.06);
      box-shadow: 0 10px 25px rgba(76,175,80,0.3);
    }

    .weather-card::after {
      content: "";
      position: absolute;
      top: -30%;
      left: -30%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle at top left, rgba(255,255,255,0.25), transparent);
      opacity: 0.4;
      pointer-events: none;
    }

    .weather-title {
      font-size: 20px;
      color: #2b7a0b;
      font-weight: 700;
      margin-bottom: 10px;
    }

    #weather {
      font-size: 17px;
      color: #333;
      line-height: 1.5;
    }

    /* 🌱 Action Buttons */
    .actions {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 40px;
      gap: 18px;
    }

    .action-btn {
      background: linear-gradient(45deg, #4caf50, #81c784, #fdd835);
      color: white;
      border: none;
      border-radius: 14px;
      padding: 16px 22px;
      font-weight: 600;
      cursor: pointer;
      width: 230px;
      font-size: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
      transition: all 0.4s;
    }

    .action-btn:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 18px rgba(76,175,80,0.4);
      background: linear-gradient(45deg, #388e3c, #66bb6a, #fbc02d);
    }

    /* 🌻 Quote Box */
    .quote-box {
      margin-top: 50px;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      padding: 25px;
      max-width: 650px;
      font-style: italic;
      font-size: 18px;
      color: #2e7d32;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      animation: fadeIn 1s ease;
      line-height: 1.6;
    }

    footer {
      text-align: center;
      background: linear-gradient(90deg, #2e7d32, #4caf50);
      color: white;
      padding: 14px;
      margin-top: 60px;
      font-size: 15px;
      letter-spacing: 0.5px;
      box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.2);
    }

    /* 🌾 Floating Icons (Decoration) */
    .floating-img {
      position: absolute;
      width: 100px;
      opacity: 0.08;
      animation: floaty 6s ease-in-out infinite alternate;
    }

    @keyframes floaty {
      from { transform: translateY(0px); }
      to { transform: translateY(-15px); }
    }

    .img1 { top: 10%; left: 5%; }
    .img2 { bottom: 10%; right: 5%; width: 120px; }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(25px);}
      to {opacity: 1; transform: translateY(0);}
    }

    @media (max-width: 600px) {
      header { font-size: 22px; }
      .greeting { font-size: 24px; }
      .action-btn { width: 90%; }
      .weather-card { width: 90%; }
      .quote-box { width: 90%; }
    }
  </style>

  <script>
  async function loadWeather() {
      try {
          const response = await fetch("https://api.open-meteo.com/v1/forecast?latitude=17.38&longitude=78.48&current_weather=true");
          const data = await response.json();
          const w = data.current_weather;
          document.getElementById("weather").innerHTML =
            `🌤️ ${w.temperature}°C<br>💨 Wind: ${w.windspeed} km/h`;
      } catch {
          document.getElementById("weather").innerHTML = "⚠️ Unable to load weather data.";
      }
  }

  function greetingMessage() {
      const hour = new Date().getHours();
      if (hour < 12) return "Good Morning 🌅";
      else if (hour < 17) return "Good Afternoon ☀️";
      else return "Good Evening 🌇";
  }

  function updateTime() {
      const now = new Date();
      document.getElementById("time").innerText =
        now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
  }

  function randomQuote() {
      const quotes = [
        "Healthy soil = Healthy life 🌱",
        "Farming is not a job, it’s a way of life 🚜",
        "Grow with passion, harvest with pride 🌾",
        "Every seed you plant counts 🌻",
        "Nature does not hurry, yet everything is accomplished 🌤️",
        "A farmer’s hands feed the world 👐"
      ];
      const randomIndex = Math.floor(Math.random() * quotes.length);
      document.getElementById("quote").innerText = quotes[randomIndex];
  }

  window.onload = () => {
      document.getElementById("greet").innerText = greetingMessage();
      randomQuote();
      loadWeather();
      updateTime();
      setInterval(updateTime, 1000);
  }
  </script>
</head>
<body>
<header>🌿 Agri Portal Dashboard</header>

<!-- 🌾 Decorative Floating Images -->
<img src="https://cdn-icons-png.flaticon.com/512/2331/2331760.png" class="floating-img img1">
<img src="https://cdn-icons-png.flaticon.com/512/590/590685.png" class="floating-img img2">

<div class="dashboard">
  <div id="greet" class="greeting"></div>
  <p class="subtext">Welcome back, <b><?= htmlspecialchars($name) ?></b> 👋</p>
  <p id="time" class="time"></p>

  <div class="weather-card">
    <div class="weather-title">Today's Weather</div>
    <div id="weather">Loading...</div>
  </div>

  <div class="actions">
    <button class="action-btn" onclick="window.location='add_data.php'">➕ Add Soil & Crop Data</button>
    <button class="action-btn" onclick="window.location='view_data.php'">📊 View Recommendations</button>
    <button class="action-btn" onclick="window.location='logout.php'">🚪 Logout</button>
  </div>

  <div class="quote-box" id="quote"></div>
</div>

<footer>🌾 Agri Portal © 2025 | Designed with ❤️ by Farmers, for Farmers</footer>
</body>
</html>
