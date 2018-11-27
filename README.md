# SilverStripe Custom Filesystem

Version of the local filesystem that allows setting of a custom location (other then assets)
via env/config variables

## Installation

```bash
composer require i-lateral/silverstripe-custom-filesystem
```

**NOTE** Once installed, this module will automatically replace the default FlySystem adapters with the custom ones provided by this module.

## Configuration

Once you have installed the module, you can change the assets location by using the following SilverStripe config variable:

    SilverStripe\Assets\Flysystem\AssetAdapter.asset_path

For example, you can add the following to your config.yml:

```YML
---
Name: myconfig
---
SilverStripe\Assets\Flysystem\AssetAdapter:
  asset_path: 'customassetsfolder'
```
