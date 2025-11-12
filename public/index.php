<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>🌾 Welcome to Agri Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Poppins', sans-serif;
  color: #2e7d32;
  background: 
    url('https://images.unsplash.com/photo-1617196034828-b6e908d30c87?auto=format&fit=crop&w=1600&q=80')
    center/cover no-repeat; /* ☀️ bright farmland image */
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow-x: hidden;
}

/* Header */
header {
  background: linear-gradient(90deg, #cddc39, #aed581, #7cb342);
  color: #1b5e20;
  padding: 22px;
  font-size: 28px;
  font-weight: 700;
  text-align: center;
  text-shadow: 1px 1px 3px rgba(255,255,255,0.6);
  letter-spacing: 1px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* Hero Section */
.hero {
  display: flex;
  align-items: center;
  justify-content: space-around;
  flex-wrap: wrap;
  padding: 60px 10%;
  position: relative;
}

.hero-content {
  flex: 1 1 400px;
  max-width: 600px;
  z-index: 2;
}

.hero h1 {
  font-size: 3rem;
  color: #2e7d32;
  line-height: 1.2;
}

.hero p {
  margin-top: 15px;
  font-size: 1.15rem;
  color: #33691e;
}

/* Buttons */
.actions {
  margin-top: 30px;
}

button {
  background: linear-gradient(45deg, #8bc34a, #cddc39);
  color: #000;
  border: none;
  border-radius: 10px;
  padding: 14px 26px;
  font-size: 16px;
  margin: 10px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

button:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 20px rgba(124,179,66,0.5);
}

/* Farmer Side Image */
.side-image {
  flex: 1 1 300px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.side-image img {
  width: 80%;
  max-width: 400px;
  animation: floaty 6s ease-in-out infinite alternate;
}

@keyframes floaty {
  from { transform: translateY(0px); }
  to { transform: translateY(-10px); }
}

/* Content Sections */
.section {
  background: rgba(255, 255, 255, 0.8);
  margin: 40px auto;
  padding: 40px;
  border-radius: 20px;
  backdrop-filter: blur(4px);
  width: 90%;
  max-width: 900px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  text-align: center;
}

.section h2 {
  color: #33691e;
  margin-bottom: 15px;
}

.section p, .section ul {
  color: #444;
  line-height: 1.8;
  font-size: 1.05rem;
}

/* Footer */
footer {
  text-align: center;
  padding: 18px;
  background: linear-gradient(90deg, #cddc39, #aed581, #7cb342);
  color: #1b5e20;
  font-weight: 600;
  letter-spacing: 0.5px;
  box-shadow: 0 -4px 10px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
  .hero { flex-direction: column; text-align: center; }
  .hero-content { text-align: center; }
  .side-image img { width: 70%; margin-top: 25px; }
}
</style>
</head>
<body>

<header>🌿 Agri Portal</header>

<section class="hero">
  <div class="hero-content">
    <h1>Empowering Farmers with Smart Agriculture</h1>
    <p>Welcome to Agri Portal for Farmers — your digital partner for smarter, greener, and more productive farming.  
    Get soil insights, weather updates, and the best crop recommendations for your land.</p>

    <div class="actions">
      <button onclick="window.location='register.php'">👨‍🌾 Register</button>
      <button onclick="window.location='login.php'">🌱 Login</button>
    </div>
  </div>

  <div class="side-image">
    <img src="https://cdn-icons-png.flaticon.com/512/2934/2934006.png" alt="Farmer Illustration">
  </div>
</section>

<section class="section">
  <h2>About the Portal</h2>
  <p>Agri Portal helps farmers take data-driven decisions.  
  From soil nutrient levels to crop selection and irrigation tips — everything you need for a successful harvest is right here.</p>
</section>

<section class="section">
  <h2>Features</h2>
  <ul style="list-style:none; padding:0;">
    <li>🌾 Smart Soil & Crop Recommendations</li>
    <li>☁️ Real-time Weather Insights</li>
    <li>📊 Visual Crop Analytics</li>
    <li>💧 Efficient Irrigation Management</li>
  </ul>
</section>

<footer>© 2025 Agri Portal | Empowering Every Farmer 🌾</footer>

</body>
</html>
