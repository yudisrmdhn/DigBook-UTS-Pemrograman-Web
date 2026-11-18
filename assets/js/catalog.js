
// ========================================
// DIGBOOK - CATALOG JAVASCRIPT
// ========================================

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('bookSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const bookCards = document.querySelectorAll('.book-card');
    const emptyMessage = document.getElementById('emptyMessage');

    // Pastikan elemen katalog tersedia
    if (!searchInput || !categoryFilter || bookCards.length === 0) {
        return;
    }

    // Fungsi pencarian dan filter buku
    function filterBooks() {

        const searchValue = searchInput.value
            .toLowerCase()
            .trim();

        const selectedCategory = categoryFilter.value;

        let visibleBooks = 0;

        bookCards.forEach(function (card) {

            const title = card.dataset.title || '';
            const author = card.dataset.author || '';
            const category = card.dataset.category || '';

            // Periksa kecocokan judul atau penulis
            const matchesSearch =
                title.includes(searchValue) ||
                author.includes(searchValue);

            // Periksa kategori yang dipilih
            const matchesCategory =
                selectedCategory === 'all' ||
                category === selectedCategory;

            // Tampilkan atau sembunyikan kartu buku
            if (matchesSearch && matchesCategory) {

                card.style.display = '';
                visibleBooks++;

            } else {

                card.style.display = 'none';

            }

        });

        // Tampilkan pesan jika buku tidak ditemukan
        if (emptyMessage) {
            emptyMessage.hidden = visibleBooks !== 0;
        }

    }

    // Jalankan pencarian ketika pengguna mengetik
    searchInput.addEventListener('input', filterBooks);

    // Jalankan filter ketika kategori berubah
    categoryFilter.addEventListener('change', filterBooks);

});
