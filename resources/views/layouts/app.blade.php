<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat App</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    @vite(['resources/css/app.css','resources/css/dist/css/lib/bootstrap.min.css','resources/css/dist/css/swipe.min.css', 'resources/css/dist/img/favicon.png', 'resources/js/js/vendor/popper.min.js', 'resources/js/js/bootstrap.min.js', 'resources/js/js/swipe.min.js', 'resources/js/js/jquery-3.3.1.slim.min.js'])
</head>
<body>

     {{ $slot }}

    <script>window.jQuery || document.write('<script src="jquery-slim.min.js"><\/script>')</script>
    <script>
        function scrollToBottom(el) { el.scrollTop = el.scrollHeight; }
        scrollToBottom(document.getElementById('content'));
    </script>
</body>
</html>
