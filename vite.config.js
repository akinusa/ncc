import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig({
  build: {
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'index.html'),
        about: resolve(__dirname, 'about.html'),
        activities: resolve(__dirname, 'activities.html'),
        gallery: resolve(__dirname, 'gallery.html'),
        enrollment: resolve(__dirname, 'enrollment.html'),
        news: resolve(__dirname, 'news.html'),
        contact: resolve(__dirname, 'contact.html'),
      },
    },
  },
})
