<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<!-- Filter status + tombol QR Meja -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="filter-tabs-order">
        <a href="<?= base_url('admin/pesanan') ?>"
           class="filter-tab <?= !$statusFilter ? 'active' : '' ?>">Semua</a>
        <a href="<?= base_url('admin/pesanan?status=menunggu') ?>"
           class="filter-tab <?= $statusFilter === 'menunggu' ? 'active' : '' ?>">⏳ Menunggu</a>
        <a href="<?= base_url('admin/pesanan?status=diproses') ?>"
           class="filter-tab <?= $statusFilter === 'diproses' ? 'active' : '' ?>">👨‍🍳 Diproses</a>
        <a href="<?= base_url('admin/pesanan?status=selesai') ?>"
           class="filter-tab <?= $statusFilter === 'selesai' ? 'active' : '' ?>">✅ Selesai</a>
        <a href="<?= base_url('admin/pesanan?status=lunas') ?>"
           class="filter-tab <?= $statusFilter === 'lunas' ? 'active' : '' ?>">💚 Lunas</a>
    </div>
    <a href="<?= base_url('admin/pesanan/qr-warung') ?>" class="btn-burjo"
       style="text-decoration:none;font-size:.85rem;padding:.45rem 1.1rem;">
        📲 QR Meja
    </a>
</div>

<!-- Tabel pesanan -->
<div class="table-card">
    <?php if (empty($orders)) : ?>
        <p class="text-center text-muted py-5">
            Belum ada pesanan<?= $statusFilter ? ' dengan status <strong>' . esc($statusFilter) . '</strong>' : '' ?>.
        </p>
    <?php else : ?>
    <div class="table-responsive">
        <table class="table-burjo">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Pesanan</th>
                    <th>Nama Pemesan</th>
                    <th class="text-center">Meja</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Status</th>
                    <th>Waktu</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $statusLabel = [
                    'menunggu' => '⏳ Menunggu',
                    'diproses' => '👨‍🍳 Diproses',
                    'selesai'  => '✅ Selesai',
                    'lunas'    => '💚 Lunas',
                ];
                foreach ($orders as $i => $order) : ?>
                <tr>
                    <td class="text-muted"><?= $i + 1 ?></td>
                    <td>
                        <code style="font-size:.82rem;color:var(--burjo-coffee);font-weight:600;">
                            <?= esc($order['kode_order']) ?>
                        </code>
                    </td>
                    <td><?= esc($order['nama_pemesan']) ?></td>
                    <td class="text-center">
                        <?= $order['nomor_meja'] ? 'Meja&nbsp;' . esc($order['nomor_meja']) : '—' ?>
                    </td>
                    <td class="text-end fw-bold" style="color:var(--burjo-amber-dark);">
                        Rp&nbsp;<?= number_format($order['total_harga'], 0, ',', '.') ?>
                    </td>
                    <td class="text-center">
                        <span class="badge-status-order badge-order-<?= esc($order['status']) ?>">
                            <?= $statusLabel[$order['status']] ?? esc($order['status']) ?>
                        </span>
                    </td>
                    <td style="font-size:.82rem;color:#888;white-space:nowrap;">
                        <?= date('d/m H:i', strtotime($order['created_at'])) ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/pesanan/detail/' . $order['id']) ?>"
                           class="btn btn-sm"
                           style="border:1px solid var(--burjo-border);border-radius:20px;font-size:.78rem;color:var(--burjo-coffee);padding:.25rem .75rem;">
                            Detail
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-end">
        <?= $pager->links() ?>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
