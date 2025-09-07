@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important
        }

        label {
            float: left;
        }

        .course {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            max-width: 100%;
            margin: 20px;
            overflow: hidden;
            width: 700px;
        }

        .course h6 {
            opacity: 0.6;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .course h2 {
            letter-spacing: 1px;
            margin: 10px 0;
        }

        .course-preview {
            background-color: #2A265F;
            color: #fff;
            padding: 30px;
            max-width: 250px;
            width: 324px;
        }

        .course-preview a {
            color: #fff;
            display: inline-block;
            font-size: 12px;
            opacity: 0.6;
            margin-top: 30px;
            text-decoration: none;
        }

        .course-info {
            padding: 30px;
            position: relative;
            width: 100%;
            height: 230px;
        }

        .progress-container {
            position: absolute;
            top: 30px;
            right: 30px;
            text-align: right;
            width: 150px;
        }

        .progress {
            background-color: #ddd;
            border-radius: 3px;
            height: 5px;
            width: 100%;
        }

        .progress::after {
            border-radius: 3px;
            background-color: #2A265F;
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 5px;
            width: 66%;
        }

        .progress-text {
            font-size: 10px;
            opacity: 0.6;
            letter-spacing: 1px;
        }

        .btn-course {
            background-color: #2A265F;
            border: 0;
            border-radius: 50px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
            color: #fff;
            font-size: 16px;
            padding: 12px 25px;
            position: absolute;
            bottom: 30px;
            right: 30px;
            letter-spacing: 1px;
        }

        /* SOCIAL PANEL CSS */
        .social-panel-container {
            position: fixed;
            right: 0;
            bottom: 80px;
            transform: translateX(100%);
            transition: transform 0.4s ease-in-out;
        }

        .social-panel-container.visible {
            transform: translateX(-10px);
        }

        .social-panel {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 16px 31px -17px rgba(0, 31, 97, 0.6);
            border: 5px solid #001F61;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Muli';
            position: relative;
            height: 169px;
            width: 370px;
            max-width: calc(100% - 10px);
        }

        .social-panel button.close-btn {
            border: 0;
            color: #97A5CE;
            cursor: pointer;
            font-size: 20px;
            position: absolute;
            top: 5px;
            right: 5px;
        }

        .social-panel button.close-btn:focus {
            outline: none;
        }

        .social-panel p {
            background-color: #001F61;
            border-radius: 0 0 10px 10px;
            color: #fff;
            font-size: 14px;
            line-height: 18px;
            padding: 2px 17px 6px;
            position: absolute;
            top: 0;
            left: 50%;
            margin: 0;
            transform: translateX(-50%);
            text-align: center;
            width: 235px;
        }

        .social-panel p i {
            margin: 0 5px;
        }

        .social-panel p a {
            color: #FF7500;
            text-decoration: none;
        }

        .social-panel h4 {
            margin: 20px 0;
            color: #97A5CE;
            font-family: 'Muli';
            font-size: 14px;
            line-height: 18px;
            text-transform: uppercase;
        }

        .social-panel ul {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .social-panel ul li {
            margin: 0 10px;
        }

        .social-panel ul li a {
            border: 1px solid #DCE1F2;
            border-radius: 50%;
            color: #001F61;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            width: 50px;
            text-decoration: none;
        }

        .social-panel ul li a:hover {
            border-color: #FF6A00;
            box-shadow: 0 9px 12px -9px #FF6A00;
        }

        .floating-btn {
            border-radius: 26.5px;
            background-color: #001F61;
            border: 1px solid #001F61;
            box-shadow: 0 16px 22px -17px #03153B;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            line-height: 20px;
            padding: 12px 20px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .floating-btn:hover {
            background-color: #ffffff;
            color: #001F61;
        }

        .floating-btn:focus {
            outline: none;
        }

        .floating-text {
            background-color: #001F61;
            border-radius: 10px 10px 0 0;
            color: #fff;
            font-family: 'Muli';
            padding: 7px 15px;
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 998;
        }

        .floating-text a {
            color: #FF7500;
            text-decoration: none;
        }

        @media screen and (max-width: 480px) {

            .social-panel-container.visible {
                transform: translateX(0px);
            }

            .floating-btn {
                right: 10px;
            }
        }

        .one-line-limit {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .avatar-initial {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            /* Adjust size as needed */
            height: 60px;
            /* Adjust size as needed */
            font-size: 43px;
            font-weight: bold;
            color: #fff;
            /* Text color */
            background-color: #007bff;
            /* Primary background color */
            border-radius: 50%;
            /* Rounded circle */
            padding: 70px !important
        }


        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            background-color: rgba(255, 255, 255, 0.08) !important;
            border: .1px solid rgb(255 255 255 / 42%) !important;
            color: white !important;
            display: flex;
            border-radius: 20px;
        }

        .img-fluid-slider {
            border-radius: 20px;
        }

        @media (max-width: 779px) {
            main {
                max-width: 90%;
                margin: 0 auto;
            }

            article {
                flex-direction: column;
            }

            article img {
                width: 100%;
                margin-bottom: 20px;
            }

            .myswiperpc {
                display: none !important;
            }

            .myswipermobile {
                display: block !important;
            }

            #swipermobile {
                display: block !important;
            }

            .article-mobile {
                margin: 0;
            }

            .col-8-mobile-article {
                padding: 0 !important;
            }

        }
        #summernote-container {
            position: relative;
            z-index: 10; /* Pastikan Summernote berada di atas elemen lain */
        }

        #summernote {
            z-index: 10;
        }

        .img-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            border-radius: 15px; /* Jika ingin rounded */
            overflow: hidden;
        }

        .img-fluid-slider {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;  /* Pastikan gambar mempertahankan proporsinya */
            object-position: center; /* Posisikan di tengah */
            margin-left: 10px
        }
        .swiper-pagination-bullet-active {
            background: #3C3C3C!important;
            width: 20px!important;
            border-radius: 5px!important;
        }

        .swiper-pagination-bullet {
            background: #3C3C3C!important;
        }

        
        .two-line-limit {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 779px) {
            .swiper-slide{
                background: transparent!important;
                border: none!important;
            }
            .card-mobile {
                display: block;
            }

            .progress-text {
                font-size: 13px;
                opacity: 0.6;
                letter-spacing: 1px;
            }

            .btn-course {
                position: revert !important;
                float: right
            }
            .img-sidebar{
                height: 200px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @php
        $usr = Auth::guard('admin')->user();
    @endphp
    <div class="main-content-inner">
        @include('backend.layouts-news.partials.message')

        <div class="row">
            <!-- data table start -->
            <div class="col-lg-9">
                <div class="container mb-2">
                    <a href="{{ route('detail.materi', $materi->slug) }}" class="btn btn-danger"
                        style="float: right">Kembali</a>
                    <div class="row" style="margin-top: 2%;">
                        <h4 class="text-white" style="font-size: 1.5em;">Pertanyaan Materi</h4>
                    </div>
                    <div class="row mt-3 ml-5">
                        <div class="card">
                            <div class="card-body">
                                <p>
                                    @php
                                        $createdpertanyaanby = \App\Models\Admin::where(
                                            'id',
                                            $pertanyaan->id_user,
                                        )->first();
                                    @endphp
                                    {{ $createdpertanyaanby->name }} | {{ $pertanyaan->created_at }}
                                </p>
                                <hr>
                                <p>
                                    {!! $pertanyaan->pertanyaan !!}
                                </p>

                                @if ($usr != null)
                                    <a href="#summernote-container" class="btn btn-info" style="float:right" id="jawabBtn">Jawab</a>
                                @else
                                    <a href="{{ url('admin/login') }}" class="btn btn-info" style="float:right">Jawab</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <h4 class="text-white" style="font-size: 1.5em;">Jawaban</h4>
                    </div>
                    @if (count($jawaban) > 0)
                        @if ($usr == null)
                            <!-- Show only one answer and a login button -->
                            <div class="row mt-3 ml-5 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <p>
                                            @php
                                                $createdjawabanby = \App\Models\Admin::where('id', $jawaban->first()->id_user)->first();
                                            @endphp
                                            {{ $createdjawabanby->name }} | {{ $jawaban->first()->created_at }}
                                        </p>
                                        <hr>
                                        <p>
                                            {!! $jawaban->first()->jawaban !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <a href="{{ url('admin/login') }}" class="btn btn-danger">Login untuk melihat jawaban lebih banyak.</a>
                            </center>
                        @else
                            <!-- Show all answers for logged-in users -->
                            @foreach ($jawaban as $jb)
                                <div class="row mt-3 ml-5 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <p>
                                                @php
                                                    $createdjawabanby = \App\Models\Admin::where('id', $jb->id_user)->first();
                                                @endphp
                                                {{ $createdjawabanby->name }} | {{ $jb->created_at }}
                                            </p>
                                            <hr>
                                            <p>
                                                {!! $jb->jawaban !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @else
                    <center>
                        <h5 style="color: red">Tidak Ada jawaban! Jadilah orang pertama yang menjawab pertanyaan ini.</h5>
                    </center>
                    @endif


                    <div id="summernote-container" style="display:none;">
                        <textarea id="summernote"></textarea>
                        <button id="submitJawaban" class="btn btn-success mt-2" style="float: right">Kirim Jawaban</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card mb-4" style="background:transparent;border:2px solid white">
                    <div class="card-body">
                        <div class="customer-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                @php
                                    $usr = Auth::guard('admin')->user();
                                @endphp
                                @if ($usr != null)
                                    @php
                                        $words = explode(' ', $usr->name);
                                        $initials = '';
                                        foreach ($words as $word) {
                                            $initials .= strtoupper($word[0]);
                                        }
                                        // return $initials;
                                    @endphp
                                    <span class="avatar-initial rounded-circle bg-label-primary"
                                        style="font-size: 43px;">{{ $initials }}</span>
                                    <div class="customer-info text-center">
                                        <h4 class="mb-1 mt-2" style="color: white!important">{{ $usr->name }}</h4>
                                    </div>
                                @else
                                    <span class="avatar-initial rounded-circle bg-label-primary"
                                        style="    font-size: 43px;">GS</span>
                                    <h4 class="mb-1 mt-2" style="color: white!important">Guest</h4>
                                    <a href="{{ url('admin/login') }}" class="btn btn-info mt-3">Login</a>
                                @endif

                                <h4 class="mb-1 mt-3 mb-2" style="color: white!important">Pertanyaan Terkini</h4>

                                @foreach ($materi_more_limit as $mm)
                                    <a href="{{ route('detail.materi', $mm->slug) }}">
                                        <div class="card mb-2"
                                            style="width: auto;background:transparent;border:2px solid white;">
                                            <div class="card-body" style="padding: 10px ">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <img src="{{ asset('assets/img/cover/' . $mm->image_cover) }}"
                                                            class="img-fluid img-sidebar" alt="..." style="object-fit: cover; width: 100%;border-radius:10px;margin-bottom : 5px">
                                                    </div>
                                                    <div class="col-lg-8" style="padding-left: 10px !important;">
                                                        <p class="card-text one-line-limit"
                                                            style="margin-bottom: 0px!important;color:white!important">
                                                            {{ $mm->judul }}
                                                        </p>
                                                        <p class="card-text one-line-limit" style="color:white!important">
                                                            @php
                                                                $dataquest = \App\Models\Pertanyaan::where(
                                                                    'id_materi',
                                                                    $mm->id,
                                                                )
                                                                    ->get()
                                                                    ->count();
                                                            @endphp
                                                            {{ $dataquest }} Pertanyaan
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- data table end -->
        </div>
        <hr>

        <div class="container" style="padding-left: 30px;">
            <div class="row" style="margin-top: 2%;">
                <h4 class="text-white" style="font-size: 1.5em;">Materi Lain nya</h4>
            </div>
            <div class="row mt-3">
                <div class="container" style="padding: 0;">

                    <div class="swiper mySwiper myswiperpc">
                        <div class="swiper-wrapper">
                            @foreach ($materi_more as $post)
                                <div class="swiper-slide card__content">
                                    <article class="">
                                        <div class="row" style="width: 100%;min-height: 180px;">
                                            <div class="col-4 align-self-center">
                                                    <img src="{{ asset('assets/img/cover/' . $post->image_cover) }}"
                                                        style="" alt="{{ $post->judul }}" 
                                                        class="mini-cover1 brd-r-15 img-fluid img-fluid-slider">
                                            </div>
                                            <div class="col-8">

                                                <div class="text text-white w-90">
                                                    <a href="{{ route('detail.materi', $post->slug) }}">
                                                        <p class="text-white mt-2 d-flex align-items-center">
                                                            Admin &nbsp; <span class="dot-separate">-</span> &nbsp;
                                                            {{ date('M d, Y', strtotime($post->created_at)) }}
                                                        </p>
                                                    </a>

                                                </div>
                                                <div class="row" style="width: 100%">
                                                    <div class="col-lg-12">
                                                        <p class="text-white mt-2 d-flex align-items-center">
                                                            {{ $post->judul }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row" style="width: 100%">
                                                    <div class="col-lg-11">
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <a class="btn btn-sm btn-primary btn-article"
                                                            href="{{ route('detail.materi', $post->slug) }}"
                                                            style="border-radius: 5px; background: linear-gradient(87.07deg, #1D2E69 -24.25%, #395BCF 116.5%);">></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach


                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="container" style="padding: 0;">

                    <div class="swiper mySwiper mySwipermobile" id="swipermobile" style="display: none">
                        <div class="swiper-wrapper">
                            @foreach ($materi_more as $post)
                                <div class="swiper-slide">
                                    <div class="card mb-3" style="width: auto; height: 400px;">
                                        <div class="image-container" style="height: 200px; overflow: hidden;">
                                            <img src="{{ asset('assets/img/cover/' . $post->image_cover) }}"
                                                class="card-img-top" alt="..."
                                                style="height: 100%; width: 100%; object-fit: cover;">
                                        </div>
                                        <div class="card-body d-flex flex-column justify-content-between"
                                            style="height: 300px;">
                                            <span class="progress-text">
                                                @php
                                                    $dataquest = \App\Models\Pertanyaan::where('id_materi', $post->id)
                                                        ->get()
                                                        ->count();
                                                @endphp
                                                {{ $dataquest }} Pertanyaan | {{ $post->created_at }}
                                            </span>
                                            <h2 class="one-line-limit mt-4 course-title">{{ $post->judul }}</h2>
                                            <p class="two-line-limit">{{ $post->description }}</p>
                                            <a href="{{ route('detail.materi', $post->slug) }}" class="btn-course"
                                                style="margin-top: 10px!important;float:right;text-align:center">Continue</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        function confirmDelete(deleteUrl) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure delete this data?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete URL if confirmed
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Include Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- Include jQuery (required for Summernote) -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <!-- Include Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>


    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1.7,
            spaceBetween: 20,
            freeMode: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
    <script>
        var swiper = new Swiper(".mySwipermobile", {
            slidesPerView: 1.2,
            spaceBetween: 20,
            freeMode: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                // Resolusi untuk layar mobile
                640: {
                    slidesPerView: 1, // 1 slide per view di layar mobile
                    spaceBetween: 10, // Jarak antar slide di layar mobile
                },
                // Resolusi untuk tablet dan di atasnya
                768: {
                    slidesPerView: 1, // 1.5 slide per view di layar tablet
                    spaceBetween: 4, // Jarak antar slide di layar tablet
                },
                // Resolusi untuk desktop dan di atasnya
                1024: {
                    slidesPerView: 1, // 1.7 slide per view di layar desktop
                    spaceBetween: 20, // Jarak antar slide di layar desktop
                }
            }
        });


        $(document).ready(function() {
            // Initialize Summernote
            $('#summernote').summernote({
                height: 200, // Tinggi editor
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ]
            });

            // Klik tombol Jawab
            $('#jawabBtn').click(function(e) {
                e.preventDefault();
                // Scroll ke Summernote dan tampilkan editor
                $('html, body').animate({
                    scrollTop: $('#summernote-container').offset().top
                }, 1000);

                // Menampilkan Summernote
                $('#summernote-container').show();

                // Set data ke Summernote jika sedang mengedit jawaban
                if ($(this).data('edit-id')) {
                    var jawaban = $(this).data('jawaban');
                    $('#summernote').summernote('code', jawaban); // Mengisi editor dengan konten jawaban yang ada

                    // Set URL untuk update (edit jawaban)
                    $('#submitJawaban').data('url', '/edit/jawaban');
                    $('#submitJawaban').data('edit-id', $(this).data('edit-id'));
                } else {
                    $('#summernote').summernote('code', ''); // Kosongkan editor jika baru

                    // Set URL untuk store (jawaban baru)
                    $('#submitJawaban').data('url', '{{ route('store-jawaban') }}');
                }
            });

            // Submit Jawaban ke URL yang ditentukan
            $('#submitJawaban').click(function() {
                var jawaban = $('#summernote').val(); // Ambil konten dari Summernote
                var url = $(this).data('url'); // Ambil URL dari data atribut tombol

                // Tentukan data yang akan dikirim
                var data = {
                    jawaban: jawaban,
                    id_pertanyaan: '{{ $pertanyaan->id }}',
                    _token: '{{ csrf_token() }}' // Pastikan token CSRF disertakan
                };

                // Jika edit, tambahkan ID jawaban yang sedang diedit
                if ($(this).data('edit-id')) {
                    data.id = $(this).data('edit-id');
                }

                // Kirim data ke server menggunakan Ajax
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function(response) {
                        console.log(response);

                        if (response.success) {
                            // Menggunakan SweetAlert untuk sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Jawaban berhasil dikirim',
                                text: 'Jawaban Anda telah berhasil disimpan.',
                            }).then(function() {
                                location.reload(); // Reload halaman setelah jawaban terkirim
                            });
                        } else {
                            // Menggunakan SweetAlert untuk gagal
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal mengirim jawaban',
                                text: 'Terjadi kesalahan saat mengirim jawaban. Coba lagi.',
                            });
                        }
                    },
                    error: function() {
                        // Menggunakan SweetAlert untuk error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Terjadi kesalahan pada server. Coba lagi nanti.',
                        });
                    }
                });
            });
        });

    </script>
@endsection
