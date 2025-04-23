// app.js
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('theme', () => ({
    isDark: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    init() {
        this.applyTheme();
    },
    toggle() {
        this.isDark = !this.isDark;
        this.applyTheme();
    },
    applyTheme() {
        document.documentElement.setAttribute('data-theme', this.isDark ? 'dark' : 'light');
        localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
    }
}));
module.exports = {
    theme: {
        extend: {
            colors: {
                'aws-navy': '#232f3e',
                'aws-dark-navy': '#121a2b',
                'aws-orange': '#ff9900',
                'aws-border': '#3a4553',
                'aws-gray': '#374151',
            },
        },
    },
    plugins: [],
}

Alpine.start();
