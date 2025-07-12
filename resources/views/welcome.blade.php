<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIG Sekolah</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map { height: 400px; width: 100%; }

        .navbar-custom {
            background-color: #183D8E;
        }

        .navbar-custom .nav-link, .navbar-custom .navbar-brand {
            color: white;
        }

        .navbar-custom .nav-link.active {
            border-bottom: 2px solid white;
        }

        footer {
            background-color: #222;
            color: #ccc;
            padding: 20px 0;
        }

        section#tentang {
            background-color: #f8f9fa;
            padding: 60px 0;
        }

        section#tentang h2 {
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#map">SIG Sekolah</a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon text-white"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#data">Data Sekolah</a></li>
                <li class="nav-item"><a class="nav-link" href="#map">Peta</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        Login
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
        @if (Route::has('register'))
            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
        @endif
    </ul>
</li>

            </ul>
        </div>
    </div>
</nav>
<!-- Jumbotron -->
<section class="bg-dark text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Sekolah Bisa</h1>
        <p class="lead">Pemetaan Sekolah Berbasis Web dengan Laravel dan Leaflet.js</p>
    </div>
</section>


<!-- Konten Utama -->
<div class="container py-5" id="data">
    <h3 class="text-center fw-bold mb-4">Data Sekolah</h3>
    <p class="text-center text-muted">Informasi lengkap sekolah-sekolah di Kota Bogor</p>

    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-md-4 mb-2">
            <label class="form-label">Jenis Sekolah</label>
            <select id="jenis_sekolah" class="form-select">
                <option value="">Pilih Jenis</option>
                <option value="SMA">SMA</option>
                <option value="SMK">SMK</option>
                <option value="SMP">SMP</option>
                <option value="SD">SD</option>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <label class="form-label">Status Sekolah</label>
            <select id="status_sekolah" class="form-select">
                <option value="">Pilih Status</option>
                <option value="Negeri">Negeri</option>
                <option value="Swasta">Swasta</option>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <label class="form-label">Akreditasi</label>
            <select id="akreditasi" class="form-select">
                <option value="">Pilih Akreditasi</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
    </div>

    <!-- Kartu -->
    <div class="row" id="cardSekolahContainer">
        <!-- Diisi lewat JavaScript -->
    </div>
</div>

<!-- Peta -->
<div class="container mb-5" id="map-container">
    <h4 class="text-center mb-3">Peta Lokasi Sekolah</h4>
    <div id="map" class="rounded shadow-sm border"></div>
</div>

<!-- Tentang -->
<section id="tentang">
    <div class="container">
        <h2 class="text-center mb-4">Tentang Aplikasi</h2>
        <p class="text-center mx-auto" style="max-width: 800px;">
            SIG Sekolah adalah Sistem Informasi Geografis berbasis web yang menampilkan informasi lengkap tentang sekolah-sekolah di Kota Bogor. Aplikasi ini dibangun menggunakan Laravel dan Leaflet JS dengan fitur pencarian, filter, serta visualisasi lokasi dalam bentuk peta interaktif.
        </p>
    </div>
</section>

<!-- Footer -->
<footer class="text-center">
    <div class="container">
        <small>&copy; {{ date('Y') }} SIG Sekolah. All rights reserved.</small>
    </div>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;

    async function loadDataSekolah(jenis = '', status = '', akreditasi = '') {
        try {
            const response = await fetch('/api/sekolah');
            const json = await response.json();
            const data = json.data;

            const container = document.getElementById('cardSekolahContainer');
            container.innerHTML = '';

            if (!map) {
                map = L.map('map').setView([-6.6, 106.8], 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);
            }

            const bounds = [];

            data.filter(item => {
                return (!jenis || item.jenis_sekolah === jenis) &&
                       (!status || item.status_sekolah === status) &&
                       (!akreditasi || item.akreditasi === akreditasi);
            }).forEach(item => {
                const card = document.createElement('div');
                card.className = 'col-md-4 mb-4';
                card.innerHTML = `
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">${item.nama}</h5>
                            <p><strong>Jenis:</strong> ${item.jenis_sekolah}</p>
                            <p><strong>Status:</strong> ${item.status_sekolah}</p>
                            <p><strong>Telepon:</strong> ${item.telepon ?? '-'}</p>
                            <p><strong>Email:</strong> ${item.email ?? '-'}</p>
                            <p><strong>Akreditasi:</strong> ${item.akreditasi ?? '-'}</p>
                            <p><strong>Website:</strong> ${item.website ? `<a href="https://${item.website}" target="_blank">${item.website}</a>` : '-'}</p>
                        </div>
                    </div>`;
                container.appendChild(card);

                const lat = parseFloat(item.latitude);
                const lng = parseFloat(item.longitude);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(`<strong>${item.nama}</strong>`);
                    bounds.push([lat, lng]);
                }
            });

            if (bounds.length) map.fitBounds(bounds);

        } catch (err) {
            console.error("Gagal load data:", err);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadDataSekolah();

        document.querySelectorAll('#jenis_sekolah, #status_sekolah, #akreditasi').forEach(el => {
            el.addEventListener('change', () => {
                loadDataSekolah(
                    document.getElementById('jenis_sekolah').value,
                    document.getElementById('status_sekolah').value,
                    document.getElementById('akreditasi').value
                );
            });
        });
    });
</script>
</body>
</html>
