<!-- master_layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Add HTTPS for jQuery and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add HTTPS for SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    
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
    <!-- The navigation bar and other common elements -->
    <?php include '../template/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <?php include '../template/sidebar.php'; ?>

            <!-- content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <?php echo $content; ?>
            </main>
        </div>
    </div>
    <?php include '../template/scripts.php'; ?>
</body>

</html>
