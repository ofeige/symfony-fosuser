#Base Project with Admin Area and FOS UserBundle

##Installation

```
composer install
bin/console doctrine:create:database
bin/console doctrine:schema:update
bin/console doctrine:fixtures:load
bin/console assetic:dump
```

