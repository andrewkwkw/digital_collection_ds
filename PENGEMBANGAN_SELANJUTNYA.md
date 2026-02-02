# Rencana Pengembangan Selanjutnya (Future Development)

Dokumen ini berisi roadmap teknis untuk peningkatan kualitas sistem Digital Collection ke standar "Museum Grade" (setara Leiden Digital Collections).

## Topik Utama: High-Fidelity Deep Zoom (Gigapixel Images)

Saat ini sistem menggunakan PDF Viewer berbasis *document-load* yang memuat seluruh gambar ke RAM. Untuk koleksi digital dengan resolusi sangat tinggi (agar tulisan kuno/serat kertas terlihat jelas saat di-zoom), diperlukan perubahan arsitektur ke sistem **Tile-Based Rendering**.

### 1. Masalah Saat Ini
*   **Limitasi RAM**: Membuka gambar resolusi sangat tinggi (misal 50MP+) akan membuat browser crash atau lambat.
*   **Bandwidth**: User harus mendownload file utuh di awal, boros kuota jika hanya ingin melihat bagian kecil.

### 2. Solusi: Arsitektur IIIF (International Image Interoperability Framework)
Mengadopsi standar dunia untuk arsip digital. Konsepnya seperti Google Maps:
1.  Gambar dipecah menjadi ribuan kotak kecil (*tiles*).
2.  Browser hanya mendownload *tile* yang sedang dilihat di layar.
3.  Memungkinkan zoom "tak terbatas" tanpa berat di sisi client.

### 3. Stack Teknologi yang Dibutuhkan

#### A. Backend (Processing)
Server harus bisa memproses file upload (PDF/TIFF) menjadi format *Deep Zoom Image (DZI)* atau *Pyramid Tiff*.
*   **Library**: `libvips` (Sangat cepat & hemat memori).
*   **Penyimpanan**: Folder struktur DZI (berisi ribuan file `.jpg` kecil).

#### B. Frontend (Viewer)
Mengganti (atau menambah opsional) viewer saat ini dengan viewer khusus Deep Zoom.
*   **OpenSeadragon**: Viewer JavaScript paling populer untuk Deep Zoom. Open Source, ringan, dan support touch gesture.

### 4. Langkah Implementasi (Roadmap)

1.  **Persiapan Server**:
    *   Install `libvips` di server VPS.
    *   Pastikan storage cukup (file DZI butuh space tambahan sekitar 20-30% dari file asli).

2.  **Backend Logic**:
    *   Buat `Job` queue di Laravel. Saat admin upload file, jalankan background process converter.
    *   Command contoh: `vips dzsave input_file.pdf output_folder`

3.  **Frontend Integration**:
    *   Buat halaman view baru `viewer-deepzoom.blade.php`.
    *   Integrasikan library **OpenSeadragon**.
    *   Sambungkan path hasil generate DZI ke viewer.

### 5. Estimasi Hasil
*   **User Experience**: Zoom sangat mulus, tajam, dan cepat (instan load).
*   **Performa**: Beban RAM user sangat rendah, cocok untuk HP spesifikasi rendah sekalipun.
