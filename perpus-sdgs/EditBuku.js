document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");

  if (!id) {
    alert("ID buku tidak ditemukan!");
    return;
  }

  // Ambil data buku dan isi ke form
  fetch("EditBuku.php?id=" + id)
    .then(response => {
      if (!response.ok) {
        throw new Error("Gagal mengambil data buku.");
      }
      return response.json();
    })
    .then(data => {
      if (data.error) {
        alert(data.error);
        return;
      }

      document.getElementById("id").value = id;
      document.getElementById("judul").value = data.title;
      document.getElementById("penulis").value = data.author;
      document.getElementById("tahun").value = data.year;
      document.getElementById("isbn").value = data.isbn;
      document.getElementById("kategori").value = data.category;
      document.getElementById("stock").value = data.stock;
    })
    .catch(error => {
      console.error("Gagal fetch data buku:", error);
      alert("Gagal mengambil data buku. Silakan coba lagi.");
    });

  // Hapus
  const hapusBtn = document.getElementById("hapus");

  if (hapusBtn) {
    hapusBtn.addEventListener("click", function () {
      if (!confirm("Yakin ingin menghapus buku ini?")) return;

      
      fetch("EditBuku.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `hapus=1&id=${id}`
      })
        .then(res => res.text())
        .then(response => {
          if (response.includes("Berhasil")) {
            alert("Buku berhasil dihapus.");
            window.location.href = "DaftarBukuUser.html"; // Arahkan kembali ke daftar buku
          } else {
            alert("Gagal menghapus buku: " + response);
          }
        })
        .catch(err => {
          console.error("Gagal menghapus buku:", err);
          alert("Gagal menghapus buku!");
        });
    });
  } else {
    console.error("Tombol hapus tidak ditemukan!");
  }

  // Tangani update saat form disubmit
  const form = document.getElementById("editForm");
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(form);
    formData.append("submit", "1");

    fetch("EditBuku.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.text())
      .then(response => {
        alert("Buku berhasil diperbarui!");
        window.location.href = "DaftarBukuUser.html";
      })
      .catch(err => {
        console.error("Gagal update:", err);
        alert("Gagal update buku!");
      });
  });
});
