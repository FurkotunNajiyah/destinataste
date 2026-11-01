<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Destinataste') }} – Dashboard Rekomendasi Wisata & Kuliner</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Cadangan sementara jika Vite belum di-build (butuh internet). Jalankan "npm run dev" atau "npm run build" untuk produksi. --}}
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        .font-display { font-family: 'Bricolage Grotesque', 'Plus Jakarta Sans', sans-serif; letter-spacing: -.02em; }
        :focus-visible { outline: 2px solid #1F7A72; outline-offset: 2px; }
        .tile-wisata { background: linear-gradient(135deg, #1F7A72, #7CC4B4); }
        .tile-kuliner { background: linear-gradient(135deg, #C8321E, #F0A04B); }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; } }
    </style>
</head>

@php
    /*
     * DATA CONTOH – ganti dengan data dari controller:
     *   return view('dashboard', ['places' => $places, 'user' => auth()->user()]);
     * Setiap item: id, nama, kategori (wisata|kuliner), area, deskripsi, rating,
     * harga (1=murah, 2=sedang, 3=premium), jarak (km), cocok (%), tag[], jam, maps
     */
    $places = $places ?? [
        ['id'=>1,'nama'=>'Guci Hot Spring & Forest','kategori'=>'wisata','area'=>'Bumijawa','deskripsi'=>'Pemandian air panas alami di lereng Gunung Slamet dengan hutan pinus dan udara sejuk. Cocok untuk melepas penat setelah perjalanan.','rating'=>4.6,'harga'=>2,'jarak'=>32,'cocok'=>98,'tag'=>['Alam','Keluarga','Sejuk'],'jam'=>'06.00–18.00','emoji'=>'♨️'],
        ['id'=>2,'nama'=>'Curug Bengkawah','kategori'=>'wisata','area'=>'Guci','deskripsi'=>'Air terjun bertingkat di kawasan Guci. Jalur jalannya pendek dan cocok untuk foto.','rating'=>4.5,'harga'=>1,'jarak'=>35,'cocok'=>91,'tag'=>['Alam','Foto','Murah'],'jam'=>'07.00–17.00','emoji'=>'🌿'],
        ['id'=>3,'nama'=>'Pantai Alam Indah','kategori'=>'wisata','area'=>'Tegal Barat','deskripsi'=>'Pantai kota dengan area jajan dan wahana. Ramai saat sore dan akhir pekan.','rating'=>4.2,'harga'=>1,'jarak'=>4,'cocok'=>86,'tag'=>['Pantai','Sore','Keluarga'],'jam'=>'08.00–18.00','emoji'=>'🏖️'],
        ['id'=>4,'nama'=>'Waduk Cacaban','kategori'=>'wisata','area'=>'Kedungbanteng','deskripsi'=>'Waduk dengan pemandangan perbukitan. Tenang untuk memancing atau menikmati matahari terbenam.','rating'=>4.3,'harga'=>1,'jarak'=>20,'cocok'=>82,'tag'=>['Tenang','Sunset','Murah'],'jam'=>'07.00–17.30','emoji'=>'🌅'],
        ['id'=>5,'nama'=>'Kupat Glabed','kategori'=>'kuliner','area'=>'Kota Tegal','deskripsi'=>'Ketupat dengan kuah santan kental, tauge, dan bawang goreng. Dimakan hangat untuk sarapan.','rating'=>4.7,'harga'=>1,'jarak'=>3,'cocok'=>95,'tag'=>['Sarapan','Khas Tegal','Murah'],'jam'=>'05.00–11.00','emoji'=>'🍲'],
        ['id'=>6,'nama'=>'Tahu Aci','kategori'=>'kuliner','area'=>'Slawi','deskripsi'=>'Tahu goreng berisi adonan aci kenyal, disantap dengan cabai rawit dan bumbu kacang.','rating'=>4.5,'harga'=>1,'jarak'=>14,'cocok'=>93,'tag'=>['Camilan','Pedas','Murah'],'jam'=>'09.00–21.00','emoji'=>'🥟'],
        ['id'=>7,'nama'=>'Sauto Tegal','kategori'=>'kuliner','area'=>'Kota Tegal','deskripsi'=>'Soto khas Tegal berkuah tauco dengan daging sapi dan sambal. Rasa gurih dan segar.','rating'=>4.6,'harga'=>2,'jarak'=>5,'cocok'=>90,'tag'=>['Makan siang','Khas Tegal','Gurih'],'jam'=>'08.00–20.00','emoji'=>'🍜'],
        ['id'=>8,'nama'=>'Teh Poci & Nasi Ponggol','kategori'=>'kuliner','area'=>'Kota Tegal','deskripsi'=>'Teh melati dalam poci tanah liat dengan gula batu, ditemani nasi ponggol untuk makan malam.','rating'=>4.4,'harga'=>1,'jarak'=>2,'cocok'=>88,'tag'=>['Malam','Santai','Murah'],'jam'=>'16.00–00.00','emoji'=>'🍵'],
    ];
    $namaUser = $user->name ?? 'Penjelajah';
@endphp

<body class="bg-[#F5F6F2] text-[#13302B] antialiased min-h-screen">
<div class="lg:grid lg:grid-cols-[15rem_1fr]">

    <!-- SIDEBAR -->
    <aside class="hidden lg:flex flex-col sticky top-0 h-screen bg-[#13302B] text-[#E6EFEA] p-6">
        <a href="{{ url('/') }}" class="font-display text-2xl font-bold text-white">Destinataste</a>
        <p class="mt-1 text-xs text-[#9DB8B0]">Wisata & kuliner Tegal dan sekitarnya</p>

        <nav class="mt-10 flex flex-col gap-1 text-sm" aria-label="Menu utama">
            <a href="{{ url('/dashboard') }}" class="rounded-md bg-white/10 px-3 py-2 font-medium text-white" aria-current="page">Rekomendasi</a>
            <a href="#" class="rounded-md px-3 py-2 hover:bg-white/5">Peta lokasi</a>
            <a href="#tersimpan" class="rounded-md px-3 py-2 hover:bg-white/5">Tersimpan <span id="savedCount" class="ml-1 rounded-full bg-[#E0A100] px-2 text-xs font-semibold text-[#13302B]">0</span></a>
            <a href="#" class="rounded-md px-3 py-2 hover:bg-white/5">Ulasan saya</a>
            <a href="#" class="rounded-md px-3 py-2 hover:bg-white/5">Preferensi</a>
        </nav>

        <div class="mt-auto border-t border-white/10 pt-4 text-sm">
            <div class="font-medium text-white">{{ $namaUser }}</div>
            @if (Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="text-[#9DB8B0] hover:text-white">Keluar</button>
                </form>
            @endif
        </div>
    </aside>

    <div class="min-w-0">
        <!-- TOPBAR MOBILE -->
        <header class="lg:hidden flex items-center justify-between bg-[#13302B] px-4 py-3 text-white">
            <span class="font-display text-xl font-bold">Destinataste</span>
            <span class="text-xs text-[#9DB8B0]">Tersimpan: <b id="savedCountM" class="text-[#E0A100]">0</b></span>
        </header>

        <main class="px-4 py-6 sm:px-8 lg:py-8 xl:grid xl:grid-cols-[1fr_21rem] xl:gap-8">
            <div class="min-w-0">
                <!-- SAPAAN + PENCARIAN -->
                <section>
                    <h1 class="font-display text-3xl font-bold sm:text-4xl">Halo, {{ $namaUser }}. Mau ke mana atau makan apa hari ini?</h1>
                    <p class="mt-2 max-w-xl text-sm text-[#4B6A63]">Urutan hasil menyesuaikan preferensi, jarak, dan penilaian pengunjung lain.</p>

                    <div class="mt-5 flex items-center gap-2 rounded-lg border border-[#C9D5CF] bg-white px-4 py-3 focus-within:border-[#1F7A72]">
                        <svg class="h-5 w-5 shrink-0 text-[#4B6A63]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5" stroke-linecap="round"/></svg>
                        <label for="q" class="sr-only">Cari tempat atau makanan</label>
                        <input id="q" type="search" placeholder="Cari nama tempat, makanan, atau suasana" class="w-full bg-transparent text-sm placeholder:text-[#7C948D] focus:outline-none">
                    </div>
                </section>

                <!-- FILTER -->
                <section class="mt-5 flex flex-wrap items-center gap-3" aria-label="Filter">
                    <div class="inline-flex rounded-lg bg-[#E4E9E4] p-1 text-sm" role="group" aria-label="Kategori" id="kategori">
                        <button data-k="semua" class="rounded-md px-4 py-1.5 font-medium">Semua</button>
                        <button data-k="wisata" class="rounded-md px-4 py-1.5 font-medium">Wisata</button>
                        <button data-k="kuliner" class="rounded-md px-4 py-1.5 font-medium">Kuliner</button>
                    </div>

                    <label class="sr-only" for="harga">Anggaran</label>
                    <select id="harga" class="rounded-lg border border-[#C9D5CF] bg-white px-3 py-2 text-sm">
                        <option value="0">Semua anggaran</option>
                        <option value="1">Hemat</option>
                        <option value="2">Menengah</option>
                        <option value="3">Premium</option>
                    </select>

                    <label class="sr-only" for="urut">Urutkan</label>
                    <select id="urut" class="rounded-lg border border-[#C9D5CF] bg-white px-3 py-2 text-sm">
                        <option value="cocok">Paling cocok</option>
                        <option value="rating">Rating tertinggi</option>
                        <option value="jarak">Terdekat</option>
                    </select>
                </section>

                <div class="mt-6 flex items-baseline justify-between">
                    <h2 class="font-display text-xl font-semibold">Rekomendasi untukmu</h2>
                    <span id="hitung" class="text-sm text-[#4B6A63]"></span>
                </div>

                <!-- DAFTAR -->
                <section id="daftar" class="mt-4 grid gap-4 sm:grid-cols-2 2xl:grid-cols-3" aria-live="polite"></section>

                <div id="kosong" class="mt-4 hidden rounded-lg border border-dashed border-[#C9D5CF] p-8 text-center text-sm text-[#4B6A63]">
                    Tidak ada hasil yang cocok. Coba ubah kata kunci atau longgarkan filter anggaran.
                </div>

                <!-- TERSIMPAN -->
                <section id="tersimpan" class="mt-10">
                    <h2 class="font-display text-xl font-semibold">Tersimpan</h2>
                    <ul id="listSimpan" class="mt-3 flex flex-wrap gap-2 text-sm"></ul>
                </section>
            </div>

            <!-- PANEL DETAIL -->
            <aside class="mt-8 xl:mt-0" aria-label="Detail tempat">
                <div id="detail" class="rounded-lg border border-[#C9D5CF] bg-white p-5 xl:sticky xl:top-8"></div>
            </aside>
        </main>
    </div>
</div>

<script>
    const PLACES = @json($places);
    const HARGA = {1: 'Hemat', 2: 'Menengah', 3: 'Premium'};
    const state = { k: 'semua', q: '', harga: 0, urut: 'cocok', sel: PLACES[0]?.id ?? null, saved: new Set() };
    const $ = (s) => document.querySelector(s);

    const esc = (v) => String(v).replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

    function filtered() {
        const q = state.q.trim().toLowerCase();
        return PLACES
            .filter((p) => state.k === 'semua' || p.kategori === state.k)
            .filter((p) => !state.harga || p.harga === state.harga)
            .filter((p) => !q || [p.nama, p.area, p.deskripsi, ...p.tag].join(' ').toLowerCase().includes(q))
            .sort((a, b) => state.urut === 'jarak' ? a.jarak - b.jarak : state.urut === 'rating' ? b.rating - a.rating : b.cocok - a.cocok);
    }

    function card(p) {
        const on = p.id === state.sel;
        return `
        <article>
            <button data-id="${p.id}" class="group w-full overflow-hidden rounded-lg border bg-white text-left transition ${on ? 'border-[#1F7A72] ring-1 ring-[#1F7A72]' : 'border-[#C9D5CF] hover:border-[#7C948D]'}">
                <div class="tile-${esc(p.kategori)} flex h-28 items-start justify-between p-3">
                    <span class="text-4xl" aria-hidden="true">${esc(p.emoji ?? '📍')}</span>
                    <span class="rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-[#13302B]">${p.cocok}% cocok</span>
                </div>
                <div class="p-4">
                    <div class="text-xs text-[#4B6A63]">${p.kategori === 'wisata' ? 'Wisata' : 'Kuliner'} · ${esc(p.area)}</div>
                    <h3 class="font-display mt-0.5 text-lg font-semibold leading-snug">${esc(p.nama)}</h3>
                    <div class="mt-2 flex items-center gap-3 text-xs text-[#4B6A63]">
                        <span><b class="text-[#13302B]">★ ${p.rating.toFixed(1)}</b></span>
                        <span>${p.jarak} km</span>
                        <span>${HARGA[p.harga]}</span>
                    </div>
                </div>
            </button>
        </article>`;
    }

    function renderDetail() {
        const p = PLACES.find((x) => x.id === state.sel);
        const box = $('#detail');
        if (!p) { box.innerHTML = '<p class="text-sm text-[#4B6A63]">Pilih tempat untuk melihat detailnya.</p>'; return; }
        const saved = state.saved.has(p.id);
        const maps = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(p.nama + ' ' + p.area);
        box.innerHTML = `
            <div class="tile-${esc(p.kategori)} flex h-32 items-center justify-center rounded-md text-6xl" aria-hidden="true">${esc(p.emoji ?? '📍')}</div>
            <h2 class="font-display mt-4 text-2xl font-bold leading-tight">${esc(p.nama)}</h2>
            <p class="mt-1 text-sm text-[#4B6A63]">${esc(p.area)} · ${p.jarak} km dari lokasimu</p>
            <p class="mt-4 text-sm leading-relaxed">${esc(p.deskripsi)}</p>
            <dl class="mt-4 grid grid-cols-3 gap-2 text-center text-sm">
                <div class="rounded-md bg-[#F5F6F2] p-2"><dt class="text-xs text-[#4B6A63]">Rating</dt><dd class="font-semibold">${p.rating.toFixed(1)}</dd></div>
                <div class="rounded-md bg-[#F5F6F2] p-2"><dt class="text-xs text-[#4B6A63]">Anggaran</dt><dd class="font-semibold">${HARGA[p.harga]}</dd></div>
                <div class="rounded-md bg-[#F5F6F2] p-2"><dt class="text-xs text-[#4B6A63]">Cocok</dt><dd class="font-semibold">${p.cocok}%</dd></div>
            </dl>
            <p class="mt-4 text-sm"><span class="text-[#4B6A63]">Jam buka:</span> ${esc(p.jam)}</p>
            <ul class="mt-3 flex flex-wrap gap-1.5">${p.tag.map((t) => `<li class="rounded-full bg-[#E4E9E4] px-2.5 py-1 text-xs">${esc(t)}</li>`).join('')}</ul>
            <div class="mt-5 flex gap-2">
                <a href="${maps}" target="_blank" rel="noopener" class="flex-1 rounded-md bg-[#13302B] px-4 py-2.5 text-center text-sm font-medium text-white hover:bg-black">Buka di Maps</a>
                <button data-save="${p.id}" class="rounded-md border border-[#C9D5CF] px-4 py-2.5 text-sm font-medium hover:bg-[#F5F6F2]" aria-pressed="${saved}">${saved ? 'Tersimpan' : 'Simpan'}</button>
            </div>`;
    }

    function renderSaved() {
        const items = PLACES.filter((p) => state.saved.has(p.id));
        $('#listSimpan').innerHTML = items.length
            ? items.map((p) => `<li><button data-id="${p.id}" class="rounded-full border border-[#C9D5CF] bg-white px-3 py-1.5 hover:border-[#1F7A72]">${esc(p.nama)}</button></li>`).join('')
            : '<li class="text-[#4B6A63]">Belum ada yang disimpan. Pilih tempat lalu tekan Simpan.</li>';
        $('#savedCount').textContent = $('#savedCountM').textContent = state.saved.size;
    }

    function render() {
        const list = filtered();
        $('#daftar').innerHTML = list.map(card).join('');
        $('#kosong').classList.toggle('hidden', list.length > 0);
        $('#hitung').textContent = list.length + ' tempat';
        document.querySelectorAll('#kategori button').forEach((b) => {
            const on = b.dataset.k === state.k;
            b.className = 'rounded-md px-4 py-1.5 font-medium ' + (on ? 'bg-white shadow-sm text-[#13302B]' : 'text-[#4B6A63]');
            b.setAttribute('aria-pressed', on);
        });
        renderDetail();
        renderSaved();
    }

    document.addEventListener('click', (e) => {
        const k = e.target.closest('[data-k]'), id = e.target.closest('[data-id]'), sv = e.target.closest('[data-save]');
        if (k) state.k = k.dataset.k;
        if (id) state.sel = +id.dataset.id;
        if (sv) { const n = +sv.dataset.save; state.saved.has(n) ? state.saved.delete(n) : state.saved.add(n); }
        if (k || id || sv) render();
    });
    $('#q').addEventListener('input', (e) => { state.q = e.target.value; render(); });
    $('#harga').addEventListener('change', (e) => { state.harga = +e.target.value; render(); });
    $('#urut').addEventListener('change', (e) => { state.urut = e.target.value; render(); });

    render();
</script>
</body>
</html>