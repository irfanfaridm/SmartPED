# Fitur Zona Waktu (WIB, WIT, WITA)

## Deskripsi
Fitur ini menampilkan zona waktu Indonesia (WIB, WIT, WITA) berdasarkan koordinat longitude dokumen. Zona waktu ditampilkan dengan badge berwarna yang berbeda untuk setiap zona.

## Zona Waktu Indonesia

### 1. WIB (Waktu Indonesia Barat) - UTC+7
- **Warna Badge:** Biru (`bg-blue-100 text-blue-800`)
- **Longitude:** >= 105° (Sumatra, Jawa, Kalimantan Barat)
- **Kota:** Jakarta, Bandung, Surabaya, Medan, Palembang

### 2. WITA (Waktu Indonesia Tengah) - UTC+8
- **Warna Badge:** Hijau (`bg-green-100 text-green-800`)
- **Longitude:** >= 120° (Kalimantan Tengah, Kalimantan Timur, Sulawesi, Bali, NTT)
- **Kota:** Makassar, Balikpapan, Manado, Denpasar, Kupang

### 3. WIT (Waktu Indonesia Timur) - UTC+9
- **Warna Badge:** Ungu (`bg-purple-100 text-purple-800`)
- **Longitude:** < 120° (Maluku, Papua)
- **Kota:** Ambon, Jayapura, Sorong, Ternate

## Implementasi

### 1. Helper Class
File: `app/Helpers/TimeZoneHelper.php`

```php
// Mendapatkan zona waktu berdasarkan longitude
$timezoneAbbr = TimeZoneHelper::getTimezoneAbbr($longitude);

// Format waktu dengan zona waktu
$formattedTime = TimeZoneHelper::formatWithTimezone($datetime, $longitude);
```

### 2. Tampilan di Aplikasi

#### Navigation Bar
- Menampilkan waktu saat ini dengan badge WIB
- Posisi: Sebelah kanan, sebelum dropdown user

#### Halaman Indihome Index
- **Header:** Badge WIB di sebelah tanggal
- **Tabel:** Badge zona waktu di kolom "Tanggal Selesai"
- **Info Terakhir Diperbarui:** Menampilkan "WIB"

#### Halaman Create/Edit
- **Informasi Tanggal:** Badge zona waktu di sebelah waktu
- **Calendar Picker:** Menampilkan zona waktu yang sesuai

### 3. Konfigurasi
File: `config/app.php`
```php
'timezone' => 'Asia/Jakarta', // Default timezone WIB
```

## Cara Kerja

1. **Deteksi Zona Waktu:**
   - Sistem membaca longitude dari dokumen
   - Menentukan zona waktu berdasarkan batas longitude
   - Jika tidak ada longitude, default ke WIB

2. **Tampilan Badge:**
   - WIB: Badge biru
   - WITA: Badge hijau  
   - WIT: Badge ungu

3. **Format Waktu:**
   - Format: `H:i ZONA` (contoh: `14:30 WIB`)
   - Badge ditampilkan di sebelah waktu

## Contoh Penggunaan

```php
// Di view
@php
    $timezoneAbbr = \App\Helpers\TimeZoneHelper::getTimezoneAbbr($doc->longitude);
@endphp

<span class="text-xs text-gray-500">{{ $doc->created_at->format('H:i') }}</span>
<span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium 
    @if($timezoneAbbr === 'WIB') bg-blue-100 text-blue-800
    @elseif($timezoneAbbr === 'WITA') bg-green-100 text-green-800
    @elseif($timezoneAbbr === 'WIT') bg-purple-100 text-purple-800
    @else bg-gray-100 text-gray-800 @endif">
    {{ $timezoneAbbr }}
</span>
```

## Keuntungan

1. **Informasi Lokasi:** User dapat melihat zona waktu dokumen berdasarkan lokasi
2. **Konsistensi:** Semua waktu ditampilkan dengan zona waktu yang jelas
3. **Visual:** Badge berwarna memudahkan identifikasi zona waktu
4. **Akurasi:** Menggunakan koordinat longitude untuk menentukan zona waktu yang tepat

## Catatan

- Zona waktu ditentukan berdasarkan longitude, bukan lokasi administratif
- Default timezone aplikasi tetap WIB (Asia/Jakarta)
- Badge hanya menampilkan informasi zona waktu, tidak mengubah waktu yang tersimpan 