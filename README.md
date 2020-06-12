# 📕 ATTACHE-NOUNOU 📕

Cahier de liaison entre les parents et l'ATSEM 
* Docker -- Symfony 5.1 -- PHP 7.3 

## 🚀 Pré-requis 🚀 ##
 * Docker 3.3
 * PHP 7
 * composer
####

 ## ❗ Setup Projet ❗

* git clone https://github.com/anais0210/attache-nounou.git
* cp .env.dist
* customize .env
* make start
* make database-create
* make database-update
* make load-fixtures
 
####

 ## 🆒 Test et qualité 🆒
 * make quality
  -> PHPCS / PHPCBF / PHPSTAN / PHPPSALM
 * make behat
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