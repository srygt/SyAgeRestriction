# SyAgeRestriction

[![Shopware Version](https://img.shields.io/badge/Shopware-6.5+-blue.svg)](https://www.shopware.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Author](https://img.shields.io/badge/Author-Serdar%20Yigit-lightgrey)](https://www.serdaryigit.de)

## 🇩🇪 Altersbeschränkung für die Shopware 6 Registrierung

Das `SyAgeRestriction` Plugin bietet eine **obligatorische Alterskontrolle** im Registrierungsformular von Shopware 6. Es ist speziell darauf ausgelegt, die Einhaltung gesetzlicher Vorschriften (z.B. für den Verkauf von Tabakwaren oder Alkohol) zu gewährleisten, indem es die Registrierung von Personen unter einem konfigurierbaren Mindestalter verhindert.

### Hauptfunktionen

* **Frontend-Validierung (UX):** Deaktiviert sofort das gesamte Registrierungsformular, sobald ein Geburtsdatum ausgewählt wird, das das Mindestalter unterschreitet.
* **Dynamische Datumseinschränkung:** Begrenzt die Auswahl der Jahre im Geburtsdatum-Dropdown dynamisch, sodass nur Jahre angezeigt werden, in denen der Benutzer das erforderliche Mindestalter erreichen *könnte*.
* **Backend-Validierung (Sicherheit):** Stellt sicher, dass die Alterskontrolle nicht umgangen werden kann, indem die Registrierungsanfrage serverseitig anhand des konfigurierten Mindestalters überprüft wird.
* **Zentrale Konfiguration:** Das erforderliche Mindestalter ist einfach über die Shopware Administration einstellbar.

---

## 🚀 Installation

### 1. Über den Shopware Community Store (Empfohlen)

* [Link zum Shopware Store] (Sobald das Plugin dort gelistet ist)

### 2. Manuelle Installation (mittels CLI)

1.  Laden Sie das Plugin-Repository herunter oder klonen Sie es in das Shopware-Plugin-Verzeichnis:
    ```bash
    git clone [https://github.com/Ihr-Github-Name/SyAgeRestriction.git](https://github.com/Ihr-Github-Name/SyAgeRestriction.git) custom/plugins/SyAgeRestriction
    ```
2.  Aktualisieren Sie die Plugin-Liste und installieren/aktivieren Sie das Plugin über die Shopware CLI:
    ```bash
    # Wechseln Sie ins Shopware Root-Verzeichnis
    cd /pfad/zu/ihrer/shopware/installation
    
    # Plugins aktualisieren und installieren
    php bin/console plugin:refresh
    php bin/console plugin:install --activate SyAgeRestriction
    
    # Storefront Assets neu bauen (WICHTIG für Frontend-Funktionalität!)
    php bin/console assets:install
    php bin/console theme:compile
    php bin/console cache:clear
    ```

---

## ⚙️ Konfiguration

Nach der Installation können Sie das erforderliche Mindestalter über die Administration festlegen:

1.  Navigieren Sie in der Shopware Administration zu **Einstellungen** > **System** > **Erweiterungen**.
2.  Wählen Sie das Plugin **"SY Altersbeschränkung für Registrierung"**.
3.  Im Feld **"Erforderliches Mindestalter"** (Systemkonfiguration > SyAgeRestriction) geben Sie den gewünschten Wert ein (z.B. `18` für Tabakprodukte).
4.  Speichern Sie die Konfiguration und leeren Sie den Cache.

---

## 💻 Technischer Aufbau

Das Plugin implementiert die Logik auf zwei Ebenen:

| Komponente | Zweck | Technologie |
| :--- | :--- | :--- |
| **Backend-Validierung** | Obligatorische Altersprüfung beim Speichern der Registrierung. | PHP (`AgeRestrictionValidator.php`, `RegisterRouteSubscriber.php`) |
| **Frontend-Logik** | Sofortige UI-Reaktion (Formular-Deaktivierung, Jahresbegrenzung). | Twig Override (`address-personal.html.twig`), JavaScript (`age-restriction.plugin.js`) |
| **Konfiguration** | Zentrale Steuerung des Mindestalters. | `config.xml` |

### Lizenz

Dieses Projekt steht unter der **MIT Lizenz**.

---

### Entwickler & Kontakt

| Name | Serdar Yigit |
| :--- | :--- |
| Website | [www.serdaryigit.de](https://www.serdaryigit.de) |
| E-Mail | info@serdaryigit.de |
