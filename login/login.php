<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #FFEBCD;
            /* Dark grayish-blue background color */
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #FF7F50;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: auto;
        }

        .login-container h2 {
            text-align: center;
        }

        .login-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        /* เพิ่มสไตล์สำหรับปุ่มสมัครสมาชิก */
        .resume-button {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 5px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            width: 100%;
            margin-top: 10px;
            /* เพิ่มขึ้นมาหน่อย */
        }
    </style>
</head>

<body>
    <?


    ?>
    <div class="login-container">
        <h2>Login</h2>
        <form class="login-form" action="./login_Processing.php" method="post">
            <div class="form-group">
                <label for="email">email:</label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>

</body>

</html>