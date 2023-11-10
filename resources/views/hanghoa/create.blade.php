@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Thêm hàng hóa</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('hang-hoa.index') }}">Quản lý
                                                kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Thêm hàng hóa</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <form action="{{ route('hang-hoa.store') }}" method="POST" enctype="multipart/form-data"
                            id="form-create">
                            @csrf
                            <div class="row g-gs">
                                <div class="col-xxl-9">
                                    <div class="gap gy-4">
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <div class="card-body">
                                                    <div class="row g-gs">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ma_hang_hoa" class="form-label">Mã hàng
                                                                    hóa</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        id="ma_hang_hoa" name="ma_hang_hoa"
                                                                        value="{{ old('ma_hang_hoa') }}"
                                                                        placeholder="Mã hàng hóa" maxlength="100">
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('ma_hang_hoa') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="ten_hang_hoa" class="form-label">Tên hàng
                                                                    hóa</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        id="ten_hang_hoa" name="ten_hang_hoa"
                                                                        value="{{ old('ten_hang_hoa') }}"
                                                                        placeholder="Tên hàng hóa" maxlength="255">
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('ten_hang_hoa') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="don_vi_tinh" class="form-label"> Đơn vị
                                                                    tính</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        id="don_vi_tinh" name="don_vi_tinh"
                                                                        value="{{ old('don_vi_tinh') }}"
                                                                        placeholder="Đơn vị tính" maxlength="50">
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('don_vi_tinh') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="barcode" class="form-label">Barcode</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control"
                                                                        id="barcode" name="barcode"
                                                                        value="{{ old('barcode') }}" placeholder="Barcode"
                                                                        maxlength="100">
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('barcode') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="barcode" class="form-label">Giá bán</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="number" class="form-control"
                                                                        id="gia_ban" name="gia_ban"
                                                                        value="{{ old('gia_ban') }}" placeholder="Giá bán"
                                                                        maxlength="100">
                                                                </div>
                                                                @if ($errors)
                                                                    <span
                                                                        class="text-danger py-1 mt-2">{{ $errors->first('gia_ban') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Mô tả</label>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xxl-3">
                                    <div class="card card-gutter-md">
                                        <div class="card-body">
                                            <div class="row g-gs">
                                                <div class="col-12">
                                                    <div class="form-group"><label class="form-label">Ảnh bìa</label>
                                                        <div class="form-control-wrap">
                                                            <div
                                                                class="image-upload-wrap d-flex flex-column align-items-center">
                                                                <div class="media media-huge border">
                                                                    <img id="img" class="w-100 h-100"
                                                                        src="{{ asset('storage/images/hanghoa/hanghoa.jpg') }}"
                                                                        alt="img">
                                                                </div>
                                                                <div class="pt-3">
                                                                    <input class="upload-image" data-target="img"
                                                                        id="change-img" name="change_img" type="file"
                                                                        max="1" hidden>
                                                                    <label for="change-img"
                                                                        class="btn btn-md btn-primary">Thay đổi</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($errors)
                                                            <span
                                                                class="text-danger py-1 mt-2">{{ $errors->first('change_img') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Loại hàng hóa</label>
                                                        <div class="form-control-wrap">
                                                            <select class="js-select" name="id_loai_hang"
                                                                data-search="true" data-sort="false">
                                                                <option value="">Loại hàng hóa</option>
                                                                @foreach ($loai_hang as $loai)
                                                                    <option value="{{ $loai->id }}"
                                                                        {{ old('id_loai_hang') == $loai->id ? 'selected' : '' }}>
                                                                        {{ $loai->ten_loai_hang }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if ($errors)
                                                            <span
                                                                class="text-danger py-1 mt-2">{{ $errors->first('id_loai_hang') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gap-col">
                                    <ul class="d-flex align-items-center gap g-3">
                                        <li><button type="submit" class="btn btn-primary">Lưu</button></li>
                                        <li><a href="{{ url()->previous() }}" class="btn border-0">Quay
                                                lại</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
    <script>
        const quill = new Quill('#quill_editor', {
            theme: 'snow'
        });

        const form = document.querySelector('#form-create');
        form.onsubmit = function(e) {
            const mo_ta = document.querySelector('input[name=mo_ta]');
            mo_ta.value = JSON.stringify(quill.getContents());

            return true;
        };
    </script>
@endsection
