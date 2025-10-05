<?php
declare(strict_types=1);

namespace App\Framework\Facade;
use App\Logger;

final class Assets
{
    const string MANIFEST = __ROOT__ . '/public/dist/manifest.json';
    const string THEME = 'xcl';
    
    protected string $_viteServer;

    /**
     * Constructor to initialize the Assets class with theme and entry point.
     *
     * @param string $theme The theme name (default is 'xcl')
     * @param string $entry The entry point for the application (default is '/resources/view/app.jsx')
     */
    public function __construct(protected string $theme 
        {
            set(string $theme) {
                $this->theme = "resources/theme/$theme/scss/main.scss";
            }
        },
        protected string $entry = '/resources/view/app.jsx'
    ) {
        $this->_viteServer = 'http://' . env('VITE_HOST', 'localhost') . ':' . env('VITE_PORT', '5173');
    }

    /**
     * Loads the assets based on the environment (development or production)
     * In development, it loads from the Vite dev server.
     * In production, it reads from the manifest file and includes the necessary CSS and JS files.
     */
    public function load()
    {
        if (env('VITE_DEV')) {
            // Dev mode: load from Vite dev server
            echo $this->_script($this->_viteServer . '/@vite/client') . PHP_EOL;
            echo $this->_script($this->_viteServer . $this->entry) . PHP_EOL;
            return;
        }

        // Production mode: load from manifest
        foreach ($this->_readManifest() as $realPath => $src) {
            if (str_ends_with($src['file'], '.css')) {
                echo $this->_link($realPath, asset('dist/' . $src['file'])) . PHP_EOL;
            } else if (str_ends_with($src['src'], '.jsx')) {
                echo $this->_script(asset('dist/' . $src['file'])) . PHP_EOL;
            } else if (str_ends_with($src['src'], '.js')) {
                echo $this->_script(asset('dist/' . $src['file']), false) . PHP_EOL;
            }
        }
    }

    /**
     * Reads and decodes the Vite manifest file
     *
     * @return array The decoded manifest data
     */
    private function _readManifest(): array
    {
        if (! file_exists(self::MANIFEST)) {
            Logger::warning("Assets manifest file not found: " . self::MANIFEST);
            return [];
        }

        $contents =  file_get_contents(self::MANIFEST, true);
        return json_decode($contents, true);
    }

    /**
     * Returns the HTML link tag for the given stylesheet if the realpath matches the theme
     *
     * @param string $realpath
     * @param string $src
     * @return string
     */
    private function _link(string $realpath, string $src): string
    {
        if ($realpath != $this->theme) {
            return '';
        }

        return '<link rel="stylesheet" href="' . $src . '">';
    }

    /**
     * Returns the HTML script tag for the given script source
     *
     * @param string $src
     * @param bool $isModule
     * @return string
     */
    private function _script(string $src, bool $isModule = true): string
    {
        return '<script type="' . ($isModule ? 'module' : 'text/javascript') . '" src="' . $src . '"></script>';
    }
}