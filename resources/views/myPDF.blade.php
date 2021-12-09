<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>ticket</title>
    <style>
        body {
            font-family: DejaVu Sans, serif
        }
    </style>
</head>
<body>
<div class="container text-right w-50">
    <table class="table mt-5 table-bordered bg-white">
        <tbody>

            <tr>

                <td>
                    <p class="small text-secondary m-2">
                        نام مسافر
                    </p>
                    <p class="h5 text-primary font-weight-bold m-2">
                        {{$passenger_first_name .' '. $passenger_last_name}}
                    </p>
                </td>

                <td>
                    <p class="small text-secondary m-2">
                        تاریخ صدور بلیت
                    </p>
                    <p class="h6 text-secondary font-weight-bold m-2">
                        {{$ticket_create_date}}
                    </p>
                </td>

            </tr>

            <tr>

                <td>
                    <p class="small text-secondary m-2">
                        شهر و پایانه مبدا
                    </p>
                    <p class="h5 text-primary font-weight-bold m-2">
                        {{$origin}}
                    </p>
                    <p class="small text-secondary m-2">
                        شهر و پایانه مقصد
                    </p>
                    <p class="h5 text-primary font-weight-bold m-2">
                        {{$destination}}
                    </p>
                </td>

                <td>
                    <p class="small text-secondary m-2">
                        شرکت
                    </p>
                    <p class="h6 text-secondary font-weight-bold m-2">
                        {{$company_name}}
                    </p>
                </td>

            </tr>

            <tr>

            <td>
                <p class="small text-secondary m-2">
                    تاریخ و ساعت حرکت اتوبوس
                </p>
                <p class="h5 text-primary font-weight-bold m-2">
                    {{$departure_date_time}}
                </p>
            </td>
            <td>
                <p class="small text-secondary m-2">
                    شماره صندلی
                </p>
                <p class="h5 text-primary font-weight-bold m-2">
                    {{$seats_number}}
                </p>
            </td>

        </tr>

        </tbody>
    </table>
</div>
{{--<div class="container text-right w-50">--}}
{{--    <div class="rounded border bg-white mt-5">--}}
{{--        <div class="row border-bottom px-4 py-2">--}}
{{--            <div class="col-7">--}}
{{--                <p class="small text-secondary m-2">--}}
{{--                    نام مسافر--}}
{{--                </p>--}}
{{--                <p class="h5 text-primary font-weight-bold m-2">--}}
{{--                    {{$passenger_first_name .' '. $passenger_last_name}}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <div class="col-5">--}}
{{--                <p class="small text-secondary m-2">--}}
{{--                    تاریخ صدور بلیت--}}
{{--                </p>--}}
{{--                <p class="h6 text-secondary font-weight-bold m-2">--}}
{{--                    {{$ticket_create_date}}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row border-bottom px-4 py-2">--}}

{{--            <div class="col-7">--}}
{{--                <p class="small text-secondary m-2">--}}
{{--                    شهر و پایانه مبدا--}}
{{--                </p>--}}
{{--                <p class="h5 text-primary font-weight-bold m-2">--}}
{{--                    {{$origin}}--}}
{{--                </p>--}}

{{--                <p class="small text-secondary m-2">--}}
{{--                    شهر و پایانه مقصد--}}
{{--                </p>--}}
{{--                <p class="h5 text-primary font-weight-bold m-2">--}}
{{--                    {{$destination}}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <div class="col-5">--}}
{{--                <p class="small text-secondary m-2">--}}
{{--                    شرکت--}}
{{--                </p>--}}
{{--                <p class="h6 text-secondary font-weight-bold m-2">--}}
{{--                    {{$company_name}}--}}
{{--                </p>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--        <div class="row border-bottom px-4 py-2">--}}
{{--            <div class="col-7">--}}
{{--                <p class="small text-secondary m-2">--}}
{{--                    تاریخ و ساعت حرکت اتوبوس--}}
{{--                </p>--}}
{{--                <p class="h5 text-primary font-weight-bold m-2">--}}
{{--                    {{$departure_date_time}}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <div class="col-5">--}}
{{--                <p class="small text-secondary m-2">--}}
{{--                    شماره صندلی--}}
{{--                </p>--}}
{{--                <p class="h5 text-primary font-weight-bold m-2">--}}
{{--                    {{$seats_number}}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
</body>
</html>
