<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Peminjaman</title>

    <!-- load bootstrap css file -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- JavaScript Cookies -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

    <!-- Sweet Alert JavaScript -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        function getData() {
            var csrf = Cookies.get('csrf_cookie');
            $.ajax({
                type: 'POST',
                data:{csrf_token: csrf},
                url: '<?php echo base_url() . "index.php/transaksi/getdata" ?>',
                dataType: 'JSON',
                success: function(data) {
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        baris += '<tr>' + '<td>' + data[i].NamaBuku + '</td>' +
                            '<td>' + data[i].NamaMember + '</td>' +
                            '<td>' + data[i].NamaPetugas + '</td>' +
                            '<td>' + data[i].tglpinjam + '</td>' +
                            '<td>' + data[i].hrskembali + '</td>' +
                            '<td><a class="btn btn-warning" onclick="edit(&#34;' + data[i].idPinjam + '&#34;)">Kembalikan</a><td><a href="#HapusForm" data-toggle="modal" class="btn btn-danger" onclick="hapusData(&#34;' + data[i].idPinjam + '&#34;)">Delete</a></td></td>' +
                            '</tr>';
                    }
                    $('#data').html(baris);
                }
            });
        }

        function pinjamBuku() {
            var IdMember = $("#AddForm [name='IdMember']").val();
            var IdBuku = $("#AddForm [name='IdBuku']").val();
            var csrf = Cookies.get('csrf_cookie');
            $.ajax({
                type: 'POST',
                data: 'IdBuku=' + IdBuku + '&IdMember=' + IdMember + '&csrf_token=' + csrf,
                url: '<?php echo base_url('') . "index.php/transaksi/pinjamBuku"; ?>',
                dataType: 'JSON',
                success: function(hasil) {
                    $("#pesan").html(hasil.pesan);
                    if (hasil.pesan == '') {
                        $("#AddForm").modal('hide');
                        
                        swal("Good Job!", "Data telah berhasil disimpan.", "success");

                        getData();

                        $("#AddForm [name='IdBuku'],#AddForm [name='nama'],#AddForm [name='stock']").val('');
                    }
                }
            });
        }

        function edit(x) {
            var csrf = Cookies.get('csrf_cookie');
            $.ajax({
                type: 'POST',
                data: 'idPinjam=' + x + '&csrf_token=' + csrf,
                url: '<?php echo base_url('') . "index.php/transaksi/kembalikanBuku"; ?>',
                dataType: 'JSON',
                success: function(hasil){
                    
                    swal("Good Job!", "Data telah berhasil diupdate.", "success");
                        
                    getData();
                }
            });
        }
        
        function hapusData(id){
            var csrf = Cookies.get('csrf_cookie');
            swal({
                title: "Apakah anda yakin?",
                text: "Data akan dihapus secara Permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if(willDelete) {
                    swal("Selamat Data berhasil dihapus!", {
                        icon: "success",
                    });
                    $.ajax({
                        type: 'POST',
                        data: 'idPinjam=' + id + '&csrf_token=' + csrf,
                        url: '<?php echo base_url('') . "index.php/transaksi/deleteData";?>',
                        success: function(){
                            getData();
                        }
                    });
                } else {
                    swal("Data tidak jadi dihapus");
                }
            });
        }
        
        getData();
    </script>

</head>

<body>
        <?php if ($_SESSION["hakAkses"] == 'Desk' || $_SESSION["hakAkses"] == 'Admin' && isset($_SESSION["idPetugas"])) { ?>
        <nav class="navbar navbar-inverse">
<div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="<?php echo base_url('').'index.php/transaksi'; ?>">Peminjaman</a>
    </div>
    <ul class="nav navbar-nav">
    <li class="active"><a href="<?php echo base_url('').'index.php/transaksi' ?>">Home</a></li>
    <li class="active"><a href="<?php echo base_url('').'index.php/transaksi/kembali' ?>">Pengembalian</a></li>
        <?php if($_SESSION["hakAkses"] == 'Admin') { ?>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Menu <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="<?php echo base_url() . 'index.php/buku' ?>">Data Buku</a></li>
        <li><a href="<?php echo base_url() . 'index.php/member' ?>">Data Member</a></li>
        <li><a href="<?php echo base_url() . 'index.php/petugas' ?>">Data Petugas</a></li>
        </ul>
    </li>
    <?php } ?>
    <?php if($_SESSION["hakAkses"] == 'Desk') { ?>
    <li class="active"><a href="<?php echo base_url('').'index.php/member' ?>">Pengembalian</a></li>
    <?php } ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <li><a href="<?php echo base_url('').'index.php/user/logout'; ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
</div>
</nav>

    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Info!</strong> Selamat datang <?php echo $_SESSION["NamaPetugas"]; ?>.
        </div>
                <h1>Peminjaman Buku</h1>
                <br>
                <a href="#AddForm" data-toggle="modal" class="btn btn-primary">Pinjam</a>
                <br>
                <!-- PDO Had some issue's with backup to SQL, It seem's haven't support. -->
                <a href="<?php echo base_url(); ?>index.php/transaksi/export_csv" data-toggle="modal" class="btn btn-primary">Backup to CSV</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nama Buku</th>
                            <th scope="col">Nama Peminjam</th>
                            <th scope="col">Nama Petugas</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Perkiraan Kembali</th>
                            <th scope="col" colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="AddForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
                </div>
                <div class="modal-body">
                    <p id="pesan"></p>
                    <div class="form-group">
                        <label>ID Peminjam</label>
                        <input type="text" class="form-control" name="IdMember">
                    </div>
                    <div class="form-group">
                        <label>ID Buku</label>
                        <input type="text" class="form-control" name="IdBuku">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="pinjamBuku()">Save</button>
                </div>
            </div>
        </div>
    </div>
        <?php } else { redirect('index.php/user/login'); } ?>
</body>

</html>