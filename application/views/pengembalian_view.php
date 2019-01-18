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
                url: '<?php echo base_url() . "index.php/transaksi/getkembali" ?>',
                dataType: 'JSON',
                success: function(data) {
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        baris += '<tr>' + '<td>' + data[i].NamaBuku + '</td>' +
                            '<td>' + data[i].NamaMember + '</td>' +
                            '<td>' + data[i].NamaPetugas + '</td>' +
                            '<td>' + data[i].tglkembali + '</td>' +
                            '</tr>';
                    }
                    $('#data').html(baris);
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nama Buku</th>
                            <th scope="col">Nama Peminjam</th>
                            <th scope="col">Nama Petugas</th>
                            <th scope="col">Tanggal Kembali</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <?php } else { redirect('index.php/user/login'); } ?>
</body>

</html>