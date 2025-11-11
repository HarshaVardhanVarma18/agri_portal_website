<?php
// ✅ Show errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../includes/config.php';
require '../includes/auth.php';

$api_key = "2b41a119fd31df5e41f3b10fd058aba1"; // 🌦️ Your OpenWeather API Key

// Fetch all soil_data entries for the logged-in farmer
$stmt = $pdo->prepare("SELECT * FROM soil_data WHERE farmer_id = ?");
$stmt->execute([$_SESSION['farmer_id']]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Smart Crop Profit Recommendations</title>
  <style>
    body { background: #f2fff3; font-family: 'Poppins', sans-serif; }
    h2 { text-align: center; margin-top: 20px; color: #1b5e20; }
    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin: 20px auto;
      max-width: 650px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .weather-box {
      background: #eaffea;
      border-left: 5px solid #43a047;
      padding: 10px;
      margin-top: 10px;
      border-radius: 8px;
      font-size: 14px;
    }
    .suggestion {
      background: #fffde7;
      border-left: 5px solid #ffb300;
      padding: 10px;
      margin-top: 10px;
      border-radius: 8px;
      font-size: 15px;
    }
  </style>
</head>
<body>
<h2>🌾 Smart Crop & Profit Recommendations</h2>

<?php foreach ($data as $row): ?>
  <div class="card" id="card<?= $row['id'] ?>">
    <h3>📍 <?= htmlspecialchars($row['district_name']) ?>, <?= htmlspecialchars($row['state_name']) ?></h3>
    <p><b>Soil Type:</b> <?= htmlspecialchars($row['soil_type']) ?> | <b>Season:</b> <?= htmlspecialchars($row['season']) ?></p>
    <p><b>Selected Crop:</b> <?= htmlspecialchars($row['crop']) ?></p>

    <div class="weather-box" id="weather<?= $row['id'] ?>">🌦️ Fetching live weather...</div>
    <div class="suggestion" id="suggestion<?= $row['id'] ?>">🤖 Analyzing crop suitability & profit...</div>
  </div>
<?php endforeach; ?>

<script>
const API_KEY = "2b41a119fd31df5e41f3b10fd058aba1";

// Helper function for variety
function randomLine(lines) {
  return lines[Math.floor(Math.random() * lines.length)];
}

async function getWeatherAndAdvice(city, id, soil, crop, season) {
  try {
    let cityName = city;
    // Fix district-to-city mapping for weather
    if (city.toLowerCase().includes("east godavari")) cityName = "Rajahmundry";
    if (city.toLowerCase().includes("west godavari")) cityName = "Eluru";
    if (city.toLowerCase().includes("krishna")) cityName = "Vijayawada";
    if (city.toLowerCase().includes("vizianagaram")) cityName = "Visakhapatnam";
    if (city.toLowerCase().includes("chittoor")) cityName = "Tirupati";
    if (city.toLowerCase().includes("nellore")) cityName = "Nellore";
    if (city.toLowerCase().includes("anantapur")) cityName = "Anantapur";
    if (city.toLowerCase().includes("kadapa")) cityName = "Kadapa";

    const res = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${cityName},IN&appid=${API_KEY}&units=metric`);
    const weather = await res.json();

    if (!weather.main) {
      document.getElementById("weather" + id).innerText = "⚠️ Weather data unavailable.";
      document.getElementById("suggestion" + id).innerText = "❌ Cannot generate recommendation.";
      return;
    }

    const temp = weather.main.temp;
    const humidity = weather.main.humidity;
    const desc = weather.weather[0].description;

    // Show weather
    document.getElementById("weather" + id).innerHTML =
      `🌤️ <b>Weather:</b> ${desc}<br>🌡️ <b>Temperature:</b> ${temp}°C<br>💧 <b>Humidity:</b> ${humidity}%`;

    // Generate smart profit-based suggestions
    let suggestion = "";
    const t = temp;
    const h = humidity;

    if (crop.toLowerCase() === "rice") {
      if (t < 20 || h < 70) {
        suggestion = randomLine([
          `⚠️ The weather seems dry (${t}°C, ${h}%). Rice may not thrive. 🌾 Wheat or Maize would bring better returns.`,
          `💧 Rice needs more humidity. You could switch to <b>Wheat</b> or <b>Groundnut</b> for stable profit this season.`,
          `☁️ Less moisture and cooler air — Rice yield might drop. Try <b>Maize</b> for quicker growth and higher gain.`
        ]);
      } else {
        suggestion = randomLine([
          `✅ Perfect for <b>Rice</b> right now! High humidity supports growth and profit margins this season.`,
          `🌾 Ideal climate (${t}°C, ${h}% humidity). Expect good yield and better selling price for Rice.`,
          `💧 Great time to grow <b>Rice</b> — strong yield potential and high local demand.`
        ]);
      }
    }

    else if (crop.toLowerCase() === "maize") {
      if (t < 18) {
        suggestion = randomLine([
          `🥶 Too cool (${t}°C) for Maize — delay sowing a few days.`,
          `⚠️ Cold air may slow germination. Wait until temp rises above 20°C.`,
          `🌽 Slightly cold now. Postpone sowing or switch to Lentils temporarily.`
        ]);
      } else {
        suggestion = randomLine([
          `🌽 Maize fits your weather perfectly (${t}°C, ${h}%). Expect strong yield and better market value this month.`,
          `✅ Conditions are ideal for <b>Maize</b>. Profit margin could rise due to steady demand.`,
          `📈 Maize looks profitable under this temperature range — low risk and consistent return.`
        ]);
      }
    }

    else if (crop.toLowerCase() === "wheat") {
      if (t > 30) {
        suggestion = randomLine([
          `☀️ Too warm (${t}°C) for Wheat — yield may fall. Cotton or Millets would give higher profit.`,
          `⚠️ Hot weather not ideal for Wheat. Try <b>Maize</b> or <b>Soybean</b> for better returns.`,
          `🔥 Temperature above 30°C can reduce grain quality. Postpone Wheat and focus on other cereals.`
        ]);
      } else {
        suggestion = randomLine([
          `✅ Good to grow <b>Wheat</b>! The current weather supports steady yield and market profit.`,
          `🌾 Favorable temperature and humidity — Wheat is a profitable choice this week.`,
          `💰 Wheat market remains stable. With these conditions, you can expect solid returns.`
        ]);
      }
    }

    else if (crop.toLowerCase() === "cotton") {
      if (h > 80) {
        suggestion = randomLine([
          `☁️ Too humid (${h}%) — may cause pest issues in Cotton. Choose <b>Maize</b> or <b>Soybean</b> for safer profit.`,
          `⚠️ High moisture isn’t ideal for Cotton. Consider crops with shorter cycles like Groundnut.`,
          `🌫️ Humidity may affect Cotton quality. Try <b>Sunflower</b> instead this season.`
        ]);
      } else {
        suggestion = randomLine([
          `✅ Cotton can do well now. The temperature suits fiber strength and yield.`,
          `🌞 Great time to sow <b>Cotton</b> — profit margins high in local markets.`,
          `💹 Cotton farming profitable under current dry-air conditions (${h}% humidity).`
        ]);
      }
    }

    else {
      suggestion = randomLine([
        `🌱 Conditions in ${cityName} (${t}°C, ${h}% humidity) look healthy. Profit potential is steady.`,
        `☁️ Balanced weather — continue irrigation and expect normal returns.`,
        `🌿 Stable atmosphere supports average yield this season in ${cityName}.`
      ]);
    }

    document.getElementById("suggestion" + id).innerHTML = suggestion;

  } catch (error) {
    console.error(error);
    document.getElementById("weather" + id).innerText = "⚠️ Error fetching weather.";
    document.getElementById("suggestion" + id).innerText = "❌ Failed to generate advice.";
  }
}

// Trigger for each card
<?php foreach ($data as $row): ?>
  getWeatherAndAdvice("<?= addslashes($row['district_name']) ?>", "<?= $row['id'] ?>", "<?= $row['soil_type'] ?>", "<?= $row['crop'] ?>", "<?= $row['season'] ?>");
<?php endforeach; ?>
</script>
</body>
</html>
