document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-bottom-products');
    const categoryFilter = document.getElementById('category-filter');
    const categoryBlocks = document.querySelectorAll('.category-block');
    
    function filterProducts() {
        if (!searchInput || !categoryFilter) return;

        const filterText = searchInput.value.toLowerCase().trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        const selectedCategory = categoryFilter.value;
        
        categoryBlocks.forEach(block => {
            const blockId = block.id;
            const categoryMatches = (selectedCategory === 'all' || selectedCategory === blockId);
            
            let visibleProductsInBlock = 0;
            const products = block.querySelectorAll('.row .col');
            
            products.forEach(product => {
                const productNameElement = product.querySelector('h6');
                if (productNameElement) {
                    const productName = productNameElement.textContent.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    
                    if (productName.includes(filterText) && categoryMatches) {
                        product.classList.remove('d-none');
                        visibleProductsInBlock++;
                    } else {
                        product.classList.add('d-none');
                    }
                }
            });
            
            if (visibleProductsInBlock > 0) {
                block.classList.remove('d-none');
            } else {
                block.classList.add('d-none');
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterProducts);
    }
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterProducts);
    }
});