<?php

namespace ilateral\SilverStripe\CustomFilesystem;

use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Environment;
use SilverStripe\Assets\Flysystem\ProtectedAssetAdapter as AssetAdapter;

/**
 * Overwrite default filesystem to allow setting of custom paths
 */
class ProtectedAssetAdapter extends AssetAdapter
{

    protected function findRoot($root)
    {
        // Use explicitly defined path
        if ($root) {
            return parent::findRoot($root);
        }

        // Use environment defined path or default location is under assets
        if ($path = Environment::getEnv('SS_PROTECTED_ASSETS_PATH')) {
            return $path;
        }

        return Controller::join_links(
            BASE_PATH,
            (PUBLIC_DIR ? PUBLIC_DIR : null),
            $this->config()->asset_path,
            Config::inst()->get(__CLASS__, 'secure_folder')
        );
    }

    /**
     * Provide secure downloadable
     *
     * @param string $path
     * @return string|null
     */
    public function getProtectedUrl($path)
    {
        // Public URLs are handled via a request handler within /assets.
        // If assets are stored locally, then asset paths of protected files should be equivalent.
        return Controller::join_links(
            Director::baseURL(),
            $this->config()->asset_path,
            $path
        );
    }
}
