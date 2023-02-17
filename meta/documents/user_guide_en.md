# Product Information

With this plugin you show your customers by means of a progress bar from which shopping cart value they will receive free shipping. This means that you can exploit the potential of higher shopping cart values ​​in your plentyShop.

## Features

<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Easy setup to display Free Shipping<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Individual and localizable messages for missing amount and success<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Vouchers are taken into account in the calculation<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Hide display for delivery countries without free shipping<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Get shipping costs automatically from the postage table of the selected shipping profile

## Installation Guide

To display the free goodie, you must enter the appropriate values ​​in the plugin configuration.

1. Open the **Plugins » Plugin set overview** menu.
2. Select the desired plugin set.
3. Click on **No shipping costs for values over**.<br>→ A new view opens.
4. Select the **Global** section from the list.
5. Enter your desired _goods value (gross)_.
6. Check the **Active** checkbox to display the progress bar
7. **Save** the settings.

<div class="alert alert-info" role="alert">
  Make sure that the value is stored in the plugin configuration in the same way as your shipping profile.
</div>

Note: Use the **Active** checkbox to temporarily turn off plugin output without changing container bindings or deactivating the plugin in the plugin set.

Then create the container links so that the progress bar is also displayed in the shopping cart of your plentyShop:

1. Change to the submenu **Container links**.
2. Associate the **Display Progress Bar to reach Free Shipping** content with the **Ceres::BasketTotals.AfterShippingCosts** container to display in the shopping cart (_Shopping cart: After "Shipping"_)

### Exclude delivery countries without free shipping

If you do not offer free shipping in one or more delivery countries, you can exclude this via the plugin configuration and thus not display a progress bar.

To do this, open the plugin configuration and enter a comma-separated list of prohibited delivery countries in the **General** area in the **Excluded shipping countries** field, e.g. _3,12_ for Belgium and the United Kingdom.

    1=Germany
    2=Austria
    ...
    
A complete list of all delivery country IDs can be found under **Setup » Orders » Shipping » Settings** in the **Shipping Countries** tab.

### Individualization

In the **CMS » Multilingualism** menu, you can customize the texts below the progress bar. **Save** after customization and don't forget to press **Publish**.

| Key                                | Description   |
|------------------------------------|---------------|
| MessageMissing | Text if the shopping cart value is not reached, the following placeholders are available: `:amount` for the missing amount and `:currency` for the currency. |
| MessageGoal | Text when the shopping cart value is reached, i.e. as soon as the shipping is free |

Table 1: Configuration options individualization

The appearance of the progress bar can be customized in the **Individualization** area in the **Plugin configuration**.

| Einstellung                        | Beschreibung  |
|------------------------------------|---------------|
| CSS class for missing | This bootstrap class will get your progress bar as background color as long as the free shipping limit has not been reached.<br>Choose Custom to override this with your theme. |
| CSS class for goal | This bootstrap class gets your progress bar as background color as soon as the order is free shipping.<br>Choose Custom to override this with your theme. |
| Progress bar striped | Adds the .progress-bar-striped bootstrap class to the progress bar. |

Table 2: Plugin configuration customization


<sub><sup>Every single purchase helps with constant further development and the implementation of user requests. Thanks very much!</sup></sub>