<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Data Petugas</title>

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
                url: '<?php echo base_url() . "index.php/petugas/getdata" ?>',
                dataType: 'JSON',
                success: function(data) {
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        baris += '<tr>' + '<td>' + data[i].IdPetugas + '</td>' +
                            '<td>' + data[i].NamaPetugas + '</td>' +
                            '<td>' + data[i].jk + '</td>' +
                            '<td>' + data[i].Alamat + '</td>' +
                            '<td>' + data[i].Tlp + '</td>' +
                            '<td>' + data[i].hakAkses + '</td>' +
                            '<td><a href="#EditForm" data-toggle="modal" class="btn btn-warning" onclick="edit(&#34;' + data[i].IdPetugas + '&#34;)">Edit</a><td><a href="#HapusForm" data-toggle="modal" class="btn btn-danger" onclick="hapusData(&#34;' + data[i].IdPetugas + '&#34;)">Delete</a></td></td>' +
                            '</tr>';
                    }
                    $('#data').html(baris);
                }
            });
        }

        function addData() {
            var jk;
            var IdPetugas = $("#AddForm [name='IdPetugas']").val();
            var password = $("#AddForm [name='pass']").val();
            var confpass = $("#AddForm [name='passwd']").val();
            var nama = $("#AddForm [name='nama']").val();
            if(document.getElementById("male").checked){
                jk = $("#AddForm [name='optradioM']").val();
            } else {
                jk = $("#AddForm [name='optradioF']").val();
            }
            var alamat = $("#AddForm [name='alamat']").val();
            var telp = $("#AddForm [name='telp']").val();
            var role = $("#AddForm [name='jabatan']").val();;
            var csrf = Cookies.get('csrf_cookie');
            $.ajax({
                type: 'POST',
                data: 'IdPetugas=' + IdPetugas + '&password=' + password + '&confpass=' + confpass + '&nama=' + nama + '&jk=' + jk + '&alamat=' + alamat + '&telp=' + telp + '&role=' + role + '&csrf_token=' + csrf,
                url: '<?php echo base_url('') . "index.php/petugas/tambahdata"; ?>',
                dataType: 'JSON',
                success: function(hasil) {
                    $("#pesan").html(hasil.pesan);
                    if (hasil.pesan == '') {
                        $("#AddForm").modal('hide');
                        
                        swal("Good Job!", "Data telah berhasil disimpan.", "success");

                        getData();

                        $("#AddForm [name='IdPetugas'],#AddForm [name='pass'],#AddForm [name='passwd'],#AddForm [name='nama'],#AddForm [name='alamat'],#AddForm [name='telp'],#role").val('');
                    }
                }
            });
        }

        function edit(x) {
            var csrf = Cookies.get('csrf_cookie');
            $.ajax({
                type: 'POST',
                data: 'IdPetugas=' + x + '&csrf_token=' + csrf,
                url: '<?php echo base_url('') . "index.php/petugas/ambilId"; ?>',
                dataType: 'JSON',
                success: function(hasil){
                    $('#EditForm [name="IdPetugas"]').val(hasil[0].IdPetugas);
                    $('#EditForm [name="pass"]').val(hasil[0].password);
                    $('#EditForm [name="nama"]').val(hasil[0].NamaPetugas);
                    $('#EditForm [name="alamat"]').val(hasil[0].Alamat);
                    $('#EditForm [name="telp"]').val(hasil[0].Tlp);
                    $('#EditForm [name="jabatan"]').val(hasil[0].hakAkses);
                }
            });
        }

        function editData(){
            var jk;
            var IdPetugas = $("#EditForm [name='IdPetugas']").val();
            var password = $("#EditForm [name='pass']").val();
            var confpass = $("#EditForm [name='passwd']").val();
            var nama = $("#EditForm [name='nama']").val();
            if(document.getElementById("male").checked){
                jk = $("#EditForm [name='optradioM']").val();
            } else {
                jk = $("#EditForm [name='optradioF']").val();
            }
            var alamat = $("#EditForm [name='alamat']").val();
            var telp = $("#EditForm [name='telp']").val();
            var role = $("#EditForm [name='jabatan']").val();;
            var csrf = Cookies.get('csrf_cookie');
            $.ajax({
                type:'POST',
                data: 'IdPetugas=' + IdPetugas + '&password=' + password + '&confpass=' + confpass + '&nama=' + nama + '&jk=' + jk + '&alamat=' + alamat + '&telp=' + telp + '&role=' + role + '&csrf_token=' + csrf,
                url: '<?php echo base_url('') . "index.php/petugas/editdata"; ?>',
                dataType: 'JSON',
                success: function(hasil){
                    $("#pesan1").html(hasil.pesan);
                    if (hasil.pesan == ''){
                        $("#EditForm").modal('hide');
                        
                        swal("Good Job!", "Data telah berhasil diupdate.", "success");
                        
                        getData();

                        $("#EditForm [name='IdPetugas'],#EditForm [name='pass'],#EditForm [name='passwd'],#EditForm [name='nama'],#EditForm [name='alamat'],#EditForm [name='telp'], #EditForm [name='jabatan']").val('');
                    }
                }
            })
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
                        data: 'IdPetugas=' + id + '&csrf_token=' + csrf,
                        url: '<?php echo base_url('') . "index.php/petugas/deleteData";?>',
                        success: function(){
                            getData();
                        }
                    });
                } else {
                    swal("Data tidak jadi dihapus");
                }
            });
        }
        function checkM(){
            if(document.getElementById("male").checked){
                document.getElementById("female").checked = false;
            }
        }
        function checkF(){
            if(document.getElementById("female").checked){
                document.getElementById("male").checked = false;
            }
        }
        
        getData();
    </script>

