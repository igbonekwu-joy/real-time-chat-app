<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat App</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    @vite(['resources/css/app.css','resources/css/dist/css/lib/bootstrap.min.css','resources/css/dist/css/swipe.min.css', 'resources/css/dist/img/favicon.png', 'resources/js/js/vendor/popper.min.js', 'resources/js/js/swipe.min.js', 'resources/js/app.js', 'resources/js/chat.js'])
</head>
<body>

     {{ $slot }}


    <script>window.jQuery || document.write('<script src="jquery-slim.min.js"><\/script>')</script>
    <script>
        function scrollToBottom(el) { el.scrollTop = el.scrollHeight; }
        scrollToBottom(document.getElementById('content'));
    </script>
     <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!--web socket connection-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.8.1/socket.io.js"></script>
</body>
</html>
