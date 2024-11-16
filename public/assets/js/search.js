document.addEventListener('DOMContentLoaded', function ()
{
    // Get DOM elements
    const searchBar = document.getElementById('searchBar');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout = null;

    // Function to perform search
    function performSearch(searchTerm)
    {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/5ewd/GAMERSWORLD/public/search-products?searchBar=' + encodeURIComponent(searchTerm), true);

        searchResults.innerHTML = '<div class="search-result-item">Searching...</div>';
        searchResults.style.display = 'block';

        xhr.onload = function ()
        {
            if (xhr.status === 200)
            {
                searchResults.innerHTML = xhr.responseText;
            } else
            {
                searchResults.innerHTML = '<div class="search-result-item">Error performing search</div>';
            }
        };

        xhr.onerror = function ()
        {
            searchResults.innerHTML = '<div class="search-result-item">Error performing search</div>';
        };

        xhr.send();
    }

    // Add input event listener
    if (searchBar)
    {
        searchBar.addEventListener('input', function ()
        {
            clearTimeout(searchTimeout);

            const term = this.value.trim();
            if (term.length > 0)
            {
                searchTimeout = setTimeout(function ()
                {
                    performSearch(term);
                }, 300);
            } else
            {
                searchResults.innerHTML = '';
                searchResults.style.display = 'none';
            }
        });
    }

    // Close results when clicking outside
    document.addEventListener('click', function (evt)
    {
        if (searchResults && !searchBar.contains(evt.target))
        {
            searchResults.style.display = 'none';
        }
    });
});