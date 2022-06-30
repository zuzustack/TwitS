<head>
    <title>Confirm Email</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: white;
        }

        .body {
            background-color: #000;
        }

        .text-center {
            text-align: center;
        }

        .header {
            text-align: center;
            color: white;
        }

        .head-1 {
            background: #25be77;
            font-size: 1.8rem;
        }

        .head-2 {
            font-size: 1.2rem;
        }

        .head-3 {
            color: gray;
            font-size: 1rem;
        }

        /*# sourceMappingURL=style.css.map */
    </style>
</head>

<body style="margin: 0; padding: 0">
    <table style="border-collapse: collapse" align="center" cellpadding="0" cellspacing="0" width="100%" class="body">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" class="header">
                    <tr>
                        <td height="65px" class="head-1"><b>TwitS</b> APP</td>
                    </tr>
                    <tr>
                        <td class="head-2" height="45px">Konfirmasi Email</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellspacing="10">
                    <tr>
                        <td height="35px">Selamat Datang di TwitS <b>{{ $username }}</b></td>
                    </tr>
                    <tr>
                        <td height="0px">Mohon verifikasi email anda</td>
                    </tr>
                    <tr>
                        <td height="0px">Kode verifikasi: <b>{{ $token }}</b></td>
                    </tr>
                    <tr>
                        <td height="35px">Jangan beritahu oranglain!</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellspacing="30">
                    <tr>
                        <td class="head-3 text-center">ZuzuStack</td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <a href="https://instagram.com/wannssss_">
                                Contact To Developer
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
