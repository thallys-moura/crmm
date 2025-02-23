<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ $locale = app()->getLocale() }}"
    dir="{{ in_array($locale, ['fa', 'ar']) ? 'rtl' : 'ltr' }}"
>
    <head>
        <!-- meta tags -->
        <meta
            http-equiv="Cache-control"
            content="no-cache"
        >

        <meta
            http-equiv="Content-Type"
            content="text/html; charset=utf-8"
        />

        @php
            if ($locale == 'en') {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            }  else {
                $fontFamily = [
                    'regular' => 'Arial, sans-serif',
                    'bold'    => 'Arial, sans-serif',
                ];
            }

            if (in_array($locale, ['ar', 'fa', 'tr'])) {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            }
        @endphp

        <!-- lang supports inclusion -->
        <style type="text/css">

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: {{ $fontFamily['regular'] }};
            }

            body {
                font-size: 10px;
                color: #091341;
                font-family: "{{ $fontFamily['regular'] }}";
            }

            b, th {
                font-family: "{{ $fontFamily['bold'] }}";
            }

            .page-content {
                padding: 12px;
            }

            .page-header {
                border-bottom: 1px solid #E9EFFC;
                text-align: center;
                font-size: 24px;
                text-transform: uppercase;
                color: #000DBB;
                padding: 24px 0;
                margin: 0;
            }

            .logo-container {
                position: absolute;
                top: 20px;
                left: 20px;
            }

            .logo-container.rtl {
                left: auto;
                right: 20px;
            }

            .logo-container img {
                max-width: 100%;
                height: auto;
            }

            .page-break {
                page-break-before: always;
            }

            .legal-terms {
                font-family: 'Times New Roman', serif;
                font-size: 14px;
                line-height: 1.8;
                text-align: justify;
                margin: 60px;
            }

            .legal-terms h1 {
                font-size: 20px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 30px;
            }

            .legal-terms h2 {
                font-size: 16px;
                font-weight: bold;
                margin-top: 25px;
            }

            .legal-terms p {
                font-size: 12px;
                margin-bottom: 15px;
            }

            .customer-signature {
                display: block;
                max-width: 200px;
                height: auto;
                margin-top: 5px;
                padding-bottom: 10px;
            }

            .footer {
                padding-top: 20px;
            }

            .footer img {
                padding-top: 20px;
                width: 200px;
            }

            .signature-footer {
                position: absolute;
                bottom: 20px;
                left: 0;
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 60px;
                margin-top: 50px;
                padding-top: 10px;
            }

            .signature {
                font-size: 18px;
                font-weight: bold;
                text-align: left;
                margin-top: 50px;
            }

            .signature-line {
                display: inline-block;
                width: 300px;
                border-bottom: 2px solid black;
            }

            .compliance-image {
                max-width: 300px;
                height: auto;
                align-items: flex-end;
                padding-left: 500px;
            }

            .footer {
                align-items: right;
                align-content: right;
            }

            .dotted-list {
                font-size: 12px;
                margin-left: 50px;
                padding-left: 30px;
            }

            .dotted-list ul {
                list-style-type: disc;
                margin-left: 30px;
                padding-left: 10px;
            }

            .dotted-list li {
                margin-bottom: 8px;
                font-size: 12px;
                font-weight: bold;
            }

            .page-header b {
                display: inline-block;
                vertical-align: middle;
            }

            .small-text {
                font-size: 7px;
            }

            table {
                width: 100%;
                border-spacing: 1px 0;
                border-collapse: separate;
                margin-bottom: 16px;
            }

            table thead th {
                background-color: #E9EFFC;
                color: #000DBB;
                padding: 6px 18px;
                text-align: left;
            }

            table.rtl thead tr th {
                text-align: right;
            }

            table tbody td {
                padding: 9px 18px;
                border-bottom: 1px solid #E9EFFC;
                text-align: left;
                vertical-align: top;
            }

            table.rtl tbody tr td {
                text-align: right;
            }

            .summary {
                width: 100%;
                display: inline-block;
            }

            .summary table {
                float: right;
                width: 250px;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #E9EFFC;
                white-space: nowrap;
            }

            .summary table.rtl {
                width: 280px;
            }

            .summary table.rtl {
                margin-right: 480px;
            }

            .summary table td {
                padding: 5px 10px;
            }

            .summary table td:nth-child(2) {
                text-align: center;
            }

            .summary table td:nth-child(3) {
                text-align: right;
            }
        </style>
    </head>

    <body dir="{{ $locale }}">
        <div class="page">
            @php
                // Defina a imagem padrão
                $defaultImage = public_path('images/products/firemax.png');

                // Verifica se o produto tem uma imagem definida e se o arquivo existe no servidor
                $productImage = (!empty($quote->items[0]->product->image) && file_exists(public_path('images/products/' . $quote->items[0]->product->image)))
                                ? public_path('images/products/' . $quote->items[0]->product->image)
                                : $defaultImage;
            @endphp

            <img src="{{ $productImage }}"
            alt="{{$quote->id}}"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; height: auto; opacity: 0.1; z-index: -1;">

            <!-- Header -->
            <div class="page-header">
                <b>@lang('admin::app.quotes.index.pdf.title')</b>
            </div>
            <div class="page-content">
                <!-- Invoice Information -->
                <table class="{{ app()->getLocale   () }}">
                    <tbody>
                        <tr>
                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                <b>
                                    @lang('admin::app.quotes.index.pdf.sales-person'):
                                </b>

                                <span>
                                    {{ $quote->user->name }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                <b>
                                    @lang('admin::app.quotes.index.pdf.date'):
                                </b>

                                <span>
                                    {{ core()->formatDate($quote->created_at, 'd-m-Y') }}
                                </span>
                            </td>

                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                <b>
                                    @lang('admin::app.quotes.index.pdf.expired-at'):
                                </b>

                                <span>
                                    {{ core()->formatDate($quote->expired_at, 'd-m-Y') }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Billing & Shipping Address -->
                <table class="{{ $locale }}">
                    <thead>
                        <tr>
                            @if ($quote->billing_address)
                                <th style="width: 50%;">
                                    <b>
                                        @lang('admin::app.quotes.index.pdf.billing-address')
                                    </b>
                                </th>
                            @endif

                            @if ($quote->shipping_address)
                                <th style="width: 50%">
                                    <b>
                                        @lang('admin::app.quotes.index.pdf.shipping-address')
                                    </b>
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            @if ($quote->billing_address)
                                <td style="width: 50%">
                                    <div>{{ $quote->billing_address['address'] ?? '' }}</div>

                                    <div>{{ $quote->billing_address['postcode'] ?? '' . ' ' .$quote->billing_address['city'] ?? '' }} </div>

                                    <div>{{ $quote->billing_address['state'] ?? '' }}</div>

                                    <div>{{ core()->country_name($quote->billing_address['country'] ?? '') }}</div>
                                </td>
                            @endif

                            @if ($quote->shipping_address)
                                <td style="width: 50%">
                                    <div>{{ $quote->shipping_address['address'] ?? ''}}</div>

                                    <div>{{ $quote->shipping_address['postcode'] ?? '' . ' ' .$quote->shipping_address['city'] ?? '' }} </div>

                                    <div>{{ $quote->shipping_address['state'] ?? '' }}</div>

                                    <div>{{ core()->country_name($quote->shipping_address['country'] ?? '') }}</div>
                                </td>
                            @endif
                        </tr>
                    </tbody>
                </table>

                <!-- Items -->
                <div class="items">
                    <table class="{{ app()->getLocale   () }}">
                        <thead>
                            <tr>
                                <th>
                                    @lang('admin::app.quotes.index.pdf.product-name')
                                </th>

                                <th>
                                    @lang('admin::app.quotes.index.pdf.price')
                                </th>

                                <th>
                                    @lang('admin::app.quotes.index.pdf.quantity')
                                </th>

                                <th>
                                    @lang('admin::app.quotes.index.pdf.amount')
                                </th>

                                <th>
                                    @lang('admin::app.quotes.index.pdf.discount')
                                </th>

                                <th>
                                    @lang('admin::app.quotes.index.pdf.tax')
                                </th>

                                <th>
                                    @lang('admin::app.quotes.index.pdf.grand-total')
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($quote->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->name }}
                                    </td>

                                    <td>{!! core()->formatBasePrice($item->price, true) !!}</td>

                                    <td class="text-center">{{ $item->quantity }}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->total, true) !!}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->discount_amount, true) !!}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->tax_amount, true) !!}</td>

                                    <td class="text-center">{!! core()->formatBasePrice($item->total + $item->tax_amount - $item->discount_amount, true) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

               <!-- Summary Table -->
                <div class="summary">
                    <table class="{{ app()->getLocale   () }}">
                        <tbody>
                            <tr>
                                <td>@lang('admin::app.quotes.index.pdf.sub-total')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($quote->sub_total, true) !!}</td>
                            </tr>

                            <tr>
                                <td>@lang('admin::app.quotes.index.pdf.tax')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($quote->tax_amount, true) !!}</td>
                            </tr>

                            <tr>
                                <td>@lang('admin::app.quotes.index.pdf.discount')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($quote->discount_amount, true) !!}</td>
                            </tr>

                            <tr>
                                <td>@lang('admin::app.quotes.index.pdf.adjustment')</td>
                                <td>-</td>
                                <td>{!! core()->formatBasePrice($quote->adjustment_amount, true) !!}</td>
                            </tr>

                            <tr>
                                <td><strong>@lang('admin::app.quotes.index.pdf.grand-total')</strong></td>
                                <td><strong>-</strong></td>
                                <td><strong>{!! core()->formatBasePrice($quote->grand_total, true) !!}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="coupons" style="margin-top: 40%; clear: both;">
                    <h3>@lang('admin::app.quotes.index.pdf.coupons-generated')</h3>
                    <table style="width: 100%;">
                        <tbody>
                            <tr>
                                <td><strong>@lang('admin::app.quotes.index.pdf.coupon') 1:</strong> {{ strtoupper(Str::random(5)) }}</td>
                                <td><strong>@lang('admin::app.quotes.index.pdf.coupon') 2:</strong> {{ strtoupper(Str::random(5)) }}</td>
                                <td><strong>@lang('admin::app.quotes.index.pdf.coupon') 3:</strong> {{ strtoupper(Str::random(5)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p style="font-size: 12px; margin-top: 15px;">
                        - @lang('admin::app.quotes.index.pdf.coupons-disclaimer.not-valid-for-1-month')<br>
                        - @lang('admin::app.quotes.index.pdf.coupons-disclaimer.valid-for-60-days')<br>
                        - @lang('admin::app.quotes.index.pdf.coupons-disclaimer.discount-info')
                    </p>
                </div>
            </div>
        </div>
        @if (!empty($remarketing))

            <div class="page-break"></div>
            <div class="legal-terms">
                <h1>Legal Terms and Customer Responsibility</h1>

                <p>By signing this document, the customer <strong>{{ $quote->person->name ?? '_____________________________' }}</strong> confirms that they are fully aware of and in complete agreement with the terms set forth below. This document serves as abinding contract and acknowledgment of the fi nancial obligation related to the purchase of theBeMother product.</p>

                <h2>1. Payment Obligation</h2>
                <p>This order was placed under the Cash on Delivery (COD) model, where payment must be made within 24 hours of product delivery using one of the following accepted payment methods: <strong>Zelle, Venmo, CashApp, Credit and debit card, Klarna.</strong></p>
                <p>The customer expressly agrees to fulfi ll the payment obligation within the specifi ed timeframe andusing the accepted payment methods. The signature on this document constitutes a legally bindingand enforceable commitment to settle the due amount.</p>

                <h2>2. Non-Payment and Legal Consequences</h2>
                <p>If the customer fails to make the payment within 24 hours or attempts to evade the agreed-upon obligation, the outstanding debt may be immediately forwarded for collection, subjecting the debtor to legal proceedings under U.S. debt collection laws, including but not limited to:</p>
                <div class="dotted-list">
                    <ul>
                        <li>Fair Debt Collection Practices Act (FDCPA - 15 U.S.C. §§ 1692-1692p)</li>
                        <li>Uniform Commercial Code (UCC - §2-709)</li>
                        <li>Small Claims Court & Civil Litigation</li>
                    </ul>
                </div>

                <p>Additionally, non-payment may result in additional penalties and restrictions on future purchases.</p>

                <h2>3. Fraud and Criminal Actions</h2>
                <p>Any attempt to deny the payment obligation after receiving the product may be considered financial fraud under U.S. commercial fraud statutes. The company reserves the right to report recurringdelinquencies to collection agencies and credit reporting organizations, potentially negativelyimpacting the customer's credit score.</p>
                <h2>4. Purpose of Signature</h2>
                <p>The signature on this document confi rms the acceptance of all the above terms and our PrivacyPolicy. It also serves as legal evidence in any future legal actions to recover unpaid amounts.</p>
                <h2>5. Immediate Action</h2>
                <p>In the event of non-payment or breach of this contract, the case will be immediately referred to thelegal department for appropriate measures, which may result in extrajudicial and judicial collectionproceedings.</p>
                <div class="signature-footer">
                    <div class="signature">
                        <p>Customer Signature:</p>
                        <div class="signature-line">
                            @if (!empty($remarketing->signature))

                                <img src="{{ $remarketing->signature }}" class="customer-signature" alt="Customer Signature">
                            @else
                                <div class="signature-placeholder"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <img src="{{ public_path('images/logos/compliance_usa.PNG') }}" alt="Compliance USA" class="compliance-image">
                </div>
            </div>
        @endif

    </body>
</html>
