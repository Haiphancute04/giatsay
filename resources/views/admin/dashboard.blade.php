@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold">{{ __('System Overview') }}</h1>
        <p class="text-muted">{{ __('Welcome :name', ['name' => Auth::user()->name]) }}</p>
    </div>

    {{-- PHẦN 1: CÁC THẺ THỐNG KÊ (CARDS) --}}
    <div class="row g-3 mb-4">
        {{-- Hàng 1 --}}
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-white-50">{{ __('Users') }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalUsers ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">group</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-white-50">{{ __('Orders') }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalOrders ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">shopping_cart</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-white-50">{{ __('Categories') }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalCategories ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">category</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-white-50">{{ __('Services') }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalServices ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">home_repair_service</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- Hàng 2 --}}
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-white-50">{{ __('Coupons') }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalCoupons ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">sell</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-white-50">{{ __('Reviews') }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalReviews ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">reviews</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark shadow-sm h-100">
                <div class="card-body">
                    <h6 class="card-title text-white-50">{{ __('Statuses') }}</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalStatuses ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">label</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white shadow-sm h-100" style="background-color: #6610f2;">
                <div class="card-body">
                    <h6 class="card-title text-white-50">Banner</h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h2 fw-bold mb-0">{{ $totalBanners ?? 0 }}</span>
                        <span class="material-symbols-outlined fs-1 text-white-50">imagesmode</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PHẦN 2: BIỂU ĐỒ THỐNG KÊ --}}
    <div class="row g-3">
        
        {{-- Biểu đồ 1: Doanh thu và Số đơn hàng (Kết hợp Bar & Line) --}}
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <span class="material-symbols-outlined align-middle me-1">analytics</span>
                        {{ __('Revenue & Order Statistics', ['year' => date('Y')]) }}
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Biểu đồ 2: Tỷ lệ trạng thái đơn hàng (Pie Chart) --}}
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <span class="material-symbols-outlined align-middle me-1">pie_chart</span>
                        {{ __('Order Status Ratio') }}
                    </h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div style="width: 100%; max-width: 300px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS VẼ BIỂU ĐỒ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- 1. Biểu đồ Doanh thu & Đơn hàng ---
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            
            const months = {!! json_encode($months) !!};
            const dataOrders = {!! json_encode($dataOrders) !!};
            const dataRevenue = {!! json_encode($dataRevenue) !!};

            new Chart(ctxRevenue, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: '{{ __("Order Count") }}',
                            data: dataOrders,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        {
                            label: '{{ __("Revenue") }} (VNĐ)',
                            data: dataRevenue,
                            type: 'line', 
                            backgroundColor: 'rgba(255, 193, 7, 0.2)',
                            borderColor: 'rgba(255, 193, 7, 1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3, 
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: { mode: 'index', intersect: false },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: '{{ __("Order Count") }}' }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: '{{ __("Revenue") }}' },
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.dataset.yAxisID === 'y1') {
                                        label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.raw);
                                    } else {
                                        label += context.raw;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // --- 2. Biểu đồ Tròn (Trạng thái đơn) ---
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            
            const statusLabels = {!! json_encode($statusLabels) !!};
            const statusData = {!! json_encode($statusData) !!};
            const statusColors = {!! json_encode($statusColors) !!};

            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: statusColors, 
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.chart._metasets[context.datasetIndex].total;
                                    let percentage = Math.round((value / total) * 100) + '%';
                                    return label + ': ' + value + ' (' + percentage + ')';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection