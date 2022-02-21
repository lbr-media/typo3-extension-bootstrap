# typo3 extension: bootstrap

Typo3 template extension with twitter bootstrap package.

## Install

Create a fresh typo composer project...

### 1. create `composer.json`

``` JSON
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/lbr-media/typo3-extension-bootstrap.git"
        }
    ],
    "require": {
        "typo3/cms-adminpanel": "^11.5",
        "typo3/cms-backend": "^11.5",
        "typo3/cms-belog": "^11.5",
        "typo3/cms-beuser": "^11.5",
        "typo3/cms-core": "^11.5",
        "typo3/cms-dashboard": "^11.5",
        "typo3/cms-extbase": "^11.5",
        "typo3/cms-extensionmanager": "^11.5",
        "typo3/cms-filelist": "^11.5",
        "typo3/cms-fluid": "^11.5",
        "typo3/cms-fluid-styled-content": "^11.5",
        "typo3/cms-frontend": "^11.5",
        "typo3/cms-impexp": "^11.5",
        "typo3/cms-info": "^11.5",
        "typo3/cms-install": "^11.5",
        "typo3/cms-lowlevel": "^11.5",
        "typo3/cms-opendocs": "^11.5",
        "typo3/cms-recordlist": "^11.5",
        "typo3/cms-recycler": "^11.5",
        "typo3/cms-redirects": "^11.5",
        "typo3/cms-reports": "^11.5",
        "typo3/cms-rte-ckeditor": "^11.5",
        "typo3/cms-scheduler": "^11.5",
        "typo3/cms-seo": "^11.5",
        "typo3/cms-setup": "^11.5",
        "typo3/cms-tstemplate": "^11.5",
        "typo3/cms-viewpage": "^11.5",
        "typo3/cms-sys-note": "^11.5",
        "helhum/typo3-console": "^7",
        "lbr-media/typo3-extension-bootstrap": "dev-main"
    },
    "config": {
        "allow-plugins": {
            "typo3/cms-composer-installers": true,
            "typo3/class-alias-loader": true
        }
    },
    "scripts": {
        "post-install-cmd": "LBRmedia\\Bootstrap\\Command\\Composer::postInstallCmd",
        "post-update-cmd": "LBRmedia\\Bootstrap\\Command\\Composer::postUpdateCmd"
    }
}
```

### 2. run `composer install`

To download all packages.

### 3. run `composer install` again or run `composer update`

To run the composer scripts which creates `fileadmin/bootstrap` and copies some jquery and bootstrap files.  
The scripts are called only, when a `composer.lock` exists. That's the reason to call `composer install` maybe twice.
