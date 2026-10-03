<?php
require_once __DIR__ . '/../../app/middleware/session_bootstrap.php';
configure_session_storage();
session_start();
require_once __DIR__ . '/../../app/models/mysqli_db.php';
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$activePage = 'report';
$today = strtoupper(date('l, F j'));
$reportError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_id <= 0) {
        $reportError = 'Please sign in again before submitting a report.';
    } elseif (!isset($conn) || $conn->connect_error) {
        $reportError = 'Database connection failed. Please try again.';
    } else {
    $required = ['incident_type','description','date','time'];
    $ok = true;
    foreach ($required as $f) { if (empty($_POST[$f])) $ok = false; }
    if ($ok) {
        $stmt = $conn->prepare("INSERT INTO incidents (user_id, incident_type, description, location, date_time, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        if (!$stmt) {
            $reportError = 'Could not prepare the report save. Please try again.';
        } else {
            $dt = $_POST['date'].' '.$_POST['time'];
            $loc = $_POST['location'] ?? 'Unknown';
            $stmt->bind_param("issss", $user_id, $_POST['incident_type'], $_POST['description'], $loc, $dt);
            if ($stmt->execute()) { header('Location: map.php'); exit(); }
            $reportError = 'Could not save the report. Please try again.';
            $stmt->close();
        }
    } else {
        $reportError = 'Please fill all required fields.';
    }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Incident — SheShield</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <link rel="stylesheet" href="../../public/css/dashboard.css?v=3">
</head>
<body class="dash-body">
<div class="dash-layout">
  <?php include __DIR__ . '/sidebar.php'; ?>
  <div class="dash-content">
    <?php include __DIR__.'/blobs.php'; ?>
    <div class="dash-topbar">
      <div>
        <div class="topbar-date"><?= $today ?> — REPORTS</div>
        <h1 class="topbar-title">Report <span class="gradient-text">Incident</span></h1>
      </div>
      <div class="topbar-right">
        <a href="../../pro/report.html" class="btn-report" style="background:linear-gradient(135deg,#ef4444,#991b1b)">🔴 SOS Emergency</a>
      </div>
    </div>
    <div class="dash-inner">
      <div style="display:grid;grid-template-columns:1fr 360px;gap:20px">
        <!-- Report Form -->
        <div class="glass-card">
          <h3 style="font-size:18px;font-weight:700;margin-bottom:6px">File a Safety Report</h3>
          <p style="font-size:12px;color:rgba(255,255,255,0.4);margin-bottom:24px">All reports are confidential and encrypted</p>
          <?php if ($reportError): ?>
            <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);color:#fca5a5;border-radius:12px;padding:12px 14px;font-size:12px;margin-bottom:16px"><?= htmlspecialchars($reportError) ?></div>
          <?php endif; ?>
          <form method="POST" style="display:flex;flex-direction:column;gap:16px">
            <div>
              <label style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:6px;display:block">Email</label>
              <input type="email" name="email" placeholder="your@email.com" class="premium-input">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
              <div>
                <label style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:6px;display:block">Date</label>
                <input type="date" name="date" class="premium-input" required>
              </div>
              <div>
                <label style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:6px;display:block">Time</label>
                <input type="time" name="time" class="premium-input" required>
              </div>
            </div>
            <div>
              <label style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:6px;display:block">Incident Type</label>
              <select name="incident_type" class="premium-input" required>
                <option value="">Select type...</option>
                <option value="harassment">Harassment</option>
                <option value="stalking">Stalking</option>
                <option value="theft">Theft</option>
                <option value="assault">Assault</option>
                <option value="cybercrime">Cybercrime</option>
                <option value="domestic">Domestic Violence</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div>
              <label style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:6px;display:block">Location</label>
              <select name="location" class="premium-input" required>
                <option value="">Select location...</option>
                <option value="Block 32">Block 32</option>
                <option value="Block 34">Block 34</option>
                <option value="Girls Hostel">Girls Hostel</option>
                <option value="Boys Hostel">Boys Hostel</option>
                <option value="Uni Mall">Uni Mall</option>
                <option value="Main Gate">Main Gate</option>
                <option value="Library">Library</option>
                <option value="Sports Complex">Sports Complex</option>
                <option value="Parking Zone">Parking Zone</option>
                <option value="Other">Other (specify in description)</option>
              </select>
            </div>
            <div>
              <label style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:6px;display:block">Description</label>
              <textarea name="description" placeholder="Describe the incident in detail..." class="premium-input" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn-primary" style="padding:14px;font-size:14px;border-radius:12px;margin-top:8px">
              <i class="fa-solid fa-paper-plane" style="margin-right:8px"></i> Submit Report
            </button>
          </form>
        </div>

        <!-- Emergency Sidebar -->
        <div style="display:flex;flex-direction:column;gap:14px">
          <div class="sos-card">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
              <h3 style="font-size:14px;font-weight:600;color:#f87171"><i class="fa-solid fa-phone-volume" style="margin-right:6px"></i> Emergency</h3>
              <span class="tag-pill red" style="animation:pulse 2s infinite">24/7</span>
            </div>
            <button class="sos-btn" onclick="activateSOS()" style="margin-bottom:12px">🔴 ACTIVATE SOS</button>
            <p style="font-size:10px;color:rgba(255,255,255,0.3);text-align:center">Alerts all emergency contacts instantly</p>
          </div>

          <?php
          $contacts = [
            ['LPU Security','1800-102-4431','#e91e8c'],
            ['Campus Emergency','+91-1824-517000','#7c3aed'],
            ['Women Helpline','1091','#ef4444'],
            ['Police','100','#3b82f6']
          ];
          foreach ($contacts as $c): ?>
          <div class="glass-card" style="padding:14px">
            <div style="display:flex;justify-content:space-between;align-items:center">
              <div>
                <div style="font-size:12px;font-weight:600"><?= $c[0] ?></div>
                <div style="font-size:14px;font-weight:700;color:<?= $c[2] ?>;margin-top:2px"><?= $c[1] ?></div>
              </div>
              <div style="display:flex;gap:6px">
                <button class="btn-secondary" style="padding:6px 10px" onclick="navigator.clipboard.writeText('<?= $c[1] ?>')"><i class="fa-regular fa-copy" style="font-size:11px"></i></button>
                <a href="tel:<?= $c[1] ?>" class="btn-primary" style="padding:6px 10px;text-decoration:none"><i class="fa-solid fa-phone" style="font-size:11px"></i></a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>

          <div class="glass-card" style="padding:14px">
            <h4 style="font-size:12px;font-weight:600;color:#f472b6;margin-bottom:8px"><i class="fa-solid fa-shield-heart" style="margin-right:6px"></i>Safety Tips</h4>
            <ul style="font-size:11px;color:rgba(255,255,255,0.4);list-style:none;display:flex;flex-direction:column;gap:6px">
              <li>• Stay in well-lit areas at night</li>
              <li>• Share your live location with trusted contacts</li>
              <li>• Save emergency numbers on speed dial</li>
              <li>• Trust your instincts — leave if unsafe</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SOS Emergency Modal -->
