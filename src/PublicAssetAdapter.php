<?php

namespace ilateral\SilverStripe\CustomFilesystem;

use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\Convert;
use SilverStripe\Assets\Flysystem\PublicAssetAdapter as AssetAdapter;

/**
 * Overwrite default filesystem to allow setting of custom paths
 */
class PublicAssetAdapter extends AssetAdapter
{

    protected function findRoot($root)
    {
        if ($root) {
            $path = parent::findRoot($root);
        } else {
            $path = Controller::join_links(
                BASE_PATH,
                (PUBLIC_DIR ? PUBLIC_DIR : null),
                $this->config()->asset_path
            );
        }

        // Assign prefix based on path
        $this->initParentURLPrefix($path);

        return $path;
    }


    /**
     * Initialise parent URL prefix
     *
     * @param string $path base path
     */
    protected function initParentURLPrefix($path)
    {
        // Detect segment between web root directory and assets root
        $path = Convert::slashes($path, '/');
        $basePath = Convert::slashes(Director::publicFolder(), '/');
        if (stripos($path, $basePath) === 0) {
            $prefix = substr($path, strlen($basePath));
        } else {
            $prefix = $this->config()->asset_path;
        }
        $this->parentUrlPrefix = ltrim($prefix, '/');
    }
}
