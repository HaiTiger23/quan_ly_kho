@extends('default')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css"
        integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Hóa đơn</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('nhap-kho.index') }}">Hóa đơn</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div>
                            @csrf
                            <form method="POST" id="form-create" class="row g-gs">
                                @csrf
                                <div class="col-xxl-12">
                                    <div class="gap gy-4">
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <div class="card-body">
                                                    <div class="row g-gs">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ma_phieu_xuat" class="form-label">Mã Hóa
                                                                    đơn</label>
                                                                <div class="form-control-wrap">
                                                                    <input  type="text" minlength="1"
                                                                        maxlength="255" class="form-control"
                                                                        name="ma_phieu_xuat" value="{{ $ma_phieu_xuat }}">
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('ma_phieu_xuat') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ngay_xuat" class="form-label">Ngày thanh
                                                                    toán</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="date" class="form-control"
                                                                        name="ngay_xuat" value="{{ old('ngay_xuat') }}"
                                                                        required>
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('ngay_xuat') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"> <label for="khach_hang"
                                                                    class="form-label">Khách hàng</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        name="khach_hang" placeholder="Nhập khách hàng"
                                                                        value="{{ old('khach_hang') }}" required>
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('khach_hang') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"> <label for="dia_chi"
                                                                    class="form-label">Địa chỉ</label>
                                                                <div class="form-control-wrap"> <input type="text"
                                                                        class="form-control" name="dia_chi"
                                                                        placeholder="Nhập địa chỉ"
                                                                        value="{{ old('dia_chi') }}" required>
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('dia_chi') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" id="quill_editor"
                                                                        value="{!! old('mo_ta') !!}"
                                                                        data-toolbar="minimal"
                                                                        data-placeholder="Viết chi tiết sản phẩm vào đây...">
                                                                    </div>
                                                                    <input type="hidden" name="mo_ta">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Đơn Giá</label>
                                                                <input type="hidden" id="don_gia_input" name="don_gia_input"
                                                                    value="0">
                                                                <div class="form-control-wrap" id="donGia">
                                                                    0 VND
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- chi tiet đơn hàng --}}

                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <table id="item-table" class="table" data-nk-container="table-responsive">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="tb-col"><span class="overline-title">ID</span></th>
                                                            <th class="tb-col"><span class="overline-title">Tên
                                                                    hàng</span></th>
                                                            <th class="tb-col"><span class="overline-title">Giá</span>
                                                            <th class="tb-col"><span class="overline-title">SL</span>
                                                            </th>
                                                            </th>
                                                            </th>
                                                            <th class="tb-col tb-col-end"><span
                                                                    class="overline-title">Hành động</span></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="tableChiTietXuat">
                                                        {{-- chi tiết phiếu xuất --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- buttons --}}

                                        <div class="gap-col">
                                            <ul class="d-flex justify-content-end gap g-3">
                                                <li>
                                                    <div id="btn-submit" class="btn btn-primary d-md-inline-flex">
                                                        <em class="icon ni ni-plus"></em>
                                                        <span>Hoàn thành</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- all hàng hóa --}}

                            <div class="nk-block mt-4">
                                <div class="card">
                                    <table class="datatable-init table" data-nk-container="table-responsive"
                                        id="hang-hoa">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="tb-col"><span class="overline-title">STT</span></th>
                                                <th class="tb-col"><span class="overline-title">Mã hàng</span></th>
                                                <th class="tb-col"><span class="overline-title">Tên hàng</span></th>
                                                <th class="tb-col"><span class="overline-title">SL</span></th>
                                                <th class="tb-col"><span class="overline-title">Đơn vị</span></th>
                                                <th class="tb-col"><span class="overline-title">Loại hàng</span></th>
                                                <th class="tb-col"><span class="overline-title">Trạng thái</span></th>
                                                <th class="tb-col"><span class="overline-title">Giá bán</span></th>
                                                <th class="tb-col tb-col-end" data-sortable="false"><span
                                                        class="overline-title">Hành động</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hang_hoa as $key => $hang)
                                                <tr id="hang-{{ $hang->ma_hang_hoa }}">
                                                    <td class="tb-col">
                                                        <span>{{ $key + 1 }}</span>
                                                    </td>
                                                    <td class="tb-col">
                                                        <input type="hidden" class="idHang"
                                                            value="{{ $hang->id }}">
                                                        <span>{{ strlen($hang->ma_hang_hoa) > 10 ? substr($hang->ma_hang_hoa, 0, 10) . '...' : substr($hang->ma_hang_hoa, 0, 10) }}</span>
                                                    </td>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media-text">
                                                                <input type="hidden" class="tenHangHoa"
                                                                    value="{{ $hang->ten_hang_hoa }}">
                                                                <a href="{{ route('hang-hoa.show', $hang->ma_hang_hoa) }}"
                                                                    class="title">{{ strlen($hang->ten_hang_hoa) > 20 ? substr($hang->ten_hang_hoa, 0, 20) . '...' : substr($hang->ten_hang_hoa, 0, 20) }}</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @php
                                                        $so_luong = 0;
                                                        foreach ($hang->getChiTiet as $value) {
                                                            $so_luong += $value->so_luong;
                                                        }
                                                    @endphp
                                                    <td class="tb-col">
                                                        <input type="hidden" class="so_luong"
                                                            value="{{ $so_luong }}">
                                                        <span>{{ $so_luong }}</span>
                                                    </td>
                                                    <td class="tb-col"><span>{{ $hang->don_vi_tinh }}</span></td>
                                                    <td class="tb-col">
                                                        <span>{{ strlen($hang->getLoaiHang->ten_loai_hang) > 15 ? substr($hang->getLoaiHang->ten_loai_hang, 0, 15) . '...' : substr($hang->getLoaiHang->ten_loai_hang, 0, 15) }}</span>
                                                    </td>
                                                    <td class="tb-col">
                                                        <span
                                                            class="badge text-bg-{{ $so_luong > 0 ? 'success' : 'danger' }}-soft">{{ $so_luong > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                                    </td>
                                                    <td class="tb-col">
                                                        <input type="hidden" value="{{ $hang->gia_ban }}"
                                                            class="giaBan">
                                                        <span>{{ number_format($hang->gia_ban) }} VND</span>
                                                    </td>
                                                    <td class="tb-col tb-col-end text-center">
                                                        <button {{ $so_luong < 1 ? 'disabled' : '' }}
                                                            class="btn btn-primary btn-sm" onclick="addItem(this)"
                                                            data-index="{{ $hang->ma_hang_hoa }}">Thêm</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast fade hide alert" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
        integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"
        integrity="sha512-zoJXRvW2gC8Z0Xo3lBbao5+AS3g6YWr5ztKqaicua11xHo+AvE1b0lT9ODgrHTmNUxeCw0Ry4BGRYZfXu70weg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const url_socket = `http://localhost:6001`;
        // const url_socket = `0.tcp.ap.ngrok.io:19554`;
        //    var socket = io('http://localhost:6001');
        var socket = io(url_socket)
        socket.on('laravel_database_Cart', (data) => {
            let items = document.querySelectorAll('.item-row');

            let check = true
            items.forEach(function(item) {
                if (item.getAttribute('id') == data.data.sanPham.ma_hang_hoa) {
                    check = false
                    let soluong = item.querySelector('.soLuong').value;
                    item.querySelector('.soLuong').value = parseInt(soluong) + 1;
                    let item2 = document.querySelector('#hang-' + item.getAttribute('data-index'))
                    let donGia = document.querySelector('#donGia')
                    let donGiaInput = document.querySelector('#don_gia_input').value

                    let gia = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(parseInt(donGiaInput) + parseInt(data.data.sanPham.gia_ban))

                    donGia.innerHTML = gia
                    document.querySelector('#don_gia_input').value = parseInt(donGiaInput) + parseInt(data.data.sanPham.gia_ban)
                }
            });
            if (check) {
                let donGia = document.querySelector('#donGia')
                let donGiaInput = document.querySelector('#don_gia_input').value
                let gia_ban = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(data.data.sanPham.gia_ban)
                let gia = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(parseInt(donGiaInput) + parseInt(data.data.sanPham.gia_ban))
                    donGia.innerHTML = gia
                    document.querySelector('#don_gia_input').value = parseInt(donGiaInput) + parseInt(data.data.sanPham.gia_ban)
                $('#tableChiTietXuat').append(`
                <tr class="item-row mb-4" id="${data.data.sanPham.ma_hang_hoa}">
                    <td class="tb-col">
                        <input type="hidden" name="id[]" value="${data.data.sanPham.id}"/>
                        <input type="hidden" name="ma_hang_hoa[]" value="${data.data.sanPham.ma_hang_hoa}"/>
                        <div class="form-control-wrap d-flex">
                            ${data.data.sanPham.ma_hang_hoa}
                        </div>
                    </td>
                    <td class="tb-col">
                        <div class="overflow-col">
                            ${data.data.sanPham.ten_hang_hoa}
                        </div>
                    </td>
                    <td class="tb-col">
                        <input style="width:100%" type="hidden"
                            class="form-control" name="gia_ban[]" value="${data.data.sanPham.gia_ban}" />
                        <div class="form-control-wrap d-flex">
                             ${gia_ban}
                        </div>
                    </td>
                    <td class="tb-col">
                        <div class="form-control-wrap"><input style="width:100%"
                                type="number" min="1" max="${data.data.sanPham.so_luong}"
                                class="form-control soLuong" name="so_luong[]" required  value="1"/>
                        </div>
                    </td>
                    <td class="tb-col tb-col-end text-center"><div class="btn btn-danger btn-sm" onclick="removeItem(this)" data-index="${data.data.sanPham.ma_hang_hoa}">Xóa</div>
                    </td>
                </tr>
                `)
            }
        })
    </script>
    <script>
        function removeItem(e) {
            let id = e.getAttribute('data-index');
            let items = document.querySelectorAll('.item-row');
            items.forEach(function(item) {
                if (item.getAttribute('id') == id) {
                    item.remove();
                }
            });
            updateTongTien();
        }

        function addItem(e) {
            let item = document.querySelector('#hang-' + e.getAttribute('data-index'))
            let items = document.querySelectorAll('.item-row');
            let check = true

            let donGia = document.querySelector('#donGia')
            let donGiaInput = document.querySelector('#don_gia_input').value

            items.forEach(function(item) {
                if (item.getAttribute('id') == e.getAttribute('data-index')) {
                    check = false
                    let soluong = item.querySelector('.soLuong').value;
                    item.querySelector('.soLuong').value = parseInt(soluong) + 1;
                }
            });
            if (check) {
                let itemData = {
                    id: e.getAttribute('data-index'),
                    idHang: item.querySelector('.idHang').value,
                    tenHangHoa: item.querySelector('.tenHangHoa').value,
                    giaBan: item.querySelector('.giaBan').value,
                    soluong: 1,
                    tongSL: item.querySelector('.so_luong').value
                }

                let gia_ban = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(itemData.giaBan)
                $('#tableChiTietXuat').append(`
                <tr class="item-row mb-4" id="${itemData.id}">
                    <td class="tb-col">
                        <input type="hidden" name="id[]" value="${itemData.idHang}"/>
                        <input type="hidden" name="ma_hang_hoa[]" value="${itemData.id}"/>
                        <div class="form-control-wrap d-flex">
                            ${itemData.id}
                        </div>
                    </td>
                    <td class="tb-col">
                        <div class="overflow-col">
                            ${itemData.tenHangHoa}
                        </div>
                    </td>
                    <td class="tb-col">
                        <input style="width:100%" type="hidden"
                            class="form-control gia_sp" name="gia_ban[]" value="${itemData.giaBan}" />
                        <div class="form-control-wrap d-flex">
                             ${gia_ban}
                        </div>
                    </td>
                    <td class="tb-col">
                        <div class="form-control-wrap"><input style="width:100%"
                                type="number" min="1" max="${itemData.tongSL}"
                                class="form-control soLuong so_luong_sp" name="so_luong[]" required  value="1"/>
                        </div>
                    </td>
                    <td class="tb-col tb-col-end text-center"><div class="btn btn-danger btn-sm" onclick="removeItem(this)" data-index="${itemData.id}">Xóa</div>
                    </td>
                </tr>
                `)
            }
            updateChangeSoLuong();
            updateTongTien();
        }

        function updateTongTien() {
            let tongTien = 0;
            let listGiaSP = document.querySelectorAll('.gia_sp');
            let listSoLuongSP = document.querySelectorAll('.so_luong_sp');

            for (let index = 0; index < listGiaSP.length; index++) {
                const giaSp = listGiaSP[index].value;
                const soLuongSp = listSoLuongSP[index].value;
                tongTien += giaSp *soLuongSp
            }
            document.querySelector('#don_gia_input').value = tongTien;
              let gia = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(tongTien)
            document.querySelector('#donGia').innerHTML = gia
        }
        function updateChangeSoLuong() {
              let listSoLuongSP = document.querySelectorAll('.so_luong_sp');
              listSoLuongSP.forEach((e) => {
                e.addEventListener('change', () => {
                    updateTongTien();
                });
              })
        }

        $('#btn-submit').on('click', () => {
            let form = $('#form-create')
            let formData = form.serialize();
            $.ajax({
                method: 'POST',
                url: '{{ route('api.xuat-kho.store') }}',
                data: formData,
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('Thành công') }}!',
                        text: '{{ __('Xuất kho thành công') }}!',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        },
                    }).then(function() {
                        window.location = "{{ route('xuat-kho.index') }}";
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('Thất bại') }}',
                        text: error.responseJSON,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                }
            });
        })
    </script>
@endsection