<div id="sosModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.85);backdrop-filter:blur(12px);align-items:center;justify-content:center">
  <div style="background:linear-gradient(145deg,#1a1a2e,#16162a);border:1px solid rgba(239,68,68,0.3);border-radius:24px;padding:32px;max-width:440px;width:90%;position:relative;animation:sosModalIn 0.4s ease">
    <!-- Close -->
    <button onclick="closeSOS()" style="position:absolute;top:14px;right:14px;background:rgba(255,255,255,0.06);border:none;color:rgba(255,255,255,0.5);width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center">✕</button>

    <!-- Header -->
    <div style="text-align:center;margin-bottom:24px">
      <div id="sosPulseRing" style="width:80px;height:80px;margin:0 auto 16px;position:relative">
        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#dc2626,#991b1b);display:flex;align-items:center;justify-content:center;font-size:32px;position:relative;z-index:2;animation:sosBtnPulse 1.5s infinite">🆘</div>
        <div style="position:absolute;inset:-8px;border-radius:50%;border:2px solid rgba(239,68,68,0.4);animation:sosRingPulse 1.5s infinite"></div>
        <div style="position:absolute;inset:-18px;border-radius:50%;border:1px solid rgba(239,68,68,0.2);animation:sosRingPulse 1.5s infinite 0.3s"></div>
      </div>
      <h2 style="font-size:20px;font-weight:700;color:#f87171;margin-bottom:4px">EMERGENCY SOS ACTIVATED</h2>
      <p id="sosStatus" style="font-size:12px;color:rgba(255,255,255,0.4)">Fetching your location...</p>
    </div>

    <!-- Location Info -->
    <div id="sosLocationCard" style="display:none;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:14px;padding:16px;margin-bottom:20px">
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px">
        <i class="fa-solid fa-location-dot" style="color:#f87171;font-size:16px"></i>
        <span style="font-size:12px;font-weight:600;color:rgba(255,255,255,0.7)">Your Live Location</span>
        <span style="margin-left:auto;font-size:10px;color:#22c55e;background:rgba(34,197,94,0.1);padding:2px 8px;border-radius:20px"><span style="display:inline-block;width:6px;height:6px;background:#22c55e;border-radius:50%;margin-right:4px;animation:blink 1s infinite"></span>LIVE</span>
      </div>
      <div style="display:flex;gap:12px;margin-bottom:12px">
        <div style="flex:1;background:rgba(255,255,255,0.03);border-radius:10px;padding:10px">
          <div style="font-size:9px;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Latitude</div>
          <div id="sosLat" style="font-size:14px;font-weight:700;color:#e91e8c;font-family:monospace">—</div>
        </div>
        <div style="flex:1;background:rgba(255,255,255,0.03);border-radius:10px;padding:10px">
          <div style="font-size:9px;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Longitude</div>
          <div id="sosLng" style="font-size:14px;font-weight:700;color:#7c3aed;font-family:monospace">—</div>
        </div>
      </div>
      <a id="sosMapLink" href="#" target="_blank" style="display:block;text-align:center;font-size:11px;color:#60a5fa;text-decoration:none;background:rgba(96,165,250,0.08);padding:8px;border-radius:8px;transition:background 0.2s" onmouseover="this.style.background='rgba(96,165,250,0.15)'" onmouseout="this.style.background='rgba(96,165,250,0.08)'">
        <i class="fa-solid fa-map-location-dot" style="margin-right:4px"></i> View on Google Maps
      </a>
    </div>

    <!-- Timestamp -->
    <div id="sosTimestamp" style="display:none;text-align:center;font-size:10px;color:rgba(255,255,255,0.3);margin-bottom:16px">
      <i class="fa-regular fa-clock" style="margin-right:4px"></i> Triggered at <span id="sosTime"></span>
    </div>

    <!-- Action Buttons -->
    <div id="sosActions" style="display:none;flex-direction:column;gap:10px">
      <button onclick="shareWhatsApp()" style="width:100%;padding:14px;border:none;border-radius:12px;background:#25D366;color:#fff;font-size:14px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:transform 0.2s,box-shadow 0.2s" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(37,211,102,0.3)'" onmouseout="this.style.transform='none';this.style.boxShadow='none'">
        <i class="fa-brands fa-whatsapp" style="font-size:18px"></i> Share Location via WhatsApp
      </button>
      <div style="display:flex;gap:10px">
        <button onclick="copyLocation()" id="sosCopyBtn" style="flex:1;padding:12px;border:1px solid rgba(255,255,255,0.1);border-radius:12px;background:rgba(255,255,255,0.05);color:#fff;font-size:12px;font-weight:600;cursor:pointer;transition:all 0.2s" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
          <i class="fa-regular fa-copy" style="margin-right:4px"></i> Copy Location
        </button>
        <a href="tel:112" style="flex:1;padding:12px;border:1px solid rgba(239,68,68,0.2);border-radius:12px;background:rgba(239,68,68,0.1);color:#f87171;font-size:12px;font-weight:600;text-decoration:none;text-align:center;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:4px" onmouseover="this.style.background='rgba(239,68,68,0.2)'" onmouseout="this.style.background='rgba(239,68,68,0.1)'">
          <i class="fa-solid fa-phone"></i> Call 112
        </a>
      </div>
      <button onclick="shareSMS()" style="width:100%;padding:12px;border:1px solid rgba(255,255,255,0.08);border-radius:12px;background:rgba(255,255,255,0.03);color:rgba(255,255,255,0.6);font-size:12px;font-weight:600;cursor:pointer;transition:all 0.2s" onmouseover="this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.background='rgba(255,255,255,0.03)'">
        <i class="fa-solid fa-message" style="margin-right:4px"></i> Share via SMS
      </button>
    </div>

    <!-- Error state -->
    <div id="sosError" style="display:none;text-align:center;padding:16px">
      <p style="color:#f87171;font-size:13px;margin-bottom:12px" id="sosErrorMsg"></p>
      <button onclick="activateSOS()" style="padding:10px 24px;border:1px solid rgba(239,68,68,0.3);border-radius:10px;background:rgba(239,68,68,0.1);color:#f87171;font-size:12px;font-weight:600;cursor:pointer">
        <i class="fa-solid fa-rotate-right" style="margin-right:4px"></i> Retry
      </button>
    </div>
  </div>
