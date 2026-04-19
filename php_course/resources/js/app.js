import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';

    if (themeIcon) themeIcon.innerText = currentTheme === 'dark' ? '☀️' : '🌙';

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const newTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            if (themeIcon) themeIcon.innerText = newTheme === 'dark' ? '☀️' : '🌙';
        })
    }

    const searchInput = document.getElementById('article-search');
    if (searchInput) {
        searchInput.addEventListener('input', (event) => {
            const query = event.target.value.toLowerCase();
            const articles = document.querySelectorAll('.article-card');
            articles.forEach(article => {
                const articleTitle = article.querySelector('.card-title')?.innerText.toLowerCase() || '';
                const articleText = article.querySelector('.card-text')?.innerText.toLowerCase() || '';

                const articleWrap = article.closest('.col-md-4');

                if (articleWrap) {
                    articleWrap.style.display = (articleTitle.includes(query) || articleText.includes(query)) ? 'block' : 'none';
                }
            });
        });
    }

    const backToTopButton = document.getElementById('btn-back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
    }

    const articleContent = document.getElementById('article-content');
    const charCounter = document.getElementById('char-counter');

    if (articleContent && charCounter) {
        const updateCharCounter = () => {
            let length = articleContent.value.length;
            charCounter.innerText = length;
            if (length >= 1000) {
                charCounter.classList.add('text-danger');
            } else {
                charCounter.classList.remove('text-danger');
            }
        }

        articleContent.addEventListener('input', updateCharCounter);
        updateCharCounter();
    }

    // alert message
    const deleteForms = document.querySelectorAll('form[data-confirm-message]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const message = form.getAttribute('data-confirm-message') || 'Вы точно хотите удалить?';
            if (confirm(message)) {
                form.submit();
            }
        });
    });

    // tooltip call
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // bootstrap alert hide
    const alertsToHide = document.querySelectorAll('.alert-dismissible');
    alertsToHide.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
