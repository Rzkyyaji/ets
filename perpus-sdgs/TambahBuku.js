document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formTambahBuku");
  
    form.addEventListener("submit", async function (e) {
      e.preventDefault();
  
      const formData = new FormData(form);
  
      try {
        const response = await fetch("TambahBuku.php", {
          method: "POST",
          body: formData,
        });
  
        const result = await response.text(); // bisa juga pakai .json() kalau kamu return JSON dari PHP
        alert(result);
        window.location.href = "DaftarBukuUser.html";
      } catch (error) {
        console.error("Gagal mengirim data:", error);
        alert("Terjadi kesalahan saat mengirim data.");
      }
    });
  });
  