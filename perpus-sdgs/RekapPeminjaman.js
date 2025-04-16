document.addEventListener("DOMContentLoaded", function () {
    fetch("RekapPeminjaman.php")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("rekap-container");

            if (data.length === 0) {
                container.innerHTML = "<p>Belum ada data peminjaman.</p>";
                setTimeout(() => window.location.href = "DaftarBukuUser.html", 2000);
                return;
            }

            const table = document.createElement("table");
            table.border = "1";

            const header = document.createElement("tr");
            header.innerHTML = "<th>ID</th><th>Judul Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th>";
            table.appendChild(header);

            data.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.borrowing_id}</td>
                    <td>${item.title}</td>
                    <td>${item.borrow_date}</td>
                    <td>${item.return_date ? item.return_date : "-"}</td>
                    <td>${item.status}</td>
                    <td>
                        <!-- Tombol Kembalikan hanya muncul jika status bukan 'Dikembalikan' -->
                        ${item.status !== 'Dikembalikan' ? `<button class="btn-kembali" data-id="${item.borrowing_id}" data-book-id="${item.book_id}">Kembalikan</button>` : ''}
                    </td>
                `;
                table.appendChild(row);
            });

            container.innerHTML = '';
            container.appendChild(table);

            // Tambahkan tombol kembali ke beranda
            const backButton = document.createElement("a");
            backButton.href = "DaftarBukuUser.html";
            backButton.textContent = "← Kembali ke Beranda";
            backButton.style.display = "inline-block";
            backButton.style.marginTop = "20px";
            backButton.style.padding = "8px 12px";
            backButton.style.backgroundColor = "#4CAF50";
            backButton.style.color = "white";
            backButton.style.textDecoration = "none";
            backButton.style.borderRadius = "4px";

            container.appendChild(backButton);  // Menambahkan tombol kembali setelah tabel
            pasangEventTombolKembali();
        })
        .catch(error => {
            console.error("Gagal memuat data:", error);
            document.getElementById("rekap-container").innerHTML = "Gagal memuat data rekap.";
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
                body: `id=${encodeURIComponent(id)}&book_id=${encodeURIComponent(book_id)}`
            })
            .then(response => response.text())
            .then(msg => {
                alert(msg);
                window.location.reload();
            });
        });
    });
}
