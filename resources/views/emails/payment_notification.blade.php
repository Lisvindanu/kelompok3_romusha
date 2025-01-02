<h1>Pembayaran Anda</h1>
<p>Halo, {{ $payment->user->fullname }}</p>
<p>Order ID: {{ $payment->id }}</p>
<p>Status Pembayaran: {{ ucfirst($payment->status) }}</p>
<p>Total: Rp{{ number_format($payment->amount, 2) }}</p>
