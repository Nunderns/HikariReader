document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('search');
    const statusSelect = document.getElementById('status');
    const genreSelect = document.getElementById('genre');
    const sortSelect = document.getElementById('sort');
    const resultsContainer = document.querySelector('.search-results');
    
    if (!searchForm) return;
    
    /**
     * Returns a debounced version of the provided function that delays its execution until after a specified wait time has elapsed since the last invocation.
     * @param {Function} func - The function to debounce.
     * @param {number} wait - The number of milliseconds to delay.
     * @return {Function} A debounced function.
     */
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
    
    /**
     * Handles dynamic search form submission and filter changes, updating results via AJAX without reloading the page.
     *
     * Prevents default form submission, serializes form data into URL parameters, updates the browser URL, displays a loading indicator, and fetches updated results asynchronously. Also manages pagination link clicks within the results, synchronizing form state and URL, and ensures smooth scrolling to the top after loading new results. Displays an error message if the AJAX request fails.
     * @param {Event} [event] - The event object from form submission or input/filter change.
     */
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
                resultsContainer.innerHTML = `
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Ocorreu um erro</h3>
                        <p class="text-gray-500 dark:text-gray-400">Não foi possível carregar os resultados. Tente novamente.</p>
                    </div>
                `;
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
