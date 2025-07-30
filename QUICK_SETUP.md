# Quick Setup SmartPED - Google Maps

## Masalah yang Terjadi
Modal "Pilih Lokasi di Peta" muncul tetapi peta tidak ter-load karena Google Maps API key belum dikonfigurasi.

## Solusi Cepat

### Opsi 1: Setup Google Maps API (Direkomendasikan)

1. **Dapatkan API Key Gratis:**
   - Kunjungi: https://console.cloud.google.com/
   - Buat project baru
   - Aktifkan "Maps JavaScript API"
   - Buat API Key

2. **Tambahkan ke file `.env`:**
```env
GOOGLE_MAPS_API_KEY=your_api_key_here
```

3. **Atau tambahkan langsung ke `config/maps.php`:**
```php
'google_maps_api_key' => 'your_api_key_here',
```

### Opsi 2: Gunakan Tanpa Google Maps (Sementara)

Jika tidak ingin setup API key sekarang, aplikasi tetap bisa digunakan:

1. **Input Manual Koordinat:**
   - Masukkan latitude dan longitude secara manual
   - Contoh: -6.2088, 106.8456 (Jakarta)

2. **Dapatkan Koordinat dari Google Maps:**
   - Buka Google Maps
   - Klik kanan pada lokasi
   - Pilih "What's here?"
   - Copy koordinat yang muncul

## Fitur yang Tetap Bekerja Tanpa API Key

✅ **Upload Dokumen** - Semua fitur upload tetap berfungsi
✅ **Input Manual Koordinat** - Bisa masukkan koordinat secara manual
✅ **Link ke Google Maps** - Tombol "Buka di Google Maps" tetap berfungsi
✅ **Filter dan Statistik** - Semua fitur filter tetap berfungsi
✅ **Download File** - Fitur download tetap berfungsi

## Fitur yang Membutuhkan API Key

❌ **Modal Peta Interaktif** - Peta tidak akan muncul
❌ **Coordinate Picker** - Tidak bisa pilih lokasi di peta
❌ **Peta Overview** - Peta overview tidak akan muncul

## Testing Aplikasi

1. **Upload dokumen tanpa koordinat:**
   - Kosongkan field latitude dan longitude
   - Upload dokumen tetap berhasil

2. **Upload dokumen dengan koordinat manual:**
   - Masukkan koordinat secara manual
   - Contoh: Latitude: -6.2088, Longitude: 106.8456

3. **Test link ke Google Maps:**
   - Klik "Lihat Peta" di halaman index
   - Modal akan muncul dengan pesan error
   - Klik "Buka di Google Maps" untuk navigasi

## Keuntungan Setup API Key

✅ **Peta Interaktif** - Bisa lihat lokasi di peta
✅ **Coordinate Picker** - Bisa pilih lokasi secara visual
✅ **Peta Overview** - Lihat semua lokasi dalam satu peta
✅ **User Experience** - Lebih mudah dan intuitif

## Kuota Gratis Google Maps

- **28,500 requests per bulan** untuk Maps JavaScript API
- **Cukup untuk aplikasi kecil-menengah**
- **Tidak ada biaya** untuk penggunaan dasar 