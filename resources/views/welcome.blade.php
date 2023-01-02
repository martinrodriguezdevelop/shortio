<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/"> -->
    <style>
        :root{
            --main-bg:#0dcaf0;
        }

        .main-bg {
            background: var(--main-bg) !important;
        }

        input:focus, button:focus {
            border: 1px solid var(--main-bg) !important;
            box-shadow: none !important;
        }

        .form-check-input:checked {
            background-color: var(--main-bg) !important;
            border-color: var(--main-bg) !important;
        }

        .card, .btn, input{
            border-radius:0 !important;
        }

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
	<title>Shortener challenge</title>

	<!-- @vite('resources/css/app.css') -->
</head>
    <body class="text-center">
        <div id="app"></div>
    </body>

	@vite('resources/js/app.js')
</body>
</html>