import { defineConfig } from "vite";
import typo3 from "vite-plugin-typo3";
import vue from "@vitejs/plugin-vue"

export default defineConfig({
    plugins: [vue(), typo3()],
    build: {
        outDir: "Public/Dist",
        emptyOutDir: true,
    },
});