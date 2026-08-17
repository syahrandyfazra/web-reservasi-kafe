@extends('admin.layouts.app')

@section('header_title', 'Kelola Pembayaran & Reservasi')

@push('styles')
    <link href="{{ asset('css/admin-pembayaran.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row g-4">
    <!-- Tabs Navigation -->
    <div class="col-12">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active btn-custom" id="pills-payments-tab" data-bs-toggle="pill" data-bs-target="#pills-payments" type="button" role="tab" aria-controls="pills-payments" aria-selected="true">
                    <i class="bi bi-wallet2 me-1"></i> Verifikasi Pembayaran
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-custom" id="pills-reservations-tab" data-bs-toggle="pill" data-bs-target="#pills-reservations" type="button" role="tab" aria-controls="pills-reservations" aria-selected="false">
                    <i class="bi bi-calendar-check me-1"></i> Riwayat Reservasi
                </button>
            </li>
        </ul>
        
        <div class="tab-content" id="pills-tabContent">
            
            <!-- Tab: Verifikasi Pembayaran -->
            <div class="tab-pane fade show active" id="pills-payments" role="tabpanel" aria-labelledby="pills-payments-tab">
                <div class="card card-custom p-4">
                    <h5 class="mb-4 font-weight-600">Daftar Transaksi Pembayaran</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Reservasi</th>
                                    <th>Pelanggan</th>
                                    <th>Metode</th>
                                    <th>Jumlah Bayar</th>
                                    <th>Bukti</th>
                                    <th>Status</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayaran as $index => $pay)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="font-weight-600 text-dark">{{ $pay->reservasi->kode_reservasi }}</span></td>
                                        <td>{{ $pay->reservasi->user?->name ?? $pay->reservasi->guest_name ?? 'Guest' }}</td>
                                        <td><span class="badge bg-secondary-subtle text-secondary">{{ strtoupper($pay->metode) }}</span></td>
                                        <td><span class="font-weight-600 text-dark">Rp {{ number_format($pay->jumlah, 0, ',', '.') }}</span></td>
                                        <td>
                                            @if($pay->bukti_bayar)
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-info btn-custom py-1 px-2 js-show-receipt"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#receiptModal"
                                                    data-receipt-src="{{ asset('storage/' . $pay->bukti_bayar) }}"
                                                    data-receipt-code="{{ $pay->reservasi->kode_reservasi }}"
                                                >
                                                    <i class="bi bi-eye-fill me-1"></i> Lihat Bukti
                                                </button>
                                            @else
                                                <span class="text-muted small">Belum diunggah</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pay->status == 'pending')
                                                <span class="badge badge-pending">Menunggu Verifikasi</span>
                                            @elseif($pay->status == 'berhasil')
                                                <span class="badge badge-success">Sukses</span>
                                            @else
                                                <span class="badge badge-danger">Gagal</span>
                                            @endif
                                        </td>
                                        <td>{{ $pay->created_at->format('d/m/Y H:i') }} WIB</td>
                                        <td>
                                            @if($pay->status == 'pending')
                                                <form action="{{ route('admin.pembayaran.verifikasi', $pay->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm btn-custom py-1 px-2">
                                                        <i class="bi bi-check-lg"></i> Setujui
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">Belum ada transaksi pembayaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab: Riwayat Reservasi -->
            <div class="tab-pane fade" id="pills-reservations" role="tabpanel" aria-labelledby="pills-reservations-tab">
                <div class="card card-custom p-4">
                    <h5 class="mb-4 font-weight-600">Semua Data Reservasi</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Pelanggan</th>
                                    <th>Meja</th>
                                    <th>Tanggal & Jam</th>
                                    <th>Pesanan Menu</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservasiList as $res)
                                    <tr>
                                        <td><span class="font-weight-600 text-dark">{{ $res->kode_reservasi }}</span></td>
                                        <td>{{ $res->user?->name ?? $res->guest_name ?? 'Guest' }}</td>
                                        <td>{{ $res->meja->nomor_meja }} <small class="text-muted">(Cap: {{ $res->meja->kapasitas }})</small></td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($res->tanggal)->format('d M Y') }}</div>
                                            <small class="text-muted">{{ substr($res->jam_mulai, 0, 5) }} - {{ substr($res->jam_selesai, 0, 5) }}</small>
                                        </td>
                                        <td>
                                            <ul class="ps-3 mb-0 text-muted small list-square">
                                                @if($res->pesanan && $res->pesanan->detailPesanan)
                                                    @foreach($res->pesanan->detailPesanan as $det)
                                                        <li>{{ $det->menu->nama_menu }} (x{{ $det->qty }})</li>
                                                    @endforeach
                                                @else
                                                    <li>Tidak ada pesanan</li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td><span class="font-weight-600 text-dark">Rp {{ number_format($res->total_harga, 0, ',', '.') }}</span></td>
                                        <td>
                                            @if($res->status == 'menunggu_pembayaran')
                                                <span class="badge badge-pending">Menunggu Pembayaran</span>
                                            @elseif($res->status == 'dibayar')
                                                <span class="badge badge-success">Sudah Dibayar</span>
                                            @elseif($res->status == 'selesai')
                                                <span class="badge bg-secondary-subtle text-secondary">Selesai</span>
                                            @else
                                                <span class="badge badge-danger">Batal</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @if($res->status == 'dibayar')
                                                    <form action="{{ route('admin.pembayaran.selesai', $res->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success btn-sm btn-custom py-1">
                                                            Selesai
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($res->status == 'menunggu_pembayaran' || $res->status == 'dibayar')
                                                    <form action="{{ route('admin.pembayaran.batal', $res->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger btn-sm btn-custom py-1" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                            Batal
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data reservasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Bukti Bayar -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content card-custom">
            <div class="modal-header">
                <h6 class="modal-title font-weight-600" id="receiptModalLabel">Bukti Pembayaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center bg-light receipt-modal-body">
                <img id="receiptModalImage" src="" alt="Bukti Pembayaran" class="img-fluid rounded receipt-image">
            </div>
            <div class="modal-footer">
                <a id="receiptModalOpen" href="#" target="_blank" rel="noopener" class="btn btn-outline-primary btn-custom">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Gambar
                </a>
                <button type="button" class="btn btn-secondary btn-custom" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const receiptModal = document.getElementById('receiptModal');
        const receiptTitle = document.getElementById('receiptModalLabel');
        const receiptImage = document.getElementById('receiptModalImage');
        const receiptOpen = document.getElementById('receiptModalOpen');

        document.querySelectorAll('.js-show-receipt').forEach((button) => {
            button.addEventListener('click', function () {
                const imageSrc = this.dataset.receiptSrc;
                const reservationCode = this.dataset.receiptCode;

                receiptTitle.textContent = `Bukti Pembayaran - ${reservationCode}`;
                receiptImage.src = imageSrc;
                receiptOpen.href = imageSrc;
            });
        });

        receiptModal.addEventListener('hidden.bs.modal', function () {
            receiptImage.src = '';
            receiptOpen.href = '#';
            receiptTitle.textContent = 'Bukti Pembayaran';
        });
    });
</script>
@endpush
