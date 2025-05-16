<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Bulk message</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-300">
<div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-4 text-center text-gray-800">Send bulk message to the users</h1>
    <form action="{{ route('bot.send_bulk_message.init', ['token' => $token]) }}" method="post">
        @csrf
        <div class="mb-4">
            <label for="message" class="block text-gray-700 text-sm font-medium mb-2">Your Message</label>
            <textarea id="message" name="message" rows="6" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your message here..."></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Send</button>
        </div>
    </form>
    <div class="text-center">
        @if(session('result'))
            <div class="text-green-400">
                {{ session('result') }}
            </div>
        @endif
    </div>
</div>
</body>
</html>
