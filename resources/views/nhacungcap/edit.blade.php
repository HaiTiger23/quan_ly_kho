@extends('default')
@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Sửa</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('nha-cung-cap.index') }}">Nhà cung cấp</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Sửa</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <form action="{{ route('nha-cung-cap.update', $nha_cung_cap->ma_ncc) }}" method="post" enctype="multipart/form-data" id="form-edit">
                            @csrf
                            @method('put')
                            <div class="row g-gs">
                                <div class="col-xxl-12">
                                    <div class="gap gy-4">
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <div class="card-body">
                                                    <div class="row g-gs">
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label for="ten_ncc" class="form-label">Tên nhà cung cấp</label>
                                                                <div class="form-control-wrap"><input type="text" class="form-control" id="ten_ncc"
                                                                        name="ten_ncc" value="{{ $nha_cung_cap->ten_ncc }}" placeholder="Tên nhà cung cấp">
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('ten_ncc') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label for="ma_ncc" class="form-label">Mã nhà cung cấp</label>
                                                                <div class="form-control-wrap"><input type="text" class="form-control" id="ma_ncc"
                                                                        name="ma_ncc" value="{{ $nha_cung_cap->ma_ncc }}" placeholder="Mã nhà cung cấp">
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('ma_ncc') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label for="sdt" class="form-label">Số điện thoại</label>
                                                                <div class="form-control-wrap"><input type="text" class="form-control" id="sdt"
                                                                        name="sdt" value="0{{ $nha_cung_cap->sdt }}" placeholder="Số điện thoại">
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('sdt') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label class="form-label">Trạng
                                                                    thái</label>
                                                                <div class="form-control-wrap">
                                                                    <select class="js-select" name="id_trang_thai" data-search="true" data-sort="false">
                                                                        <option value="">Select an option</option>
                                                                        @foreach ($trang_thai as $tt)
                                                                            <option value="{{ $tt->id }}"
                                                                                {{ $nha_cung_cap->id_trang_thai == $tt->id ? 'selected' : '' }}>{{ $tt->ten_trang_thai }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('id_trang_thai') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group"><label for="dia_chi" class="form-label">Địa chỉ</label>
                                                                <div class="form-control-wrap"><input type="text" class="form-control" id="dia_chi"
                                                                        name="dia_chi" value="{{ $nha_cung_cap->dia_chi }}" placeholder="Địa chỉ">
                                                                </div>
                                                                {{-- @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('dia_chi') }}</span>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" name="mo_ta" id="quill_editor" value="{!! $nha_cung_cap->mo_ta !!}"
                                                                        data-toolbar="minimal" data-placeholder="Viết chi tiết nhà cung cấp vào đây...">
                                                                    </div>
                                                                    <input type="hidden" name="mo_ta" value="{{ $nha_cung_cap->mo_ta }}">
                                                                </div>
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

        let mo_ta = document.querySelector('input[name=mo_ta]').value;
        quill.setContents(quill.clipboard.convert(mo_ta));

        const form = document.querySelector('#form-edit');
        form.onsubmit = function(e) {
            mo_ta = document.querySelector('input[name=mo_ta]');
            mo_ta.value = JSON.stringify(quill.getContents());

            return true;
        };
    </script>
@endsection
