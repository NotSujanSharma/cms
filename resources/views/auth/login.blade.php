
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCT Student Club - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl flex bg-white rounded-3xl shadow-xl overflow-hidden">
        <!-- Left side with logo -->
        <div class="w-1/2 p-12 flex items-center justify-center bg-white">
            <div class="w-64 h-64 rounded-full bg-navy-900 flex items-center justify-center p-8">
                <img src="https://via.placeholder.com/300" alt="NCT Student Club Logo" class="w-full rounded-full">
            </div>
        </div>

        <!-- Right side with login form -->
        <div class="w-1/2 p-12">
            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-2" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif
            <h2 class="text-3xl font-bold mb-8">Login</h2>
            <form  method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        name="email"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Email">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Password">
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition duration-300">
                    Login
                </button>
                <div class="text-center">
                    <a href="#" class="text-blue-500 text-sm hover:underline">Forgot Password?</a>
                </div>
                <div class="text-center text-sm">
                    <span class="text-gray-600">Don't have an account?</span>
                    <a href="#" class="text-blue-500 hover:underline ml-1">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>