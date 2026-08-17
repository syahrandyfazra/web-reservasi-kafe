@extends('layouts.customer')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Step Title -->
    <div>
        <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-wide">Buat Reservasi Baru</h2>
        <p class="text-stone-400 text-sm mt-1">Isi detail jadwal, pilih meja, dan pilih menu makanan & minuman Anda.</p>
    </div>

    <!-- Info alert rombongan -->
    <div class="bg-blue-950/40 border border-blue-500/30 rounded-2xl p-4 flex gap-4 items-start shadow-lg">
        <i class="bi bi-info-circle-fill text-blue-400 text-xl mt-0.5"></i>
        <div>
            <h4 class="font-semibold text-blue-300">Reservasi Rombongan (> 10 Orang)?</h4>
            <p class="text-sm text-stone-400 mt-1">Sistem ini membatasi pilihan meja reguler. Jika Anda ingin mereservasi untuk acara besar atau rombongan lebih dari 10 orang, silakan <a href="https://wa.me/6282360535593?text=Halo%20Admin%20Aroma%20Kafe,%20saya%20ingin%20reservasi%20untuk%20rombongan." target="_blank" class="text-amber-500 underline hover:text-amber-400 font-semibold transition">hubungi Admin via WhatsApp</a> untuk pengaturan khusus.</p>
        </div>
    </div>

    <!-- Form Jadwal & Cek Ketersediaan -->
    <div class="bg-stone-900 rounded-3xl border border-stone-800 p-6 shadow-xl">
        <h3 class="text-lg font-bold text-stone-200 mb-4 flex items-center gap-2">
            <i class="bi bi-clock-history text-amber-500"></i> 1. Tentukan Jadwal Reservasi
        </h3>
        
        <form action="{{ route('customer.reservasi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="tanggal" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Tanggal Reservasi</label>
                <input type="date" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" id="tanggal" name="tanggal" value="{{ $tanggal ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
            </div>
            
            <div>
                <label for="jam_mulai" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Jam Mulai</label>
                <input type="time" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" id="jam_mulai" name="jam_mulai" value="{{ $jam_mulai ?? '18:00' }}" required>
            </div>

            <div>
                <label for="jam_selesai" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Jam Selesai</label>
                <input type="time" class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" id="jam_selesai" name="jam_selesai" value="{{ $jam_selesai ?? '20:00' }}" required>
            </div>

            <div>
                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-500 text-white font-semibold py-3 px-6 rounded-xl text-sm transition flex items-center justify-center gap-2 shadow-lg shadow-amber-900/10">
                    <i class="bi bi-search"></i> Cek Ketersediaan Meja
                </button>
            </div>
        </form>
    </div>

    <!-- Jika Jadwal Sudah Dicek, Tampilkan Langkah Selanjutnya -->
    @if($tanggal && $jam_mulai && $jam_selesai)
        <form action="{{ auth()->check() ? route('customer.reservasi.store') : route('customer.reservasi.store.guest') }}" method="POST" id="reservationForm" class="space-y-8">
            @csrf

            @guest
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Nama Pemesan</label>
                    <input id="name" name="name" type="text" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" value="{{ old('name') }}">
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-stone-400 mb-2">Email</label>
                    <input id="email" name="email" type="email" required class="w-full bg-stone-950 border border-stone-800 rounded-xl px-4 py-3 text-stone-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 text-sm" value="{{ old('email') }}">
                </div>
            </div>
            @endguest

            <!-- Hidden inputs untuk menyimpan jadwal -->
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="jam_mulai" value="{{ $jam_mulai }}">
            <input type="hidden" name="jam_selesai" value="{{ $jam_selesai }}">

            <!-- Section 2: Pilih Meja -->
            <div class="bg-stone-900 rounded-3xl border border-stone-800 p-6 shadow-xl">
                <h3 class="text-lg font-bold text-stone-200 mb-2 flex items-center gap-2">
                    <i class="bi bi-grid-3x3-gap text-amber-500"></i> 2. Pilih Meja Kafe
                </h3>
                <p class="text-xs text-stone-400 mb-6">{{ $message }}</p>

                <!-- Checkbox Meja Acak -->
                <div class="mb-6 p-4 border border-stone-700 bg-stone-950 rounded-xl">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="meja_acak" value="1" id="meja_acak" class="w-5 h-5 text-amber-500 bg-stone-900 border-stone-700 rounded focus:ring-amber-500">
                        <span class="text-sm font-bold text-stone-200">Pilihkan Saya Meja Secara Acak</span>
                    </label>
                    <p class="text-xs text-stone-500 mt-1 pl-8">Sistem akan otomatis mencarikan meja reguler yang tersedia untuk Anda.</p>
                </div>

                <div id="meja_selection_container">
                    @if(!$mejaReguler->isEmpty() || !$mejaMeeting->isEmpty())
                        
                        @if(!$mejaReguler->isEmpty())
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 border-b border-stone-800 pb-2 mb-4 mt-2">Meja Reguler</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            @foreach($mejaReguler as $meja)
                                <label class="relative block cursor-pointer group">
                                    <input type="radio" name="meja_id" value="{{ $meja->id }}" class="peer sr-only radio-meja" required>
                                    
                                    <div class="bg-stone-950 border border-stone-800 peer-checked:border-amber-500 peer-checked:bg-amber-950/20 rounded-2xl p-5 text-center transition group-hover:border-stone-700">
                                        <i class="bi bi-table text-3xl text-stone-500 peer-checked:text-amber-500 group-hover:scale-105 transition block mb-2"></i>
                                        <span class="block font-bold text-white text-base">{{ $meja->nomor_meja }}</span>
                                        <span class="text-xs text-stone-400 mt-1 block">Kapasitas: {{ $meja->kapasitas }} Orang</span>
                                    </div>
                                    
                                    <!-- Indicator checkmark icon -->
                                    <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition">
                                        <i class="bi bi-check-circle-fill text-amber-500 text-sm"></i>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @endif

                        @if(!$mejaMeeting->isEmpty())
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 border-b border-stone-800 pb-2 mb-4 mt-8">Meeting Room</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($mejaMeeting as $meja)
                                <label class="relative block cursor-pointer group">
                                    <input type="radio" name="meja_id" value="{{ $meja->id }}" class="peer sr-only radio-meja" required>
                                    
                                    <div class="bg-stone-950 border border-stone-800 peer-checked:border-amber-500 peer-checked:bg-amber-950/20 rounded-2xl p-5 text-center transition group-hover:border-stone-700">
                                        <i class="bi bi-door-open-fill text-3xl text-stone-500 peer-checked:text-amber-500 group-hover:scale-105 transition block mb-2"></i>
                                        <span class="block font-bold text-white text-base">{{ $meja->nomor_meja }}</span>
                                        <span class="text-xs text-stone-400 mt-1 block">Kapasitas: {{ $meja->kapasitas }} Orang</span>
                                    </div>
                                    
                                    <!-- Indicator checkmark icon -->
                                    <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition">
                                        <i class="bi bi-check-circle-fill text-amber-500 text-sm"></i>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @endif

                    @else
                        <div class="bg-stone-950/50 border border-stone-800 p-6 rounded-2xl text-center text-stone-500 text-sm">
                            Silakan pilih jadwal lain untuk mencari meja yang kosong.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 3: Pemesanan Menu Makanan & Minuman -->
            @if(!$mejaReguler->isEmpty() || !$mejaMeeting->isEmpty())
                <div class="bg-stone-900 rounded-3xl border border-stone-800 p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-stone-200 mb-2 flex items-center gap-2">
                        <i class="bi bi-journal-richtext text-amber-500"></i> 3. Tambahkan Makanan & Minuman (Wajib)
                    </h3>
                    <p class="text-xs text-stone-400 mb-6">Pilih menu minimal 1 item. Anda wajib membayar lunas seluruh pesanan ini untuk menyelesaikan reservasi.</p>

                    <!-- Tempat Rekomendasi Menu (Apriori) -->
                    <div id="recommendation_container" class="hidden mb-8 p-4 bg-amber-950/20 border border-amber-900/50 rounded-2xl">
                        <h4 class="text-sm font-bold text-amber-500 mb-3 flex items-center gap-2">
                            <i class="bi bi-stars"></i> Rekomendasi Untuk Anda (Metode Asosiasi)
                        </h4>
                        <div id="recommendation_list" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Injected by JS -->
                        </div>
                    </div>

                    <div class="space-y-8" id="menu_catalog">
                        @foreach($categories as $category)
                            @if(!$category->menu->isEmpty())
                                <div>
                                    <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 border-b border-stone-800 pb-2 mb-4">{{ $category->nama_kategori }}</h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($category->menu as $menu)
                                            <div class="bg-stone-950 border border-stone-800 hover:border-stone-700 p-4 rounded-2xl flex items-center gap-4 transition">
                                                
                                                <!-- Image -->
                                                <div class="shrink-0">
                                                    @if($menu->foto)
                                                        <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama_menu }}" class="w-20 h-20 object-cover rounded-xl border border-stone-800">
                                                    @else
                                                        <div class="w-20 h-20 bg-stone-900 text-stone-600 border border-stone-800 rounded-xl flex items-center justify-center text-[10px]">
                                                            No Image
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Details -->
                                                <div class="flex-grow">
                                                    <h5 class="font-bold text-white text-sm">{{ $menu->nama_menu }}</h5>
                                                    <p class="text-xs text-stone-500 mt-0.5 line-clamp-1">{{ $menu->deskripsi ?? '-' }}</p>
                                                    <p class="text-xs font-semibold text-stone-300 mt-2 font-mono" data-price="{{ intval($menu->harga) }}">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                                </div>

                                                <!-- Quantity selector spinner -->
                                                <div class="flex items-center bg-stone-900 border border-stone-800 rounded-xl p-1">
                                                    <button type="button" class="btn-qty-minus text-stone-400 hover:text-amber-500 w-8 h-8 flex items-center justify-center transition" data-menu-id="{{ $menu->id }}"><i class="bi bi-dash"></i></button>
                                                    <input type="number" name="qty[{{ $menu->id }}]" id="qty-{{ $menu->id }}" value="0" min="0" class="input-qty w-10 text-center bg-transparent border-0 focus:ring-0 text-sm font-bold text-white font-mono p-0" readonly>
                                                    <button type="button" class="btn-qty-plus text-stone-400 hover:text-amber-500 w-8 h-8 flex items-center justify-center transition" data-menu-id="{{ $menu->id }}"><i class="bi bi-plus"></i></button>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Floating Checkout Summary bar -->
                <div class="sticky bottom-6 z-40 bg-stone-900/95 border border-stone-800 rounded-3xl p-6 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-4 backdrop-blur-md">
                    <div>
                        <span class="text-xs text-stone-400 uppercase tracking-wider block">Estimasi Pembayaran</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-bold text-amber-500 font-mono" id="totalPaymentDisplay">Rp 0</span>
                            <span class="text-xs text-stone-500 font-normal"> (Sudah Termasuk Meja)</span>
                        </div>
                    </div>
                    
                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-amber-600 hover:bg-amber-500 text-white font-bold py-3.5 px-8 rounded-2xl shadow-lg shadow-amber-900/25 transition">
                            <i class="bi bi-shield-check text-lg"></i>
                            <span>Konfirmasi & Lanjutkan Bayar</span>
                        </button>
                    </div>
                </div>
            @endif

        </form>
    @endif
