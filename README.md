Clone project, go to the cloned folder, then run the commands and follow hints in round brackets:

1. `composer install` (follow the instructions to configure application for you system configuration, 
pay attention on parameters)
2. `php bin/console doctrine:database:create`
3. `php bin/console doctrine:schema:update --force`
4. `php bin/console doctrine:fixtures:load` (type `y` end press enter)
5. `sudo bash deploy.sh`
6. `php bin/console server:run`
7. And go to 127.0.0.1:8000 or  in browser
