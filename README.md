# 📕 ATTACHE-NOUNOU 📕

Cahier de liaison entre les parents et l'ATSEM 
* Docker -- Symfony 5.1 -- PHP 7.4 

## 🚀 Pré-requis 🚀 ##
 * Docker 3.3
 * PHP 7.4
 * composer
####

 ## ❗ Setup Projet ❗

* git clone https://github.com/anais0210/attache-nounou.git
* cp .env.dist
* customize .env
* docker exec -it attache-nounou bash
* composer install
* 'sortir du bash'
* make start
* make database-create
* make database-update
* make load-fixtures
 
####

 ## 🆒 Test et qualité 🆒
 * make quality
  -> PHPCS / PHPCBF / PHPSTAN / PHPPSALM
####

 ## 👪 👪 Load Fixtures 👪 👪
 * make fixtures
####

 ## 🐳 Logs Docker 🐳
 * make docker-logs
####

## 📚 Générer le Swagger 📚
* make swagger
####