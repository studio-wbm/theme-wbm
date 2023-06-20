# Thème WBM

###Description
* 🪄 SCSS : Compilation et minification dans un seul fichier CSS
* 🚀 JS : Compilation et minification dans un seul fichier JS
* ⚡ Hot reloading
* 🖼️ Images PNG et JPEG convertis automatiquement au format WEBP

### Prérequis
🛠️ Node ```18.15.0```

### Installation
  * **Wordpress**
    * Base de données (BDD) :
      * Créer votre BDD
      * Récupérer un dump, et insérer le dans la BDD
    * changer l'url dans le fichier ```gulpfile.js ```
      * ```browserSync.init({ proxy: "mon_url_localhost" });```
    *  Dans un terminal
        * ```npm i``` (Installation des modules node)
        * ```npx gulp``` (Démarrage du serveur)
