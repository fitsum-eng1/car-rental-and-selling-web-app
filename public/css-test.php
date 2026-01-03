<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSS Test - Car Rental System</title>
    
    <!-- Test CSS Loading -->
    <link rel="stylesheet" href="build/assets/app-HUF5mJBU.css">
    <link rel="stylesheet" href="build/assets/app-DmuyVQv5.css">
    <script type="module" src="build/assets/app-CFdEZBK1.js"></script>
    
    <style>
        .test-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 1rem;
            margin: 2rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="max-w-4xl mx-auto py-8">
        <div class="test-box">
            <h1 class="text-4xl font-bold mb-4">🎨 CSS Loading Test</h1>
            <p class="text-xl mb-6">Testing if CSS and animations are working properly</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 mx-4 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Tailwind CSS Test</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg text-center">
                    <h3 class="font-semibold">Blue Box</h3>
                    <p>If you see this styled, Tailwind is working!</p>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg text-center">
                    <h3 class="font-semibold">Green Box</h3>
                    <p>Responsive grid is working!</p>
                </div>
                <div class="bg-purple-500 text-white p-4 rounded-lg text-center">
                    <h3 class="font-semibold">Purple Box</h3>
                    <p>Colors and spacing work!</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 mx-4 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Animation Test</h2>
            <div class="space-y-4">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300 animate-ripple">
                    Hover Me (Should have ripple effect)
                </button>
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 rounded-lg animate__animated animate__fadeInUp">
                    <h3 class="text-xl font-bold">Animated Card</h3>
                    <p>This should fade in from bottom</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 mx-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Navigation Links</h2>
            <div class="space-y-2">
                <a href="/" class="block text-blue-600 hover:text-blue-800 font-medium">🏠 Laravel Home Page</a>
                <a href="working-app.php" class="block text-green-600 hover:text-green-800 font-medium">✅ Working App</a>
                <a href="simple-test.php" class="block text-purple-600 hover:text-purple-800 font-medium">🧪 Simple Test</a>
                <a href="laravel-test.php" class="block text-orange-600 hover:text-orange-800 font-medium">🔧 Laravel Test</a>
            </div>
        </div>
    </div>
    
    <script>
        console.log('CSS Test page loaded');
        console.log('Checking if animations are working...');
        
        // Test if animate.css is loaded
        if (document.querySelector('.animate__animated')) {
            console.log('✅ Animate.css classes found');
        } else {
            console.log('❌ Animate.css classes not found');
        }
        
        // Test if Tailwind is working
        const testElement = document.querySelector('.bg-blue-500');
        if (testElement) {
            const styles = window.getComputedStyle(testElement);
            if (styles.backgroundColor === 'rgb(59, 130, 246)') {
                console.log('✅ Tailwind CSS is working');
            } else {
                console.log('❌ Tailwind CSS not working properly');
            }
        }
    </script>
</body>
</html>