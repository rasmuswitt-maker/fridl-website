---
title: FRIDL Website – Bauanleitung & Deployment
tags: [fridl, website, hostinger]
---

# FRIDL PU-Schaum Antihaft – Landingpage

Fertige, eigenständige Produkt-Landingpage im FRIDL-Look (Navy/Orange).
Sprache: Deutsch · Zielgruppe: Profis + Heimwerker · Verkauf: extern (Amazon/eBay).

## Dateien

| Datei | Zweck |
|-------|-------|
| `index.html` | Die Landingpage (komplett, inkl. CSS/JS inline) |
| `impressum.html` | Impressum (Pflicht in DE) |
| `datenschutz.html` | Datenschutzerklärung (Vorlage) |
| `assets/` | Logo-Grafiken & Favicon (siehe unten) |

Keine Build-Tools, keine Abhängigkeiten – nur Google Fonts werden per CDN geladen.

## Logo-Assets (`assets/`)

Seit 29.08.2026 das **offizielle Logo** aus `FRIDL OptiTren Pro/Logos.zip` (Rasmus' Projektordner) –
vorher war hier eine handgebaute Näherung. `logo-fridl.svg`/`logo-fridl-white.svg` sind SVG-Wrapper
um das offizielle PNG (Base64-eingebettet, kein Qualitätsverlust bei Logo-Größe im Header/Footer);
`logo-fridl-white.png` ist per Skript aus der Transparent-Version weiß eingefärbt (im offiziellen
Paket gab es keine echte weiße Logo-Variante, nur „weiss" = navy-Logo auf weißem statt transparentem
Grund).

| Datei | Verwendung |
|-------|-----------|
| `logo-fridl.svg` | Hauptlogo (Navy/Orange, transparent) – Web, helle Hintergründe |
| `logo-fridl-white.svg` | Weiße Variante (für dunkle Hintergründe, z. B. Footer) – selbst eingefärbt |
| `favicon.svg` | Browser-Icon / App-Kachel |
| `logo-fridl.png` | Offizielles Hauptlogo, transparent – für Amazon, E-Mail, Office |
| `logo-fridl-onwhite.png` | Offizielles Logo auf weißem Grund (PNG) |
| `logo-fridl-white.png` | Weiße Variante als PNG, transparent (selbst generiert) |
| `favicon-512.png` | Favicon als PNG 512 px (für Plattformen ohne SVG-Support) |
| `produkt-dose.png` | Produktfoto (Dose), aus `FRIDL OptiTren Pro/Flyer Fridl 06 2026.pdf` gecroppt – Hero-Visual |
| `vorher.png` / `nachher.png` | Vorher/Nachher-Fotos, ebenfalls aus dem Flyer gecroppt |

> Original-Logo-Paket (SVG-Trace, alle Formate) liegt in `FRIDL OptiTren Pro/Logos.zip`, falls die
> Base64-Wrapper hier mal neu gebaut werden müssen. Es gibt dort auch ein `favicon.ico` – noch nicht
> eingebunden, aktuell läuft `favicon.svg` weiter.

## Vorbestellung (aktueller Verkaufsmodus)

Das Produkt ist noch nicht bestellbar → primärer Call-to-Action ist die **Vorbestellung**.
Interessenten tragen Kontaktdaten + gewünschte Menge ein und werden informiert, sobald bestellbar.

Das Formular (`#vorbestellen`) läuft im **E-Mail-Modus** (kein Server nötig): Beim Absenden
öffnet sich eine vorbefüllte E-Mail an die Adresse aus `data-mailto` (aktuell
`vorbestellung@fridl.info` – bitte auf eine echte Adresse ändern).

**Für automatische Erfassung (empfohlen für Live-Betrieb)** – zwei Wege:
- **Statisch/Formspree:** Konto bei [formspree.io](https://formspree.io) anlegen, Form-ID holen
  und am `<form id="preorderForm">` setzen: `data-endpoint="https://formspree.io/f/DEIN-ID"`.
  Dann werden Einträge automatisch gesammelt.
- **WordPress:** Formular-Plugin nutzen (Fluent Forms, WPForms, Contact Form 7) und das
  HTML-Formular dadurch ersetzen – Einträge landen in der WP-Datenbank / per Mail.

## Noch zu erledigen (Platzhalter) ⚠️

- [ ] **Vorbestell-Ziel:** `data-mailto` auf echte Adresse setzen bzw. `data-endpoint` (Formspree) hinterlegen.
- [ ] **Shop-Links (später):** Sobald bestellbar – Abschnitt „Bald im Handel" auf echte Amazon-/eBay-Buttons umstellen.
- [x] **Produktfotos:** Vorher/Nachher-Boxen (`.ba-card`) nutzen Fotos aus dem Flyer-PDF. Hero-Bild ist seit 30.08.2026 ein KI-Rendering (`ChatGPT Image 29. Aug. 2026, 21_38_38.png` in `FRIDL OptiTren Pro/`) des echten Schraubverschluss-Tiegels statt des ursprünglichen Flyer-Eimers mit Henkel – zeigt jetzt korrekt die tatsächliche Verpackungsform. `.product-photo` läuft seither als Vollbild (`object-fit:cover`) statt freigestelltes Objekt.
- [ ] **Drittes Video:** 2 von 3 angekündigten Videos sind eingebunden (`videos/fridl-produkt-in-aktion.mp4`, `videos/fridl-test-lackierte-flaeche.mp4`). Die Karte „Anleitung zur Verarbeitung" ist noch Platzhalter – drittes Video folgt.
- [ ] **Videos auf YouTube:** Sobald Kanal steht, alle 3 Videos zusätzlich dort hochladen und auf YouTube-Embeds umstellen (aktuell selbst gehostete `<video>`-Tags).
- [ ] **YouTube-Kanal:** Kanal anlegen, dann `id="youtubeChannelLink"` (Footer) und `id="youtubeChannelBtn"` (Video-Sektion) von `href="#"` auf die echte Kanal-URL setzen.
- [ ] **Impressum:** Alle `[…]`-Felder (Geschäftsführer, HRB, USt-IdNr., Mail, Telefon) ausfüllen.
- [ ] **Datenschutz:** `[…]`-Felder ausfüllen (Hoster-Adresse, Mail); Vorbestell-Formular/Formspree ergänzen. Formular erfasst jetzt zusätzlich ein `newsletter`-Feld (Checkbox „Produktneuigkeiten per E-Mail") – in der Datenschutzerklärung erwähnen.
- [ ] **Hautfreundlich-Aussage:** Auf der Seite steht „hautfreundlich" als Produkteigenschaft; ein Sicherheitsdatenblatt (SDB), das das belegt, liegt aktuell noch nicht vor. Vor Live-Schaltung idealerweise durch SDB/Hersteller absichern.
- [ ] **Hero-Bild final ersetzen:** Aktuell ein KI-Rendering des Tiegels (siehe oben) – sobald ein echtes Produktfoto der finalen Verpackung vorliegt, `assets/produkt-dose.png` damit austauschen.

## Auf fridl.info bei Hostinger live nehmen

### Variante A – Schnell: als statische Seite hochladen
1. Hostinger → **hPanel** → *Dateien* → **Dateimanager**.
2. In den Ordner `public_html` wechseln (Inhalt ggf. vorher leeren).
3. `index.html`, `impressum.html`, `datenschutz.html` hochladen.
4. Domain `fridl.info` auf dieses Hosting zeigen lassen → fertig.

### Variante B – Wie gewählt: in WordPress einsetzen
1. Hostinger → **WordPress in 1 Klick** installieren (Domain `fridl.info`).
2. Neue **Seite** anlegen → Block **„Custom HTML"** → den `<body>`-Inhalt aus `index.html` einfügen.
   Das `<style>` aus dem `<head>` mit übernehmen (z. B. via Plugin „WPCode" als Header-Snippet
   oder direkt in den Custom-HTML-Block).
3. Diese Seite unter *Einstellungen → Lesen* als **Startseite** festlegen.
4. Impressum & Datenschutz je als eigene WP-Seite anlegen, Inhalt einfügen, im Footer-Menü verlinken.

> Hinweis: WooCommerce ist **nicht** nötig, solange der Verkauf über Amazon/eBay läuft.
> Will man später direkt verkaufen, lässt es sich jederzeit nachrüsten.

## DSGVO-Tipp
Für volle Rechtssicherheit die Google Fonts **lokal** einbinden (statt per CDN), damit keine
IP-Adressen an Google gehen. Bei statischer Seite: Schriften herunterladen und per `@font-face`
einbinden; bei WordPress übernimmt das ein Plugin wie „OMGF".
