document.addEventListener('DOMContentLoaded', () => {
    const exploreBtn = document.querySelector('button');
    if (exploreBtn) {
        exploreBtn.addEventListener('click', () => {
            alert("Fitur eksplorasi koleksi belum tersedia. Silakan login terlebih dahulu.");
        });
    }
});
