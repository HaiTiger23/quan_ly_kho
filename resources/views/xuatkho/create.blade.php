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
                                <h2 class="nk-block-title">Thanh toán</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('nhap-kho.index') }}">Thanh toán</a></li>
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
                                                                <label for="ma_phieu_xuat" class="form-label">Mã Hóa đơn</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" minlength="1" maxlength="255"
                                                                        class="form-control" name="ma_phieu_xuat"
                                                                        value="{{ $ma_phieu_xuat }}">
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('ma_phieu_xuat') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ngay_xuat" class="form-label">Ngày thanh toán</label>
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
                                                                <input type="hidden" id="don_gia" name="don_gia"
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
                                                <table id="item-table" class="table"
                                                    data-nk-container="table-responsive">
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
                                                        {{-- item --}}
                                                        {{-- <tr class="item-row mb-4">
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap d-flex">
                                                                    1.
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap d-flex">
                                                                    <input style="width:100%" list="ma_hang_hoa"
                                                                        name="ma_hang_hoa[]" class="form-control">

                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input style="width:100%"
                                                                        type="number" min="1" max="1000000000"
                                                                        class="form-control" name="so_luong[]" required />
                                                                </div>
                                                            </td>
                                                            <td class="tb-col">
                                                                <div class="form-control-wrap"><input style="width:100%"
                                                                        type="number" min="1" max="1000000000"
                                                                        class="form-control" name="gia_nhap[]" required />
                                                                </div>
                                                            </td>
                                                            <td class="tb-col tb-col-end text-center"><button
                                                                    type="button"
                                                                    class="btn btn-danger btn-sm remove-item">Xóa</button>
                                                            </td>
                                                        </tr> --}}
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
                                                        <span>Xác nhận</span>
                                                    </div>
                                                </li>
                                                <li style="margin-left: 10px">
                                                    <button id="btn-export" type="submit"
                                                        class="btn btn-primary d-md-inline-flex">
                                                        <em class="icon ni ni-file-download"></em>
                                                        <span>Export</span>
                                                    </button>
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
                                                    <td class="tb-col"><span>{{ $so_luong }}</span></td>
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
                                                        <div class="btn btn-primary btn-sm" onclick="addItem(this)"
                                                            data-index="{{ $hang->ma_hang_hoa }}">Thêm</div>
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
    <script>
        $(document).ready(function() {
            const formCreate = document.getElementById('form-create')
            const inNum = document.querySelectorAll('input[type="number"]');
            const quill = new Quill('#quill_editor', {
                theme: 'snow'
            });
            let selectedValues = []

            inNum.forEach(e => {
                e.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    } else if (this.value > parseInt(e.getAttribute('max'))) {
                        this.value = parseInt(e.getAttribute('max'));
                    }
                });
            });

            $('#searchInput').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('api.xuat-kho.search') }}",
                        data: {
                            searchInput: request.term, // dữ liệu nhập vào
                            selectedValues: selectedValues
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(data)
                            response(
                                $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        so_luong: item.so_luong,
                                        gia_nhap: item.gia_nhap,
                                        ngay_san_xuat: item.ngay_san_xuat,
                                        tg_bao_quan: item.tg_bao_quan,
                                        ma_hang_hoa: item.get_hang_hoa.ma_hang_hoa,
                                        ten_hang_hoa: item.get_hang_hoa
                                            .ten_hang_hoa,
                                        don_vi_tinh: item.get_hang_hoa.don_vi_tinh,
                                        hang_hoa: item
                                    }
                                })
                            );
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    let hang_hoa = ui.item.hang_hoa
                    selectedValues.push(hang_hoa.id)

                    const htmls = `<tr>
                                    <input type="hidden" class="hang-hoa" value="${hang_hoa.id}">
                                    <td class="tb-col"><span>${hang_hoa.ma_hang_hoa}</span></td>
                                    <td class="tb-col"><span>${hang_hoa.get_hang_hoa.ten_hang_hoa}</span></td>
                                    <td class="tb-col"><span>${hang_hoa.get_hang_hoa.don_vi_tinh}</span></td>
                                    <td class="tb-col"><span>${hang_hoa.so_luong}</span></td>
                                    <td class="tb-col"><input style="width:100%;" type="number" min="0" max="${hang_hoa.so_luong}" class="so-luong"></td>
                                    <td class="tb-col"><input style="width:80%" type="number" min="0" class="gia">  VNĐ</td>
                                    <td class="tb-col"><span class="thanh-tien"> 0 VNĐ</span></td>
                                    <td class="tb-col tb-col-end"><button type="button" class="btn-delete btn btn-danger">Xóa</button></td>
                                </tr>`

                    const $htmls = $(htmls);
                    const $soLuong = $htmls.find('.so-luong');
                    const $gia = $htmls.find('.gia');
                    const $thanhTien = $htmls.find('.thanh-tien');
                    const btnXoa = $htmls.find('.btn-delete');

                    btnXoa.on('click', function() {
                        const $row = $(this).closest('tr');
                        $row.remove();
                        selectedValues = selectedValues.filter(function(id) {
                            return id !== hang_hoa.id;
                        });
                    });

                    $soLuong.on('input', function() {
                        if (this.value <= 0) {
                            this.value = '';
                        } else if (this.value > parseInt($soLuong.attr('max'))) {
                            this.value = parseInt($soLuong.attr('max'));
                        }
                    });

                    $soLuong.on('keyup', function() {
                        if ($soLuong.val() > 0 && $gia.val() > 0) {
                            let tongTien = $soLuong.val() * $gia.val();
                            $thanhTien.html(
                                `<span>${new Intl.NumberFormat('vi-VN', { maximumSignificantDigits: 3 }).format(tongTien)} VNĐ</span>`
                            );
                        } else {
                            $thanhTien.html(`<span>0 VNĐ</span>`);
                        }
                    });

                    $gia.on('keyup', function() {
                        if ($soLuong.val() > 0 && $gia.val() > 0) {
                            let tongTien = $soLuong.val() * $gia.val();
                            $thanhTien.html(
                                `<span>${new Intl.NumberFormat('vi-VN', { maximumSignificantDigits: 3 }).format(tongTien)} VNĐ</span>`
                            );
                        } else {
                            $thanhTien.html(`<span>0 VNĐ</span>`);
                        }
                    });

                    $('tbody').append($htmls)
                }
            }).autocomplete("instance")._renderItem = function(ul, item) {
                return $("<li>")
                    .append(`
                            <div>
                                MHH: ${item.ten_hang_hoa} - Tên: ${item.ma_hang_hoa} - SL: ${item.so_luong} - Giá: ${item.gia_nhap}
                                - NSX: ${item.ngay_san_xuat} - TGBQ: ${item.tg_bao_quan}
                            </div>
                        `)
                    .appendTo(ul);
            };

            const btnSubmit = document.getElementById('btn-submit')
            const btnExport = document.getElementById('btn-export')
            let apiUrl = ''

            btnSubmit.onclick = function() {
                apiUrl = '{{ route('api.xuat-kho.store') }}'
            }

            btnExport.onclick = function() {
                apiUrl = '{{ route('xuat-kho.export') }}'
            }


            formCreate.onsubmit = function(e) {
                e.preventDefault()
                const ma_phieu_xuat = $('input[name="ma_phieu_xuat"]').val()
                const ngay_xuat = $('input[name="ngay_xuat"]').val()
                const khach_hang = $('input[name="khach_hang"]').val()
                const dia_chi = $('input[name="dia_chi"]').val()
                const mo_ta = quill.getContents().ops[0].insert
                const id_user = {{ auth()->user()->id }}
                console.log(mo_ta);

                let data = [{
                    ma_phieu_xuat: ma_phieu_xuat,
                    ngay_xuat: ngay_xuat,
                    khach_hang: khach_hang,
                    dia_chi: dia_chi,
                    mo_ta: mo_ta === "\n" ? '' : mo_ta,
                    id_user: id_user
                }]

                $('tbody tr').each(function() {
                    const item = {
                        id_chi_tiet_hang_hoa: $(this).find('.hang-hoa').val(),
                        so_luong: $(this).find('.so-luong').val(),
                        gia_xuat: $(this).find('.gia').val()
                    }
                    data.push(item);
                });

                const token = '{{ csrf_token() }}'

                $.ajax({
                    type: 'POST',
                    url: apiUrl,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    data: JSON.stringify(data),
                    success: function(response) {
                        if (response.type === 'success') {
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                            });
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 3000);
                        } else if (response.type === 'export') {
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#fc0303',
                                confirmButtonText: 'OK',
                                cancelButtonText: 'Đóng'
                            }).then((result) => {
                                if (result.value) {
                                    let downloadLink = document.createElement("a");
                                    downloadLink.href = response.downloadUrl;
                                    document.body.appendChild(downloadLink);
                                    downloadLink.click();
                                    document.body.removeChild(downloadLink);
                                }
                            }).catch((error) => {
                                console.log(error);
                            });
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        var errorText = '';

                        $.each(errors, function(index, error) {
                            $.each(error, function(key, value) {
                                errorText += value + "\n";
                            })
                        })

                        alert(errorText);
                    }
                });

                return true
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.2/socket.io.js"
        integrity="sha512-zoJXRvW2gC8Z0Xo3lBbao5+AS3g6YWr5ztKqaicua11xHo+AvE1b0lT9ODgrHTmNUxeCw0Ry4BGRYZfXu70weg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var socket = io('http://localhost:6001')
        socket.on('laravel_database_Cart', (data) => {
            let items = document.querySelectorAll('.item-row');
            let check = true
            items.forEach(function(item) {
                if (item.getAttribute('id') == data.data.sanPham.ma_hang_hoa) {
                    check = false
                    let soluong = item.querySelector('.soLuong').value;
                    item.querySelector('.soLuong').value = parseInt(soluong) + 1;
                }
            });
            if (check) {
                let gia_ban = new Intl.NumberFormat('en-IN', {
                    maximumSignificantDigits: 3
                }).format(data.data.sanPham.gia_ban)
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
                             ${gia_ban} VND
                        </div>
                    </td>
                    <td class="tb-col">
                        <div class="form-control-wrap"><input style="width:100%"
                                type="number" min="1" max="1000000000"
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
        }

        function addItem(e) {
            let item = document.querySelector('#hang-' + e.getAttribute('data-index'))
            let items = document.querySelectorAll('.item-row');
            let check = true

            let donGia = document.querySelector('#donGia')
            let donGiaInput = document.querySelector('#don_gia').value

            document.querySelector('#don_gia').value = parseInt(donGiaInput) + parseInt(item.querySelector('.giaBan').value)

            let gia = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(parseInt(donGiaInput) + parseInt(item.querySelector('.giaBan').value))

            donGia.innerHTML = gia

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
                    soluong: 1
                }

                let gia_ban = new Intl.NumberFormat('en-IN', {
                    maximumSignificantDigits: 3
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
                            class="form-control" name="gia_ban[]" value="${itemData.giaBan}" />
                        <div class="form-control-wrap d-flex">
                             ${gia_ban} VND
                        </div>
                    </td>
                    <td class="tb-col">
                        <div class="form-control-wrap"><input style="width:100%"
                                type="number" min="1" max="1000000000"
                                class="form-control soLuong" name="so_luong[]" required  value="1"/>
                        </div>
                    </td>
                    <td class="tb-col tb-col-end text-center"><div class="btn btn-danger btn-sm" onclick="removeItem(this)" data-index="${itemData.id}">Xóa</div>
                    </td>
                </tr>
                `)
            }
        }
        $('#btn-submit').on('click', () => {
            let form = $('#form-create')
            let formData = form.serialize();
            $.ajax({
                method: 'POST',
                url: '/xuat-kho/tao-phieu',
                data: formData,
                success: function() {
                    Swal.fire({
                        icon: 'success',
                        title: '{{ __('Thành công') }}!',
                        text: '{{ __('Đã thêm bài khảo sát') }}!',
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
