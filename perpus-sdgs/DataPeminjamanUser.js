document.addEventListener("DOMContentLoaded", function () {
    // Ambil role pengguna dan tampilkan menu sesuai role
    fetch("CekRole.php")
        .then(response => response.text())
        .then(role => {
            const navList = document.querySelector("nav ul");

            if (role === "admin") {
                const liTambah = document.createElement("li");
                const linkTambah = document.createElement("a");
                linkTambah.href = "TambahBuku.html";
                linkTambah.textContent = "Tambah Buku";
                liTambah.appendChild(linkTambah);
                navList.appendChild(liTambah);

                const liRekap = document.createElement("li");
                const linkRekap = document.createElement("a");
                linkRekap.href = "RekapPeminjaman.html";
                linkRekap.textContent = "Rekap";
                liRekap.appendChild(linkRekap);
                navList.appendChild(liRekap);
            } else if (role === "anggota") {
                // Memuat data peminjaman buku untuk anggota
                fetch("DataPeminjamanUser.php")
                    .then(response => response.json())
                    .then(books => {
                        const table = document.createElement("table");
                        table.border = 1;

                        const headerRow = document.createElement("tr");
                        headerRow.innerHTML = "<th>ID</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th>";
                        table.appendChild(headerRow);

                        if (books.length > 0) {
                            books.forEach(book => {
                                const row = document.createElement("tr");
                                row.innerHTML = `<td>${book.borrowing_id}</td>
                                                 <td>${book.title}</td>
                                                 <td>${book.borrow_date}</td>
                                                 <td>${book.return_date}</td>
                                                 <td>${book.status}</td>`;
                                table.appendChild(row);
                            });
                        } else {
                            const row = document.createElement("tr");
                            row.innerHTML = "<td colspan='5'>Belum ada peminjaman.</td>";
                            table.appendChild(row);
                        }

                        document.getElementById("book-table").appendChild(table);

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

                        document.getElementById("book-table").appendChild(backButton);
                    })
                    .catch(error => {
                        console.error("Error fetching borrowings:", error);
                        document.getElementById("book-table").innerHTML = "Gagal memuat data peminjaman.";
                    });
            }
        })
        .catch(error => {
            console.error("Error checking user role:", error);
        });
});
