# SerpAPI Setup untuk Google Maps

## Konfigurasi SerpAPI

Untuk menggunakan SerpAPI sebagai alternatif Google Maps API, ikuti langkah-langkah berikut:

### 1. Daftar di SerpAPI
- Kunjungi [https://serpapi.com](https://serpapi.com)
- Daftar akun dan dapatkan API key

### 2. Konfigurasi Environment Variables
Tambahkan konfigurasi berikut ke file `.env`:

```env
# SerpAPI Configuration
SERPAPI_KEY=your_serpapi_key_here
SERPAPI_BASE_URL=https://serpapi.com/search
```

### 3. Fitur yang Tersedia

#### Static Maps
- Peta statis untuk detail lokasi dokumen
- Peta overview untuk melihat semua lokasi dokumen
- Fallback ke Google Maps jika SerpAPI gagal

#### Keuntungan SerpAPI
- Tidak memerlukan billing setup seperti Google Maps
- Lebih mudah untuk development dan testing
- Mendukung berbagai engine pencarian

### 4. Penggunaan

Setelah konfigurasi selesai, aplikasi akan otomatis menggunakan SerpAPI untuk:
- Menampilkan peta detail lokasi dokumen
- Menampilkan peta overview semua dokumen
- Fallback ke Google Maps jika diperlukan

### 5. Troubleshooting

Jika peta tidak muncul:
1. Pastikan `SERPAPI_KEY` sudah dikonfigurasi dengan benar
2. Periksa apakah API key masih aktif
3. Periksa console browser untuk error messages
4. Pastikan koneksi internet stabil

### 6. Alternatif

Jika SerpAPI tidak tersedia, aplikasi akan menampilkan:
- Link langsung ke Google Maps
- Pesan error yang informatif
- Fallback UI yang user-friendly 