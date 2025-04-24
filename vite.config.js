import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    server: {
        host: "0.0.0.0", // Agar Vite dapat diakses oleh device lain
        port: 5173, // Atur port sesuai konfigurasi
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    build: {
        minify: "esbuild", // Gunakan Esbuild (lebih cepat dari Terser)
        terserOptions: {
            compress: {
                drop_console: true, // Hapus console.log untuk produksi
                drop_debugger: true,
            },
        },
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes("node_modules")) {
                        return "vendor"; // Pisahkan library ke vendor.js
                    }
                },
            },
        },
    },
});
