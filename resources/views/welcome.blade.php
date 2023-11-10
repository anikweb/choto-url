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
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    {{-- Add favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    {{-- Add font --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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
            <div class="col-xl-5 col-md-8 col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h2 class="text-success">Choto URL</h2>
                    </div>
                    <div class="card-body">
                        <div id="error-message"></div>
                        <div class="form group my-2 long_url_wrapper">
                            <label for="long_url"><i class="lni lni-link"></i> Long URL</label>
                            <input type="url" id="long_url" class="form-control" placeholder="Enter URL">
                        </div>
                        <div class="form group my-2 alias_wrapper">
                            <label for="alias"> Alias <span><small>(Optional)</small></span></label>
                            <input type="text" id="alias" class="form-control" placeholder="Enter alias">
                        </div>
                        <div class="form group my-2 d-none choto_url_wrapper">
                            <label for="choto_url"> <i class="fa-solid fa-paperclip"></i> Your Choto URL</span></label>
                            <input disabled type="text" id="choto_url" class="form-control" value="choto_url"
                                style="cursor: text" placeholder="Enter alias">
                        </div>

                        <div class="generatedBtn"></div>

                        <div class="form-group text-center my-2 submit_btn_wrapper">
                            <button id="submit_url" class="btn main-btn btn-success text-center">Shorten URL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- QR Modal  --}}

    <div class="modal fade " id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                    <button type="button" class="close main-btn btn text-white closeModalButton" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <canvas id="qrcode" style="overflow: hidden"></canvas>
                </div>
                <div class="modal-footer d-flex justify-content-center">

                    <a id="downloadLink" class="btn btn-success" download="qrcode.png"><i class="lni lni-download"></i>
                        Download</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


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
                            if (response.status) {
                                console.log(response);
                                $("#error-message").html('')
                                $(".alias_wrapper").addClass('d-none');
                                $(".choto_url_wrapper").removeClass('d-none');
                                $("#choto_url").val(response.data.short_url);
                                $("#long_url").attr('disabled', 'disabled');

                                $(".submit_btn_wrapper").html(
                                    `<a  href="{{ url('/') }}" class="btn btn-success text-center main-btn">Shorten Another</a>`
                                )

                                // generated btn
                                $(".generatedBtn").html(generateBtn(response.data
                                    .short_url))


                            } else {
                                let errorHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>${response.message}</span>
                            <button type="button" class="btn-close main-btn" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>`
                                $("#error-message").html(errorHTML)
                            }

                        }, 1000);

                    },
                    error: function(error) {
                        setTimeout(() => {
                            toggleSpinner(false)
                            console.log(error);
                            let errorHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>${error.responseJSON.message}</span>
                            <button type="button" class="btn-close main-btn" data-bs-dismiss="alert"
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

        function generateBtn(url) {
            let html =
                `
        <button onclick="copyToClipboard('${url}', this)" class="btn secondary-btn btn-success my-1" data-toggle="tooltip" data-placement="top" title="Copied!"><i class="lni lni-clipboard"></i> Copy</button>
        <button onclick="generateQRCode('${url}',this)" class="btn secondary-btn btn-primary my-1"><i class="fa-solid fa-qrcode"></i> QR Code</button>
        <a href="${url}" target="_blank" class="btn btn-primary secondary-btn my-1"><i class="fa-solid fa-share"></i> Visit</a>`;
            return html;
        }

        function copyToClipboard(text, btnElement) {
            navigator.clipboard.writeText(text).then(function() {
                console.log('Copying to clipboard was successful!');
                $(btnElement).tooltip('show');
                setTimeout(function() {
                    $(btnElement).tooltip('hide');
                }, 2000);
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        function generateQRCode(url, btn) {

            const html = `<i class="fa-solid fa-qrcode"></i> Generating QR <span class="ms-2 waveform">
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                    <div class="wave-bar"></div>
                                </span>`;
            $(btn).html(html).attr('disabled', 'disabled');

            let tempElem = document.createElement('div');

            let qrcode = new QRCode(tempElem, {
                text: url,
                width: 400,
                height: 400,
                colorDark: "#000000",
                colorLight: "#ffffff"
            });

            let qrCanvas = tempElem.querySelector('canvas');
            let largerCanvas = document.getElementById('qrcode');
            largerCanvas.width = 420;
            largerCanvas.height = 420;

            let ctx = largerCanvas.getContext('2d');
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, largerCanvas.width, largerCanvas.height);
            ctx.drawImage(qrCanvas, 10, 10);

            let img = largerCanvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
            let link = document.getElementById('downloadLink');
            link.href = img;

            setTimeout(() => {
                $(btn).html(`<i class="fa-solid fa-qrcode"></i> QR Code`).removeAttr('disabled');
                $('#qrModal').modal('show');
            }, 1500);
        }



        $('.closeModalButton').click(function() {
            $('#qrModal').modal('hide');
        });
    </script>
</body>

</html>
