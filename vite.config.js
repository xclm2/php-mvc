import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: "public/dist",
    emptyOutDir: true,
    manifest: "manifest.json",
    rollupOptions: {
        input: [
            "resources/view/app.jsx",
            "resources/theme/xcl/scss/main.scss"
        ]
    }
  }
});
