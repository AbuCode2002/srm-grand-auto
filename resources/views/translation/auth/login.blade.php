<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login page</title>
    <link href="https://fonts.googleapis.com/css?family=Asap" rel="stylesheet">
    <link href="{{asset('assets/css/login.css')}}" rel="stylesheet">
    <script>
        window.console = window.console || function (t) {
        };
    </script>
    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>


</head>

<body translate="no">
<form class="login" method="POST" action="{{ route('login') }}">
    @csrf
    <x-message/>
    <p>Вход</p>
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <button>Login</button>
</form>

</body>

</html>

