# SYMFONY

## COMPOSER

- aller sur Getcomposer.org, lien "download" sur la page d'accueil
- Windows : télécharger l'exécutable et le lancer
- Mac : ouvrir un terminal et suivre les instructions
- pas besoin de réinstaller à chaque nouveau projet Symfony

## NOUVEAU PROJET SYMFONY

- dans un nouveau terminal :
```
composer create-project symfony/website-skeleton project_name
```

## GIT

- créer un dépôt distant sur GitHub
- dans un nouveau terminal :
```
git init
```
```
git remote add origin https://github.com/GitHub_user/repository_name.git
```
```
git add *
```
```
git commit -m "commit_name"
```
```
git pull origin master
```
```
git push origin master
```
- voir la liste des commits (flèche du bas pour naviguer, q pour quitter) :
```
git log
```

## RÉCUPÉRER UN PROJET

- créer un nouveau dossier dans www (ou htdocs)
- ouvrir un terminal puis accéder au dossier :
```
cd le_chemin_du_dossier_créé
```
```
git init
```
```
git remote add origin le_lien_du_depot_github
```
```
git pull origin master
```
- créer un nouveau fichier .env dans le dossier créé
- regénérer les dossiers var et vendor :
```
composer update
```

## APACHE-PACK

- barre de débug / routing / .htaccess
- dans le terminal :
```
composer require symfony/apache-pack
```

## CONTROLLER

- créer un contrôleur :
```
php bin/console make:controller
```

## BASE DE DONNÉES

- .env, ligne 31 : (dépend du serveur utilisé : WAMP, MAMP, XAMPP)
```
DATABASE_URL="mysql://root@127.0.0.1:3306/immobilier?serverVersion=5.7"
```
- créer la base de données :
```
php bin/console doctrine:database:create
```
- créer une entité (table) :
```
php bin/console make:entity
```
- migration (vérifier le fichier de version généré avant la deuxième commande) :
```
php bin/console make:migration
```
```
php bin/console doctrine:migrations:migrate
```

## FIXTURES

- installer le bundle :
```
composer require --dev orm-fixtures
```
- compléter le fichier src/DataFixtures/AppFixtures.php
- persist()
- flush()
- envoyer en bdd (en écrasant) :
```
php bin/console doctrine:fixtures:load
```
- envoyer en bdd (en ajoutant à la suite) :
```
php bin/console doctrine:fixtures:load --append
```
- utiliser un générateur de données :
```
composer require fakerphp/faker
```

## FORMULAIRE

- créer un nouveau formulaire :
```
php bin/console make:form
```
- ajouter un bouton de validation du formaulaire (dans le Form) :
```
->add('valider', SubmitType::class)
```

## LOGIN

- créer l'entité User :
```
php bin/console make:user
```
- migration
- créer "l'authentification" :
```
php bin/console make:auth
```
- 1
- Authenticator
- SecurityController
- yes
- dans config/packages/security.yaml, décommenter :
```
- { path: ^/admin, roles: ROLE_ADMIN }
```

## REGISTER

- créer le formulaire d'inscription :
```
php bin/console make:registration-form
```
- rediriger vers accueil quand on se connecte (src/Security/Authenticator.php, vers ligne 100) :
```
return new RedirectResponse($this->urlGenerator->generate('home'));
```
- installer rollerworks :
```
composer require rollerworks/password-strength-bundle
```
- src/Form/RegistrationFormType.php :
```
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;
```
```
new PasswordStrength();
```
- y ajouter les contraintes souhaitées (minLength, minStrength, messages...)

## ROUTER DEBUG

- voir toutes les routes :
```
php bin/console debug:router
```
- vérifier si une route existe (et obtenir ses infos) :
```
php bin/console router:match /le_chemin_de_la_route
```

## VARIABLES GLOBALES

- config/packages/twig.yaml :
```
twig:
    ...
    globals:
        copyright: '%app.copyright%'
```
- config/setvices.yaml :
```
parameters:
    ...
    app.copyright: 'Copyright &copy; 2021 - David HURTREL'
```
- templates :
```
{{ copyright|raw }}
```

## DROITS - RÔLES

- config/packages/security.yaml :
```
access_control:
    - { path: ^/admin/user, roles: ROLE_SUPER_ADMIN }
    ...
role_hierarchy:
    ROLE_ADMIN: ROLE_USER
    ROLE_SUPER_ADMIN: ROLE_ADMIN
```

## MESSAGES FLASH

- dans le controller :
```
$this->addFlash(
    'success',
    'La maison a bien été modifiée'
);
```
- où on veut afficher les messages :
```
{% for label, messages in app.flashes(['success', 'danger']) %}
    {% for message in messages %}
        <div class="flash-{{ label }}">
            {{ message }}
        </div>
    {% endfor %}
{% endfor %}
```

## EMAILS

- installer SwiftMailer :
```
composer require symfony/swiftmailer-bundle
```
- .env :
```
MAILER_URL=gmail://username:password@localhost
```
- créer le formaulaire de contact :
```
php bin/console make:form
```
- créer le controller associé
- afficher le formulaire dans une page / vue