</div>

<!-- Quantity & Total calculation script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInputs = document.querySelectorAll('.input-qty');
        const totalPaymentDisplay = document.getElementById('totalPaymentDisplay');
        const mejaAcakCheckbox = document.getElementById('meja_acak');
        const mejaSelectionContainer = document.getElementById('meja_selection_container');
        const radioMejas = document.querySelectorAll('.radio-meja');
        
        // Data Rekomendasi (Apriori)
        const recommendations = {!! $recommendationJson ?? '{}' !!};
        const recommendationContainer = document.getElementById('recommendation_container');
        const recommendationList = document.getElementById('recommendation_list');

        // Toggle meja selection when 'Acak' is checked
        if (mejaAcakCheckbox) {
            mejaAcakCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    mejaSelectionContainer.classList.add('opacity-50', 'pointer-events-none');
                    radioMejas.forEach(radio => {
                        radio.required = false;
                        radio.checked = false;
                    });
                } else {
                    mejaSelectionContainer.classList.remove('opacity-50', 'pointer-events-none');
                    radioMejas.forEach(radio => radio.required = true);
                }
            });
        }

        // Plus Quantity button click handler
        document.querySelectorAll('.btn-qty-plus').forEach(button => {
            button.addEventListener('click', function() {
                const menuId = this.getAttribute('data-menu-id');
                const input = document.getElementById(`qty-${menuId}`);
                let value = parseInt(input.value) || 0;
                input.value = value + 1;
                calculateTotal();
                updateRecommendations();
            });
        });

        // Minus Quantity button click handler
        document.querySelectorAll('.btn-qty-minus').forEach(button => {
            button.addEventListener('click', function() {
                const menuId = this.getAttribute('data-menu-id');
                const input = document.getElementById(`qty-${menuId}`);
                let value = parseInt(input.value) || 0;
                if (value > 0) {
                    input.value = value - 1;
                    calculateTotal();
                    updateRecommendations();
                }
            });
        });

        function updateRecommendations() {
            // 1. Ambil semua ID menu yang sedang dipilih (qty > 0)
            const selectedMenuIds = [];
            qtyInputs.forEach(input => {
                if ((parseInt(input.value) || 0) > 0) {
                    selectedMenuIds.push(input.id.replace('qty-', ''));
                }
            });

            // 2. Cari rekomendasi berdasarkan ID menu yang dipilih
            let recIds = new Set();
            selectedMenuIds.forEach(id => {
                if (recommendations[id]) {
                    recommendations[id].forEach(recId => {
                        // Pastikan menu rekomendasi tidak ditambahkan jika sudah dipilih/dibeli oleh pengguna
                        if (!selectedMenuIds.includes(String(recId))) {
                            recIds.add(String(recId));
                        }
                    });
                }
            });
            
            // 3. Tampilkan rekomendasi di UI (User Interface)
            if (recIds.size > 0 && selectedMenuIds.length > 0) {
                recommendationContainer.classList.remove('hidden');
                recommendationList.innerHTML = '';
                
                recIds.forEach(id => {
                    // Clone the element from the catalog
                    const originalMenuDiv = document.getElementById(`qty-${id}`).closest('.bg-stone-950');
                    if (originalMenuDiv) {
                        const clone = originalMenuDiv.cloneNode(true);
                        // Make inputs and buttons in clone point to the original
                        const cloneMinus = clone.querySelector('.btn-qty-minus');
                        const clonePlus = clone.querySelector('.btn-qty-plus');
                        
                        cloneMinus.onclick = function() {
                            const originalInput = document.getElementById(`qty-${id}`);
                            let value = parseInt(originalInput.value) || 0;
                            if (value > 0) {
                                originalInput.value = value - 1;
                                clone.querySelector('input').value = value - 1;
                                calculateTotal();
                                updateRecommendations();
                            }
                        };
                        clonePlus.onclick = function() {
                            const originalInput = document.getElementById(`qty-${id}`);
                            let value = parseInt(originalInput.value) || 0;
                            originalInput.value = value + 1;
                            clone.querySelector('input').value = value + 1;
                            calculateTotal();
                            updateRecommendations();
                        };
                        
                        // Sync value
                        const originalInput = document.getElementById(`qty-${id}`);
                        clone.querySelector('input').value = originalInput.value;
                        clone.querySelector('input').removeAttribute('id'); // prevent duplicate IDs
                        
                        recommendationList.appendChild(clone);
                    }
                });
            } else {
                recommendationContainer.classList.add('hidden');
            }
        }

        // Calculate total function
        function calculateTotal() {
            let total = 0;
            
            qtyInputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    const priceElement = input.closest('.flex').previousElementSibling.querySelector('[data-price]');
                    const price = parseFloat(priceElement.getAttribute('data-price')) || 0;
                    total += (price * qty);
                }
            });

            // Format total rupiah
            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(total);

            totalPaymentDisplay.textContent = formattedTotal;
        }

        // Form submission validator
        const form = document.getElementById('reservationForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                let totalQty = 0;
                qtyInputs.forEach(input => {
                    totalQty += (parseInt(input.value) || 0);
                });

                if (totalQty === 0) {
                    e.preventDefault();
                    alert('Maaf, Anda wajib memesan minimal 1 menu makanan atau minuman untuk melakukan reservasi meja!');
                }
            });
        }
    });
</script>
@endsection
