MODUL PRAKTIKUM 1
Modul Praktikum – Pertemuan 7
WEB SERVICE
(Dokumentasi API dengan Postman)
Dr. Imam Ahmad Ashari, M.Kom.
PROGRAM STUDI INFORMATIKA
FAKULTAS SAINS DAN TEKNOLOGI
UNIVERSITAS HARAPAN BANGSA
TAHUN 2026
Modul Praktikum: Dokumentasi API SIAKAD (Standar SATUSEHAT)
Standarisasi: https://www.postman.com/satusehat/satusehat-public/overview?sideView=agentMode
1. Arsitektur Folder Koleksi
Untuk mengikuti standar profesional, kita tidak akan menumpuk semua request di satu tempat. Buatlah
folder-folder berikut di dalam koleksi SIAKAD API:
• 01 Authentication (Login & Refresh Token)
• 02 Master Data Mahasiswa
• 03 Master Data Dosen
• 04 Akademik - Mata Kuliah
• 05 Fasilitas - Ruang Kelas
• 06 Operasional - Jadwal Perkuliahan
Langkah 1: Membuat Koleksi Utama (Parent)
Sebelum membuat folder, Anda harus memiliki wadah utamanya.
1. Buka aplikasi Postman.
2. Di sidebar sebelah kiri, klik ikon "+" (Create New Collection).
3. Beri nama koleksi tersebut: SIAKAD API v1.0.
Langkah 2: Membuat Folder di Dalam Koleksi
Sekarang, mari kita buat arsitektur folder sesuai instruksi Anda:
1. Arahkan kursor ke koleksi SIAKAD API v1.0.
2. Klik ikon tiga titik (...) di samping nama koleksi.
3. Pilih menu Add Folder.
4. Beri nama folder pertama: 01 Authentication.
5. Ulangi langkah di atas hingga Anda memiliki 6 folder:
✓ 01 Authentication
✓ 02 Master Data Mahasiswa
✓ 03 Master Data Dosen
✓ 04 Akademik - Mata Kuliah
✓ 05 Fasilitas - Ruang Kelas
✓ 06 Operasional - Jadwal Perkuliahan
Langkah 3: Menambahkan Deskripsi Folder (Gaya SATUSEHAT)
Agar terlihat seperti SATUSEHAT, folder tidak boleh kosong. Anda harus mengisi penjelasan di setiap
folder:
1. Klik pada salah satu folder (misal: 01 Authentication).
2. Di panel tengah, Anda akan melihat tab Documentation (biasanya di sebelah kanan atau di
bawah nama folder).
3. Klik ikon Pensil (Edit).
4. Masukkan deskripsi menggunakan format Markdown. Contoh:
Markdown
## Deskripsi Folder
Folder ini berisi semua endpoint yang berkaitan dengan keamanan dan akses pengguna.
### Prosedur
1. Gunakan endpoint **Login** untuk mendapatkan token.
2. Masukkan token ke dalam **Collection Variables**.
Langkah 4: Memasukkan Request ke Dalam Folder
1. Klik tiga titik (...) pada folder spesifik (misal: 02 Master Data Mahasiswa).
2. Pilih Add Request.
3. Beri nama requestnya, contoh: Get All Students.
4. Ubah Method (GET/POST/PUT/DELETE) dan masukkan URL-nya.
Langkah 5: Mengatur Penomoran (Sorting)
Postman mengurutkan folder secara alfabetis. Dengan memberikan penomoran 01, 02, dst., di depan
nama folder (seperti yang Anda tuliskan), Postman akan menjaga urutan alur kerja (workflow) API Anda
tetap berurutan dari proses Login hingga Operasional.
Tips Visual agar Mirip SATUSEHAT:
• Gunakan Emoji: Anda bisa menambahkan emoji pada nama folder agar lebih menarik secara
visual, misalnya: 01 Authentication.
• Collection Overview: Jangan lupa klik pada nama Koleksi utama dan isi bagian Documentation
dengan "Introduction" atau "Cara Penggunaan API" secara umum. Ini akan muncul sebagai
halaman utama saat dokumentasi di-publish.
Setelah struktur ini jadi, saat Anda mengeklik "View Documentation", Postman akan otomatis membuat
menu navigasi di sisi kiri berdasarkan folder-folder yang baru saja Anda buat.
2. Panduan Penulisan Deskripsi (Gaya SATUSEHAT)
SATUSEHAT tidak hanya menulis "ini API login", tapi memberikan konteks. Terapkan ini pada setiap folder
dan request:
• Header Utama: Gunakan # untuk judul dan ## untuk sub-judul.
• Status Endpoint: Beri label seperti [STAGING] atau [PRODUCTION].
• Informasi Teknis: Gunakan tabel Markdown untuk menjelaskan parameter.
1. Header Utama (Struktur Hirarki)
Jangan menulis teks datar. Gunakan simbol # di panel deskripsi (tab Documentation) untuk menciptakan
struktur yang bisa dipindai mata dengan cepat.
Teknisnya: Di dalam panel deskripsi Postman, ketik:
# 02 Master Data Mahasiswa
Folder ini mengelola seluruh informasi biodata mahasiswa.
## Aturan Penggunaan
* NIM tidak boleh duplikat.
* Format tanggal lahir harus `YYYY-MM-DD`.
• # akan menjadi judul besar (H1).
• ## akan menjadi sub-judul (H2) yang juga otomatis muncul di daftar isi (sidebar) saat
dokumentasi dipublikasikan.
2. Status Endpoint (Visual Label)
SATUSEHAT memberikan kejelasan apakah sebuah API siap pakai atau masih uji coba. Karena Postman
tidak punya tombol "label" khusus, kita menggunakan teks tebal atau blok kode di awal deskripsi.
Teknisnya: Tulis di baris pertama deskripsi request Anda:
• Opsi A (Bold): **Status:** [PRODUCTION]
• Opsi B (Code Block): `STATUS: STAGING`
• Opsi C (Emoji): [PRODUCTION] atau [STAGING]
Contoh Penerapan:
### Get All Students
`STATUS: PRODUCTION`
`VERSION: 1.0.4`
Endpoint ini digunakan untuk menarik data seluruh mahasiswa dari
server produksi.
3. Informasi Teknis (Tabel Markdown)
Daripada menulis "Parameter ID adalah angka", gunakan tabel agar terlihat sangat profesional dan
mudah dibaca.
Teknisnya: Gunakan format pipe (|) dan dash (-) di dalam deskripsi Postman:
| Parameter | Tipe | Wajib | Deskripsi |
| :--- | :--- | :--- | :--- |
| `nim` | String | Ya | Nomor Induk Mahasiswa (10 digit). |
| `prodi_id` | Integer | Ya | ID program studi yang terdaftar. |
| `status` | String | Tidak | Filter status: `aktif`, `lulus`, `cuti`.
|
Langkah-Langkah Menerapkannya di Postman:
1. Pilih Request/Folder: Klik nama folder atau request di sidebar kiri.
2. Buka Documentation: Lihat di panel sebelah kanan aplikasi Postman, klik ikon dokumen/kertas
(Documentation).
3. Klik Edit (Ikon Pensil): Jika deskripsi masih kosong, klik ikon pensil untuk mulai menulis.
4. Tulis Markdown: Masukkan kombinasi Header, Status, dan Tabel di atas.
5. Preview: Postman akan langsung menampilkan hasil render Markdown tersebut sehingga
terlihat rapi (persis seperti tampilan web SATUSEHAT).
Contoh Lengkap Gabungan (Gaya SATUSEHAT):
Jika Anda menggabungkan ketiganya pada request Login, maka isinya akan seperti ini:
# Login Pengguna
`STATUS: PRODUCTION`
Silahkan gunakan endpoint ini untuk mendapatkan access token. Token
ini wajib disertakan dalam setiap request di folder lain.
## Request Headers
| Key | Value | Description |
| :--- | :--- | :--- |
| Content-Type | application/json | Format data yang dikirim. |
## Request Body
| Field | Type | Description |
| :--- | :--- | :--- |
| username | String | NIK atau Username admin. |
| password | String | Password minimal 8 karakter. |
> **Note:** Token akan kadaluwarsa dalam 24 jam. Gunakan Refresh Token
jika session habis.
Dengan teknis ini, dokumentasi Anda tidak hanya berisi daftar URL, tapi menjadi sebuah Developer
Portal yang sangat informatif.
3. Detail Implementasi per Folder
Folder 01: Authentication
Dokumentasikan proses mendapatkan akses.
• Endpoint: POST {{base_url}}/auth/login
• Deskripsi (Markdown):
API ini merupakan pintu masuk utama. Sistem menggunakan JWT (JSON Web Token). Token harus
dikirimkan pada setiap request di header Authorization: Bearer <token>.
• Contoh Respon (Save as Example): Sertakan respon 200 OK dengan properti access_token dan
expires_in.
Folder 02: Master Data Mahasiswa (CRUD)
Gunakan Path Variables untuk operasi spesifik.
• GET /mahasiswa (List all)
• POST /mahasiswa (Create)
• GET /mahasiswa/:nim (Detail by NIM)
• PUT /mahasiswa/:nim (Update)
• DELETE /mahasiswa/:nim (Delete)
• Penting: Pada bagian deskripsi, jelaskan bahwa NIM bersifat unik dan immutable (tidak bisa
diubah).
Folder 06: Operasional - Jadwal Perkuliahan
Ini adalah bagian yang paling kompleks karena melibatkan relasi. Ikuti gaya SATUSEHAT dalam
menjelaskan keterkaitan data:
• Deskripsi: "Endpoint ini mengintegrasikan data dosen_id, matakuliah_id, dan ruangan_id.
Pastikan jadwal tidak bentrok pada jam yang sama di ruangan yang sama."
• Request Body Example:
JSON
{
 "matakuliah_id": "MK001",
 "dosen_id": "D005",
 "ruangan_id": "LAB-01",
 "hari": "Selasa",
 "jam_mulai": "08:00",
 "jam_selesai": "10:00"
}
1. Folder 01: Authentication (Teknis Token & Automation)
Pada folder ini, tujuan utamanya adalah agar pengguna tahu cara mendapatkan kunci akses.
• Pembuatan Request: Klik kanan folder 01 Authentication > Add Request > Beri nama Login.
• Set Method & URL: Ubah ke POST dan masukkan {{base_url}}/auth/login.
• Mengisi Deskripsi (Markdown): Di panel kanan (Documentation), tempel teks Markdown yang
Anda buat. Sertakan blok kode untuk memperjelas format header:
Setiap request berikutnya wajib menyertakan header:
`Authorization: Bearer <token>`
• Membuat "Save as Example":
1. Masukkan dummy body di tab Body (raw JSON).
2. Klik Send.
3. Di area respon bawah, klik Save as Example.
4. Beri nama 200 OK - Success Login. Pastikan JSON responnya terlihat seperti ini:
JSON
{
 "access_token": "eyJhbGci...",
 "expires_in": 86400,
 "token_type": "Bearer"
}
2. Folder 02: Master Data Mahasiswa (Teknis Path Variables)
Di sini kita akan menggunakan titik dua (:) untuk membuat variabel di dalam URL (Path Variables).
• Membuat Endpoint Spesifik (Detail, Update, Delete):
1. Buat request baru, masukkan URL: {{base_url}}/mahasiswa/:nim
2. Postman akan otomatis memunculkan tabel Path Variables di bawah baris URL.
3. Di kolom Value, masukkan contoh seperti 2024001.
4. Di kolom Description, tulis: Nomor Induk Mahasiswa sebagai identifier unik.
• Deskripsi Penting (Markdown): Tambahkan blok Callout atau Warning di deskripsi
folder/request agar terlihat menonjol seperti SATUSEHAT:
> ### PENTING
> Field **NIM** bersifat **Unik** dan **Immutable**.
> NIM tidak dapat diubah setelah data dibuat. Jika terjadi kesalahan
input NIM, data harus dihapus dan dibuat ulang.
3. Folder 06: Jadwal Perkuliahan (Teknis Relasi & Validasi Body)
Karena ini adalah endpoint relasional, deskripsinya harus menjelaskan dari mana ID berasal.
• Menjelaskan Relasi di Deskripsi: Gunakan list atau tabel untuk menunjukkan keterkaitan antar
modul:
## Relasi Data
Input jadwal memerlukan ID valid dari folder berikut:
- `matakuliah_id` (Ambil dari Folder 04)
- `dosen_id` (Ambil dari Folder 03)
- `ruangan_id` (Ambil dari Folder 05)
• Body Example dengan Penjelasan:
1. Pilih tab Body > raw > JSON.
2. Masukkan contoh JSON yang Anda sertakan di atas.
3. Tips: Tambahkan komentar di dalam JSON (jika server mendukung) atau jelaskan format
jam di deskripsi teknis (misal: jam_mulai harus format HH:mm 24 jam).
• Validasi "Bentrok" (Business Logic): Tuliskan aturan bisnis di deskripsi:
### Aturan Bentrok (Collision Rule)
Sistem akan menolak (409 Conflict) jika:
1. Dosen mengajar di jam yang sama di kelas berbeda.
2. Ruangan digunakan oleh mata kuliah lain di jam yang sama.
Ringkasan Teknis Postman yang Harus Dilakukan:
1. Gunakan Double Curly Braces {{ }} untuk semua URL agar fleksibel berpindah dari server lokal ke
cloud.
2. Gunakan Path Variables :id atau :nim daripada menulis manual mahasiswa/123. Ini membuat
dokumentasi terlihat jauh lebih rapi.
3. Wajib Klik "Save as Example" setelah melakukan testing, karena tanpa ini, orang yang membaca
dokumentasi tidak akan tahu bentuk data yang akan mereka terima.
4. Gunakan Markdown Callouts (>) untuk informasi krusial seperti "NIM tidak bisa diubah" agar
developer tidak melewatkan informasi tersebut.
4. Teknik "Advanced Documentation" (Kunci Sukses SATUSEHAT)
A. Penggunaan Examples yang Masif
Jangan hanya menyimpan respon sukses. Ikuti standar SATUSEHAT dengan menyediakan:
1. Example: 200 OK (Data ditemukan/berhasil).
2. Example: 400 Bad Request (Validasi input salah).
3. Example: 401 Unauthorized (Token tidak valid).
4. Example: 404 Not Found (ID mahasiswa tidak ada).
B. Visualizer & Scripts
Sama seperti SATUSEHAT yang memberikan kemudahan, tambahkan script pada tab Tests untuk
mengotomatisasi token:
JavaScript
if (pm.response.code === 200) {
 var jsonData = pm.response.json();
 pm.collectionVariables.set("token", jsonData.access_token);
}
Di Postman, Examples bukan sekadar lampiran, melainkan referensi utama bagi developer frontend
untuk melakukan error handling.
Cara Membuat Berbagai Skenario Respon:
1. Lakukan Request: Klik tombol Send pada endpoint Anda (misal: Get Student by NIM).
2. Simpan Respon Sukses:
✓ Setelah muncul respon 200 OK, klik Save as Example (pojok kanan atas).
✓ Beri nama: 200 - Success Data Found.
3. Simpan Respon Error (Skenario 404):
✓ Ubah NIM di URL menjadi angka yang tidak ada (misal: 999999). Klik Send.
✓ Setelah muncul 404 Not Found, klik Save as Example.
✓ Beri nama: 404 - Student Not Found.
4. Simpan Respon Validasi (Skenario 400):
✓ Kosongkan body atau masukkan format salah. Klik Send.
✓ Simpan respon 400 Bad Request. Beri nama: 400 - Invalid Input Format.
5. Hasil Akhir: Saat dokumentasi dipublikasikan, pengguna bisa memilih menu dropdown di bagian
contoh respon untuk melihat berbagai kemungkinan output.
B. Teknis Visualizer & Scripts (Otomatisasi)
Salah satu fitur terbaik SATUSEHAT adalah kemudahan bagi developer. Menggunakan script untuk
otomatisasi token membuat developer tidak perlu melakukan copy-paste token manual dari hasil login
ke folder lain.
Cara Memasang Script Otomatisasi:
1. Buka request Login di folder 01 Authentication.
2. Klik tab Tests (terletak di antara tab Body dan Settings).
3. Tempelkan kode JavaScript berikut:
JavaScript
// Pastikan kode respon adalah 200 (berhasil)
if (pm.response.code === 200) {
 // Mengambil data JSON dari respon
 var jsonData = pm.response.json();
 // Menyimpan nilai access_token ke dalam variabel koleksi bernama
"token"
 pm.collectionVariables.set("token", jsonData.access_token);
 console.log("Token berhasil diperbarui otomatis!");
}
4. Konfigurasi Variabel: * Klik nama koleksi utama (SIAKAD API).
o Pilih tab Variables.
o Tambahkan baris baru dengan nama token. Biarkan kolom Initial Value kosong.
5. Cara Kerja: Setiap kali Anda klik Send pada API Login, Postman akan otomatis mengambil token
terbaru dan menyimpannya di variabel token.
C. Menghubungkan Token ke Seluruh Folder
Agar variabel {{token}} yang didapat secara otomatis di atas bisa digunakan oleh semua folder
(Mahasiswa, Dosen, dll):
1. Klik nama koleksi utama (SIAKAD API).
2. Pilih tab Authorization.
3. Ubah Type menjadi Bearer Token.
4. Di kolom Token, ketik: {{token}}.
5. Simpan (Save).
6. Setting di setiap Request: Pastikan di setiap request (misal: CRUD Mahasiswa), pada tab
Authorization, tipenya adalah Inherit auth from parent.
D. Mengaktifkan Visualizer (Opsional tapi Keren)
Ingin membuat tampilan tabel cantik di dalam Postman seperti SATUSEHAT? Anda bisa menambahkan
kode di tab Tests:
JavaScript
var template = `
 <table bgcolor="#FFFFFF">
 <tr bgcolor="#F2F2F2">
 <th>ID</th>
 <th>NIM</th>
 <th>Nama</th>
 </tr>
 {{#each response.data}}
 <tr>
 <td>{{id}}</td>
 <td>{{nim}}</td>
 <td>{{nama}}</td>
 </tr>
 {{/each}}
 </table>
`;
pm.visualizer.set(template, {
 response: pm.response.json()
});
Setelah klik Send, klik tab Visualize di area respon bawah untuk melihat data mentah JSON berubah
menjadi tabel rapi.
Dengan menerapkan teknik ini, praktikum dokumentasi Anda akan memiliki kualitas standar industri
yang sangat memudahkan pengembang lain dalam melakukan integrasi.
5. Langkah Publikasi Seperti SATUSEHAT
Setelah koleksi dan folder rapi:
1. Klik ... pada Koleksi > View Documentation.
2. Klik Publish di pojok kanan atas.
3. Styling: Pilih layout Double Column (ini adalah tampilan yang digunakan SATUSEHAT di mana
kode berada di samping teks).
4. SEO & Metadata: Isi deskripsi publik agar mudah dicari oleh pengembang lain.
6. Kuis
Buatkan dokumentasi untuk project akhir Web Service yang telah dibuat!