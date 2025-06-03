import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel([
      'resources/css/app.css',
      'resources/js/app.js',
    ]),
  ],
  preview: {
    allowedHosts: ['laravel-backend-4.onrender.com'],
  },
});
