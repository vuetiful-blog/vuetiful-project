<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

        <title>Vuetiful Blog</title>

        <link href="/css/app.css" rel="stylesheet" type="text/css" />


    </head>
    <body>
       <div id="app">

       </div>
       <script src="/js/admin/admin.js"></script>
    </body>
</html>