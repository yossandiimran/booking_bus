<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
        }
        .container {
            margin: 0 auto;
            padding: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h4 {
            margin: 0;
        }
        .content {
            margin-bottom: 20px;
        }
        .content label {
            font-weight: bold;
        }
        .content .info {
            margin-bottom: 10px;
        }
        .content .info span {
            display: block;
            margin-top: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h4>Purchase Order</h4>
        </div>
        <hr>
        <div class="content">
            <div class="info">
                <label>Customer:</label>
                <span>{{ $order->customer->name }}</span>
                <span>{{ $order->customer->no_hp }}</span>
                <span>{{ $order->customer->email }}</span>
                <span>{{ $order->customer->alamat }}</span>
                <span>{{ $order->customer->kode_pos }} {{ $order->customer->kota }}</span>
                <span>{{ $order->customer->provinsi }}</span>
                <span>Kel. {{ $order->customer->kelurahan }}</span>
                <span>Kec. {{ $order->customer->kecamatan }}</span>
            </div>
            <div class="info">
                <label>No. PO:</label>
                <span>{{ $order->nomor_po }}</span>
            </div>
            <div class="info">
                <label>Tanggal:</label>
                <span>{{ $order->created_at }}</span>
            </div>
        </div>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kode</th>
                    <th>Supplier</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
              <?php $grandTotal = 0;?>
              @foreach($order->orderDetail as $od)
              <tr>
                <td>{{$od->barang->nama_barang}}</td>
                <td>{{$od->barang->kode_barang}}</td>
                <td>{{$od->barang->supplier->nama_supplier}}</td>
                <td style="text-align: right;">Rp. {{number_format($od->barang->harga, 2)}}</td>
                <td style="text-align: right;">{{$od->jumlah}}</td>
                <td>{{$od->barang->satuan}}</td>
                <td style="text-align: right;">Rp. {{number_format($od->jumlah * $od->barang->harga, 2)}}</td>
                <?php $grandTotal = $grandTotal + ($od->jumlah * $od->barang->harga)?>
              </tr>
              @endforeach
            </tbody>
        </table>
        <hr>
        <h3 style="text-align: right;">Total : Rp. {{number_format($grandTotal, 2)}} </h3>
    </div>
</body>
</html>
