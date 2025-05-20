# WWM - Laravel Developer Assessment 🚀

### 🧩 Szenario

Ihr Kunde, TechGear, ist ein Elektronik-Einzelhändler, der seine Abläufe modernisieren möchte. Sie wurden beauftragt, eine einfache, saubere API in Laravel als Grundlage für ein künftiges Inventar-Management-System zu entwickeln.

Der Kunde verkauft elektronische Produkte, die in Kategorien organisiert sind. Mitarbeiter haben unterschiedliche Rollen (Admin, Manager, Staff).

---

### ✅ Ihre Aufgabe

#### **Teil 1: Design & Planung**

* Erstellen Sie ein **vereinfachtes ERM-Diagramm** mit folgenden Entities:

  * `User`
  * `Role`
  * `Product`
  * `Category`

* Planen Sie Ihre API-Endpunkte:

  * Fokus auf CRUD für `Product` und `Category`
  * Authentifizierte User können je nach Rolle unterschiedliche Aktionen ausführen

* Notieren Sie Architekturüberlegungen **in einem kurzen Textdokument** (max. 1 Seite)

---

#### **Teil 2: Implementation**

* Initialisieren Sie ein Laravel-Projekt mit:

  * `Laravel Breeze` oder `Sanctum` für einfache Token-basierte Authentifizierung
  * `Spatie Laravel Permission` (optional, wenn gewünscht) zur Rollenzuweisung

* Implementieren Sie die folgenden **API-Funktionalitäten**:

  * Login / Registration (nur für Testzwecke)
  * CRUD für `Product` und `Category`
  * Zugriffskontrolle (z. B. nur Admin darf Produkte erstellen)

* Verwenden Sie **Form Requests** für Data Validation

* Fügen Sie eine einfache **Fehlerbehandlung** hinzu (strukturierte JSON Errors)

* Schreiben Sie **einige Tests für zentrale Funktionen** (z. B. Product-Create mit Role-Check)

* Dokumentieren Sie die API grob:

  * Beispiel: Markdown-Readme mit Endpunkten oder automatisch generiert mit `L5-Swagger` (optional)

---

### 🧹 Optional (falls noch Zeit bleibt)

* `InventoryTransaction`-Modell zur Nachverfolgung von Produktmengen
* Swagger/OpenAPI-Doku mit `L5-Swagger`
* Ein zusätzlicher Endpunkt für das Filtern oder Suchen von Produkten

---

### 🎯 Ziel

> **Liefern Sie eine kleine, wartbare Laravel-API mit Fokus auf Codequalität, Struktur und sauberer Rollenlogik.** Umfang und Tiefe sind bewusst begrenzt – Qualität vor Vollständigkeit.

Viel Erfolg! 🍀
