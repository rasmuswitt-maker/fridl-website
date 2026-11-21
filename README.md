---
title: FRIDL Website – Bauanleitung & Deployment
tags: [fridl, website, hostinger]
---

# FRIDL PU-Schaum Antihaft – Landingpage

Fertige, eigenständige Produkt-Landingpage im FRIDL-Look (Navy/Orange).
Sprache: Deutsch · Zielgruppe: Profis + Heimwerker · Verkauf: extern (Amazon).

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
| `fridl-grenze.jpg` | Beweisfoto 1 (21.11.2026): eine Platte, oben mit FRIDL behandelt, unterhalb der gelben Linie unbehandelt – dort klebt der PU-Schaum und reisst die Oberflaeche aus |
| `fridl-abgehoben.jpg` | Beweisfoto 2 (21.11.2026): ausgehaerteter PU-Schaum, in einem Stueck von der behandelten Flaeche abgehoben |

> Original-Logo-Paket (SVG-Trace, alle Formate) liegt in `FRIDL OptiTren Pro/Logos.zip`, falls die
> Base64-Wrapper hier mal neu gebaut werden müssen. Es gibt dort auch ein `favicon.ico` – noch nicht
> eingebunden, aktuell läuft `favicon.svg` weiter.

## Vorbestellung (aktueller Verkaufsmodus)

Das Produkt ist noch nicht bestellbar → primärer Call-to-Action ist die **Vorbestellung**.
Interessenten tragen Kontaktdaten + gewünschte Menge ein und werden informiert, sobald bestellbar.

Das Formular (`#vorbestellen`) läuft im **E-Mail-Modus** (kein Server nötig): Beim Absenden
öffnet sich eine vorbefüllte E-Mail an die Adresse aus `data-mailto` (aktuell
`service@fridl.shop` – echtes Hostinger-Postfach, seit 30.08.2026 live, mit Weiterleitung
an `witt@hinsch-voelckers.de`). Dieselbe Adresse steht auch in Impressum und Datenschutzerklärung.

