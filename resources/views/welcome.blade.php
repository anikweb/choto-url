<!doctype html>
<html lang="en">

<head>
    <title>Choto URL</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            background-color: #f5f5f5;
            background: url("{{ asset('assets/img/background.webp') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center" style="height: 100vh">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="text-success">Choto URL</h3>
                    </div>
                    <div class="card-body">
                        <div class="form group my-2 ">
                            <label for="long_url"><i class="fa-solid fa-link"></i> Long URL</label>
                            <input type="text" id="long_url" class="form-control"
                                placeholder="Enter your long URL here">
                        </div>
                        <div class="form group my-2">
                            <label for="long_url"> Alias <span>Optional</span></label>
                            <input type="text" id="long_url" class="form-control" placeholder="Enter alias">
                        </div>

                        <div class="form-group text-center my-2">
                            <button class="btn btn-success text-center">Shorten URL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('p').click(function() {
                alert('hi')
            })
        })
    </script>
</body>

</html>
