@extends('admin.layouts.app')

@section('content')
<div class="page-inner">
    <div class="card full-height">
        <div class="row">
            <div class="col-md-5 pl-5" style="display: flex; align-items:center;">
                <span class="text-home">
                    <h1>Selamat Datang Di Aplikasi <br> Booking Bus Halaman Admin</h1>
                </span>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('assets/image/home/welcome.png') }}" width="100%">
            </div>
        </div>
    </div>
</div>
@endsection