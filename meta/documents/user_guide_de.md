# Produktinformationen

Mit diesem Plugin zeigst du deinen Kund:innen mittels einer Fortschrittsanzeige, ab welchem Warenkorbwert sie den Versand gratis erhalten. Dies führt dazu, dass du in deinem plentyShop das Potenzial höherer Warenkorbwerte ausschöpfen kannst.

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

### Individualisierung

| Einstellung                        | Beschreibung |
|------------------------------------|---------------|
| Nachricht Nichterreichen Warenwert | Text bei Nichterreichen des Warenkorbwert, folgende Platzhalter stehen zur Verfügung: `:amount` für den fehlenden Betrag und `:currency` für die Währung. |
| Nachricht Warenwert erreicht       | Text bei Erreichen des Warenkorbwert, d.h. sobald die Versandkosten entfallen |

Tabelle 1: Konfigurationsoptionen Individualisierung


<sub><sup>Jeder einzelne Kauf hilft bei der ständigen Weiterentwicklung und der Umsetzung von Userwünschen. Vielen Dank!</sup></sub>
