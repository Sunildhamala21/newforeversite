import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/cart.js',
        'resources/js/home.js',
        'resources/js/trip-details.js',
        'resources/js/admin/admin.js',
        'resources/js/admin/editor.js',
        'resources/js/admin/select.js',
      ],
      refresh: true,
    }),
    tailwindcss()
  ],
});