</div>

<style>
@keyframes sosModalIn{from{opacity:0;transform:scale(0.9) translateY(20px)}to{opacity:1;transform:scale(1) translateY(0)}}
@keyframes sosBtnPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}
@keyframes sosRingPulse{0%{transform:scale(1);opacity:0.6}100%{transform:scale(1.4);opacity:0}}
@keyframes blink{0%,100%{opacity:1}50%{opacity:0.3}}
</style>

<script>
let sosLat = null, sosLng = null;

function activateSOS() {
  const modal = document.getElementById('sosModal');
  modal.style.display = 'flex';
  document.getElementById('sosLocationCard').style.display = 'none';
  document.getElementById('sosActions').style.display = 'none';
  document.getElementById('sosTimestamp').style.display = 'none';
  document.getElementById('sosError').style.display = 'none';
  document.getElementById('sosStatus').textContent = 'Fetching your location...';

  if (!navigator.geolocation) {
    showSOSError('Geolocation is not supported by your browser.');
    return;
  }

  navigator.geolocation.getCurrentPosition(
    function(pos) {
      sosLat = pos.coords.latitude.toFixed(6);
      sosLng = pos.coords.longitude.toFixed(6);

      document.getElementById('sosLat').textContent = sosLat;
      document.getElementById('sosLng').textContent = sosLng;
      document.getElementById('sosMapLink').href = 'https://www.google.com/maps?q=' + sosLat + ',' + sosLng;
      document.getElementById('sosStatus').textContent = 'Location captured — share with your emergency contacts';
      document.getElementById('sosStatus').style.color = '#22c55e';

      const now = new Date();
      document.getElementById('sosTime').textContent = now.toLocaleTimeString('en-IN', {hour:'2-digit',minute:'2-digit',second:'2-digit'}) + ' — ' + now.toLocaleDateString('en-IN');
      document.getElementById('sosTimestamp').style.display = 'block';

      document.getElementById('sosLocationCard').style.display = 'block';
      document.getElementById('sosActions').style.display = 'flex';
    },
    function(err) {
      let msg = 'Unable to fetch location. ';
      if (err.code === 1) msg += 'Please allow location access in your browser.';
      else if (err.code === 2) msg += 'Location unavailable. Check your GPS.';
      else if (err.code === 3) msg += 'Location request timed out. Try again.';
      showSOSError(msg);
    },
    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
  );
}

