@props(['message'])
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Simple Email Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Preheader text (shows in inbox preview) -->
    <style>
        /* Basic reset for many email clients */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            display: block;
            border: 0;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Container */
        .email-wrapper {
            width: 100%;
            background-color: #f4f6f8;
            padding: 20px 0;
        }

        /* Card */
        .email-card {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Spacing */
        .pad {
            padding: 24px;
        }

        .spacer {
            height: 12px;
            line-height: 12px;
            font-size: 12px;
        }

        /* Type */
        h1 {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 22px;
            margin: 0 0 8px;
            color: #111827;
        }

        h2 {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 16px;
            margin: 0 0 8px;
            color: #111827;
        }

        p {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 15px;
            color: #4b5563;
            margin: 0 0 12px;
            line-height: 1.45;
        }

        .logo {
            height: 64px;
        }

        .data {
            width: 100%;
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        .data th {
            font-size: 14px;
            font-weight: 400;
        }

        .data td {
            border: 1px solid #ddd;
            padding: 6px 10px;
        }

        .data td p {
            margin-bottom: 0;
        }

        .data td p.d {
            font-size: 18px;
            font-weight: 500;
            color: black;
        }

        /* Mobile */
        @media screen and (max-width:480px) {
            .pad {
                padding: 16px;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body style="margin:0; padding:0; background:#f4f6f8;">

    <table role="presentation" class="email-wrapper" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table role="presentation" class="email-card" width="100%" cellspacing="0" cellpadding="0">
                    {{-- Logo --}}
                    <tr>
                        <td class="pad">
                            <a href="{{ route('home') }}">
                                <img src="{{ $message->embed('assets/front/img/logo.webp') }}" alt=""
                                    style="margin:0 auto;height:64px;width:108.98px;">
                            </a>
                        </td>
                    </tr>

                    {{-- Hero --}}

                    <tr>
                        <td class="pad" style="padding:28px; text-align:left;background:#00498E;">
                            <h1 style="color:white;">{{ $heading }}</h1>
                            {{ $body }}
                        </td>
                    </tr>

                    <tr>
                        <td class="pad">
                            {{ $slot }}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
