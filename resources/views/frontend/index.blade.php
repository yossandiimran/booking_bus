<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Bus</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ asset('assets/frontend/font-awesome-4.7.0/css/font-awesome.min.css')}}">    
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css')}}">                      
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/slick/slick.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/slick/slick-theme.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/datepicker.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/tooplate-style.css')}}">                          
</head>

    <body>
        <div class="tm-main-content" id="top">
            <div class="tm-top-bar-bg"></div>
            <div class="tm-top-bar" id="tm-top-bar">
                <!-- Top Navbar -->
                <div class="container">
                    <div class="row">
                        
                        <nav class="navbar navbar-expand-lg narbar-light">
                            <a class="navbar-brand mr-auto" href="#">
                                <img src="{{ asset('assets/frontend/img/logo.png')}}" alt="Site logo">
                                Bus Padang
                            </a>
                            <button type="button" id="nav-toggle" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div id="mainNav" class="collapse navbar-collapse tm-bg-white">
                                <ul class="navbar-nav ml-auto">
                                  <li class="nav-item">
                                    <a class="nav-link" href="#top">Home <span class="sr-only">(current)</span></a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#tm-section-4">Destinasi</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#tm-section-5">Armada</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#tm-section-6">Cek Booking</a>
                                  </li>
                                </ul>
                            </div>                            
                        </nav>            
                    </div>
                </div>
            </div>
            <div class="tm-section tm-bg-img" id="tm-section-1">
                <div class="tm-bg-white ie-container-width-fix-2">
                    <div class="container ie-h-align-center-fix">
                        <div class="row">
                            <div class="col-xs-12 ml-auto mr-auto ie-container-width-fix">
                                <form action="{{route('prosesFormFe')}}" method="post" class="tm-search-form tm-section-pad-2">
                                    @csrf
                                    <div class="form-row tm-search-form-row">
                                        <div class="form-group tm-form-element tm-form-element-100">
                                            <i class="fa fa-map-marker fa-2x tm-form-element-icon"></i>
                                            <input name="lokasi" type="text" class="form-control" id="lokasi" placeholder="Kemana anda akan pergi ?" required>
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-50">
                                            <i class="fa fa-calendar fa-2x tm-form-element-icon"></i>
                                            <input name="tgl_berangkat" type="date" class="form-control" id="tgl_berangkat" placeholder="Tanggal Pergi" required>
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-50">
                                            <i class="fa fa-calendar fa-2x tm-form-element-icon"></i>
                                            <input name="tgl_kembali" type="date" class="form-control" id="tgl_kembali" placeholder="Tanggal Kembali" required>
                                        </div>
                                    </div>
                                    <div class="form-row tm-search-form-row">
                                        <div class="form-group tm-form-element tm-form-element-4">                                            
                                            <select name="bus" class="form-control tm-select" id="bus">
                                                <option value="">Pilih Kelas Bus</option>
                                                @foreach($type_bus as $bs)
                                                <option value="{{ $bs }}">{{ $bs }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fa fa-2x fa-bus tm-form-element-icon"></i>
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-4">                                            
                                            <input name="jumlahSeat" type="number" class="form-control" id="jumlahSeat" placeholder="Jumlah Penumpang" required>
                                            <i class="fa fa-user tm-form-element-icon tm-form-element-icon-small"></i>
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-4">
                                            <button type="submit" class="btn btn-primary tm-btn-search">Cek Ketersediaan</button>
                                        </div>
                                      </div>
                                      <div class="form-row clearfix pl-2 pr-2 tm-fx-col-xs">
                                          <p class="tm-margin-b-0"><i> *) syarat dan ketentuan berlaku </i></p>
                                          <a href="#" class="ie-10-ml-auto ml-auto mt-1 tm-font-semibold tm-color-primary">Butuh Bantuan?</a>
                                      </div>
                                </form>
                            </div>                        
                        </div>      
                    </div>
                </div>                  
            </div>
            
            <div class="tm-section-2">
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <h2 class="tm-section-title">Mengapa Harus Bus Padang ?</h2>
                            <p class="tm-color-white tm-section-subtitle">Kami melayani dengan sepenuh hati</p>
                        </div>                
                    </div>
                </div>        
            </div>
            
            <div class="tm-section tm-position-relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" class="tm-section-down-arrow">
                    <polygon fill="#ee5057" points="0,0  100,0  50,60"></polygon>                   
                </svg> 
                <div class="container tm-pt-5 tm-pb-4">
                    <div class="row text-center">
                        <article class="col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-article">                            
                            <i class="fa tm-fa-6x fa-bus tm-color-primary tm-margin-b-20"></i>
                            <h3 class="tm-color-primary tm-article-title-1">Armada Bus</h3>
                            <p>Kami memiliki armada bus terbaik dengan bus bus keluaran terbaru dan pastinya tangguh di segala medan.</p>
                        </article>
                        <article class="col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-article">                            
                            <i class="fa tm-fa-6x fa-money tm-color-primary tm-margin-b-20"></i>
                            <h3 class="tm-color-primary tm-article-title-1">Harga Bersaing</h3>
                            <p>Kami memiliki komitmen untuk persaingan harga dan juga memberikan kualitas seusai harga yang kami tawarkan.</p>
                        </article>
                        <article class="col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-article">                           
                            <i class="fa tm-fa-6x fa-image tm-color-primary tm-margin-b-20"></i>
                            <h3 class="tm-color-primary tm-article-title-1">Rekomendasi wisata</h3>
                            <p>Butuh rekomendasi destinasi tujuan? tenang, kami bisa memberikan beberapa rekomendasi yang tepat untuk perjalanan anda .</p>
                        </article>
                    </div>        
                </div>
            </div>
            
            <div class="tm-section tm-section-pad tm-bg-gray" id="tm-section-4">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                            <div class="tm-article-carousel">                     
                                @foreach($tempat as $tmpt)       
                                <article class="tm-bg-white mr-2 tm-carousel-item">
                                    <img src="{{ asset('storage/' . $tmpt->foto) }}" alt="Image" class="img-fluid">
                                    <div class="tm-article-pad">
                                        <header><h3 class="text-uppercase tm-article-title-2">{{ $tmpt["nama_tempat"] }}</h3></header>
                                        <p>{{ $tmpt["keterangan"] }}</p>
                                        <a href="#" class="text-uppercase btn-primary tm-btn-primary">Get More Info.</a>
                                    </div>                                
                                </article>     
                                @endforeach               
                            </div>    
                        </div>
                        
                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 tm-recommended-container">
                            <div class="tm-bg-white">
                                <div class="tm-bg-primary tm-sidebar-pad">
                                    <h3 class="tm-color-white tm-sidebar-title">Rekomendasi Tempat</h3>
                                    <p class="tm-color-white tm-margin-b-0 tm-font-light">beberapa destinasi yang kami rekomendasikan</p>
                                </div>
                                <div class="tm-sidebar-pad-2">
                                    @foreach($tempat as $tmpt2)       
                                    <a href="#" class="media tm-media tm-recommended-item">
                                        <img src="{{ asset('storage/' . $tmpt2->foto) }}" width="80" alt="Image">
                                        <div class="media-body tm-media-body tm-bg-gray">
                                            <h4 class="text-uppercase tm-font-semibold tm-sidebar-item-title">{{ $tmpt2->nama_tempat }}</h4>
                                        </div>                                        
                                    </a>
                                    @endforeach
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <div class="tm-section tm-section-pad tm-bg-img" id="tm-section-5">                                                        
                    <div class="container ie-h-align-center-fix">
                        <div class="row tm-flex-align-center">
                            <div class="col-xs-12 col-md-12 col-lg-3 col-xl-3 tm-media-title-container">
                                <h2 class="text-uppercase tm-section-title-2">Armada</h2>
                                <h3 class="tm-color-primary tm-font-semibold tm-section-subtitle-2">Kami</h3>
                            </div>
                            <div class="col-xs-12 col-md-12 col-lg-9 col-xl-9 mt-0 mt-sm-3">
                                <div class="ml-auto tm-bg-white-shadow tm-pad tm-media-container">
                                    @foreach($bus as $data)
                                    <article class="media tm-margin-b-20 tm-media-1">
                                        <img src="{{ asset('storage/' . $data->foto) }}" alt="Image" width="250">
                                        <div class="media-body tm-media-body-1 tm-media-body-v-center">
                                            <h3 class="tm-font-semibold tm-color-primary tm-article-title-3">{{ $data["bus"] }}</h3>
                                            <p>{{ $data["keterangan"] }}</p>
                                        </div>                                
                                    </article>
                                    @endforeach
                                </div>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
            
            <div class="tm-section tm-section-pad tm-bg-img tm-position-relative" id="tm-section-6">
                <div class="container ie-h-align-center-fix">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-7">
                            <div id="google-map"></div>        
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 mt-3 mt-md-0">
                            <div class="tm-bg-white tm-p-4">
                                <form action="index.html" method="post" class="contact-form">
                                    <div class="form-group">
                                        <input type="text" id="noHp" name="noHp" class="form-control" placeholder="Nomor HP" value="0812334343434" required/>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="kodeBooking" name="kodeBooking" class="form-control" placeholder="Kode Booking" value="BK180724JDNM" required/>
                                    </div>
                                    <button type="button" onclick="checkKodeBooking()" class="btn btn-primary tm-btn-primary">Cek Kode Booking Anda</button>
                                </form>
                            </div>                            
                        </div>
                    </div>        
                </div>
            </div>
            
            <footer class="tm-bg-dark-blue">
                <div class="container">
                    <div class="row">
                        <p class="col-sm-12 text-center tm-font-light tm-color-white p-4 tm-margin-b-0">
                            Copyright &copy; <span class="tm-current-year">2018</span> Bus Padang
                        </p>        
                    </div>
                </div>                
            </footer>
        </div>
        
        <!-- load JS files -->
        <script src="{{ asset('assets/frontend/js/jquery-1.11.3.min.js')}}"></script>          
        <script src="{{ asset('assets/frontend/js/popper.min.js')}}"></script>                  
        <script src="{{ asset('assets/frontend/js/bootstrap.min.js')}}"></script>               
        <script src="{{ asset('assets/frontend/js/jquery.singlePageNav.min.js')}}"></script>     
        <script src="{{ asset('assets/frontend/slick/slick.min.js')}}"></script>     
	    <script src="{{ asset('template/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
        <script>

            function prosesSubmitCekBooking(){
                var lokasi = $('#lokasi').val();
                var tgl_berangkat = $('#tgl_berangkat').val();
                var tgl_kembali = $('#tgl_kembali').val();
                var bus = $('#bus').val();
                var jumlahSeat = $('#jumlahSeat').val(); 
                console.log(lokasi);
                console.log(tgl_berangkat);
                console.log(tgl_kembali);
                console.log(bus);
                console.log(jumlahSeat);
            }

            function setCarousel() {
                
                if ($('.tm-article-carousel').hasClass('slick-initialized')) {
                    $('.tm-article-carousel').slick('destroy');
                } 

                if($(window).width() < 438){
                    // Slick carousel
                    $('.tm-article-carousel').slick({
                        infinite: false,
                        dots: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    });
                }
                else {
                 $('.tm-article-carousel').slick({
                        infinite: false,
                        dots: true,
                        slidesToShow: 2,
                        slidesToScroll: 1
                    });   
                }
            }

            function setPageNav(){
                if($(window).width() > 991) {
                    $('#tm-top-bar').singlePageNav({
                        currentClass:'active',
                        offset: 79
                    });   
                }
                else {
                    $('#tm-top-bar').singlePageNav({
                        currentClass:'active',
                        offset: 65
                    });   
                }
            }

            function togglePlayPause() {
                vid = $('.tmVideo').get(0);

                if(vid.paused) {
                    vid.play();
                    $('.tm-btn-play').hide();
                    $('.tm-btn-pause').show();
                }
                else {
                    vid.pause();
                    $('.tm-btn-play').show();
                    $('.tm-btn-pause').hide();   
                }  
            }
       
            $(document).ready(function(){

                $(window).on("scroll", function() {
                    if($(window).scrollTop() > 100) {
                        $(".tm-top-bar").addClass("active");
                    } else {
                        //remove the background property so it comes transparent again (defined in your css)
                       $(".tm-top-bar").removeClass("active");
                    }
                });      

                // Slick carousel
                setCarousel();
                setPageNav();

                $(window).resize(function() {
                  setCarousel();
                  setPageNav();
                });

                // Close navbar after clicked
                $('.nav-link').click(function(){
                    $('#mainNav').removeClass('show');
                });

                // Control video
                $('.tm-btn-play').click(function() {
                    togglePlayPause();                                      
                });

                $('.tm-btn-pause').click(function() {
                    togglePlayPause();                                      
                });

                // Update the current year in copyright
                $('.tm-current-year').text(new Date().getFullYear());                           
            });

            async function checkKodeBooking(){
                var noHp = $('#noHp').val()
                var kodeBooking = $('#kodeBooking').val()
                var headers = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') };
                if(noHp == '' || kodeBooking == ''){
                    return swal({
                        title: "Cek kembali form isian",
                        icon: "warning",
                    })
                }else{
                    $.ajax({
                        url: "{{ route('cekTransaksi') }}",
                        type: "POST",
                        headers: headers,
                        data: {no_hp: noHp, kode_booking: kodeBooking},
                        success:function(res){
                            console.log(res);
                            return swal({
                                title: `Kode Booking ${res.data.kode_booking}`,
                                text: `
                                Atas Nama : ${res.data.nama_pelanggan}
                                Tanggal Booking : ${formatTanggal(res.data.tgl_booking)}
                                Status Booking : ${getStatusBooking(res.data.status_booking)}
                                `,
                                icon: "info",
                                buttons:{
                                    cancel: {
                                        visible: true,
                                        text : 'Close',
                                        className: 'btn btn-warning'
                                    },
                                    confirm: {
                                        text : 'Hubungi Admin',
                                        className : 'btn btn-success'
                                    }
                                }
                            }).then((willDelete) => {
                                if (willDelete) {
                                    prosesSubmitCekBooking(res.data);
                                }
                            });
                        },
                        error:function(err, status, message){
                            response = err.responseJSON;
                            message = (typeof response != "undefined") ? response.message : message;
                            return swal({
                                title: message,
                                icon: "warning",
                            })
                        },
                        complete:function(){
                        }
                    });
                }
            }

            function getStatusBooking(status){
                if(status == "1"){
                        return `Baru`;
                    }else if(status == "2"){
                        return `Proses`;
                    }else if(status =="3"){
                        return `Batal`;
                    }else if(status =="4"){
                        return `Selesai`;
                    }
            }

            function formatTanggal(dateString) {
                let date = new Date(dateString);
                let options = { day: 'numeric', month: 'long', year: 'numeric' };
                let formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
                return formattedDate;
            }

            function prosesSubmitCekBooking(data){
                const phone = '6281224580919';
                const text = `*Konfirmasi Booking*
                
A.n : ${data.nama_pelanggan}
No. HP : ${data.kontak_pelanggan}
ID Booking : ${data.kode_booking}

============================
Cek Status Booking
============================

`;
                // const action = "https://wa.me/" + phone + "?text=" + encodeURIComponent(text);
                // console.log(action)
                const action = "https://web.whatsapp.com/send?phone=" + phone + "&text=" + encodeURIComponent(text.trim());
                window.open(action, '_blank');

            }

        </script>  
        
        <script>

    /* Google map
    ------------------------------------------------*/
    var map = '';
    var center;

    function initialize() {
        var mapOptions = {
            zoom: 13,
            center: new google.maps.LatLng(-23.013104,-43.394365),
            scrollwheel: false
        };

        map = new google.maps.Map(document.getElementById('google-map'),  mapOptions);

        google.maps.event.addDomListener(map, 'idle', function() {
        calculateCenter();
    });

        google.maps.event.addDomListener(window, 'resize', function() {
        map.setCenter(center);
    });
    }

    function calculateCenter() {
        center = map.getCenter();
    }

    function loadGoogleMap(){
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDVWt4rJfibfsEDvcuaChUaZRS5NXey1Cs&v=3.exp&sensor=false&' + 'callback=initialize';
        document.body.appendChild(script);
    } 

    function setCarousel() {
        
        if ($('.tm-article-carousel').hasClass('slick-initialized')) {
            $('.tm-article-carousel').slick('destroy');
        } 

        if($(window).width() < 438){
            $('.tm-article-carousel').slick({
                infinite: false,
                dots: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        }
        else {
        $('.tm-article-carousel').slick({
                infinite: false,
                dots: true,
                slidesToShow: 2,
                slidesToScroll: 1
            });   
        }
    }

    function setPageNav(){
        if($(window).width() > 991) {
            $('#tm-top-bar').singlePageNav({
                currentClass:'active',
                offset: 79
            });   
        }
        else {
            $('#tm-top-bar').singlePageNav({
                currentClass:'active',
                offset: 65
            });   
        }
    }

    function togglePlayPause() {
        vid = $('.tmVideo').get(0);

        if(vid.paused) {
            vid.play();
            $('.tm-btn-play').hide();
            $('.tm-btn-pause').show();
        }
        else {
            vid.pause();
            $('.tm-btn-play').show();
            $('.tm-btn-pause').hide();   
        }  
    }

    $(document).ready(function(){

        $(window).on("scroll", function() {
            if($(window).scrollTop() > 100) {
                $(".tm-top-bar").addClass("active");
            } else {
            $(".tm-top-bar").removeClass("active");
            }
        });      

        loadGoogleMap();  

        setCarousel();
        setPageNav();

        $(window).resize(function() {
            setCarousel();
            setPageNav();
        });

        $('.nav-link').click(function(){
            $('#mainNav').removeClass('show');
        });

        $('.tm-btn-play').click(function() {
            togglePlayPause();                                      
        });

        $('.tm-btn-pause').click(function() {
            togglePlayPause();                                      
        });

        $('.tm-current-year').text(new Date().getFullYear());                           
    });
</script>   

</body>
</html>