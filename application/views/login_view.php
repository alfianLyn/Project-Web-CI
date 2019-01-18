<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- load bootstrap css file -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
    .form-signin {
        width: 100%;
        max-width: 400px;
        padding: 15px;
        margin: auto;
        margin-top:50px;
    }
    .form-signin h3 {
        margin-bottom:30px;
    }
    </style>
</head>
<body>
    <div class="form-signin">
    <center>
    <h1 class="mb-4" style="font-family:Monospace;">Login form</h1>
    <br />
    </center>
            <div class="form-group">
                <form action="<?php echo base_url('') . 'index.php/user/ceklogin'; ?>" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Masukkan username" name="user"> </div>
                    <br />
                    <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Masukkan password" name="pass"> </div>
                    <br />
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
        </div>
    
    </body>
</html>