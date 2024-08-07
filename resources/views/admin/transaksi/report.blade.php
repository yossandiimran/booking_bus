@extends('admin.layouts.app')

@section('content')
<div class="page-inner"> 
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Rekap Laporan Transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2">
                                Tgl Awal
                            </div>
                            <div class="col-md-2">
                                Tgl Akhir
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success btn-md btn-acc" type="button">
                                    <span class="fa fa-filter"></span> Filter Tanggal
                                </button>
                                <button class="btn btn-danger btn-md" type="button" id="downloadPdfBtn">
                                    <span class="fa fa-file"></span> Unduh Dokumen
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="container" id="downloadPdf">
                        <div class="row">
                            <table class="table" width="100%">
                                <thead>
                                    <th>Nomor</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Bus yang disewa</th>
                                    <th>Durawsi sewa</th>
                                    <th>Sewa Per Hari</th>
                                    <th>Pendapatan</th>
                                </thead>  
                                <tbody id="divPendapatan">

                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.17/jspdf.plugin.autotable.min.js"></script>
<script>
    var dt;
    $(document).ready(function() {

        $('#downloadPdfBtn').click(function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4');
            doc.autoTable({ html: '#downloadPdf table' });
            doc.save('Laporan_Pendapatan.pdf');
        });

        $("body").on("click",".btn-acc",function(){
            $.ajax({
                url: "{{ route('admin.laporan.getDataLaporan') }}",
                type: "GET",
                data: {tgl_awal: $("#tgl_awal").val(), tgl_akhir:  $("#tgl_akhir").val()},
                success:function(res){
                    console.log(res);
                    $('#divPendapatan').empty();
                    var total = 0;
                    if (res.data.length > 0) {
                        res.data.forEach((item, index) => {
                            let row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${new Date(item.created_at).toLocaleDateString()}</td>
                                    <td>${item.bus ? item.bus.bus : "<i>Bus Sudah Dihapus</i>"}</td>
                                    <td>${hitungHari(item.parent.tgl_berangkat, item.parent.tgl_kembali)} hari</td>
                                    <td>${formatRibuan(item.tarif)}</td>
                                    <td>${formatRibuan(hitungHari(item.parent.tgl_berangkat, item.parent.tgl_kembali) * item.tarif)}</td>
                                </tr>
                            `;
                            total = total + hitungHari(item.parent.tgl_berangkat, item.parent.tgl_kembali) * item.tarif
                            $('#divPendapatan').append(row);
                        });
                        var row = `<tr>
                                    <td colspan="5" align="right"><b>Total</b></td>
                                    <td rowspan="1">${total}</td>
                                </tr>`
                        $('#divPendapatan').append(formatRibuan(row));
                    } else {
                        let row = `
                            <tr>
                                <td colspan="5" class="text-center">No data available</td>
                            </tr>
                        `;
                        $('#divPendapatan').append(row);
                    }
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
            });
        
    });

    function hitungHari(tgl_berangkat, tgl_kembali) {
        const startDate = new Date(tgl_berangkat);
        const endDate = new Date(tgl_kembali);
        const diffTime = Math.abs(endDate - startDate);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        return diffDays + 1;
    }

    function formatRibuan(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

</script>
@endsection