<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaraPoultry</title>
</head>
<body>
    <nav class="flex justify-between items-center mb-4">
        <a href="/"
            ><img class="w-24" src="{{asset('storage/images/icon.png')}}" alt="" class="logo"
        /></a>
        <ul class="flex space-x-6 mr-6 text-lg">
            <li>
                <span class="font-bold uppercase">
                    Welcome 
                </span>
            </li>
            <li>
                <a href="/" class="hover:text-laravel"
                    ><i class="fa-solid fa-gear"></i>
                    Manage Listing</a
                >
            </li>
            <li>
                <form class="inline" method="POST" action="/logout">
                    @csrf
                    <button type="submit">
                        <i class="fa-solid fa-door-closed"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
    
</body>
</html>