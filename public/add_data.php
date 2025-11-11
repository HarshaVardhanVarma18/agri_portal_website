<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../includes/config.php';
require '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $state = $_POST['state_name'];
    $district = $_POST['district_name'];
    $season = $_POST['season'];
    $soil = $_POST['soil_type'];
    $crop = $_POST['crop'];

    // 🌾 Dynamic NPK, pH, Rainfall generation
    switch (strtolower($soil)) {
        case 'clay': $ph=6.0;$n=80;$p=35;$k=130;$rain=1100;break;
        case 'red sandy': $ph=6.8;$n=60;$p=45;$k=140;$rain=700;break;
        case 'loamy': $ph=6.5;$n=75;$p=40;$k=150;$rain=900;break;
        case 'alluvial': $ph=7.0;$n=85;$p=50;$k=170;$rain=950;break;
        case 'black': $ph=7.2;$n=90;$p=60;$k=180;$rain=1000;break;
        default: $ph=6.5;$n=70;$p=40;$k=150;$rain=850;break;
    }

    // 🌱 Extended Smart Recommendations (40+)
    $soilLow = strtolower($soil);
    $cropLow = strtolower($crop);
    $seasonLow = strtolower($season);
    $rec = "";

    if ($cropLow === 'rice') {
        if (strpos($soilLow,'red')!==false) $rec="❌ Rice not ideal for red soil; try Maize or Pulses 🌽";
        elseif (strpos($soilLow,'sandy')!==false) $rec="⚠️ Sandy soil drains fast — irrigate well 💧";
        elseif (strpos($soilLow,'loamy')!==false) $rec="✅ Loamy soil perfect for Rice 🌾";
        elseif (strpos($soilLow,'alluvial')!==false) $rec="✅ Alluvial soil + monsoon = high yield 🌧️";
        else $rec="🌾 Rice performs okay in $soil soil this $season.";
    }

    elseif ($cropLow === 'wheat') {
        if (strpos($soilLow,'alluvial')!==false) $rec="✅ Alluvial soil + winter = premium wheat 🌾❄️";
        elseif (strpos($soilLow,'loamy')!==false) $rec="✅ Loamy soil gives balanced roots 🌱";
        elseif (strpos($soilLow,'black')!==false) $rec="⚠️ Black soil retains moisture, sow early 🌅";
        else $rec="🌾 Keep irrigation steady for better wheat yield.";
    }

    elseif ($cropLow === 'maize') {
        if (strpos($soilLow,'loamy')!==false) $rec="✅ Loamy soil & sunshine perfect for Maize 🌽☀️";
        elseif (strpos($soilLow,'red')!==false) $rec="✅ Red soil + summer = strong cobs 🌽";
        elseif (strpos($soilLow,'black')!==false) $rec="✅ Black soil retains moisture — good yield 💧";
        else $rec="🌾 Maize needs 600–800mm rainfall 🌦️";
    }

    elseif ($cropLow === 'cotton') {
        if (strpos($soilLow,'black')!==false) $rec="✅ Cotton thrives in black soil 👕🌿";
        elseif (strpos($soilLow,'red')!==false) $rec="✅ Red soil good with irrigation 💧";
        else $rec="⚠️ Cotton prefers dry climate & well-drained soil 🌞";
    }

    elseif ($cropLow === 'groundnut') {
        if (strpos($soilLow,'red')!==false || strpos($soilLow,'sandy')!==false) $rec="✅ Groundnut loves red/sandy soil 🌰";
        elseif (strpos($soilLow,'black')!==false) $rec="⚠️ Needs drainage in black soil 🚿";
        else $rec="❌ Avoid clay — poor pod growth 🥜";
    }

    elseif ($cropLow === 'sugarcane') {
        if (strpos($soilLow,'alluvial')!==false) $rec="✅ Alluvial soil grows tall, sweet canes 🍬";
        elseif (strpos($soilLow,'black')!==false) $rec="✅ Black soil stores moisture well 🌾";
        else $rec="⚠️ Add compost & irrigate often 💧";
    }

    elseif ($cropLow === 'pulses') {
        if (strpos($soilLow,'red')!==false) $rec="✅ Pulses like red soil — rich in iron 🌱";
        elseif (strpos($soilLow,'loamy')!==false) $rec="✅ Loamy soil ideal for lentils 🫘";
        else $rec="🌿 Pulses need mild weather & light soil 🌤️";
    }

    elseif ($cropLow === 'vegetables') {
        if (strpos($soilLow,'loamy')!==false) $rec="✅ Loamy soil suits most vegetables 🥦🥕";
        elseif (strpos($soilLow,'alluvial')!==false) $rec="✅ Alluvial soil best for tomatoes & onions 🍅🧅";
        else $rec="⚠️ Add compost for fresh greens 🌿";
    }

    elseif ($cropLow === 'millets') $rec="✅ Millets are drought-tolerant 🌾 good for red/sandy soil.";
    elseif ($cropLow === 'fruits') $rec="🍊 Fruits like loamy/alluvial soil — mango, banana thrive 🍌🥭";
    elseif ($cropLow === 'turmeric') $rec="✅ Turmeric loves loamy soil + humid weather 🌿🧡";
    elseif ($cropLow === 'onion') $rec="✅ Onion grows shiny bulbs in sandy loam 🧅";
    elseif ($cropLow === 'sunflower') $rec="🌻 Sunflower likes deep loamy soil and sunlight ☀️";
    elseif ($cropLow === 'banana') $rec="🍌 Banana prefers rich alluvial soil with good irrigation 💧";
    elseif ($cropLow === 'chili') $rec="🌶️ Chili thrives in black/red soil; needs warm climate 🔥";
    elseif ($cropLow === 'tomato') $rec="🍅 Tomato loves loamy soil with organic matter 🌱";
    elseif ($cropLow === 'soybean') $rec="🌿 Soybean yields best in black or alluvial soil.";
    elseif ($cropLow === 'mustard') $rec="🌾 Mustard needs cool climate + loamy soil ❄️";
    elseif ($cropLow === 'jowar') $rec="🌾 Jowar suits red/black soils with low rainfall.";
    elseif ($cropLow === 'lentil') $rec="🫘 Lentil loves loamy soil & mild winter ❄️";
    else $rec="🌱 Maintain pH 6–7, compost often, and irrigate regularly 💧";

    echo json_encode(['ph'=>$ph,'n'=>$n,'p'=>$p,'k'=>$k,'rain'=>$rain,'rec'=>$rec]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🌿 Smart Agriculture Recommendations</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f1f8e9, #fffde7);
      color: #333;
      text-align: center;
    }

    header {
      background: linear-gradient(90deg, #43a047, #66bb6a, #fdd835);
      color: white;
      padding: 20px;
      font-size: 28px;
      font-weight: 700;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    /* 🌾 Emoji banner */
    .icon-banner {
      font-size: 2rem;
      padding: 15px;
      display: flex;
      justify-content: center;
      gap: 15px;
      background: #f9fbe7;
    }
    .icon-banner span { transition: transform 0.3s; }
    .icon-banner span:hover { transform: scale(1.2); }

    form {
      background: rgba(255,255,255,0.95);
      border-radius: 16px;
      padding: 25px;
      width: 90%;
      max-width: 500px;
      margin: 30px auto;
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
      animation: fadeIn 0.8s ease;
    }

    label { font-weight: 600; color: #2e7d32; display: block; text-align: left; }
    select {
      width: 100%; padding: 10px; border-radius: 10px;
      border: 2px solid #c8e6c9; margin: 8px 0;
      font-size: 15px; transition: all 0.3s;
    }
    select:focus { border-color: #4caf50; box-shadow: 0 0 6px rgba(76,175,80,0.4); outline: none; }

    button {
      background: linear-gradient(45deg, #4caf50, #81c784, #fdd835);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
      transition: transform 0.3s, box-shadow 0.3s;
      margin-top: 12px;
    }
    button:hover { transform: scale(1.05); box-shadow: 0 6px 15px rgba(76,175,80,0.4); }

    #recBox {
      display: none;
      background: rgba(255,255,255,0.95);
      border-left: 6px solid #43a047;
      border-radius: 12px;
      padding: 20px;
      margin: 30px auto;
      max-width: 600px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.15);
      font-size: 16px;
    }

    #recBox h3 { color: #2e7d32; margin-top: 0; }
    #autoValues { font-size: 15px; color: #444; margin-top: 10px; }

    footer {
      margin-top: 40px;
      padding: 14px;
      background: linear-gradient(90deg, #388e3c, #4caf50);
      color: white;
      font-size: 15px;
      letter-spacing: 0.5px;
    }

    @keyframes fadeIn { from {opacity:0;transform:scale(0.95);} to {opacity:1;transform:scale(1);} }
  </style>
</head>
<body>
<header>🌾 Smart Agriculture Recommendations 🚜</header>

<!-- 🌻 Agriculture Emoji Banner -->
<div class="icon-banner">
  <span>🌾</span>
  <span>🚜</span>
  <span>🐄</span>
  <span>🌻</span>
  <span>🥦</span>
  <span>🍅</span>
  <span>🌱</span>
  <span>💧</span>
</div>

<form id="recommendForm">
  <label>State:</label>
  <select id="state_name" name="state_name" required onchange="updateDistricts();">
    <option value="">-- Select State --</option>
  </select>

  <label>District:</label>
  <select id="district_name" name="district_name" required>
    <option value="">-- Select District --</option>
  </select>

  <label>Soil Type:</label>
  <select id="soil_type" name="soil_type" required>
    <option value="">-- Select Soil Type --</option>
    <option>Alluvial</option>
    <option>Black</option>
    <option>Red Sandy</option>
    <option>Clay</option>
    <option>Loamy</option>
    <option>Laterite</option>
  </select>

  <label>Season:</label>
  <select name="season" required>
    <option value="">-- Select Season --</option>
    <option>Rainy Season (June–Oct)</option>
    <option>Winter Season (Nov–Apr)</option>
    <option>Summer Season (Apr–Jun)</option>
  </select>

  <label>Crop Type:</label>
  <select name="crop" required>
    <option value="">-- Select Crop --</option>
    <option>Rice</option>
    <option>Wheat</option>
    <option>Maize</option>
    <option>Sugarcane</option>
    <option>Groundnut</option>
    <option>Cotton</option>
    <option>Pulses</option>
    <option>Vegetables</option>
    <option>Millets</option>
    <option>Fruits</option>
    <option>Turmeric</option>
    <option>Onion</option>
    <option>Sunflower</option>
    <option>Banana</option>
    <option>Chili</option>
    <option>Tomato</option>
    <option>Soybean</option>
    <option>Mustard</option>
    <option>Jowar</option>
    <option>Lentil</option>
  </select>

  <button type="submit">🌿 Get Smart Recommendation</button>
</form>

<div id="recBox">
  <h3>💡 Smart Recommendation</h3>
  <div id="recText"></div>
  <div id="autoValues"></div>
</div>

<footer>🌾 Agri Portal © 2025 | Sustainable Farming for the Future 🌱</footer>

<script>
async function loadStates() {
  const res = await fetch("data/india_states_districts.json");
  const statesData = await res.json();
  const stateSelect = document.getElementById("state_name");
  for (const state in statesData) {
    const opt = document.createElement("option");
    opt.value = state;
    opt.textContent = state;
    stateSelect.appendChild(opt);
  }
  window.statesData = statesData;
}

function updateDistricts() {
  const state = document.getElementById("state_name").value;
  const districtSelect = document.getElementById("district_name");
  districtSelect.innerHTML = "<option value=''>-- Select District --</option>";
  if (window.statesData && window.statesData[state]) {
    window.statesData[state].forEach(d => {
      const opt = document.createElement("option");
      opt.value = d;
      opt.textContent = d;
      districtSelect.appendChild(opt);
    });
  }
}

document.getElementById("recommendForm").onsubmit = async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  const response = await fetch("", { method: "POST", body: formData });
  const data = await response.json();
  document.getElementById("recBox").style.display = "block";
  document.getElementById("recText").innerHTML = data.rec;
  document.getElementById("autoValues").innerHTML =
    `<b>📊 Soil Analysis:</b><br>pH: ${data.ph} | N: ${data.n} | P: ${data.p} | K: ${data.k} | Rainfall: ${data.rain} mm`;
}

window.onload = loadStates;
</script>
</body>
</html>
