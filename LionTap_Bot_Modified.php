<?php
$BOT_TOKEN = "TOKEN";
$ADMIN_ID = "ID";
$CHANNEL_ID = "Bchanal";
$WEB_APP_URL = "https://lion-tap-webapp-url"; // ← ضع هنا رابط Vercel بعد رفع صفحة HTML

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🦁 Lion Tap Bot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');
        
        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            min-height: 100vh;
        }
        
        .lion-button {
            transition: all 0.2s ease;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }
        
        .lion-button:active {
            transform: scale(0.95);
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        
        .tap-effect {
            position: absolute;
            color: #dc2626;
            font-weight: bold;
            font-size: 1.5rem;
            pointer-events: none;
            animation: tapFloat 1s ease-out forwards;
        }
        
        @keyframes tapFloat {
            0% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-50px); }
        }
        
        .energy-bar {
            background: linear-gradient(90deg, #dc2626, #fbbf24);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .nav-item {
            transition: all 0.3s ease;
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
        }
        
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-lg z-50">
        <div class="flex justify-around py-3">
            <button onclick="showSection('home')" class="nav-item active px-4 py-2 rounded-lg flex flex-col items-center" id="nav-home">
                <i class="fas fa-home text-xl mb-1"></i>
                <span class="text-xs">الرئيسية</span>
            </button>
            <button onclick="showSection('wallet')" class="nav-item px-4 py-2 rounded-lg flex flex-col items-center" id="nav-wallet">
                <i class="fas fa-wallet text-xl mb-1"></i>
                <span class="text-xs">المحفظة</span>
            </button>
            <button onclick="showSection('referrals')" class="nav-item px-4 py-2 rounded-lg flex flex-col items-center" id="nav-referrals">
                <i class="fas fa-users text-xl mb-1"></i>
                <span class="text-xs">الإحالات</span>
            </button>
            <button onclick="showSection('boosts')" class="nav-item px-4 py-2 rounded-lg flex flex-col items-center" id="nav-boosts">
                <i class="fas fa-rocket text-xl mb-1"></i>
                <span class="text-xs">المعززات</span>
            </button>
            <button onclick="showSection('admin')" class="nav-item px-4 py-2 rounded-lg flex flex-col items-center" id="nav-admin">
                <i class="fas fa-cog text-xl mb-1"></i>
                <span class="text-xs">الأدمن</span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 pb-6 px-4">
        <!-- Home Section -->
        <div id="home-section" class="section">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">🦁 Lion Tap</h1>
                <div class="flex justify-center items-center space-x-4 mb-4">
                    <div class="bg-white rounded-full px-4 py-2 shadow-lg">
                        <span class="text-2xl font-bold text-red-600" id="lion-balance">0</span>
                        <span class="text-sm text-gray-600"> LION</span>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <span class="text-lg font-semibold text-gray-700">المستوى </span>
                    <span class="text-xl font-bold text-red-600" id="user-level">1</span>
                </div>
            </div>

            <!-- Lion Button -->
            <div class="flex justify-center mb-8 relative" id="lion-container">
                <button onclick="tapLion()" class="lion-button">
                    <div class="w-64 h-64 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-8xl pulse-animation">
                        🦁
                    </div>
                </button>
            </div>

            <!-- Energy Bar -->
            <div class="card p-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-semibold text-gray-700">⚡ الطاقة</span>
                    <span class="text-sm text-gray-600"><span id="current-energy">1000</span> / 1000</span>
                </div>
                <div class="w-full bg-gray-300 rounded-full h-6">
                    <div class="energy-bar h-6 rounded-full transition-all duration-300" id="energy-bar" style="width: 100%"></div>
                </div>
                <div class="text-xs text-gray-500 mt-1 text-center">تتجدد 1 طاقة كل 3 ثواني</div>
            </div>
        </div>

        <!-- Wallet Section -->
        <div id="wallet-section" class="section hidden">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">💰 المحفظة</h2>
            
            <!-- Balance Cards -->
            <div class="grid grid-cols-1 gap-4 mb-6">
                <div class="card p-6 text-center">
                    <div class="text-4xl mb-2">🦁</div>
                    <div class="text-2xl font-bold text-red-600" id="wallet-lion-balance">0</div>
                    <div class="text-gray-600">LION</div>
                </div>
                <div class="card p-6 text-center">
                    <div class="text-4xl mb-2">💵</div>
                    <div class="text-2xl font-bold text-green-600" id="wallet-usdt-balance">0</div>
                    <div class="text-gray-600">USDT</div>
                </div>
            </div>

            <!-- Exchange Section -->
            <div class="card p-6 mb-6">
                <h3 class="text-xl font-bold mb-4 text-center">🔄 تبديل العملة</h3>
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="text-center">
                        <span class="text-lg font-semibold">10,000 LION</span>
                        <i class="fas fa-arrow-left mx-2 text-red-600"></i>
                        <span class="text-lg font-semibold">0.3 USDT</span>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">كمية LION للتبديل:</label>
                    <input type="number" id="exchange-amount" class="w-full p-3 border rounded-lg" placeholder="10000" min="10000" step="10000">
                </div>
                <button onclick="exchangeCoins()" class="btn-primary w-full py-3 rounded-lg font-semibold">
                    تبديل الآن
                </button>
            </div>

            <!-- Withdrawal Section -->
            <div class="card p-6">
                <h3 class="text-xl font-bold mb-4 text-center">💸 سحب USDT</h3>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">عنوان المحفظة (BEP20):</label>
                    <input type="text" id="withdrawal-address" class="w-full p-3 border rounded-lg" placeholder="0x...">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">المبلغ:</label>
                    <input type="number" id="withdrawal-amount" class="w-full p-3 border rounded-lg" placeholder="0.3" min="0.3" step="0.1">
                </div>
                <button onclick="requestWithdrawal()" class="btn-primary w-full py-3 rounded-lg font-semibold">
                    طلب سحب
                </button>
            </div>
        </div>

        <!-- Referrals Section -->
        <div id="referrals-section" class="section hidden">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">👥 نظام الإحالات</h2>
            
            <!-- Referral Stats -->
            <div class="card p-6 mb-6">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-3xl font-bold text-red-600" id="total-referrals">0</div>
                        <div class="text-gray-600">إجمالي الإحالات</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-green-600" id="referral-earnings">0</div>
                        <div class="text-gray-600">الأرباح LION</div>
                    </div>
                </div>
            </div>

            <!-- Referral Rewards -->
            <div class="card p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">🎁 مكافآت الإحالة</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span>1 إحالة</span>
                        <span class="font-bold text-red-600">200 LION</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span>3 إحالات</span>
                        <span class="font-bold text-red-600">600 LION</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span>6 إحالات</span>
                        <span class="font-bold text-red-600">1,000 LION</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span>10 إحالات</span>
                        <span class="font-bold text-red-600">2,000 LION</span>
                    </div>
                </div>
            </div>

            <!-- Share Link -->
            <div class="card p-6">
                <h3 class="text-lg font-bold mb-4">📤 رابط الدعوة</h3>
                <div class="flex items-center space-x-2 mb-4">
                    <input type="text" id="referral-link" class="flex-1 p-3 border rounded-lg text-sm" readonly value="https://t.me/lion_tap_bot?start=ref123456">
                    <button onclick="copyReferralLink()" class="btn-primary px-4 py-3 rounded-lg">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <button onclick="shareReferralLink()" class="btn-primary w-full py-3 rounded-lg font-semibold">
                    مشاركة الرابط
                </button>
            </div>
        </div>

        <!-- Boosts Section -->
        <div id="boosts-section" class="section hidden">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">🚀 المعززات</h2>
            
            <div class="space-y-4">
                <!-- Tap Power Boost -->
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold">⚡ قوة النقر</h3>
                            <p class="text-gray-600">زيادة LION لكل نقرة</p>
                            <p class="text-sm text-red-600">المستوى <span id="tap-power-level">1</span></p>
                        </div>
                        <div class="text-2xl">👆</div>
                    </div>
                    <button onclick="upgradeTapPower()" class="btn-primary w-full py-3 rounded-lg font-semibold">
                        ترقية - 1000 LION
                    </button>
                </div>

                <!-- Energy Capacity Boost -->
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold">🔋 سعة الطاقة</h3>
                            <p class="text-gray-600">زيادة الطاقة القصوى</p>
                            <p class="text-sm text-red-600">المستوى <span id="energy-capacity-level">1</span></p>
                        </div>
                        <div class="text-2xl">⚡</div>
                    </div>
                    <button onclick="upgradeEnergyCapacity()" class="btn-primary w-full py-3 rounded-lg font-semibold">
                        ترقية - 2000 LION
                    </button>
                </div>

                <!-- Energy Recovery Boost -->
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold">⏱️ سرعة التجديد</h3>
                            <p class="text-gray-600">تسريع تجديد الطاقة</p>
                            <p class="text-sm text-red-600">المستوى <span id="energy-recovery-level">1</span></p>
                        </div>
                        <div class="text-2xl">💨</div>
                    </div>
                    <button onclick="upgradeEnergyRecovery()" class="btn-primary w-full py-3 rounded-lg font-semibold">
                        ترقية - 1500 LION
                    </button>
                </div>
            </div>
        </div>

        <!-- Admin Section -->
        <div id="admin-section" class="section hidden">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">⚙️ لوحة الأدمن</h2>
            
            <!-- Withdrawal Requests -->
            <div class="card p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">💸 طلبات السحب</h3>
                <div id="withdrawal-requests" class="space-y-3">
                    <!-- Withdrawal requests will be populated here -->
                </div>
            </div>

            <!-- Admin Controls -->
            <div class="card p-6">
                <h3 class="text-lg font-bold mb-4">🛠️ إعدادات النظام</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">معدل التبديل (LION لكل USDT):</label>
                        <input type="number" id="exchange-rate" class="w-full p-3 border rounded-lg" value="33333.33">
                    </div>
                    <button onclick="updateExchangeRate()" class="btn-primary w-full py-3 rounded-lg font-semibold">
                        تحديث المعدل
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Game Data
        let gameData = {
            lionBalance: 0,
            usdtBalance: 0,
            energy: 1000,
            maxEnergy: 1000,
            tapPower: 0.5,
            level: 1,
            referrals: 0,
            referralEarnings: 0,
            tapPowerLevel: 1,
            energyCapacityLevel: 1,
            energyRecoveryLevel: 1,
            energyRecoveryRate: 3000, // 3 seconds
            exchangeRate: 33333.33 // LION per USDT
        };

        let withdrawalRequests = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadGameData();
            updateUI();
            startEnergyRecovery();
        });

        // Save/Load Game Data
        function saveGameData() {
            localStorage.setItem('lionTapGameData', JSON.stringify(gameData));
            localStorage.setItem('withdrawalRequests', JSON.stringify(withdrawalRequests));
        }

        function loadGameData() {
            const saved = localStorage.getItem('lionTapGameData');
            if (saved) {
                gameData = { ...gameData, ...JSON.parse(saved) };
            }
            
            const savedRequests = localStorage.getItem('withdrawalRequests');
            if (savedRequests) {
                withdrawalRequests = JSON.parse(savedRequests);
            }
        }

        // UI Functions
        function updateUI() {
            document.getElementById('lion-balance').textContent = formatNumber(gameData.lionBalance);
            document.getElementById('wallet-lion-balance').textContent = formatNumber(gameData.lionBalance);
            document.getElementById('wallet-usdt-balance').textContent = gameData.usdtBalance.toFixed(2);
            document.getElementById('current-energy').textContent = Math.floor(gameData.energy);
            document.getElementById('user-level').textContent = gameData.level;
            document.getElementById('total-referrals').textContent = gameData.referrals;
            document.getElementById('referral-earnings').textContent = formatNumber(gameData.referralEarnings);
            document.getElementById('tap-power-level').textContent = gameData.tapPowerLevel;
            document.getElementById('energy-capacity-level').textContent = gameData.energyCapacityLevel;
            document.getElementById('energy-recovery-level').textContent = gameData.energyRecoveryLevel;
            
            // Update energy bar
            const energyPercentage = (gameData.energy / gameData.maxEnergy) * 100;
            document.getElementById('energy-bar').style.width = energyPercentage + '%';
            
            updateWithdrawalRequests();
        }

        function formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            }
            return Math.floor(num).toString();
        }

        // Navigation
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Remove active class from all nav items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionName + '-section').classList.remove('hidden');
            document.getElementById('nav-' + sectionName).classList.add('active');
        }

        // Game Logic
        function tapLion() {
            if (gameData.energy >= 1) {
                gameData.energy -= 1;
                gameData.lionBalance += gameData.tapPower;
                
                // Update level
                gameData.level = Math.floor(gameData.lionBalance / 10000) + 1;
                
                // Create tap effect
                createTapEffect();
                
                updateUI();
                saveGameData();
            }
        }

        function createTapEffect() {
            const container = document.getElementById('lion-container');
            const effect = document.createElement('div');
            effect.className = 'tap-effect';
            effect.textContent = '+' + gameData.tapPower;
            effect.style.left = Math.random() * 200 + 'px';
            effect.style.top = Math.random() * 100 + 'px';
            container.appendChild(effect);
            
            setTimeout(() => {
                container.removeChild(effect);
            }, 1000);
        }

        function startEnergyRecovery() {
            setInterval(() => {
                if (gameData.energy < gameData.maxEnergy) {
                    gameData.energy += 1;
                    updateUI();
                    saveGameData();
                }
            }, gameData.energyRecoveryRate);
        }

        // Exchange Functions
        function exchangeCoins() {
            const amount = parseInt(document.getElementById('exchange-amount').value);
            if (amount && amount >= 10000 && gameData.lionBalance >= amount) {
                const usdtAmount = amount / gameData.exchangeRate;
                gameData.lionBalance -= amount;
                gameData.usdtBalance += usdtAmount;
                
                updateUI();
                saveGameData();
                
                alert(`تم تبديل ${formatNumber(amount)} LION إلى ${usdtAmount.toFixed(2)} USDT بنجاح!`);
                document.getElementById('exchange-amount').value = '';
            } else {
                alert('الرصيد غير كافي أو المبلغ أقل من الحد الأدنى (10,000 LION)');
            }
        }

        // Withdrawal Functions
        function requestWithdrawal() {
            const address = document.getElementById('withdrawal-address').value;
            const amount = parseFloat(document.getElementById('withdrawal-amount').value);
            
            if (address && amount && amount >= 0.3 && gameData.usdtBalance >= amount) {
                const request = {
                    id: Date.now(),
                    address: address,
                    amount: amount,
                    status: 'pending',
                    timestamp: new Date().toLocaleString('ar-SA')
                };
                
                withdrawalRequests.push(request);
                gameData.usdtBalance -= amount;
                
                updateUI();
                saveGameData();
                
                alert('تم إرسال طلب السحب للمراجعة!');
                document.getElementById('withdrawal-address').value = '';
                document.getElementById('withdrawal-amount').value = '';
            } else {
                alert('تأكد من صحة البيانات والرصيد الكافي');
            }
        }

        function updateWithdrawalRequests() {
            const container = document.getElementById('withdrawal-requests');
            container.innerHTML = '';
            
            if (withdrawalRequests.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center">لا توجد طلبات سحب</p>';
                return;
            }
            
            withdrawalRequests.forEach(request => {
                const div = document.createElement('div');
                div.className = 'p-4 border rounded-lg';
                div.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="font-semibold">${request.amount} USDT</div>
                            <div class="text-sm text-gray-600">${request.address}</div>
                            <div class="text-xs text-gray-500">${request.timestamp}</div>
                        </div>
                        <span class="px-2 py-1 rounded text-xs ${request.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : request.status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                            ${request.status === 'pending' ? 'قيد المراجعة' : request.status === 'approved' ? 'مقبول' : 'مرفوض'}
                        </span>
                    </div>
                    ${request.status === 'pending' ? `
                        <div class="flex space-x-2">
                            <button onclick="approveWithdrawal(${request.id})" class="btn-primary px-3 py-1 rounded text-sm">موافقة</button>
                            <button onclick="rejectWithdrawal(${request.id})" class="bg-red-600 text-white px-3 py-1 rounded text-sm">رفض</button>
                        </div>
                    ` : ''}
                `;
                container.appendChild(div);
            });
        }

        function approveWithdrawal(requestId) {
            const request = withdrawalRequests.find(r => r.id === requestId);
            if (request) {
                request.status = 'approved';
                updateUI();
                saveGameData();
                alert('تم قبول طلب السحب!');
            }
        }

        function rejectWithdrawal(requestId) {
            const request = withdrawalRequests.find(r => r.id === requestId);
            if (request) {
                request.status = 'rejected';
                gameData.usdtBalance += request.amount; // Return money
                updateUI();
                saveGameData();
                alert('تم رفض طلب السحب وإرجاع المبلغ!');
            }
        }

        // Referral Functions
        function copyReferralLink() {
            const link = document.getElementById('referral-link');
            link.select();
            document.execCommand('copy');
            alert('تم نسخ الرابط!');
        }

        function shareReferralLink() {
            const link = document.getElementById('referral-link').value;
            if (navigator.share) {
                navigator.share({
                    title: '🦁 Lion Tap - اربح العملات المشفرة!',
                    text: 'انضم إلي في Lion Tap واربح LION مجاناً!',
                    url: link
                });
            } else {
                copyReferralLink();
            }
        }

        // Boost Functions
        function upgradeTapPower() {
            const cost = 1000 * gameData.tapPowerLevel;
            if (gameData.lionBalance >= cost) {
                gameData.lionBalance -= cost;
                gameData.tapPowerLevel++;
                gameData.tapPower = 0.5 * gameData.tapPowerLevel;
                
                updateUI();
                saveGameData();
                alert('تم ترقية قوة النقر!');
            } else {
                alert('الرصيد غير كافي!');
            }
        }

        function upgradeEnergyCapacity() {
            const cost = 2000 * gameData.energyCapacityLevel;
            if (gameData.lionBalance >= cost) {
                gameData.lionBalance -= cost;
                gameData.energyCapacityLevel++;
                gameData.maxEnergy = 1000 + (500 * (gameData.energyCapacityLevel - 1));
                
                updateUI();
                saveGameData();
                alert('تم ترقية سعة الطاقة!');
            } else {
                alert('الرصيد غير كافي!');
            }
        }

        function upgradeEnergyRecovery() {
            const cost = 1500 * gameData.energyRecoveryLevel;
            if (gameData.lionBalance >= cost) {
                gameData.lionBalance -= cost;
                gameData.energyRecoveryLevel++;
                gameData.energyRecoveryRate = Math.max(1000, 3000 - (500 * (gameData.energyRecoveryLevel - 1)));
                
                updateUI();
                saveGameData();
                alert('تم ترقية سرعة التجديد!');
            } else {
                alert('الرصيد غير كافي!');
            }
        }

        // Admin Functions
        function updateExchangeRate() {
            const newRate = parseFloat(document.getElementById('exchange-rate').value);
            if (newRate && newRate > 0) {
                gameData.exchangeRate = newRate;
                saveGameData();
                alert('تم تحديث معدل التبديل!');
            }
        }

        // Add some test data for demonstration
        function addTestData() {
            gameData.lionBalance = 50000;
            gameData.usdtBalance = 1.5;
            gameData.referrals = 5;
            gameData.referralEarnings = 1000;
            updateUI();
            saveGameData();
        }

        // Uncomment the line below to add test data
        // addTestData();
    </script>
</body>
</html>
