# TYPO3 TodoList Projekt

Dieses Projekt ist eine Beispiel-Anwendung zur Verwaltung von Aufgaben (Tasks) mit **TYPO3 v13**, **Vite** und **Vue 3**. Aufgaben können sowohl im TYPO3-Backend als auch im Frontend erstellt, bearbeitet und gelöscht werden. Die Kommunikation zwischen Vue und TYPO3 erfolgt über eine REST API mit [t3api].

# Schnellstart

git clone [<repo-url>](https://github.com/kkroff/todolist) todolist
cd todolist
ddev start
ddev composer install
ddev npm install
ddev import-db --src=.ddev/todolist_db.sql.gz
ddev vite

=> Frontend erreichbar unter: https://todolist.ddev.site

---

# Technologien

- TYPO3 v13 (Composer-Installation)
- Vite, Vue 3, Axios
- REST API via [t3api](https://extensions.typo3.org/extension/t3api)
- Asset Management via [vite_asset_collector](https://extensions.typo3.org/extension/vite_asset_collector)
- DDEV für lokale Container-Entwicklung
- Codequalität:
  - PHP: PHP-CS-Fixer, PHPStan
  - JS/SCSS: ESLint, Prettier, Stylelint
  - Testing: Vitest (unit tests)

---

# Features (Frontend)
- Aufgaben anzeigen, erstellen, bearbeiten und löschen
-	Aufgaben als erledigt markieren
- Aufgaben nach Fälligkeitsdatum sortiert
-	Bearbeiten mit “Speichern” & “Abbrechen”
-	Datumsauswahl & Navigation über aktuelle Ansicht
-	Responsive & einfache Benutzeroberfläche mit Vue 3

---

🚀 Ausbaumöglichkeiten
- Accountgebundene ToDo-Listen (z. B. pro Frontend-Benutzer)
-	Authentifizierung für API-Zugriffe (z. B. über fe_login)
-	Pagination, Filter & Sortierung in der Aufgabenliste
-	Mehrsprachigkeit der Vue-Komponenten (i18n)
-	Drag & Drop Sortierung von Aufgaben
...