**Für automatische Erfassung (empfohlen für Live-Betrieb)** – zwei Wege:
- **Statisch/Formspree:** Konto bei [formspree.io](https://formspree.io) anlegen, Form-ID holen
  und am `<form id="preorderForm">` setzen: `data-endpoint="https://formspree.io/f/DEIN-ID"`.
  Dann werden Einträge automatisch gesammelt.
- **WordPress:** Formular-Plugin nutzen (Fluent Forms, WPForms, Contact Form 7) und das
  HTML-Formular dadurch ersetzen – Einträge landen in der WP-Datenbank / per Mail.

## Noch zu erledigen (Platzhalter) ⚠️

- [ ] **Vorbestell-Ziel:** `data-mailto` auf echte Adresse setzen bzw. `data-endpoint` (Formspree) hinterlegen.
- [ ] **Shop-Links (später):** Sobald bestellbar – Abschnitt „Bald im Handel" auf einen echten Amazon-Button umstellen.
- [x] **Produktfotos:** Vorher/Nachher-Boxen (`.ba-card`) nutzen Fotos aus dem Flyer-PDF. Hero-Bild ist seit 30.08.2026 ein KI-Rendering (`ChatGPT Image 29. Aug. 2026, 21_38_38.png` in `FRIDL OptiTren Pro/`) des echten Schraubverschluss-Tiegels statt des ursprünglichen Flyer-Eimers mit Henkel – zeigt jetzt korrekt die tatsächliche Verpackungsform. `.product-photo` läuft seither als Vollbild (`object-fit:cover`) statt freigestelltes Objekt.
- [x] **Video-Anzeige-Bug behoben (30.08.2026):** `.video-frame` nutzte `display:grid;place-items:center`, wodurch das Portrait-Video (`fridl-produkt-in-aktion.mp4`, 576×1024) nicht gestreckt, sondern in Originalgröße zentriert und vom `overflow:hidden`-Rahmen oben abgeschnitten wurde (nur ein Ausschnitt sichtbar). Fix: `.video-frame.has-video { display:block; }`, dadurch greift `object-fit:contain` korrekt und zeigt das komplette Video (mit Letterboxing links/rechts).
- [ ] **Drittes Video:** Nur 2 von 3 angekündigten Videos sind eingebunden. Die Platzhalter-Karte für das dritte Video („Anleitung zur Verarbeitung") wurde auf Wunsch entfernt – Grid läuft aktuell zweispaltig (`.videos-2`). Sobald das dritte Video da ist: dritte `<article class="video-card">` wieder ergänzen und `.videos-2`-Klasse vom Grid entfernen.
- [ ] **Videos auf YouTube:** Sobald Kanal steht, Videos zusätzlich dort hochladen und auf YouTube-Embeds umstellen (aktuell selbst gehostete `<video>`-Tags).
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

> Hinweis: WooCommerce ist **nicht** nötig, solange der Verkauf über Amazon läuft.
> Will man später direkt verkaufen, lässt es sich jederzeit nachrüsten.

## DSGVO-Tipp
Für volle Rechtssicherheit die Google Fonts **lokal** einbinden (statt per CDN), damit keine
IP-Adressen an Google gehen. Bei statischer Seite: Schriften herunterladen und per `@font-face`
einbinden; bei WordPress übernimmt das ein Plugin wie „OMGF".

## Relaunch Startseite (24.09.2026)

Umbau nach dem Marketing-Feedback: Problem → Beweis → Lösung → Vormerken, durchgehend **Du-Form**
(Impressum/Datenschutz bleiben beim Sie).

- **Hero:** „PU-Schaum gehört in die Fuge. Nicht auf deine Oberflächen." + 4 Schritte + stummer
  8-s-Loop `videos/fridl-hero-loop.mp4` (Poster `assets/hero-loop-poster.jpg`), geschnitten aus
  `fridl-produkt-in-aktion.mp4` Sek. 3–11,5. Neu schneiden: `ffmpeg -ss 3 -t 8.5 -i videos/fridl-produkt-in-aktion.mp4 -an -vf "crop=576:576:0:40,scale=720:720" -c:v libx264 -crf 27 -movflags +faststart videos/fridl-hero-loop.mp4`
- **Reihenfolge:** Vergleich ohne/mit FRIDL → Videos → 3 Schritte → Einsatzbereiche → Oberflächen →
  Vorteile → Vormerken → Final-CTA → FAQ.
- **Formular (`#vormerken`):** Pflicht nur E-Mail + Einwilligung; Firma/Menge/Nachricht optional
  unter „Sonderkonditionen anfragen". `send-preorder.php` prüft entsprechend nur noch die E-Mail.
- Beim Upload mitnehmen: `index.html`, `send-preorder.php`, `videos/fridl-hero-loop.mp4`,
  `assets/hero-loop-poster.jpg`.

### Mobil-Optimierung (24.09.2026)
- Unter 940 px steht das Hero-Video direkt unter der Überschrift (Effekt im ersten Bildschirm).
- Unter 560 px: Buttons auf voller Breite, Trust-Leiste 2×2, kompaktere Karten, Oberflächen 4-spaltig,
  Sticky-Leiste „Jetzt vormerken" unten (erscheint nach dem Hero, verschwindet am Formular/Footer).
- Fix: Das Formular lief auf dem Handy über den rechten Rand (Button nicht klickbar) – jetzt einspaltig.

### Neue Logos (24.09.2026)
Quelle: `FRIDL OptiTren Pro/RGB/Fridel_Logo.svg|png` (echter Vektor). `assets/logo-fridl.svg` = Original mit
enger viewBox, `logo-fridl-white.svg` = Navy→Weiß (Orange bleibt), PNGs aus `Fridel_Logo.png` gecroppt,
`favicon.svg` = „F" aus dem Logo + Schwung. Logo in der Kopfzeile 76 px (beim Scrollen 52 px), Footer 110 px.

## Stand 22.10.2026: Formular im Mailto-Modus

Wegen einer PHP-Sicherheitslücke (Hostinger lieferte nur 8.3.35 / 8.4.26 / 8.5.11) wurden
`send-preorder.php`, `mail-config.php` und Hostingers `default.php` aus `public_html` entfernt;
das Formular öffnet eine vorbefüllte E-Mail an service@fridl.shop.
Zurück zum serverseitigen Versand, sobald eine gepatchte PHP-Version läuft (8.3.36 / 8.4.27 / 8.5.12):
am `<form id="preorderForm">` wieder `data-endpoint="send-preorder.php"` setzen und
`send-preorder.php` + `mail-config.php` (mit dem NEUEN Postfach-Passwort) hochladen.

## Stand 20.11.2026: Werbeaussagen und Preisdarstellung

Vor dem Verkaufsstart bereinigt, damit Seite, Etikett und Amazon-Listing dasselbe sagen:

- **„umweltfreundlich" gestrichen.** Pauschale Umweltaussagen ohne Nachweis sind seit der
  UWG-Novelle zur Richtlinie (EU) 2024/825 unlauter; das Produkt ist WGK 1 und enthält eine
  Isothiazolinon-Konservierung.
- **„hautfreundlich" und „sicher in der Anwendung" gestrichen.** Beides widerspricht dem eigenen
  Etikett (H319, „Kann allergische Reaktionen hervorrufen"). Die FAQ nennt die Einstufung jetzt
  offen und empfiehlt bei empfindlicher Haut Handschuhe.
- **„rückstandslos entfernbar" → „wieder abnehmen".** Die eigene Anleitung sagt, dass Rückstände
  abgewischt werden müssen.
- **Preisdarstellung:** Normalpreis 24,95 €, Einführungspreis 19,95 €, jeweils zzgl. Versand.
  Der durchgestrichene 24,95 € steht auf ausdrückliche Entscheidung von Rasmus (20.11.2026) in
  Hero, Perk-Liste und Kaufbox, damit der Einführungsrabatt erkennbar ist. Hinweis für später:
  § 11 PAngV verlangt bei einer Preisermäßigung den niedrigsten Gesamtpreis der letzten 30 Tage;
  vor dem ersten Verkauf gibt es diese Historie nicht. Sobald das Produkt eine Weile zu 24,95 €
  verkauft wurde, ist die Darstellung unproblematisch.

## Stand 20.11.2026: Textänderungen nach Rasmus

- Trust-Bar, Sym-Buttons, Einsatzbereiche und Oberflächen-Unterzeile: **Hände & Werkzeug raus**.
  Bewusst stehen geblieben sind die Vorteilskachel, Schritt 1 und die eigene FAQ.
- **Sprühlack komplett raus**: Kachel, Sternchen-Fußnote, FAQ und der Nachsatz unter den
  Einsatzbereichen.
- Absatz 1 und 2 der Sym-Sektion neu formuliert (angrenzende und zu schützende Oberflächen;
  „Mit FRIDL änderst du die Situation …").
- Vergleich: „Flächendeckend mit einem Pinsel einstreichen" und „FRIDL-Rückstände abwischen".
- Einsatzbereiche: Holz & Innenausbau „bevor mit PU-Schaum eingeschäumt wird", Heimwerken
  „Nimm vorher FRIDL."
- Vorteile: „4–5 Minuten Arbeitsaufwand" statt „Gesamtaufwand".
- Produkt immer beim Namen: „Du trägst FRIDL auf" statt „es".
