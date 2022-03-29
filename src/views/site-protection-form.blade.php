<!DOCTYPE html>
<html>
    <head>
        <title>Password protected</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 36px;
            }

            .form-control {
                border: 1px solid #ccc;
                padding: 10px 20px;
            }

            .hidden {
                display: none;
            }

            .text-danger {
                color: #d9534f;
            }
        </style>

        @if (config('site-protection.css_file_uri'))
            <link href="{{ config('site-protection.css_file_uri') }}" rel="stylesheet" >
        @endif

    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Password protected</div>

                <form method="GET">
                    {{ csrf_field() }}

                    <div class="form-group">

                        <input type="password" name="site-password-protected" placeholder="Please enter password" class="form-control" tabindex="1" autofocus />
                        @if (Request::get('site-password-protected'))
                            <div class="text-danger">Password is wrong</div>
                        @else
                            <div class="small help-block">And press enter</div>
                        @endif
                    </div>

                    <input type="submit" class="hidden" />

                </form>
            </div>
        </div>
    </body>
</html>
