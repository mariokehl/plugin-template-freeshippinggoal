# Produktinformationen

Mit diesem Plugin zeigst du deinen Kund:innen mittels einer Fortschrittsanzeige, ab welchem Warenkorbwert sie den Versand gratis erhalten. Dies führt dazu, dass du in deinem plentyShop das Potenzial höherer Warenkorbwerte ausschöpfen kannst.

## Features

<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Einfache Einrichtung<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Individuelle und lokalisierbare Texte für Fehlbetrag und Erfolg<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Gutscheine werden in der Berechnung berücksichtigt<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Anzeige für Lieferländer ohne kostenlosen Versand ausblenden

## Installationsanleitung

Für die Anzeige der Fortschrittsanzeige musst du die entsprechenden Werte in der Plugin-Konfiguration hinterlegen.

1. Öffne das Menü **Plugins » Plugin-Set-Übersicht**.
2. Wähle das gewünschte Plugin-Set aus.
3. Klicke auf **Versandkostenfrei ab Warenwert erreichen**.<br>→ Eine neue Ansicht öffnet sich.
4. Wähle den Bereich **Allgemein** aus der Liste.
5. Trage deinen gewünschten _Warenkorbwert (Brutto)_ ein.
6. Aktiviere die Checkbox **Aktiv**, damit die Fortschrittsanzeige angezeigt wird
7. **Speichere** die Einstellungen.

<div class="alert alert-info" role="alert">
    Achte darauf, dass bei der Plugin-Konfiguration der Wert analog zu deinem Versandprofil hinterlegt ist.
</div>

Hinweis: Verwende die Checkbox **Aktiv**, um die Plugin-Ausgabe temporär abzuschalten ohne die Container-Verknüpfungen zu ändern oder das Plugin im Plugin-Set zu deaktivieren.

Danach die Container-Verknüpfungen anlegen, so dass die Fortschrittsanzeige auch im Frontend deines plentyShop angezeigt wird:

1. Wechsel zum Untermenü **Container-Verknüpfungen**.
1. Verknüpfe den Inhalt **Display Progress Bar to reach Free Shipping** mit dem Container **Ceres::BasketTotals.AfterShippingCosts** zur Anzeige im Warenkorb (_Shopping cart: After "Shipping"_)

### Lieferländer ohne Gratis-Versand ausschließen

Bietest du in einem oder mehreren Lieferländern keinen Gratis-Versand an, kannst du diese über die Plugin-Konfiguraton ausschließen und somit keine Fortschrittsanzeige darstellen.

Öffne dazu die Plugin-Konfiguration und trage im Bereich **Allgemein** im Feld **Ausgenommene Lieferländer** eine kommaseparierte Liste von verbotenen Lieferländern ein, z.B. _3,12_ für Belgien und United Kingdom.

    1=Deutschland
    2=Österreich
    ...
    
Eine vollständige Liste aller Lieferland-IDs findest du unter **Einrichtung » Aufträge » Versand » Optionen** im Tab **Lieferländer**.

### Individualisierung

Im Menü **CMS » Mehrsprachigkeit** kannst du die Texte unterhalb der Fortschrittsanzeige anpassen. **Speichere** nach der Anpassung und vergiss nicht auf **Veröffentlichen** zu drücken.

| Schlüssel                          | Beschreibung  |
|------------------------------------|---------------|
| MessageMissing | Text bei Nichterreichen des Warenkorbwert, folgende Platzhalter stehen zur Verfügung: `:amount` für den fehlenden Betrag und `:currency` für die Währung. |
| MessageGoal | Text bei Erreichen des Warenkorbwert, d.h. sobald die Versandkosten entfallen |

Tabelle 1: Konfigurationsoptionen Individualisierung

Das Aussehen der Fortschrittsanzeige lässt sich im Bereich **Individualisierung** in der **Plugin-Konfiguration** anpassen.

| Setting                            | Description  |
|------------------------------------|---------------|
| CSS-Klasse für Fehlbetrag | Diese Bootstrap-Klasse erhält deine Fortschrittsanzeige als Hintergrundfarbe, solange die Grenze für Versandkostenfrei noch nicht erreicht wurde.<br>Wähle Eigene um dies mit deinem Theme zu überschreiben. |
| CSS-Klasse für Erfolg | Diese Bootstrap-Klasse erhält deine Fortschrittsanzeige als Hintergrundfarbe, sobald die Bestellung Versandkostenfrei ist.<br>Wähle Eigene um dies mit deinem Theme zu überschreiben. |
| Fortschrittsanzeige gestreift | Fügt der Fortschrittsanzeige die Bootstrap-Klasse .progress-bar-striped hinzu. |

Tabelle 2: Plugin-Konfiguration Individualisierung


<sub><sup>Jeder einzelne Kauf hilft bei der ständigen Weiterentwicklung und der Umsetzung von Userwünschen. Vielen Dank!</sup></sub>