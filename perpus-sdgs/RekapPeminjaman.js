document.addEventListener("DOMContentLoaded", function () {
    fetch("RekapPeminjaman.php")
        .then(response => response.text())
        .then(data => {
            // Memastikan jika tidak ada data peminjaman
            if (data.includes("Belum ada data peminjaman")) {
                window.location.href = 'DaftarBukuUser.html'; // Arahkan ke DaftarBukuUser.html langsung
            } else {
                document.getElementById("rekap-container").innerHTML = data;
                pasangEventTombolKembali();
            }
        })
        .catch(error => {
            document.getElementById("rekap-container").innerHTML = "Gagal memuat data rekap.";
            console.error("Error:", error);
        });
});

function pasangEventTombolKembali() {
    // Mengambil semua tombol dengan kelas 'btn-kembali'
    document.querySelectorAll(".btn-kembali").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const book_id = this.getAttribute("data-book-id");

            // Mengirimkan data pengembalian ke server menggunakan fetch POST
            fetch("RekapPeminjaman.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + encodeURIComponent(id) + "&book_id=" + encodeURIComponent(book_id)
            })
            .then(response => response.text())
            .then(msg => {
                alert(msg); // Menampilkan pesan setelah pengembalian berhasil
                // Mengarahkan kembali ke halaman RekapPeminjaman.html
                window.location.href = "RekapPeminjaman.html";
            })
            .catch(error => {
                console.error("Error saat mengembalikan buku:", error);
                alert("Terjadi kesalahan. Coba lagi.");
            });
        });
    });
}
