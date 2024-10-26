<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            box-sizing: border-box;
        }
        body {
            font-size: 10px;
            color: #091341;
        }
        .page-content {
            padding: 12px;
        }
        .page-header {
            text-align: center;
            font-size: 18px;
            color: #000DBB;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary table {
            width: 50%;
        }
        .details {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="page">
        @php
        // Defina a imagem da logomarca
            $logoImage = public_path('images/logos/logo-inicio.png');
        @endphp

        <div class="logo-container" style="text-align: center; padding: 10px 0;">
            <img src="{{ $logoImage }}" alt="Logomarca" style="width: 150px; height: auto;">
        </div>
        <!-- Header -->
        <div class="page-header">
            <h1>@lang('admin::app.dashboard.index.pdf.sales.title')</h1>
        </div>

        <div class="page-content">
            <!-- Resumo das Vendas -->
            <div class="summary">
                <h3>@lang('admin::app.dashboard.index.pdf.sales.summary')</h3>
                <table>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.total-sales')</th>
                        <td>{{ $summary['total_sales'] }}</td>
                    </tr>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.total-paid')</th>
                        <td>{{ $summary['total_paid'] }}</td>
                    </tr>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.total-pending')</th>
                        <td>{{ $summary['total_pending'] }}</td>
                    </tr>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.total-unpaid')</th>
                        <td>{{ $summary['total_unpaid'] }}</td>
                    </tr>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.total-value')</th>
                        <td>R$ {{ number_format($summary['total_value'], 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.total-value-paid')</th>
                        <td>R$ {{ number_format($summary['total_value_paid'], 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.total-value-unpaid')</th>
                        <td>R$ {{ number_format($summary['total_value_unpaid'], 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('admin::app.dashboard.index.pdf.sales.weekly-avg-sales')</th>
                        <td>{{ number_format($summary['weekly_avg_sales'], 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <!-- Detalhamento das Vendas -->
            <div class="details">
                <h3>@lang('admin::app.dashboard.index.pdf.sales.details')</h3>
                <table>
                    <thead>
                        <tr>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.date')</th>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.sale')</th>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.client')</th>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.payment-method')</th>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.product')</th>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.seller')</th>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.value')</th>
                            <th>@lang('admin::app.dashboard.index.pdf.sales.status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $detail)
                        <tr>
                            <td>{{ $detail['date'] }}</td>
                            <td>{{ $detail['sale'] }}</td>
                            <td>{{ $detail['client'] }}</td>
                            <td>{{ $detail['payment_method'] }}</td>
                            <td>{{ $detail['product'] }}</td>
                            <td>{{ $detail['seller'] }}</td>
                            <td>R$ {{ number_format($detail['value'], 2, ',', '.') }}</td>
                            <td>{{ $detail['status'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>