<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>

    <style>
        /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */

        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

        .body {
            border-radius: 30px;
            background-color: #fff;
            width: 100%;
            max-width: 800px;
        }

        table.table-centered {
            text-align: center;
        }
        table td {
            padding: 10px;
        }

        .strong-text {
            font-weight: 400;
            font-size: 18px;
        }

        .padding-default {
            padding: 10px 30px;
        }

        .p30 {
            padding: 30px;
        }

        .pt15 {
            padding-top: 15px;
        }

        .pb15 {
            padding-bottom: 15px;
        }

        .pl15 {
            padding-left: 15px;
        }

        .pr15 {
            padding-right: 15px;
        }

        .small-font {
            font-size: 10px;

        }

        /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
        h1,
        h2,
        h3,
        h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
        }

        h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize;
        }

        p,
        ul,
        ol,
        td {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            padding: 0;
            margin-bottom: 15px;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin: 5px;
        }

        a {
            color: #3498db;
            text-decoration: underline;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #ccc;
            width: 80%;
        }
    </style>

</head>

<body>
    <center>
        <table border="0" cellpadding="0" cellspacing="0" class="body">
            <tr align="center">
                <td class="padding-default"><img src="{{ asset('/assets/img/mail/email_confirmations_logo.jpg')}}" alt="{{ config('app.name') }}" /></td>
            </tr>
            <tr>
                <td valign="top">
                    @yield('content')
                </td>
            </tr>
        </table>
    </center>
</body>

</html>