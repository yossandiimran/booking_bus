@extends('admin.layouts.app')

@section('css')
<style>
    #btn-add, #btn-add-multiple {
        margin: 0px -10px 20px 15px;
    }
    .btn-group button {
        margin: 0px 4px;
    }
    .icon-big {
        font-size: 2.1em;
    }
    #pwInfo {
        font-style: italic;
        font-size: 12.5px;
    }
    .select2-container {
        width: 100% !important;
        padding: 0;
    }
    .swal-text {
        text-align: center !important;
    }
</style>
@endsection

@section('content')
<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Bus</h4>
                </div>
                <div class="card-body">
                    <button type="button" id="btn-add" class="btn btn-primary btn-md">
                        Tambah Data
                    </button>
                    <div class="table-responsive">
                        <table id="table-data" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="40px">No</th>
                                    <th>Bus</th>
                                    <th>Nomor Polisi</th>
                                    <th>Jumlah Kursi</th>
                                    <th>Tarif</th>
                                    <th>Sopir</th>
                                    <th>Status</th>
                                    <th>Foto</th>
                                    <th width="80px">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalData" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
            <form id="form-data" method="post" action="{{ route('admin.master.bus.store') }}">
              @csrf
              <input type="hidden" name="key" class="form-control" id="key-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDataLabel">Modal title</h5>
                </div>
                <div class="modal-body" id="modal-body">
                    <div class="form-group">
                        <label for="bus-form">Nama bus</label>
                        <input type="text" name="bus" class="form-control" id="bus-form" placeholder="Masukan bus" required/>
                    </div>
                    <div class="form-group">
                        <label for="id_sopir-form">Sopir</label>
                        <select name="id_sopir" class="form-control" id="id_sopir-form"></select>
                    </div>
                    <div class="form-group">
                        <label for="nopol-form">Nomor Polisi</label>
                        <input type="text" name="nopol" class="form-control" id="nopol-form" placeholder="Masukan Nomor Polisi" required/>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_kursi-form">Jumlah Kursi</label>
                        <input type="number" name="jumlah_kursi" class="form-control" id="jumlah_kursi-form" placeholder="Masukan Jumlah Kursi" required/>
                    </div>
                    <div class="form-group">
                        <label for="tarif-form">Tarif Bus</label>
                        <input type="number" name="tarif" class="form-control" id="tarif-form" placeholder="Masukan Tarif Bus" required/>
                    </div>
                    <div class="form-group">
                        <label for="type_bus-form">Tipe Bus</label>
                        <!-- <input type="text" name="type_bus" class="form-control" id="type_bus-form" placeholder="Masukan Tarif Bus" required/> -->
                        <select name="type_bus" class="form-control" id="type_bus-form">
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="Eksekutif">Eksekutif</option>
                        </select>
                         
                    </div>
                    <div class="form-group">
                        <label for="keterangan-form">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan-form" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="foto-form">Foto Bus</label>
                        <input type="file" name="foto" class="form-control" id="foto-form"/>
                         
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-md">Simpan</button>
                </div>
            </form>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
    var dt;
    var $sopirForm = $("#id_sopir-form");
    $(document).ready(function() {

        $sopirForm.select2({
            placeholder: "Pilih Sopir",
            language: "id",
            ajax: {
                url: "{{route('admin.getSelectsopir')}}",
                dataType: 'json',
                delay: 500,
                cache: true,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (res) {
                    return {
                        results: $.map(res.data, function (item) {
                            return {
                                id: `${item.id}`,
                                text: `${item.nama}`
                            };
                        })
                    };
                },
                error: function (err, textStatus, errorThrown) {
                    var message = err.responseJSON.message;
                    notif("danger", "fas fa-exclamation", "Notifikasi Error", message, "error");
                }
            }
        });

        dt = $("#table-data").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.master.bus.scopeData') }}",
                type: "post"
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex", searchable: "false", orderable: "false" },
                { data: "bus", name: "bus" },
                { data: "nopol", name: "nopol" },
                { data: "jumlah_kursi", name: "jumlah_kursi" },
                { data: "tarif", name: "tarif" },
                { data: "sopir", name: "sopir" },
                { data: "status", name: "status" },
                { data: "foto", name: "foto" },
                { data: "action", name: "action", searchable: "false", orderable: "false" }
            ],
            order: [[ 1, "asc" ]],
        });

        $("#btn-add").on("click",function(){
            $("#modalDataLabel").text("Tambah Data Bus");
            $("#modalData").modal("show");
        });

        $("body").on("click",".btn-edit",function(){
            $("#modalDataLabel").text("Ubah Data bus");
            formLoading("#form-data","#modal-body",true);
            let key = $(this).data("key");
            $.ajax({
                url: "{{ route('admin.master.bus.detail') }}",
                type: "POST",
                data: {key:key},
                success:function(res){
                    $("#key-form").val(key);
                    $.each(res.data,function(k,v){
                        console.log(res.data);
                        if(k == 'id_sopir' && v !== '-'){
                            $sopirForm.append(`<option value="${v}" selected="selected">${res.data.sopir.nama}</option>`);
                        }
                        if(`#${k}-form` != '#foto-form'){
                            $(`#${k}-form`).val(v).trigger("change");
                        }
                    });
                },
                error:function(err, status, message){
                    response = err.responseJSON;
                    message = (typeof response != "undefined") ? response.message : message;
                    notif("danger","fas fa-exclamation","Notifikasi Error",message,"error");
                },
                complete:function(){
                    formLoading("#form-data","#modal-body",false);
                }
            });
            $("#modalData").modal("show");
        });

        $("body").on("click",".btn-delete",function(){
            let key = $(this).data("key");
            swal({
                title: "Apakah anda yakin?",
                text: "Data yang dihapus tidak akan bisa dikembalikan!",
                icon: "warning",
                buttons:{
                    cancel: {
                        visible: true,
                        text : 'Batal',
                        className: 'btn btn-danger'
                    },
                    confirm: {
                        text : 'Yakin',
                        className : 'btn btn-primary'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    notifLoading("Jangan tinggalkan halaman ini sampai proses penghapusan selesai !");
                    $.ajax({
                        url: "{{ route('admin.master.bus.destroy') }}",
                        type: "POST",
                        data: {key:key},
                        success:function(res){
                            notif("success","fas fa-check","Notifikasi Progress",res.message,"done");
                            dt.ajax.reload(null, false);
                        },
                        error:function(err, status, message){
                            response = err.responseJSON;
                            message = (typeof response != "undefined") ? response.message : message;
                            notif("danger","fas fa-exclamation","Notifikasi Error",message,"error");
                        },
                        complete:function(){
                            setTimeout(() => {
                                loadNotif.close();
                            }, 1000);
                        }
                    });
                }
            });
        });

        $("#modalData").on("hidden.bs.modal",function(){
            $("#password-form").prop("required",true);
            $("#pwInfo").addClass("hidden");
            if($("#key-form").val()) $("#form-data .form-control").val("");
        });

        $("#form-data").ajaxForm({
            beforeSend:function(){
                formLoading("#form-data","#modal-body",true,true);
            },
            success:function(res){
                dt.ajax.reload(null, false);
                notif("success","fas fa-check","Notifikasi Progress",res.message,"done");
                $("#form-data .form-control").val("")
                $("#modalData").modal("hide");
            },
            error:function(err, status, message){
                response = err.responseJSON;
                title = "Notifikasi Error";
                message = (typeof response != "undefined") ? response.message : message;
                if(message == "Error validation"){
                    title = "Error Validasi";
                    $.each(response.data, function(k,v){
                        message = v[0];
                        return false;
                    });
                }
                notif("danger","fas fa-exclamation",title,message,"error");
            },
            complete:function(){
                formLoading("#form-data","#modal-body",false);
            }
        });
    });
</script>
@endsection