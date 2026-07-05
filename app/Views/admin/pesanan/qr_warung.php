<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="text-center">
    <p class="text-muted mb-4" style="font-size:.9rem;">
        Print halaman ini dan tempel di meja.<br>
        Pelanggan cukup scan untuk langsung memesan.
    </p>

    <div class="qr-warung-card mx-auto">
        <div class="gingham-strip" style="border-radius:var(--radius) var(--radius) 0 0;"></div>
        <div class="qr-warung-body">
            <div class="qr-warung-brand">Warung Burjo Barokah</div>
            <div class="qr-warung-sub">Scan untuk memesan</div>
            <div id="qrWarung" class="qr-warung-code"></div>
            <div class="qr-warung-url"><?= base_url('pesan') ?></div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap no-print">
        <button onclick="window.print()" class="btn-burjo" style="cursor:pointer;border:none;">
            Print QR Code
        </button>
        <a href="<?= base_url('admin/pesanan') ?>"
           style="color:var(--burjo-coffee);text-decoration:none;padding:.55rem 1.4rem;border-radius:50px;border:1px solid var(--burjo-border);font-weight:600;font-size:.9rem;">
            Kembali ke Pesanan
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
new QRCode(document.getElementById("qrWarung"), {
    text: "<?= base_url('pesan') ?>",
    width: 240, height: 240,
    colorDark: "#3b2417",
    colorLight: "#fbf3e7",
    correctLevel: QRCode.CorrectLevel.H
});
</script>

<style>
@media print {
    .no-print, .admin-sidebar, .admin-topbar { display: none !important; }
    .admin-content { margin: 0 !important; padding: 0 !important; }
    .qr-warung-card { box-shadow: none !important; border: 2px solid #ccc !important; }
}
</style>

<?= $this->endSection() ?>
