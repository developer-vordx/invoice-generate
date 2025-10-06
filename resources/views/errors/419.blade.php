<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Authentication Timeout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'slate-950': '#0f172a',
                        'slate-900': '#1e293b',
                        'slate-800': '#334155',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4">
<div class="max-w-md w-full">
    <!-- Error Card -->
    <div class="bg-slate-900 border border-slate-800 rounded-xl p-8 text-center shadow-2xl">
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-yellow-500 p-4 rounded-xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-white mb-4">419</h1>

        <!-- Error Message -->
        <h2 class="text-2xl font-semibold text-white mb-3">Session Expired</h2>
        <p class="text-slate-400 mb-8 leading-relaxed">
            Your authentication session has expired for security reasons.
            Please refresh the page or log in again to continue.
        </p>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <button onclick="window.location.reload()" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                Refresh Page
            </button>
            <a href="/login" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                Sign In Again
            </a>
            <a href="/" class="block w-full bg-slate-800 hover:bg-slate-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 border border-slate-700">
                Return Home
            </a>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="text-center mt-6">
        <p class="text-slate-500 text-sm">
            Error Code: 419 | Authentication Timeout
        </p>
    </div>
</div>
</body>
</html>
