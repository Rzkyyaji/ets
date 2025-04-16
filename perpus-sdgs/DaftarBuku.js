document.addEventListener("DOMContentLoaded", function () {
    fetch("DaftarBuku.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("book-table").innerHTML = data;
        })
        .catch(error => {
            document.getElementById("book-table").innerHTML = "Gagal memuat data buku.";
            console.error("Terjadi kesalahan:", error);
        });
});

document.addEventListener("DOMContentLoaded", function () {
// Ambil daftar buku
fetch("DaftarBuku.php")
.then(response => response.text())
.then(data => {
document.getElementById("book-table").innerHTML = data;
})
.catch(error => {
document.getElementById("book-table").innerHTML = "Gagal memuat data buku.";
console.error("Terjadi kesalahan:", error);
});

// Cek role user
fetch("CekRole.php")
.then(response => response.text())
.then(role => {
if (role === "admin") {
  const navList = document.querySelector("nav ul");
  const li = document.createElement("li");
  const link = document.createElement("a");
  link.href = "TambahBuku.html"; // misalnya halaman tambah buku
  link.textContent = "Tambah Buku";
  li.appendChild(link);
  navList.appendChild(li);
}
});
});