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
  
          // Tambah tombol "Tambah Buku"
          const liTambah = document.createElement("li");
          const linkTambah = document.createElement("a");
          linkTambah.href = "TambahBuku.html";
          linkTambah.textContent = "Tambah Buku";
          liTambah.appendChild(linkTambah);
          navList.appendChild(liTambah);
  
          // Tambah tombol "Rekap"
          const liRekap = document.createElement("li");
          const linkRekap = document.createElement("a");
          linkRekap.href = "RekapPeminjaman.html";
          linkRekap.textContent = "Rekap";
          liRekap.appendChild(linkRekap);
          navList.appendChild(liRekap);
        }
      });
  });
  