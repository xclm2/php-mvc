<?php
namespace App\Theme;

use App\Framework\Facade\Assets;

class Main
{
    /**
     * Loads the assets for the theme.
     *
     * @return void
     */
    public function loadAssets()
    {
        $assets = new Assets('xcl');
        $assets->load();
    }
}