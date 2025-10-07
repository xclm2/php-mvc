import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
  plugins: [react()],
  server: {
    host: "xmvc.local",
    port: 5173,
    cors: true, 
    origin: "http://xmvc.local:5173", 
    watch: {
      usePolling: true
    },
    hmr: { host: "xmvc.local" }
  },
  build: {
    outDir: "public/dist",
    emptyOutDir: true,
    manifest: "manifest.json",
    rollupOptions: {
        input: [
            "resources/view/App.jsx",
            "resources/theme/xcl/scss/main.scss"
        ]
    }
  }
});
