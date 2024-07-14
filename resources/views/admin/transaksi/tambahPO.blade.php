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

    .text-width{
        width: 40%;
    }

    .menuList{
        display: none;
        height: 0;
    }

    .activeSub{
        background: #1572e8;
        color: red;
    }

    .activeSub:hover{
        background: #1572e8;
        color: black;
    }

    @keyframes listMenu {
        0% {
          height: 0;  
        }
        25%{
            height: 25%;
        }
        50%{
            height: 50%;
        }
        75%{
            height: 75%;
        }
        100% {
            height: 100%;
        }
    }

</style>
@endsection

@section('content')
<div class="page-inner"> 
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2"> 
                            <h4>Tambah PO</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container d-flex flex-wrap justify-content-between">
                       <div class="text-width mb-3">
                        <label for="formFile" class="form-label pb-1">Customer</label>
                        <select name="id_customer" class="form-control" id="id_customer-form"></select>
                    </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">No Hp</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="No Hp" id="hp" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Nama Customer</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="Nama Customer" id="customer" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Email</label>
                            <input class="form-control" type="email" value="" aria-label="readonly input example" placeholder="Alamat Email" id="email" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Alamat</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="Alamat" id="alamat" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Kode Pos</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="Kode Pos" id="pos" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Kota</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="Kota" id="kota" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Provinsi</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="Provinsi" id="provinsi" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Kelurahan</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="Kelurahan" id="kelurahan" readonly>
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Kecamatan</label>
                            <input class="form-control" type="text" value="" aria-label="readonly input example" placeholder="Kecamatan" id="kecamatan" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">No. PO</label>
                            <input class="form-control" type="text" value="" id="no_po" aria-label="No.PO" placeholder="No. PO" >
                        </div>
                        <div class="text-width mb-3">
                            <label for="formFile" class="form-label pb-1">Tanggal</label>
                            <input class="form-control" type="date" value="" id="tanggal" aria-label=" input example" placeholder="Tanggal" >
                        </div>
                    </div>
                    <div class="container d-flex justify-content-end mt-3">
                        <button type="button" id="btn-add" class="btn btn-primary btn-md">
                            Tambah Barang
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="table-data" class="table table-bordered table-hover" >
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kode</th>
                                    <th>Supplier</th>
                                    <th>Harga</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th width="80px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-barang-detail">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.transaksi.po.index') }}" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>
                            &nbsp;Kembali
                        </a>
                        <button type="button" class="btn btn-success" onclick="saveDataToOrder()"><span class="fa fa-check"></span> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalData" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <input type="hidden" name="key" class="form-control" id="key-form">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalDataLabel">Detail</h5>
              </div>
              <div class="modal-body" id="modal-body">
                  <div class="table-responsive">
                      <table id="table-list" class="table table-bordered table-hover w-100" >
                          <thead>
                              <tr>
                                  <th width="40px">No</th>
                                  <th>Nama Barang</th>
                                  <th>Stok</th>
                                  <th>Harga</th>
                                  <th width="10%">Aksi</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              </div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script>
    var dt;
    var $customerForm = $("#id_customer-form");
    var customerData = {}; 

    $(document).ready(function() {
        $customerForm.select2({
            placeholder:"Pilih Customer",
            allowClear:true,
            language: "id",
            ajax: {
                url: "{{route('admin.getSelectCustomer')}}",
                dataType: 'json',
                delay: 500,
                cache: true,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (res) {
                    res.data.forEach(function(item) {
                        customerData[item.id] = item;  
                    });
                    return {
                        results: $.map(res.data, function (item) {
                            id = `${item.id}`;
                            text = `${item.name} - ${item.username}`;
                            return {
                                id: id,
                                text: text
                            }
                        })
                    };
                },
                error: function (err, textStatus, errorThrown) {
                    message = err.responseJSON.message;
                    notif("danger","fas fa-exclamation","Notifikasi Error",message,"error");
                }
            }
        }).on('change', function(e) {
            var selectedCustomerId = $(this).val();
            if (selectedCustomerId) {
                var selectedCustomer = customerData[selectedCustomerId];
                console.log('Selected Customer Data:', selectedCustomer);
                $("#hp").val(selectedCustomer.no_hp);
                $("#email").val(selectedCustomer.email);
                $("#customer").val(selectedCustomer.name);
                $("#pos").val(selectedCustomer.kode_pos);
                $("#alamat").val(selectedCustomer.alamat);
                $("#provinsi").val(selectedCustomer.provinsi);
                $("#kota").val(selectedCustomer.kota);
                $("#kecamatan").val(selectedCustomer.kelurahan);
                $("#kelurahan").val(selectedCustomer.kecamatan);
            } else {
                $("#hp").val("");
                $("#email").val("");
                $("#customer").val("");
                $("#pos").val("");
                $("#alamat").val("");
                $("#provinsi").val("");
                $("#kota").val("");
                $("#kecamatan").val("");
                $("#kelurahan").val("");
            }
        });;

        dt = $("#table-list").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.transaksi.po.scopeList') }}",
                type: "post"
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex", searchable: "false", orderable: "false" },
                { data: "nama_barang", name: "nama_barang" },
                { data: "stok", name: "stok" },
                { data: "harga", name: "harga" },
                { data: "action", name: "action", searchable: "false", orderable: "false" }
            ],
            order: [[ 1, "asc" ]],
        });

        $("#btn-add").on("click",function(){
            $("#modalDataLabel").text("List Barang Barang");
            $("#modalData").modal("show");
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

    function appendBarang(key){
        var jsonValue = atob(key);
        var value = JSON.parse(jsonValue);
        console.log(value);
        const $tbody = $('#data-barang-detail');
        const $row = $('<tr>');
        $row.append(`<td>${value.kode_barang}</td>`);
        $row.append(`<td>${value.nama_barang}</td>`);
        $row.append(`<td>${value.supplier.nama_supplier}</td>`);
        $row.append(`<td>${value.harga}</td>`);
        $row.append(`<td>${value.satuan}</td>`);
        $row.append(`<input type="hidden" name="id_barang[]" value="${value.kode_barang}">`);
        $row.append(`<td><div class="container"><input type="number" name="jumlah_barang[]" value="${value.jumlah}" class="input-jumlah form-control" data-harga="${value.harga}"></div></td>`);
        $row.append(`<td><div class="container"><input type="number value="${value.harga * value.jumlah}" class="input-total form-control" readonly></div></td>`);
        $row.append(`<td><button class="btn btn-danger" onclick="removeRow(this)"><span class="fa fa-trash"></span></button></td>`);
        $row.append(`</tr>`);
        $tbody.append($row);

        $('.input-jumlah').on('input', function() {
            const harga = $(this).data('harga');
            const $totalInput = $(this).closest('td').next().find('.input-total');
            $totalInput.val($(this).val() * harga);
        });
    }

    function removeRow(button) {
        $(button).closest('tr').remove();
    }

    function saveDataToOrder(){
        var formData = {
            id_customer: $('#id_customer-form').val(),
            no_hp: $('#hp').val(),
            email: $('#email').val(),
            nama_customer: $('#customer').val(),
            alamat: $('#alamat').val(),
            kode_pos: $('#pos').val(),
            kota: $('#kota').val(),
            provinsi: $('#provinsi').val(),
            kelurahan: $('#kelurahan').val(),
            kecamatan: $('#kecamatan').val(),
            no_po: $('#no_po').val(),
            tanggal: $('#tanggal').val(),
            detail_barang: []
        };
    
        $('#data-barang-detail tr').each(function() {
            var detail_barang = {
                kode_barang: $(this).find('td:nth-child(1)').text(),
                nama_barang: $(this).find('td:nth-child(2)').text(),
                supplier: $(this).find('td:nth-child(3)').text(),
                satuan: $(this).find('td:nth-child(4)').text(),
                harga: $(this).find('td:nth-child(5)').text(),
                jumlah: $(this).find('input[name="jumlah_barang[]"]').val(),
                total: $(this).find('.input-total').val()
            };
            formData.detail_barang.push(detail_barang);
        });
        console.log(formData)
        $.ajax({
            url: "{{ route('admin.transaksi.po.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                window.location.href = "{{ url('admin/transaksi/po') }}";
            },
            error: function(xhr, status, error) {
                notif("danger","fas fa-exclamation","Gagal Membuat PO !","error");
            }
        });
    }

</script>
@endsection