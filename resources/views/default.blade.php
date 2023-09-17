<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quản lý kho</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style8a4f.css?v1.1.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/libs/editors/quill8a4f.css?v1.1.0') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css"
        integrity="sha512-1k7mWiTNoyx2XtmI96o+hdjP8nn0f3Z2N4oF/9ZZRgijyV4omsKOXEnqL1gKQNPy2MTSP9rIEWGcH/CInulptA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('style')
</head>

<style>
    /* Áp dụng CSS cho cột cụ thể */
    .overflow-col {
        white-space: nowrap;
        /* Ngăn ngắn dòng */
        max-width: 500px;
        /* Giới hạn chiều rộng */
        overflow: hidden;
        /* Ẩn nội dung vượt quá giới hạn */
        text-overflow: ellipsis;
        /* Hiển thị dấu ba chấm (...) nếu nội dung bị ẩn */
    }
</style>

<body class="nk-body" data-sidebar-collapse="lg" data-navbar-collapse="lg">
    <div class="nk-app-root">
        <div class="nk-main">
            @auth
                @include('parts.sidebar')

                <div class="nk-wrap">
                    @include('parts.header')

                    <div class="nk-content">

                    @endauth

                    @yield('content')

                    @auth
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/data-tables/data-tables.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/js/bootstrap.min.js"
        integrity="sha512-EKWWs1ZcA2ZY9lbLISPz8aGR2+L7JVYqBAYTq5AXgBkSjRSuQEGqWx8R1zAX16KdXPaCjOCaKE8MCpU0wcHlHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')

    {{-- <script>
        const bell = document.querySelector('.ni-bell')

        intervalId = setInterval(function() {
            bell.classList.toggle('notified')
        }, 800);

        function GetData() {
            $.ajax({
                url: '',
                type: 'GET',
                dataType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    let intervalId = null
                    bell = document.querySelector('.ni-bell')
                    let alertElement = document.querySelector('.nk-schedule')

                    while (alertElement.firstChild) {
                        alertElement.removeChild(alertElement.firstChild);
                    }

                    if (data['data'].length > 0) {

                        intervalId = setInterval(function() {
                            bell.classList.toggle('notified')
                        }, 1000);


                        data['data'].forEach(e => {
                            const dateObj = new Date(e.created_at)
                            const now = new Date()

                            const timeDiff = now.getTime() - dateObj.getTime()
                            let timeAgo

                            if (timeDiff < 60 * 1000) {
                                timeAgo = Math.floor(timeDiff / 1000) + ' giây trước';
                            } else if (timeDiff < 60 * 60 * 1000) {
                                const minutesDiff = Math.floor(timeDiff / (60 * 1000));
                                const secondsDiff = Math.floor((timeDiff - (minutesDiff * 60 * 1000)) / 1000);
                                timeAgo = minutesDiff + ' phút ' + secondsDiff + ' giây trước';
                            } else if (timeDiff < 60 * 60 * 1000 * 24) {
                                const hoursDiff = Math.floor(timeDiff / (60 * 60 * 1000));
                                const minutesDiff = Math.floor((timeDiff - (hoursDiff * 60 * 60 * 1000)) / (60 * 1000));
                                timeAgo = hoursDiff + ' giờ ' + minutesDiff + ' phút trước';
                            } else {
                                const daysDiff = Math.floor(timeDiff / (60 * 60 * 1000 * 24))
                                timeAgo = daysDiff + ' ngày trước'
                            }

                            const element = document.createElement('div')

                            element.innerHTML = `
                                            <li class="nk-schedule-item">
                                                <div class="nk-schedule-item-inner">
                                                    <div class="nk-schedule-symbol active"></div>
                                                    <div class="nk-schedule-content"><span class="smaller">${timeAgo}</span>
                                                        <div class="h6"><a href="/${e.id}"><span>Bạn có 1 đơn hàng mới từ ${e.ten_khach}</span></a></div>
                                                    </div>
                                                </div>
                                            </li>
                                            `

                            alertElement.appendChild(element)
                        })
                    } else {
                        clearInterval(intervalId);
                        bell.classList.remove('notified')
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) { // hàm được gọi khi yêu cầu thất bại
                    console.log(errorThrown);
                }
            });
        }
        GetData()

        setInterval(function() {
            GetData()
        }, 60000)
    </script> --}}

    @yield('script')
</body>

</html>
