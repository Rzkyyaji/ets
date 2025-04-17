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
      role = role.trim(); // penting!

      const navList = document.querySelector("nav ul");
      if (!navList) return;

      if (role === "admin") {
        // Tambah Buku
        const liTambah = document.createElement("li");
        liTambah.innerHTML = `<a href="TambahBuku.html">Tambah Buku</a>`;
        navList.appendChild(liTambah);

        // Rekap
        const liRekap = document.createElement("li");
        liRekap.innerHTML = `<a href="RekapPeminjaman.html">Rekap</a>`;
        navList.appendChild(liRekap);
      } else if (role === "anggota") {
        const liUser = document.createElement("li");
        liUser.innerHTML = `<a href="DataPeminjamanUser.html">Data Peminjaman Buku</a>`;
        navList.appendChild(liUser);
      }
    })
    .catch(error => {
      console.error("Error checking user role:", error);
    });
});
