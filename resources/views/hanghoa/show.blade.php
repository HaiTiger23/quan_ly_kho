@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Thông tin</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        <li class="breadcrumb-item"><a href="{{ route('hang-hoa.index') }}">Quản lý siêu thị</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $hang_hoa->ten_hang_hoa }}</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                @can('user')
                                    <ul class="d-flex">
                                        <li><a href="{{ route('hang-hoa.edit', $hang_hoa->ma_hang_hoa) }}" class="btn btn-primary btn-md d-md-none"><em
                                                    class="icon ni ni-edit"></em></em><span>Sửa</span></a></li>
                                        <li><a href="{{ route('hang-hoa.edit', $hang_hoa->ma_hang_hoa) }}" class="btn btn-primary d-none d-md-inline-flex"><em
                                                    class="icon ni ni-edit"></em><span>Sửa thông tin</span></a>
                                        </li>
                                    </ul>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-5"><img src="{{ asset('storage/images/hanghoa/' . $hang_hoa->img) }}" alt="{{ $hang_hoa->ten_hang_hoa }}"
                                width="400" style="max-height: 300px; height: auto" class="rounded mx-auto d-block">
                        </div>
                        <div class="col-md-6 card mb-5">
                            <div class="card-body">
                                <h4 class="bio-block-title">Chi tiết</h4>
                                <ul class="list-group list-group-borderless small">
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Mã
                                            hàng hóa:</span><span class="text">{{ $hang_hoa->ma_hang_hoa }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Tên
                                            hàng hóa:</span><span class="text">{{ $hang_hoa->ten_hang_hoa }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Loại
                                            hàng hóa:</span><span class="text">{{ $hang_hoa->getLoaiHang->ten_loai_hang }}</span></li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Đơn
                                            vị:</span><span class="text">{{ $hang_hoa->don_vi_tinh }}</span></li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Barcode:</span><span class="text">
                                            {{ $hang_hoa->barcode }}</span></li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Tổng giá trị:</span>
                                        <span class="text tong_gia_tri"> {{ number_format($hang_hoa->tong, 0, '', '.') }} VNĐ
                                        </span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Mô
                                            tả:</span><span class="text"> {!! $hang_hoa->mo_ta !!}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <table class="table" data-nk-container="table-responsive" id="hang-hoa">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col"><span class="overline-title">STT</span></th>
                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                    <th class="tb-col"><span class="overline-title">Giá nhập</span></th>
                                    <th class="tb-col"><span class="overline-title">Ngày sản xuất</span></th>
                                    <th class="tb-col"><span class="overline-title">Bảo quản(tháng)</span>
                                    <th class="tb-col"><span class="overline-title">Hạn sử dụng</span>
                                    <th class="tb-col"><span class="overline-title">Thành tiền</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    use Carbon\Carbon;
                                @endphp
                                @foreach ($chi_tiet_hang_hoa as $key => $chi_tiet)
                                    @php
                                        $gia_nhap = number_format($chi_tiet->gia_nhap, 0, '', '.');
                                        $thanh_tien = number_format($chi_tiet->so_luong * $chi_tiet->gia_nhap, 0, '', '.');
                                        $date = Carbon::parse($chi_tiet->ngay_san_xuat);
                                        $date->addMonths($chi_tiet->tg_bao_quan);
                                        $diffDays = Carbon::now()->diffInDays($date, false);
                                        $ngay_san_xuat = Carbon::createFromFormat('Y-m-d', $chi_tiet->ngay_san_xuat)->format('d-m-Y');
                                    @endphp
                                    <tr>
                                        <td class="tb-col">
                                            <span>{{ $key + 1 }}</span>
                                        </td>
                                        <td class="tb-col"><span>{{ $chi_tiet->so_luong }}</span></td>
                                        <td class="tb-col"><span>{{ $gia_nhap }} VNĐ</span></td>
                                        <td class="tb-col">
                                            <span>{{ $ngay_san_xuat }}</span>
                                        </td>
                                        <td class="tb-col">
                                            <span>{{ $chi_tiet->tg_bao_quan }}</span>
                                        </td>
                                        <td class="tb-col">
                                            @if ($diffDays > 30)
                                                <span class="badge text-bg-success-soft">Còn {{ $diffDays }} ngày</span>
                                            @elseif ($diffDays <= 30 && $diffDays > 0)
                                                <span class="badge text-bg-warning-soft">Còn {{ $diffDays }} ngày</span>
                                            @else
                                                <span class="badge text-bg-danger-soft">Hết hạn {{ abs($diffDays) }} ngày</span>
                                            @endif
                                        </td>
                                        <td class="tb-col">
                                            <span class="tb-col">{{ $thanh_tien }} VNĐ</span>
                                        </td>
                                        <td class="tb-col tb-col-end"><a class="btn btn-info btn-sm"
                                                href="{{ route('nhap-kho.show', $chi_tiet->ma_phieu_nhap) }}"><em class="icon ni ni-eye"></em><span>Xem</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('parts.paginate', ['paginator' => $chi_tiet_hang_hoa])
            </div>
        </div>
    </div>
    </div>
@endsection


@section('script')
@endsection
