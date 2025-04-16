document.addEventListener("DOMContentLoaded", function () {
    fetch("RekapPeminjaman.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("rekap-container").innerHTML = data;
            pasangEventTombolKembali();
        })
        .catch(error => {
            document.getElementById("rekap-container").innerHTML = "Gagal memuat data rekap.";
            console.error("Error:", error);
        });
});

function pasangEventTombolKembali() {
    document.querySelectorAll(".btn-kembali").forEach(button => {
        button.addEventListener("click", function () {
            const borrowId = this.getAttribute("data-id");
            const bookId = this.getAttribute("data-book-id");

            fetch("ProsesPengembalian.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "borrow_id=" + encodeURIComponent(borrowId) + "&book_id=" + encodeURIComponent(bookId)
            })
            .then(response => response.text())
            .then(result => {
                alert(result);
                location.reload();
            })
            .catch(error => {
                console.error("Gagal proses pengembalian:", error);
            });
        });
    });
}