function showSOSError(msg) {
  document.getElementById('sosStatus').textContent = 'Failed to get location';
  document.getElementById('sosStatus').style.color = '#f87171';
  document.getElementById('sosErrorMsg').textContent = msg;
  document.getElementById('sosError').style.display = 'block';
}

function shareWhatsApp() {
  const msg = '🆘 *SOS EMERGENCY — SheShield Alert*%0A%0A' +
    '⚠️ I need immediate help!%0A%0A' +
    '📍 *My Live Location:*%0A' +
    'Latitude: ' + sosLat + '%0A' +
    'Longitude: ' + sosLng + '%0A%0A' +
    '🗺️ *Google Maps:*%0A' +
    'https://www.google.com/maps?q=' + sosLat + ',' + sosLng + '%0A%0A' +
    '🕐 Time: ' + new Date().toLocaleString('en-IN') + '%0A' +
    '— Sent via SheShield 🛡️';
  window.open('https://wa.me/?text=' + msg, '_blank');
}

function shareSMS() {
  const msg = 'SOS EMERGENCY! I need help. My location: https://www.google.com/maps?q=' + sosLat + ',' + sosLng + ' — Sent via SheShield';
  window.open('sms:?body=' + encodeURIComponent(msg), '_blank');
}

function copyLocation() {
  const text = 'SOS Emergency — My Location: https://www.google.com/maps?q=' + sosLat + ',' + sosLng;
  navigator.clipboard.writeText(text).then(function() {
    const btn = document.getElementById('sosCopyBtn');
    btn.innerHTML = '<i class="fa-solid fa-check" style="margin-right:4px;color:#22c55e"></i> Copied!';
    btn.style.borderColor = 'rgba(34,197,94,0.3)';
    setTimeout(function() {
      btn.innerHTML = '<i class="fa-regular fa-copy" style="margin-right:4px"></i> Copy Location';
      btn.style.borderColor = 'rgba(255,255,255,0.1)';
    }, 2000);
  });
}

function closeSOS() {
  document.getElementById('sosModal').style.display = 'none';
}
</script>

<?php include __DIR__.'/toast.php'; ?>
</body>
</html>
