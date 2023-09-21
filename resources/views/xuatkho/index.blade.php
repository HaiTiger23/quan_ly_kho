@extends('default')

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
                                        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li>
                                        <a href="{{ route('xuat-kho.create') }}" class="btn btn-primary btn-md d-md-none">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Thanh toán</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('xuat-kho.create') }}"
                                            class="btn btn-primary d-none d-md-inline-flex">
                                            <em class="icon ni ni-plus"></em>
                                            <span>Thanh toán mới</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã hóa đơn</span></th>
                                        <th class="tb-col"><span class="overline-title">Nhân viên</span></th>
                                        <th class="tb-col" data-type="date" data-format="DD-MM-YYYY"><span
                                                class="overline-title">Ngày</span></th>
                                        <th class="tb-col tb-col-end"><span class="overline-title">Hành động</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($phieu_xuat as $key => $phieu)
                                        <tr>
                                            <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                            <td class="tb-col"><span>{{ $phieu->ma_phieu_xuat }}</span></td>
                                            <td class="tb-col"><span>{{ $phieu->getUsers->name }}</span></td>
                                            <td class="tb-col"><span>
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $phieu->ngay_xuat)->format('d-m-Y') }}
                                                </span></td>
                                            <td class="tb-col tb-col-end">
                                                <a href="{{ route('xuat-kho.show', $phieu->ma_phieu_xuat) }}"
                                                    class="btn btn-info btn-sm"><em
                                                        class="icon ni ni-eye"></em><span>Xem</span></a>
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

    <div class="modal fade" id="xuat_excel" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollableLabel">Nhập thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('xuat-kho.export') }}" method="POST" enctype="multipart/form-data" id="form-create">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-gs">
                            <div class="col-lg-6">
                                <div class="form-group"><label for="ma_phieu_xuat" class="form-label">Mã phiếu xuất</label>
                                    <div class="form-control-wrap">
                                        <input type="text" minlength="1" maxlength="255" class="form-control"
                                            id="ma_phieu_xuat" value="#{{ $ma_phieu_xuat }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"> <label for="ngay_xuat" class="form-label">Ngày xuất</label>
                                    <div class="form-control-wrap"> <input placeholder="yyyy/mm/dd" type="date"
                                            class="form-control" name="ngay_xuat" value="{{ old('ngay_xuat') }}"
                                            id="ngay_xuat" required> </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Chi tiết</label>
                                    <div class="form-control-wrap">
                                        <div class="js-quill" id="quill_editor" value="{!! old('mo_ta') !!}"
                                            data-toolbar="minimal" data-placeholder="Viết chi tiết sản phẩm vào đây...">
                                        </div>
                                        <input type="hidden" name="mo_ta">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group"><input type="file" class="form-control"
                                            name="excel_file" id="file" required></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-sm btn-primary">Đồng
                            ý</button>
                    </div>
                    <input type="hidden" name="ma_phieu_xuat" value="{{ $ma_phieu_xuat }}">
                </form>
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
