document.addEventListener("DOMContentLoaded", function () {
    fetch("RekapPeminjaman.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("rekap-container").innerHTML = data;

            // Cek apakah data kosong atau mengandung pesan 'Belum ada data peminjaman'
            if (data.includes('Belum ada data peminjaman') || !data.trim()) {
                // Jika kosong, arahkan ke halaman DaftarBukuUser.html
                setTimeout(function() {
                    window.location.href = 'DaftarBukuUser.html';
                }, 2000); // Tunggu 2 detik sebelum pindah
            } else {
                pasangEventTombolKembali(); // Pasang event tombol kembali jika data ada
            }
        })
        .catch(error => {
            document.getElementById("rekap-container").innerHTML = "Gagal memuat data rekap.";
            console.error("Error:", error);
        });
});

function pasangEventTombolKembali() {
    document.querySelectorAll(".btn-kembali").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const book_id = this.getAttribute("data-book-id");

            fetch("RekapPeminjaman.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + encodeURIComponent(id) + "&book_id=" + encodeURIComponent(book_id)
            })
            .then(response => response.text())
            .then(msg => {
                alert(msg);
                window.location.href = "RekapPeminjaman.html"; // Arahkan kembali ke halaman rekap
            });
        });
    });
}
