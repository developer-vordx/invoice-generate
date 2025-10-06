<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
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
            <div class="bg-red-500 p-4 rounded-xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <h1 class="text-6xl font-bold text-white mb-4">404</h1>

        <!-- Error Message -->
        <h2 class="text-2xl font-semibold text-white mb-3">Page Not Found</h2>
        <p class="text-slate-400 mb-8 leading-relaxed">
            Sorry, the page you are looking for doesn't exist or has been moved.
            Please check the URL or navigate back to the homepage.
        </p>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <button onclick="history.back()" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                Go Back
            </button>
            <a href="/" class="block w-full bg-slate-800 hover:bg-slate-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 border border-slate-700">
                Return Home
            </a>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="text-center mt-6">
        <p class="text-slate-500 text-sm">
            Error Code: 404 | Not Found
        </p>
    </div>
</div>
</body>
</html>
