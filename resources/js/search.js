document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const genreSelect = document.getElementById('genre');
    const sortSelect = document.getElementById('sort');
    const resultsContainer = document.querySelector('.search-results');
    
    if (!searchForm) return;
    
    // Debounce function to limit how often the search runs
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }
    
    // Handle form submission
    function handleSearch(event) {
        if (event) {
            event.preventDefault();
        }
        
        const formData = new FormData(searchForm);
        const searchParams = new URLSearchParams(formData);
        
        // Update URL without page reload
        const newUrl = `${window.location.pathname}?${searchParams.toString()}`;
        window.history.pushState({ path: newUrl }, '', newUrl);
        
        // Show loading state
        if (resultsContainer) {
            resultsContainer.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
                </div>
            `;
        }
        
        // Make AJAX request
        fetch(`${window.location.pathname}?${searchParams.toString()}&ajax=1`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (resultsContainer) {
                resultsContainer.innerHTML = data.html;
                
                // Update pagination links
                const paginationContainer = resultsContainer.querySelector('.pagination') || resultsContainer;
                const paginationLinks = paginationContainer.querySelectorAll('a');
                
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(this.href);
                        const searchParams = new URLSearchParams(url.search);
                        searchParams.set('ajax', '1');
                        
                        // Update form values from URL
                        if (searchParams.has('search')) {
                            searchInput.value = searchParams.get('search');
                        }
                        if (searchParams.has('status')) {
                            statusSelect.value = searchParams.get('status');
                        }
                        if (searchParams.has('genre')) {
                            genreSelect.value = searchParams.get('genre');
                        }
                        if (searchParams.has('sort')) {
                            sortSelect.value = searchParams.get('sort');
                        }
                        
                        // Update URL and make new request
                        window.history.pushState({}, '', url.pathname + '?' + searchParams.toString());
                        fetch(url.pathname + '?' + searchParams.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            resultsContainer.innerHTML = data.html;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        });
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (resultsContainer) {
                // Create main error container
                const errorContainer = document.createElement('div');
                errorContainer.className = 'text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow';
                
                // Create and append icon
                const icon = document.createElement('i');
                icon.className = 'fas fa-exclamation-triangle text-4xl text-red-500 mb-4';
                errorContainer.appendChild(icon);
                
                // Create and append heading
                const heading = document.createElement('h3');
                heading.className = 'text-lg font-medium text-gray-900 dark:text-white mb-1';
                heading.textContent = 'Ocorreu um erro';
                errorContainer.appendChild(heading);
                
                // Create and append error message
                const message = document.createElement('p');
                message.className = 'text-gray-500 dark:text-gray-400';
                message.textContent = 'Não foi possível carregar os resultados. Tente novamente.';
                errorContainer.appendChild(message);
                
                // Create and append reload button
                const reloadButton = document.createElement('button');
                reloadButton.className = 'mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors';
                reloadButton.textContent = 'Tentar novamente';
                reloadButton.addEventListener('click', () => window.location.reload());
                errorContainer.appendChild(reloadButton);
                
                // Clear previous content and append new error container
                resultsContainer.innerHTML = '';
                resultsContainer.appendChild(errorContainer);
            }
        });
    }
    
    // Add event listeners
    searchForm.addEventListener('submit', handleSearch);
    
    // Add debounced input event for search
    searchInput.addEventListener('input', debounce(handleSearch, 500));
    
    // Add change events for filters
    statusSelect.addEventListener('change', handleSearch);
    genreSelect.addEventListener('change', handleSearch);
    sortSelect.addEventListener('change', handleSearch);
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Update form values from URL
        searchInput.value = urlParams.get('search') || '';
        statusSelect.value = urlParams.get('status') || 'all';
        genreSelect.value = urlParams.get('genre') || 'all';
        sortSelect.value = urlParams.get('sort') || 'latest';
        
        // Trigger search
        handleSearch();
    });
});