</head>

<body>
        <?php if ($_SESSION["hakAkses"] == 'Admin' && isset($_SESSION["idPetugas"])) : ?>
        <nav class="navbar navbar-inverse">
<div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="<?php echo base_url('').'index.php/transaksi'; ?>">Peminjaman</a>
    </div>
    <ul class="nav navbar-nav">
    <li class="active"><a href="<?php echo base_url('').'index.php/transaksi' ?>">Home</a></li>
    <li class="active"><a href="<?php echo base_url('').'index.php/transaksi' ?>">Pengembalian</a></li>
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
                <h1>Data Petugas</h1>
                <br>
                <a href="#AddForm" data-toggle="modal" class="btn btn-primary">Tambah</a>
                <br>
                <!-- PDO Had some issue's with backup to SQL, It seem's haven't support. -->
                <a href="<?php echo base_url(); ?>index.php/petugas/export_csv" data-toggle="modal" class="btn btn-primary">Backup to CSV</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id Petugas</th>
                            <th scope="col">Nama Petugas</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No Telepon</th>
                            <th scope="col">Jabatan</th>
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
                    <h5 class="modal-title">Tambah Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
                </div>
                <div class="modal-body">
                    <p id="pesan"></p>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="IdPetugas">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="pass">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" class="form-control" name="passwd">
                    </div>
                    <div class="form-group">
                        <label>Nama Petugas</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" name="optradioM" id="male" value="L" checked onclick="checkM()">Laki-Laki</label>
                            <label class="radio-inline"><input type="radio" name="optradioF" id="female" value="P" onclick="checkF()">Perempuan</label>
                    </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat">
                    </div>
                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="text" class="form-control" name="telp">
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" name="jabatan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addData()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Petugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
                </div>
                <div class="modal-body">
                    <p id="pesan"></p>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="IdPetugas" readonly>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="pass">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" class="form-control" name="passwd">
                    </div>
                    <div class="form-group">
                        <label>Nama Petugas</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" name="optradioM" id="male" value="L" onclick="checkM()">Laki-Laki</label>
                            <label class="radio-inline"><input type="radio" name="optradioF" id="female" value="P" onclick="checkF()">Perempuan</label>
                    </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat">
                    </div>
                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="text" class="form-control" name="telp">
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" name="jabatan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editData()">Update</button>
                </div>
            </div>
        </div>
    </div>
        <?php else : redirect('index.php/user/login'); endif; ?>
</body>

</html>