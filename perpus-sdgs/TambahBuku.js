document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
  
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // Mencegah reload halaman
  
      const formData = new FormData(form);
  
      fetch('TambahBuku.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.message) {
            alert(data.message);
            form.reset(); // Kosongkan form setelah berhasil
          } else if (data.error) {
            alert('Error: ' + data.error);
          }
        })
        .catch(error => {
          console.error('Terjadi kesalahan:', error);
          alert('Terjadi kesalahan saat menambahkan buku.');
        });
    });
  });
  