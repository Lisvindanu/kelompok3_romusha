// JavaScript untuk Select All Checkbox
document.getElementById('select-all').addEventListener('change', function() {
    const isChecked = this.checked;
    document.querySelectorAll('.product-check').forEach(function(checkbox) {
        checkbox.checked = isChecked;
    });
});

// Update subtotal saat jumlah produk berubah
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function() {
        const row = this.closest('tr');
        const priceText = row.querySelector('td:nth-child(3)').textContent.trim(); // Ambil harga
        const price = parseInt(priceText.replace('Rp', '').replace('.', '').trim());
        const quantity = parseInt(this.value);
        const subtotal = row.querySelector('td:nth-child(5)');
        
        // Hitung dan update subtotal
        const newSubtotal = price * quantity;
        subtotal.textContent = `Rp ${newSubtotal.toLocaleString('id-ID')}`;
    });
});
