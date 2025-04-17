document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const categorySelect = document.getElementById("category-filter");
  
    function fetchFilteredBooks() {
      const keyword = searchInput.value.trim();
      const kategori = categorySelect.value;
  
      fetch(`Pencarian.php?keyword=${encodeURIComponent(keyword)}&kategori=${encodeURIComponent(kategori)}`)
        .then(response => response.text())
        .then(data => {
          document.getElementById("book-table").innerHTML = data;
        })
        .catch(error => {
          document.getElementById("book-table").innerHTML = "Terjadi kesalahan saat memuat data.";
          console.error(error);
        });
    }
  
    searchInput.addEventListener("input", fetchFilteredBooks);
    categorySelect.addEventListener("change", fetchFilteredBooks);
  
    // Panggil pertama kali
    fetchFilteredBooks();
  });
  