# TYPO3 TodoList Projekt

Dieses Projekt ist eine Beispiel-Anwendung zur Verwaltung von Aufgaben (Tasks) mit **TYPO3 v13**, **Vite** und **Vue 3**. Aufgaben können sowohl im TYPO3-Backend als auch im Frontend erstellt, bearbeitet und gelöscht werden. Die Kommunikation zwischen Vue und TYPO3 erfolgt über eine REST API mit [t3api].

# Schnellstart

- git clone https://github.com/kkroff/todolist todolist
- cd todolist
- ddev start
- ddev composer install
- ddev npm install
- ddev import-db --src=.ddev/todolist_db.sql.gz
- ddev vite (oder ddev ssh => npm run dev)

=> Frontend: https://todolist.ddev.site  
=> Backend: https://todolist.ddev.site/typo3 || Login:admin PW:ToDo%75e

# Technologien

- DDEV
- TYPO3 v13
- Vite, Vue 3, Axios
- REST API via [t3api](https://extensions.typo3.org/extension/t3api)
- Asset Management via [vite_asset_collector](https://extensions.typo3.org/extension/vite_asset_collector)
- Codequalität:
  - PHP: PHP-CS-Fixer, PHPStan
  - JS/SCSS: ESLint, Prettier, Stylelint
  - Testing: Vitest (unit tests)

# Features im Frontend

- Aufgaben anzeigen (offene und erledigte)
- Neue Aufgaben erstellen (Titel ist Pflicht, Beschreibung und Fälligkeitsdatum optional)
-	Aufgaben bearbeiten
- Aufgaben löschen
- Aufgaben als erledigt markieren
- Visuelle Hervorhebung von Aufgaben mit heutigem Fälligkeitsdatum + überfällig
- Anzeige offener Aufgabenanzahl
- Sortierung nach Fälligkeitsdatum
- Kommunikation mit TYPO3-Backend via REST-API (Axios)
- Menu für Zeitsprünge
- Ansprechendes Design :D

# Codequalität & Tests

| Zweck                 | Technologie        | Befehl zur Ausführung (im Container)     |
|----------------------|--------------------|-------------------------------------------|
| JS/TS Linting        | ESLint             | `npm run lint:js`                         |
| SCSS/CSS Linting     | Stylelint          | `npm run lint:scss`                       |
| Formatierung         | Prettier           | `npm run format`                          |
| Frontend Unit Tests  | Vitest             | `npm run test` / `npm run test:watch`     |
| PHP Linting          | PHP-CS-Fixer       | `composer lint:php` / `composer fix:php`  |
| PHP Static Analysis  | PHPStan (+ TYPO3)  | `composer phpstan`                        |

# Ausbaumöglichkeiten
- Accountgebundene ToDo-Listen (z. B. pro Frontend-Benutzer)
-	Authentifizierung für API-Zugriffe (z. B. über fe_login)
-	Pagination, Filter & Sortierung in der Aufgabenliste
-	Mehrsprachigkeit der Vue-Komponenten (i18n)
-	Drag & Drop Sortierung von Aufgaben
...
