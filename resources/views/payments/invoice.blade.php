<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <title>Invoice - {{ $project->user->name }}{{ $invoice_date }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monsieur+La+Doulaise&family=Pinyon+Script&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600&display=swap" rel="stylesheet">



    <style>
        body {
            font-family: 'Lato', sans-serif;
            background: #f9f9f9;
            color: #222;
            font-size: 14px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: #000;
            margin-bottom: 0.5rem;
        }

        .tagline {
        /* font-family: 'Great Vibes', cursive; */
        /* font-family: 'Pinyon Script', cursive; */
        font-family: 'Dancing Script', cursive;
        font-size: 1.2rem!important;
        text-align: center;
        font-weight: 400;
        color: #2ba58b;
        margin-top: 10px;
        letter-spacing: 0.5px;
        }

    .invoice-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem!important;
        text-align: center;
        font-weight: 700;
        margin-top: 5px;
        letter-spacing: 1px;
    }


    
        .invoice-box {
            max-width: 900px;
            margin: 40px auto;
            padding: 40px;
            background: #fff;
            border-radius: 8px;
        }
        .head-text {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }
        .top-section { margin-bottom: 30px; }
        .top-section h1 { font-size: 48px; font-weight: 700; margin-bottom: 10px; }
        .top-section p { font-size: 13px; margin: 2px 0; }
        .invoice-meta { float: right; text-align: right; margin-top: -100px; }
        .invoice-meta h1 { font-family: 'Lato', sans-serif; font-size: 50px; color: #444; }
        .section-title {font-family: 'Lato', sans-serif; font-weight: bold; font-size: 15px; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-top: 10px; page-break-after: avoid; page-break-inside: avoid; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px 8px; border-bottom: 1px solid #e0e0e0; font-size: 13px; }
        th { background-color:#E2EFDA!important; font-weight: 600; border-top: 2px solid #333; border-bottom: 2px solid #333; text-transform: uppercase; font-size: 12px; }
        tr:nth-child(even) { background-color: #fafafa; }
        .total-row td { font-weight: bold; background: #f9f9f9; border-top: 2px solid #999; }
        .qr-code { background-color: #000; width: 150px; padding: 10px; border-radius: 10px; }
        .qr-code img { height: 120px; display: block; margin: auto; }
        .signature img { height: 60px; }
        .notes { margin-top: 20px; font-size: 13px; }
        .notes ol { padding-left: 16px; }
        .payment-section { margin-top: 40px; display: flex; justify-content: space-between; flex-wrap: wrap; }
        .signature, .qr-sign { margin-top: 20px; }
        .no-print { text-align: center; margin-top: 40px; }
        .btn-print { background-color: #333; color: #fff; border: none; padding: 10px 25px; font-size: 14px; border-radius: 4px; }
        .btn-print:hover { background-color: #555; }
        .no-break { page-break-inside: avoid; page-break-before: auto; page-break-after: auto; }
        @media print {
            body { margin: 0; padding: 0; font-size: 12pt; }
            .invoice-box { padding: 10px !important; margin: 0 auto; width: 100%; max-width: 100%; box-shadow: none; }
            table { width: 100%; border-collapse: collapse; }
            @page { size: A4 portrait; margin:4mm}
            .no-print { display: none; }
        }
        @media screen and (max-width: 768px) {
            .invoice-box { padding: 20px; margin: 10px; }
            .top-section h1 { font-size: 28px; text-align: center; }
            .invoice-meta { float: none; text-align: right; margin-top: -15px!important; }
            .invoice-meta h1 { font-size: 36px; }
            .top-section img { height: 100px; display: block; margin: 0 auto 10px auto; }
            table th, table td { font-size: 12px; padding: 6px 4px; }
            .payment-section { flex-direction: column; align-items: center; }
            .signature, .qr-sign { width: 100%; text-align: center; }
            .qr-code { margin-bottom: 20px; }
            .notes ol { padding-left: 20px; font-size: 12px; }
            .no-print button, .no-print a { display: inline-block; width: 90%; margin: 8px auto; font-size: 15px; }
        }


    .wave-top {
        position: relative;
        top: 0;
        left: 0;
        width: 100%;       /* full viewport width */
        overflow: hidden;
        line-height: 0;
        margin-bottom: 0; /* removes gap between wave and invoice box */
    }

    .wave-top svg {
        display: block;
        width: 100%;
        height: 120px;      /* adjust wave height */
    }

    .wave-top path {
        fill: #E2EFDA;      /* ✅ brand color */
        stroke: none;
    }



    .brand-header {
        display: flex;
        align-items: center;
        gap: 10px; /* space between logo and text */
        margin-top: 2px
    }

    .brand-logo {
        height: 80px;
        object-fit: contain;
    }

    .head-text {
        font-size: 2em;
        font-weight: 700;
        color: var(--color-2);
        line-height: 1.1;
    }

    .text-liner {
        background: linear-gradient(to right, #e3c882, #cfa64e, #a8732a, #7a4e14);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
@media print {
    .text-liner {
        background: none !important;
        -webkit-text-fill-color: #a8732a !important; /* fallback gold color */
    }
}

    .brand-sub {
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.9px;
        line-height: 1;
        margin-left: 3px;
    }
.thank-you {
    text-align: center;
    margin-top: 30px;
    padding: 20px 10px;

    border-top: 2px solid #ccc;
    border-radius: 6px;
}

.thank-heading {
    font-size: 20px;
    font-weight: 700;
    color: #444;
    margin-bottom: 10px;
}

.thank-you p {
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
}

@media print {
    .thank-you {
        background: none;
        border: none;
    }
}

/* Force background colors in print PDF */
@media print {
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    table, tr, td, th {
        background-color: inherit !important;
    }
}


/* DomPDF background fix */
.floor-row {
    background: rgb(226,239,218) !important; /* #E2EFDA */
}

.room-row {
    background: rgb(238,244,255) !important; /* #EEF4FF */
}

.total-row {
    background: rgb(225,255,232) !important; /* #E1FFE8 */
}

table, th, td {
    border: 1px solid #000;
    border-collapse: collapse;
}

td, th {
    padding: 6px;
}

.no-print2 {
    display: inline;
}

.print-only {
    display: none;
}

@media print {
    .no-print {
        display: none !important;
    }
    .print-only {
        display: inline !important;
    }
}





    </style>
</head>
<body>
<div class="invoice-box">

        <!-- 🌊 Decorative Wave Top -->

    <div class="top-section">

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" transform="rotate(180)" style="transform: rotate(180deg);">
    <!-- Background white -->
    <!-- <rect width="1440" height="320" fill="#ffffff" /> -->

    <!-- Purple back wave -->
    <path fill="#39AE6E " fill-opacity="0.6" 
        d="M0,192 C160,160 320,128 480,144 C640,160 800,224 960,234.7 C1120,245 1280,203 1440,176 L1440,320 L0,320 Z">
    </path>

    <!-- Orange middle wave -->
    <path fill="#39AE6E" fill-opacity="0.4" 
        d="M0,128 C120,160 240,192 400,176 C560,160 720,96 880,106.7 C1040,117 1200,203 1360,213.3 C1400,216 1420,213.3 1440,210.7 L1440,320 L0,320 Z">
    </path>

    <!-- Pink front wave -->
    <path fill="#39AE6E" fill-opacity="0.2" 
        d="M0,224 C180,245 360,224 540,197.3 C720,171 900,139 1080,165.3 C1260,192 1350,229 1440,245.3 L1440,320 L0,320 Z">
    </path>
    </svg>

        <div class="brand-header d-flex align-items-center justify-content-center" style="margin-top: -30px;">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="brand-logo">
            
            <div class="brand-text ms-2 d-flex flex-column align-items-start">
                <h5 class="head-text mb-0" style="color: #2ba58b;">
                    HOME <span class="text-liner">DEN</span><sup class="text-liner">&trade;</sup>
                </h5>
                <p class="brand-sub mb-0">
                    <span class="text-liner" style="margin-left: 23px;">INTERIOR </span>
                    <span style="color: #2ba58b;">FIRM</span>
                </p>
            </div>
        </div>


<p class="tagline">
  “We don’t just design spaces — we create experiences.”
</p>

<h1 class="invoice-title">INVOICE</h1>


        <div class="invoice-meta">
            <p><strong style="font-family: 'Lato', sans-serif">INVOICE NO :</strong> {{ $invoice_number }}</p>
            <p><strong style="font-family: 'Lato', sans-serif">DATE :</strong> {{ $invoice_date }}</p>
        </div>

    </div>

    <p class="section-title" style="text-align: right; margin-top:20px;">CLIENT INFORMATION</p>
    <p style="text-align: right;font-family: 'Lato', sans-serif"><strong>NAME :</strong> <strong>{{ strtoupper($user->name) }}</strong></p>
    <p style="text-align: right;"><strong style="font-family: 'Lato', sans-serif">MOBILE :</strong> <strong>{{ strtoupper($user->mobile) }}</strong></p>
    <p class="section-title">PROJECT SUMMARY</p>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr style="text-align: center;" class="floor-row">
                    <th>#</th>
                    <th>Entity</th>
                    <th>Specification</th>
                    <th>Area</th>
                    <th>Unit</th>
                    <th>Rate/Unit</th>
                    <th>Total</th>
                </tr>
            </thead>
<tbody>

@php
$row = 1;

// Group by Floor → then Room
$grouped = $expenses
    ->whereNotNull('floorType')
    ->groupBy(fn($e) => $e->floorType->name)
    ->map(fn($items) => 
        $items->groupBy(fn($e) => $e->roomType->name ?? 'Room')
    );
@endphp



@foreach($grouped as $floor => $rooms)

    {{-- Floor Header --}}
<tr class="floor-row">
    <td colspan="7" style="
        background:#E2EFDA;
        padding:8px;
        text-align:center;
        font-weight:700;
        text-transform:uppercase;">
        {{ $floor }}
    </td>
</tr>


    {{-- Loop Rooms inside this Floor --}}
    @foreach($rooms as $room => $items)

        {{-- Room Header --}}
        <tr style="background:#eef4ff;" class="room-row">
            <td colspan="7" style="text-align:center;font-weight:700;text-transform:uppercase;padding:4px;border-top:1px solid #1a1414ff;border-bottom:1px solid #000000ff;">
                {{ $room }}
            </td>
        </tr>

        {{-- Items inside this room --}}
        @foreach($items as $expense)
        <tr>
            <td style="text-align:center; width:40px;">{{ $row++ }}</td>
            <td style="font-weight:bold;text-align:center;">
                {{ $expense->spec }}
            </td>
            <td style="text-align:center;">{{ $expense->description }}</td>
            <td style="text-align:center;">{{ number_format($expense->area,2) }}</td>
            <td style="text-align:center;">{{ $expense->unit }}</td>
            <td style="text-align:center;">₹{{ number_format($expense->rate,2) }}</td>
            <td style="text-align:right;">₹{{ number_format($expense->amount,2) }}</td>
        </tr>
        @endforeach

        
    @endforeach

@endforeach

{{-- TOTAL --}}
<tr style="font-weight:bold;background:#e1ffe8;" class="total-row">
    <td colspan="6">Total Amount</td>
    <td style="text-align:right;">₹{{ number_format($total_expense, 2) }}</td>
</tr>

@php
    $user = Auth::user();
    // ensure the flag exists (false by default)
    $isWhatsApp = isset($is_whatsapp) && $is_whatsapp ? true : false;
    // ensure total_expense exists and is numeric
    $totalExpenseValue = isset($total_expense) ? (float)$total_expense : 0;
@endphp





@if ($user && $user->role === 'admin')


{{-- GST Input --}}
<tr style="font-weight:bold;background:#e1ffe8;" class="total-row">
    <td colspan="6">
        GST 
        @if(! $isWhatsApp && $user && optional($user)->role === 'admin')
            {{-- Show Input only for admin and not in WhatsApp --}}
            <input
                type="number"
                id="gstRate"
                class="no-print"
                value="18"
                step="0.01"
                min="0"
                style="width:80px;text-align:right;border:1px solid #ccc;border-radius:5px;padding:3px;">
        @endif

        {{-- Always show percentage text for all users --}}
        <span id="gstRateText">(18%)</span>
    </td>
    <td style="text-align:right;" id="gstAmount">₹{{ number_format($totalExpenseValue * 0.18, 2) }}</td>
</tr>




    {{-- Discount Row --}}
    <tr style="font-weight:bold;background:#fff4e1;" class="total-row">
        <td colspan="6">
            Discount (₹)
            @if(!$isWhatsApp)
                <input
                    type="number"
                    id="discountAmount"
                    class="no-print"
                    value="0"
                    step="0.01"
                    min="0"
                    style="width:100px;text-align:right;border:1px solid #ccc;border-radius:5px;padding:3px;">
            @endif
        </td>
        <td style="text-align:right;" id="discountDisplay">₹0.00</td>
    </tr>

    {{-- Grand Total --}}
    <tr style="font-weight:bold;background:#f2fff5;" class="total-row">
        <td colspan="6">Grand Total (Including GST & Discount)</td>
        <td style="text-align:right;" id="grandTotal">₹{{ number_format($totalExpenseValue * 1.18, 2) }}</td>
    </tr>

@else
<tr>
    <td style="font-size: 12px; color: #666; text-align:center;" colspan="7">
        <strong>Note:</strong> This amount does not include GST & discounts.
        &nbsp;&nbsp;&nbsp;&nbsp;
        If you want to include GST in the invoice, please contact support.
    </td>
</tr>
@endif





<script>
document.addEventListener('DOMContentLoaded', function() {
    // guaranteed numeric value passed from PHP
    const totalExpense = {{ $totalExpenseValue }};
    const gstRateInput = document.getElementById('gstRate');
    const gstRateText = document.getElementById('gstRateText');
    const discountInput = document.getElementById('discountAmount');
    const gstAmountEl = document.getElementById('gstAmount');
    const discountDisplay = document.getElementById('discountDisplay');
    const grandTotalEl = document.getElementById('grandTotal');

    function calculateTotal() {
        const gstRate = gstRateInput ? parseFloat(gstRateInput.value) || 0 : 18;
        const discount = discountInput ? parseFloat(discountInput.value) || 0 : 0;

        const gstAmount = totalExpense * (gstRate / 100);
        const grandTotal = (totalExpense + gstAmount) - discount;

        if (gstAmountEl) gstAmountEl.textContent = '₹' + gstAmount.toFixed(2);
        if (discountDisplay) discountDisplay.textContent = '- ₹' + discount.toFixed(2);
        if (grandTotalEl) grandTotalEl.textContent = '₹' + grandTotal.toFixed(2);
        if (gstRateText) gstRateText.textContent = '(' + Math.round(gstRate) + '%)';
    }

    if (gstRateInput) gstRateInput.addEventListener('input', calculateTotal);
    if (discountInput) discountInput.addEventListener('input', calculateTotal);

    calculateTotal();
});
</script>








</tbody>
</table>
    </div>

    <div class="no-break" style="overflow-x: auto; margin-top: 10px;">
        <p class="section-title">PAYMENT DETAILS</p>
        <table>
            <thead>
                <tr class="floor-row">
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Previously Received</th>
                    <th>Now Received</th>
                    <th>Balance</th>
                    <th>Payment Mode</th>
                </tr>
            </thead>
<tbody>
    @foreach($payment_rows as $row)
    <tr>
        <td>{{ $row['date'] }}</td>
        <td style="text-align: right;">₹{{ number_format($total_expense, 2) }}</td>
        <td style="text-align: right;">
            @if($loop->first)
                -
            @else
                ₹{{ number_format($row['previous_payment'], 2) }}
            @endif
        </td>
        <td style="text-align: right;">₹{{ number_format($row['amount'], 2) }}</td>
        <td style="text-align: right;">₹{{ number_format($row['remaining_after_payment'], 2) }}</td>
        <td style="text-align: center;">{{ ucfirst($row['payment_mode']) }}</td>
    </tr>
    @endforeach
</tbody>
<tfoot>
    <tr class="total-row">
        <td colspan="4" >Total Received</td>
        <td colspan="2" style="text-align: right;">₹{{ number_format($total_received, 2) }}</td>
    </tr>
    <tr class="total-row">
        <td colspan="4">Yet to Receive (rounded value)</td>
        <td colspan="2" style="text-align: right;">₹{{ number_format($yet_to_receive) }}</td>
    </tr>
</tfoot>


        </table>
    </div>

    @if(count($expenses))
    <div class="notes">
        <strong style="font-family: 'Lato', sans-serif">NOTES:</strong>
        <ol>
            @foreach($expenses as $expense)
                @if($expense->specs)
                    <li><strong>{{ $expense->description }}:</strong> {{ $expense->spec }}</li>
                @endif
            @endforeach
        </ol>
    </div>
    @endif


    <!-- 📝 Thank You Greeting Section -->
    <div class="thank-you text-center mt-4">
        <h3 class="thank-heading">✨ Thank You for Your Business ✨</h3>
        <p style="font-family: 'Lato', sans-serif font-weight:600;">We truly appreciate your trust in<br><span style="font-weight: 800;font-family: 'Lato', sans-serif font-size:0.8rem;"> HOME DEN INTERIORS.</span></p>
    </div>


    <div class="payment-section d-flex justify-content-between flex-wrap">
        <div class="qr-sign" style="text-align: left; flex: 2; min-width: 250px;">
            <div class="qr-code" style="display: inline-block;">
                <img src="{{ asset('images/QR.png') }}" alt="UPI QR Code">
            </div>

            <div style="display: block; width:150px;">
                <p style="text-align: center; color: #000000ff; line-height: 1.2;">Scan to View</p>
            </div>

        </div> 
        <div class="signature" style="margin-top: 20px; text-align: right; flex: 1; min-width: 200px;">
        <p style="font-family: 'Lato', sans-serif font-weight:700;">For: <strong style="font-family: 'Lato', sans-serif">HOME DEN INTERIORS</strong></p>
            <img src="{{ asset('images/xxx.png') }}" alt="E-signature" style="height:60px;">
            <p style="font-family: 'Lato', sans-serif">Authorized Signatory</p>
        </div>
    </div>

    <div class="text-center no-print my-4">
        <button class="btn btn-success" onclick="window.print()">Print / Download</button>
    </div>
    <div class="text-center mt-4 no-print">
        <a href="{{ route('projects.payments', $project->id) }}" class="btn btn-secondary"><i class="bi bi-box-arrow-left"></i> Back to Project</a>
    </div>
    
<hr style="border: 1px solid #000; margin: 5px 0;">
<div class="company-info text-center" style="line-height: 1.4;">
    <p style="font-size: 11px; font-weight: 500; margin-bottom: 4px;">
        <strong>FACTORY ADDRESS :</strong> Soosai Nagar, Ponmalaipatti Road, Ponneripuram, Trichy - 07
    </p>
    <p style="font-size: 11px; margin: 0;">
       <strong> GSTIN: </strong> 33AKTPH2053F1ZC &nbsp; | &nbsp; 
        <a href="https://www.homedeninterior.com" target="_blank" style="color: #000; text-decoration: none;">
            www.homedeninterior.com
        </a>
    </p>
</div>


</div>
</body>
</html>
