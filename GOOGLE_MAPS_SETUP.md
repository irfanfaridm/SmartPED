# Google Maps API Setup untuk SmartPED

## Langkah-langkah Setup Google Maps API

### 1. Dapatkan Google Maps API Key

1. Kunjungi [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang sudah ada
3. Aktifkan Google Maps JavaScript API
4. Buat credentials (API Key)
5. Batasi API key untuk domain Anda (opsional tapi direkomendasikan)

### 2. Konfigurasi di Aplikasi

1. Tambahkan API key ke file `.env`:
```env
GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here
```

2. Atau jika tidak ada file `.env`, tambahkan langsung ke `config/maps.php`:
```php
'google_maps_api_key' => 'your_google_maps_api_key_here',
```

### 3. Fitur yang Tersedia

#### Halaman Index (Daftar Dokumen)
- ✅ **Modal Google Maps** - Klik "Lihat Peta" untuk membuka peta interaktif
- ✅ **Peta Overview** - Menampilkan semua lokasi dokumen dalam satu peta
- ✅ **Info Window** - Menampilkan detail dokumen saat marker diklik
- ✅ **Link ke Google Maps** - Tombol untuk membuka lokasi di Google Maps

#### Halaman Create (Upload Dokumen)
- ✅ **Coordinate Picker** - Klik "Pilih Lokasi di Peta" untuk memilih koordinat secara visual
- ✅ **Input Manual** - Masukkan koordinat secara manual
- ✅ **Preview Koordinat** - Menampilkan koordinat yang dipilih

### 4. Contoh Penggunaan

#### Untuk Dokumen "Pembangunan ODC Tebet":
- **Nama Dokumen**: Pembangunan ODC Tebet
- **Lokasi**: Tebet, Jakarta Selatan
- **Koordinat**: -6.2088, 106.8456
- **Fitur Peta**: 
  - Klik "Lihat Peta" untuk melihat lokasi di modal
  - Klik marker di peta overview untuk detail
  - Klik "Buka di Google Maps" untuk navigasi

### 5. Keamanan

- ✅ API key disimpan di konfigurasi
- ✅ Validasi koordinat (latitude: -90 sampai 90, longitude: -180 sampai 180)
- ✅ Error handling untuk koordinat yang tidak valid

### 6. Troubleshooting

#### Jika peta tidak muncul:
1. Pastikan API key sudah benar
2. Periksa apakah Google Maps JavaScript API sudah diaktifkan
3. Periksa console browser untuk error JavaScript
4. Pastikan domain sudah diizinkan di Google Cloud Console

#### Jika koordinat tidak tersimpan:
1. Pastikan format koordinat benar (desimal)
2. Periksa validasi di controller
3. Periksa database migration sudah dijalankan

### 7. API Key Gratis

Google Maps API menyediakan kuota gratis:
- 28,500 requests per bulan untuk Maps JavaScript API
- Cukup untuk penggunaan aplikasi kecil-menengah

### 8. Alternatif (Jika Tidak Ada API Key)

Jika tidak ingin menggunakan Google Maps API, Anda bisa:
1. Hapus script Google Maps dari view
2. Gunakan link ke Google Maps saja
3. Atau gunakan OpenStreetMap (gratis, tidak perlu API key) 