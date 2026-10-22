## S-Cockpit Laravel Base Projekt

Das Projekt "LBS-SuedWest" soll einen einfachen Einstieg in die Entwicklung neuer Portale mit Anbindung an S-Cockpit bieten.

Viele Bestandteile sind bereits vorkonfiguriert, wie z.B. die OAuth Anbindung, die S-Cockpit SDK oder das Base Layout.

Sobald das Projekt gecloned/heruntergeladen (siehe Dokumentation zu Fork) wurde, führen Sie folgende Befehle aus:
```bash
cp .env.example .env
php artisan key:generate
```

Ändern Sie nun die Datenbank Zugangsdaten in der `.env` - Datei und erstellen Sie die Datenbank.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=svc-013-sterntaler
DB_USERNAME=root
DB_PASSWORD=root
```
Anschließend führen Sie die Migration mit folgendem Befehl im Terminal aus:
```bash
php artisan migrate --seed
```

Ändern Sie nun die Zugangsdaten zum Manager in der `.env`:
```bash
# Diese Werte werden im S-Cockpit bereitgestellt

SCOCKPIT_API=http://127.0.0.1:8000
SCOCKPIT_CLIENT_ID=
SCOCKPIT_CLIENT_SECRET=
SCOCKPIT_REDIRECT=http://127.0.0.1:8013/auth
SCOCKPIT_PORTAL_API_TOKEN=
SCOCKPIT_URL=http://127.0.0.1:8000
SCOCKPIT_PORTAL_ID=13

# Path to SDK (https://sdk.s-cockpit.de for latest stable SDK release or 127.0.0.1:3000 for locally hosted development)
SDK_URL=https://sdk-v2.s-cockpit.s-mm.host
```

Folgende Werte müssen aus dem S-Cockpit manuell eingpflegt werden:
```bash
SCOCKPIT_CLIENT_ID=
SCOCKPIT_CLIENT_SECRET=
SCOCKPIT_PORTAL_API_TOKEN=
```
Diese finden Sie unter http://127.0.0.1:8000/admin/portals/12

Anschließend führen Sie folgende Befehle in PHP in zwei unterschiedlichen Terminals aus:
```bash
php artisan serve --port=8013
npm run watch
```
Die Befehle werden bei jedem Start des Projektes verlangt und müssen ausgeführt werden.