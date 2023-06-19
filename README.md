# Thème WBM

### Prérequis
Node 14.17.1 (10.13.0)

### Installation
  * **Wordpress**
    * Base de données (BDD) :
      * Créer votre BDD
      * Récupérer un dump, et insérer le dans la BDD
    * Dans ```wp-config.php```
        * Rajouter votre domaine dans le switch
        * Mettre le chemin vers votre config ```config/xxxx/xxxx```
    * Créer ensuite votre config, en prenant comme example ```_sample_config.php```
    * ```npm i```
    * ```npm run watch ```
