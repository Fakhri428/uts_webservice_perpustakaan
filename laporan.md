# Laporan UTS Web Service

## 1. Identitas Proyek
- Nama proyek: uts-webservice
- Framework: Laravel
- Autentikasi: session web + Sanctum API
- Role user: admin dan user

## 2. Ringkasan Fitur
- CRUD buku
- CRUD kategori
- Peminjaman buku (loans)
- Endpoint AI: recommend, summarize, chat
- Dashboard berbeda untuk admin dan user

## 3. Ringkasan Endpoint
### API Publik
- GET /api/books
- GET /api/books/{id}
- GET /api/books/recommend
- GET /api/categories
- GET /api/categories/{id}

### API Admin
- POST /api/books
- PUT /api/books/{id}
- DELETE /api/books/{id}
- POST /api/categories
- PUT /api/categories/{id}
- DELETE /api/categories/{id}

### API Autentikasi
- GET /api/loans
- POST /api/loans
- GET /api/loans/{id}
- PUT /api/loans/{id}
- DELETE /api/loans/{id}
- POST /api/ai/recommend
- POST /api/ai/summarize
- POST /api/ai/chat

## 4. Ringkasan Database
- users: name, email, password, role
- books: title, author, description, category, published_year, isbn, stock
- loans: book_id, user_id, borrowed_at, due_at, returned_at, status

## 5. Relasi Model
- `Book` hasMany `Loan`
- `Loan` belongsTo `Book`
- `Loan` belongsTo `User`

## 6. Tampilan / Screenshot
> Simpan gambar ke folder `screenshots/` lalu sesuaikan nama file di bawah.

### 6.1 Halaman Utama
![Halaman Utama](screenshots/home.png)

### 6.2 Dashboard Admin
![Dashboard Admin](screenshots/admin-dashboard.png)

### 6.3 Dashboard User
![Dashboard User](screenshots/user-dashboard.png)

### 6.4 Daftar Buku
![Daftar Buku](screenshots/books.png)

### 6.5 Detail Buku
![Detail Buku](screenshots/book-detail.png)

### 6.6 Halaman Kategori
![Kategori](screenshots/categories.png)

### 6.7 Halaman Peminjaman
![Peminjaman](screenshots/loans.png)

### 6.8 Endpoint API (Postman / JSON)
![API Response](screenshots/api-response.png)

## 7. Kesimpulan
Aplikasi berhasil menampilkan pengelolaan buku, kategori, peminjaman, dan AI dengan pembagian akses admin dan user.
