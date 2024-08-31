<!-- master_layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Add HTTPS for jQuery and Popper.js -->

    <link rel="stylesheet" href="../asset/bootstrap-5.3.2-dist/bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <!-- Add HTTPS for SweetAlert2 -->
    <link rel="stylesheet" href="../asset/css/sweetalert2.min.css">
    <link href="../asset/dataTable/datatables.min.css" rel="stylesheet">


    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #fe9f602e;
            margin: 0;
        }

        main {
            flex: 1;
        }

        .sidebar {
            background-color: #f8f9fa;
            padding: 20px;
            height: 100%;
        }

        .nav-item {
            padding: 10px;
        }
    </style>
</head>

<body class="d-flex">
    <?php include '../template/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include '../template/sidebar.php'; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php echo $content; ?>
            </main>
        </div>
    </div>
    <?php include '../template/scripts.php'; ?>

</body>

</html>