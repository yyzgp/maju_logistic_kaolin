<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            padding-left: 16%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            width: 100%;
            box-sizing: border-box;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .dashboard {
            display: inline-block;
            padding: 10px 20px;
            background-color: #22d0f3;
            color: #0a0a0a;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dashboard:hover {
            background-color: #bcbec3;
        }

        /* .voucher {
            text-align: left;
            margin-top: 20px;
            padding-left: 0;
            list-style-type: none;
            text-align: left;
        }

        .voucher:hover {
            color: #050505;
        } */

        .content{
            margin-left: 15%;
        }

        ul {
            text-align: left;
            margin-top: 20px;
            padding-left: 0;
            list-style-type: none;
            text-align: left; /* Adjust text alignment */
        }

        ul li {
            margin-bottom: 5px;
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 0;
                margin: 0;
                max-width: 100%;
            }
            .content{
            margin-left: 0;
        }
        }
    </style>
</head>

<body>
    <div class="container">
        <img class="logo" src="https://kaolin.n2rdev.in/assets/images/logo/login-logo.png" alt="Logisticss Pvt Ltd" width="150px" height="150px">
        <h1>Logisticss Pvt Ltd</h1>

        <p><b>Dear {{ isset($name) ? strtoupper($name) : 'N/A' }},</b></p>
        <h4>Thank you for completing the task successfully with us!.</h4>
        <p>Please find the delivery order in attachment</p>

        <p><b>Best regards,<br>
            Logisticss Pvt Ltd</b></p>
    </div>
</body>

</html>
