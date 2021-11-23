@extends('layouts.app')

@section('content')

    <div class="overflow-hidden position-absolute">
        <img src="https://cdn.alibaba.ir/h/desktop/assets/images/hero/hero.jpg-c519cbc5.jpg" alt="Bus"
             class="overflow-hidden" height="320">
    </div>
    <div class="position-absolute d-flex flex-column align-items-center w-100" style="top:310px">
        <div class=" bg-white rounded w-75 border">
            <div class="border-bottom p-4 text-primary h4 text-center">
                {{__('bus ticket')}}
            </div>
            <form action="#" class="p-4" method="post">
                @csrf
                <div class="d-flex">
                    <div class="input-group input-group-lg col-5 p-0 " dir="ltr">
                        <input dir={{__('direction')}} type="text" class="form-control" id="destination"
                               placeholder={{__('destination')}} >
                        <input dir={{__('direction')}} type="text" class="form-control" id="origin"
                               placeholder={{__('origin')}} >
                    </div>
                    <div class="col-5 px-2">
                        <input type="text" class="form-control form-control-lg" id="date"
                               placeholder="{{__('date of departure')}}" aria-label="Username"
                               aria-describedby="basic-addon1">
                    </div>
                    <div class="col-2 p-0">
                        <button class="btn btn-lg w-100" id="reserve_submit"
                                style="background-color: #FDB93C; border-color: #E3A535">{{__('search')}}</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="w-75 my-3 rounded border bg-white" id="vehicle_list">
            <ul class="w-100" id="trips"  style="list-style-type:none;">
            </ul>
        </div>


        <div class="d-none  w-75 my-3 alert alert-danger" id="no_vehicle">برای این تاریخ اتوبوس خالی وجود ندارد</div>
    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {

        $('#reserve_submit').on("click", function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                }
            });
            $.ajax({
                url: "{{url('/reservable')}}",
                method: 'POST',
                data: {
                    destination: $('#destination').val(),
                    origin: $('#origin').val(),
                    date: $('#date').val()
                },
                success: function (result) {

                    console.log(result);
                    if (result['status'] === 204) {
                        $("#no_vehicle").removeClass("d-none")
                    } else if (result['status'] === 200) {

                        $.each(result['data']['trips'], function (index, value) {

                            $("#trips").append("<li class='w-100'>" +
                                "<div class=''>" +
                                "<div class='row'>" +
                                "<div class='col-9 p-4 border-left'>" +
                                "<p class='text-muted font-weight-lighter' id='company_name'>"+ value['vehicle']['0']['plate'] +"</p>" +
                                "<p class='font-weight-bolder' id='vehicle_name'>" + "ماهانVIP مانیتوردار(کاوه و صفه )" + "</p>" +
                                "<div class='col-8'>" +
                                "<div class='row py-2'>" +
                                "<div class='h4 col-4 font-weight-bolder text-center' id='date_of_departure'> 00:15</div>" +
                                "<div class='col-2'>" +
                                "<p class='h5' id='origin_town_name'>تهران</p>" +
                                "</div>" +
                                "<div class='col-3 d-flex justify-content-center'>" +
                                '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#fbb33b"><path d="M41.13219,48.11969c-0.88687,0.05375 -1.72,0.44344 -2.32469,1.10188l-35.31375,36.77844l35.31375,36.77844c0.84656,0.90031 2.10969,1.27656 3.30563,0.98094c1.19594,-0.29563 2.15,-1.20938 2.48594,-2.39188c0.34937,-1.19594 0.02687,-2.4725 -0.84656,-3.34594l-27.42594,-28.58156h148.79344c1.23625,0.01344 2.39188,-0.63156 3.02344,-1.70656c0.61813,-1.075 0.61813,-2.39187 0,-3.46687c-0.63156,-1.075 -1.78719,-1.72 -3.02344,-1.70656h-148.79344l27.42594,-28.58156c1.00781,-1.00781 1.29,-2.52625 0.69875,-3.81625c-0.57781,-1.30344 -1.89469,-2.10969 -3.31906,-2.0425z"></path></g></g></svg>' +
                                "</div>" +
                                "<div class='col-3'>" +
                                "<p class='h5' id='destination_name'>اصفهان</p>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "<div class='col-3 p-5'>" +
                                "<div class='d-flex justify-content-center mb-1'>" +
                                "<p class='h4 text-primary font-weight-bolder mx-1'>94000</p>" +
                                "<p class='text-muted small align-self-end mx-1'>ریال</p>" +
                                "</div>" +
                                "<div class='d-flex justify-content-center mb-2'>" +
                                "<button class='btn btn-primary w-100'>" +
                                "انتخاب بلیط" +
                                "</button>" +
                                "</div>" +
                                "<div>" +
                                "<p class='text-muted text-center'><span class='text-muted text-center' id='remaining_capacity'>18</span>صندلی باقی ماند</p>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</li>"
                            );

                        });

                        // console.log(result['data']['trips'][0]['capacity']);
                        $("#remaining_capacity").html(result['data']['trips'][0]['capacity'])

                        $("#vehicle_list").removeClass("d-none")
                    } else {
                        $("#no_vehicle").removeClass("d-none")
                    }
                }
            });
        });

    })

</script>
