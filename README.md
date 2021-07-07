#Installation

Run Following Command via terminal
-----------------------------------
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy

Flush the cache and reindex all.

now module is properly installed

#User Guide

Schedule a cron for everyday and data will uploaded to database from given api.

run php bin/magento cron:run --group="default"



