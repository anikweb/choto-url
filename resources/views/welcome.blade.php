<!doctype html>
<html lang="en">

<head>
    <title>Choto URL</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/img/css/loader.css') }}">
    <style>
        body {
            background-color: #f5f5f5;
            background: url("{{ asset('assets/img/background.webp') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .btn-check:focus+.btn-success,
        .btn-success:focus {
            color: #fff;
            background-color: #157347;
            border-color: transparent;
            box-shadow: 0 0 0 0.25rem transparent;
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
                        <div id="error-message"></div>
                        <div class="form group my-2 long_url_wrapper">
                            <label for="long_url"><i class="fa-solid fa-link"></i> Long URL</label>
                            <input type="url" id="long_url" class="form-control"
                                placeholder="Enter your long URL here">
                        </div>
                        <div class="form group my-2 alias_wrapper">
                            <label for="alias"> Alias <span>Optional</span></label>
                            <input type="text" id="alias" class="form-control" placeholder="Enter alias">
                        </div>
                        <div class="form group my-2 d-none choto_url_wrapper">
                            <label for="choto_url"> <i class="fa-solid fa-paperclip"></i> Your Choto URL</span></label>
                            <input disabled type="text" id="choto_url" class="form-control" value="choto_url"
                                style="cursor: text" placeholder="Enter alias">
                        </div>

                        <div class="form-group text-center my-2">
                            <button id="submit_url" class="btn btn-success text-center">Shorten URL</button>
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


            $('#submit_url').click(function(event) {

                toggleSpinner();

                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const url = "{{ route('short-url.store') }}"
                const long_url = $("#long_url").val();
                const alias = $("#alias").val();

                const data = {
                    _token: token,
                    long_url: long_url,
                    alias: alias,
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(response) {

                        setTimeout(() => {
                            toggleSpinner(false)
                            if (response) {
                                console.log(response);
                                $("#error-message").html('')
                                $(".alias_wrapper").addClass('d-none');
                                $(".choto_url_wrapper").removeClass('d-none');
                                $("#choto_url").val(response);
                            }

                        }, 1000);

                    },
                    error: function(error) {
                        setTimeout(() => {
                            toggleSpinner(false)
                            console.log(error);
                            let errorHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>${error.responseJSON.message}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>`
                            $("#error-message").html(errorHTML)
                        }, 1000);
                    }
                });
            })
        })

        function toggleSpinner(status = true) {
            if (status) {



                const html = `Processing <span class="ms-2 waveform">
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                </span>`;

                $("#submit_url").html(html).attr('disabled', 'disabled');
            } else {
                $("#submit_url").html("Shorten URL").removeAttr("disabled")

            }
        }
    </script>
</body>

</html>
