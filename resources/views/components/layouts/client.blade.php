<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cinema</title>
    <link rel="stylesheet" href="{{ asset('css/client/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/styles.css') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext"
        rel="stylesheet">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        <header class="page-header">
            <h1 class="page-header__title">Идём<span>в</span>кино</h1>
        </header>

        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>