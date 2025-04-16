document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
  
    if (!id) {
      alert("ID buku tidak ditemukan!");
      return;
    }
  
    document.getElementById("id").value = id;
  
    fetch("EditBuku.php?id=" + id)
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
          return;
        }
  
        document.getElementById("judul").value = data.title;
        document.getElementById("penulis").value = data.author;
        document.getElementById("tahun").value = data.year;
        document.getElementById("isbn").value = data.isbn;
        document.getElementById("kategori").value = data.category;
        document.getElementById("stock").value = data.stock;
      })
      .catch(error => {
        console.error("Gagal fetch data buku:", error);
      });
  });
  
  function hapusBuku() {
    const id = document.getElementById("id").value;
    if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
      fetch("EditBuku.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `hapus=1&id=${id}`
      })
      .then(res => res.text())
      .then(response => {
        alert(response);
        if (response.includes("Berhasil")) {
          window.location.href = "DaftarBukuUser.html";
        }
      })
      .catch(err => {
        console.error("Gagal menghapus buku:", err);
        alert("Gagal menghapus buku!");
      });
    }
  }
  