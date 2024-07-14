<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <div class="container">
                <div class="row">
                    <a class="navbar-brand mr-auto" href="{{url('/')}}">
                        <img src="{{ asset('assets/frontend/img/logo.png')}}" alt="Site logo">
                            Bus Padang
                        </a>
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
                                            <input name="lokasi" type="text" class="form-control" id="lokasi" placeholder="Kemana anda akan pergi ?" value="{{ $formData['lokasi'] }}">
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-50">
                                            <i class="fa fa-calendar fa-2x tm-form-element-icon"></i>
                                            <input name="tgl_berangkat" type="date" class="form-control" id="tgl_berangkat" placeholder="Tanggal Pergi" value="{{ $formData['tgl_berangkat'] }}">
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-50">
                                            <i class="fa fa-calendar fa-2x tm-form-element-icon"></i>
                                            <input name="tgl_kembali" type="date" class="form-control" id="tgl_kembali" placeholder="Tanggal Kembali" value="{{ $formData['tgl_kembali'] }}">
                                        </div>
                                    </div>
                                    <div class="form-row tm-search-form-row">
                                        <div class="form-group tm-form-element tm-form-element-4">                                            
                                            <select name="bus" class="form-control tm-select" id="bus">
                                                <option value="">Pilih Kelas Bus</option>
                                                @foreach($type_bus as $bs)
                                                <option value="{{ $bs }}"  @if($formData['bus'] == $bs) selected @endif >{{ $bs }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fa fa-2x fa-bus tm-form-element-icon"></i>
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-4">                                            
                                            <input name="jumlahSeat" type="number" class="form-control" id="jumlahSeat" placeholder="Jumlah Penumpang" value="{{ $formData['jumlahSeat'] }}">
                                            <i class="fa fa-user tm-form-element-icon tm-form-element-icon-small"></i>
                                        </div>
                                        <div class="form-group tm-form-element tm-form-element-4">
                                            <button type="submit"  class="btn btn-primary tm-btn-search">Cek Ketersediaan</button>
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
                            <h2 class="tm-section-title">Bus yang tersedia nih</h2>
                            <p class="tm-color-white tm-section-subtitle">Pilih aja suka suka !</p>
                        </div>                
                    </div>
                </div>        
            </div>
            <div class="tm-section tm-section-pad tm-bg-img" id="tm-section-5">   
              
                <div class="container">
                    @foreach($bus as $data)
                    <article class="media tm-margin-b-20 tm-media-1">
                        <img src="{{ asset('storage/' . $data->foto) }}" alt="Image" width="300">
                        <div class="media-body tm-media-body-1 tm-media-body-v-center">
                            <h3 class="tm-font-semibold tm-color-primary tm-article-title-3">{{ $data["bus"] }} - {{ $data['nopol'] }}</h3>
                            <p>{{ $data["keterangan"] }}</p>
                            <ul>
                                <li><p>Kelas Bus : {{ $data["type_bus"] }}</p></li>
                                <li><p>Kapasitas Bus : {{ $data["jumlah_kursi"] }}</p></li>
                                <li><p>Tarif Standar : {{ $data["tarif"] }} /  Hari</p></li>
                            </ul>
                            <button type="button" class="btn btn-primary tm-btn-primary"  onclick="openModalData({{$data}})">
                                Booking Sekarang
                            </button>
                        </div>                                
                        </article>
                        <hr>
                    @endforeach
                </div>
            </div>
            
            <div class="tm-section tm-section-pad tm-bg-img tm-position-relative" id="tm-section-6">
                <div class="container ie-h-align-center-fix">
                 
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

        <!-- Modal Form Booking -->
        <div class="modal fade bd-example-modal-xl" id="formBookingModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Form Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bus-form">Nama Pemesan</label>
                        <input type="text" name="nama_pelanggan" class="form-control" id="bus-form" placeholder="Masukan nama anda" required/>
                    </div>
                    <div class="form-group">
                        <label for="bus-form">Nomor Hp</label>
                        <input type="number" name="kontak_pelanggan" class="form-control" id="bus-form" placeholder="Masukan Kontak anda" required/>
                    </div>
                    <div class="form-group">
                        <label for="bus-form">Tanggal Berangkat</label>
                        <input type="date" name="tgl_berangkat" class="form-control" id="bus-form" value="{{ $formData['tgl_berangkat'] }}" required/>
                    </div>
                    <div class="form-group">
                        <label for="bus-form">Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali" class="form-control" id="bus-form" value="{{ $formData['tgl_kembali'] }}" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">cancel</button>
                    <button type="button" class="btn btn-success">Booking</button>
                </div>
                </div>
            </div>
        </div>
        
        <!-- load JS files -->
        <script src="{{ asset('assets/frontend/js/jquery-1.11.3.min.js')}}"></script>          
        <script src="{{ asset('assets/frontend/js/popper.min.js')}}"></script>                  
        <script src="{{ asset('assets/frontend/js/bootstrap.min.js')}}"></script>               
        <script src="{{ asset('assets/frontend/js/jquery.singlePageNav.min.js')}}"></script>     
        <script src="{{ asset('assets/frontend/slick/slick.min.js')}}"></script>                 
        <script>
            function openModalData(data){
                console.log(data)
                $('#formBookingModal').modal('toggle')

            }


            // Fungsi Booking Langsung Kirim Ke Wa
            function prosesSubmitCekBooking(){
                const $form = $("#send-message-whatsapp");

                const phone = '6281224580919';

                let data = {}
                $form.serializeArray().forEach(v => data[v.name] = v.value)

                const text = `*Formulir Booking Bus*
A.n : Yossandi Imran Prihartanto
No. HP : 081224580919
ID Booking : BK001

============================
*Tujuan* : ${data.lokasi}
*Tgl Berangkat* : ${data.tgl_berangkat}
*Tgl Kembali* : ${data.tgl_kembali}
*Bus* : ${data.bus}
*Jumlah Seat* : ${data.jumlahSeat}
============================

`;

                // const action = "https://wa.me/" + phone + "?text=" + encodeURIComponent(text);
                // console.log(action)

                const action = "https://web.whatsapp.com/send?phone=" + phone + "&text=" + encodeURIComponent(text.trim());
                window.open(action, '_blank');

            }

        </script>             

</body>
</html>