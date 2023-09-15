@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="row g-gs">
                        <div class="col-xxl-12">
                            <div class="row g-gs">
                                <div class="col-md-6">
                                    <div class="card h-100 border-info">
                                        <div class="card-header text-white text-bg-info">Trong ngày</div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Tổng nhập</span>
                                                <span>{{ number_format($tien_nhap_kho) ?? 0 }} VNĐ</span>
                                            </div>
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Doanh thu</span>
                                                <span>{{ number_format($tien_xuat_kho) ?? 0 }} VNĐ</span>
                                            </div>
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Lãi</span>
                                                <span>{{ number_format($lai) ?? 0 }} VNĐ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100 border-warning">
                                        <div class="card-header text-white text-bg-warning">Thông tin hàng hóa</div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Loại hàng</span>
                                                <span>{{ $so_luong_loai_hang ?? 0 }}</span>
                                            </div>
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Hàng hóa</span>
                                                <span>{{ $so_luong_hang_hoa ?? 0 }}</span>
                                            </div>
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Hết hàng</span>
                                                <span>{{ $so_luong_het_hang ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6">
                            <div class="card h-100">
                                <div class="row g-0 col-sep col-sep-md">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="card-title-group mb-4">
                                                <div class="card-title">
                                                    <h4 class="title">Doanh thu hàng hóa theo tháng</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <canvas id="chart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6">
                            <div class="card h-100">
                                <div class="card-body flex-grow-0 py-2">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h4 class="title">Top hàng hóa theo doanh thu</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-middle mb-0">
                                        <thead class="table-light table-head-sm">
                                            <tr>
                                                <th class="tb-col"><span class="overline-title">Hàng hóa</span></th>
                                                <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Xuất
                                                        kho</span></th>
                                                <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Doanh
                                                        thu</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($doanh_thu as $dt)
                                                <tr>
                                                    <td class="tb-col">
                                                        <div class="media-group">
                                                            <div class="media media-md flex-shrink-0 media-middle">
                                                                <img
                                                                    src="{{ asset('storage/images/hanghoa/' . $dt->img) }}">
                                                            </div>
                                                            <div class="media-text">
                                                                <a href="{{ route('hang-hoa.show', $dt->ma_hang_hoa) }}"
                                                                    class="title">{{ strlen($dt->ten_hang_hoa) > 20 ? substr($dt->ten_hang_hoa, 0, 20) . '...' : substr($dt->ten_hang_hoa, 0, 20) }}</a>
                                                            </div>
                                                    </td>
                                                    <td class="tb-col tb-col-end tb-col-sm"><span
                                                            class="small">{{ $dt->so_luong }}</span></td>
                                                    <td class="tb-col tb-col-end tb-col-sm"><span
                                                            class="small">{{ number_format($dt->doanh_thu, 0, '', '.') }}
                                                            VNĐ</span></td>
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('api.doanh-thu') }}',
                method: 'GET',
                success: function(response) {
                    let ctx = document.getElementById('chart').getContext('2d');
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Doanh thu theo tháng',
                                data: response.values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        })
    </script>
@endsection
