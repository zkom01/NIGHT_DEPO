# 🎓 Vysoká škola ZKOM – Informační systém

## 📌 Popis projektu
Webová aplikace pro komplexní správu obsahu vysoké školy. Umožňuje administraci studentů, vysokých škol, uživatelských účtů a komunikaci přes kontaktní formulář[cite: 1].

Projekt je postaven na moderním PHP s důrazem na **objektově orientované programování (OOP)**, bezpečnost a čistotu kódu[cite: 1].

---

## ⚙️ Funkcionalita
*   **Autentizace a autorizace:** Bezpečné přihlášení s rozlišením rolí (Admin vs. SuperAdmin)[cite: 1].
*   **Správa dat (CRUD):** Plná administrace studentů (včetně nahrávání fotografií), škol a uživatelů.
*   **Dynamický obsah:** Flexibilní správa obsahu webu[cite: 1].
*   **Komunikace:** Kontaktní formulář pro odesílání e-mailů pomocí PHPMailer[cite: 1].
*   **Zabezpečená administrace:** Oddělená část `/admin` s vylepšeným přesměrováním a kontrolou přístupu[cite: 1].

---

## 🧱 Technologie
*   **PHP 8.x (OOP):** Využití jmenných prostorů a čisté architektury tříd[cite: 1].
*   **MySQL / MariaDB:** Databáze s kódováním `utf8mb4` pro plnou podporu diakritiky.
*   **Frontend:** HTML5, CSS3 (Bootstrap 5), JavaScript[cite: 1].
*   **Composer:** Správa závislostí (PHPMailer atd.)[cite: 1].

---

## 🚀 Instalace

### 1. Klonování projektu
```bash
git clone https://github.com/tvuj-repozitar.git
cd projekt
```

### 2. Nastavení serveru
*   PHP >= 8.0[cite: 1]
*   MySQL / MariaDB[cite: 1]
*   Web server (Apache / Nginx)[cite: 1]

### 3. Instalace závislostí
```bash
composer install
```

---

## 🗄️ Databáze

### Import databáze
1.  Vytvoř novou databázi (např. `vszkom`)[cite: 1].
2.  Importuj aktuální soubor: `vszkom_DB.sql`[cite: 1].

### Nastavení připojení
Uprav přihlašovací údaje v souboru `classes/Database.php` (nebo v `.env`, pokud jej používáš)[cite: 1]:
```php
DB_HOST=localhost
DB_NAME=vszkom
DB_USER=root
DB_PASS=heslo
```

---

## 🔑 Přístupové údaje (testovací)
| Role | Email | Heslo |
| :--- | :--- | :--- |
| **Super Admin** | `zkom@zkom.cz` | `pondeli4381`[cite: 1] |

*(Doporučeno změnit ihned po první instalaci!)*[cite: 1]

---

## 📁 Struktura projektu
```text
/admin      → administrační rozhraní a kontrola přístupu[cite: 1]
/assets     → statické soubory (CSS, JS, obrázky, formuláře)[cite: 1]
/classes    → PHP třídy (StudentsDB, UserDB, PhotoDB, Auth, atd.)[cite: 1]
/uploads    → úložiště pro nahrané fotografie studentů
/vendor     → externí knihovny spravované Composerem[cite: 1]
index.php   → hlavní vstupní bod aplikace[cite: 1]
login.php   → přihlašovací formulář[cite: 1]
```

---

## 🔒 Bezpečnost a refaktoring
Aplikace prošla procesem "profi úklidu", který zahrnuje:
*   **Prepared Statements:** Ochrana proti SQL injection u všech dotazů[cite: 1].
*   **Error Handling:** Chyby se již nevypisují přímo, ale využívají třídu `LogError` pro tichý zápis[cite: 1].
*   **Zpřísněná Validace:** Kritické operace (mazání uživatelů) vyžadují oprávnění `requireSuperAdmin()`.
*   **Bezpečné přesměrování:** Ochrana adresářové struktury pomocí hlaviček v `index.php` souborech.

---

## 📄 Licence
Tento projekt je určen pro studijní účely[cite: 1].

## 👨‍💻 Autor
Zdeněk Komárek[cite: 1]

---

### Poznámka:
Vždy mluvíme česky a to vždy. Pokud potřebuješ v README něco změnit nebo doplnit specifické technické detaily, stačí napsat!