document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("filterInput")?.addEventListener("keyup", function () {
      const filter = this.value.toLowerCase();
      document.querySelectorAll("#bukuTable tr").forEach(row => {
        const kategori = row.dataset.kategori.toLowerCase();
        row.style.display = kategori.includes(filter) ? "" : "none";
      });
    });
  });
  
  function konfirmasiHapus(id) {
    if (confirm("Yakin ingin menghapus buku ini?")) {
      window.location.href = "hapus.php?id=" + id;
    }
  }