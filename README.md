# TYPO3 TodoList Projekt

Dieses Projekt ist eine Beispiel-Anwendung zur Verwaltung von Aufgaben (Tasks) mit TYPO3 v13, Vite und Vue 3. Die Aufgaben werden über eine REST-API (t3api) verwaltet. Die Oberfläche ist eine moderne Vue-App, die im TYPO3-Plugin eingebunden ist.

# Technologien

- TYPO3 v13
- Vite + Vue 3 + Axios
- t3api => https://extensions.typo3.org/extension/t3api
- Vite AssetCollector => https://extensions.typo3.org/extension/vite_asset_collector
- PHP-CS-Fixer, PHPStan
- ESLint, Prettier, Stylelint, Vitest 
 
---

# Schnellstart

git clone <repo-url> todolist
cd todolist
ddev start
ddev composer install
ddev npm install
ddev import-db --src=.ddev/todolist_db.sql.gz

ddev vite
