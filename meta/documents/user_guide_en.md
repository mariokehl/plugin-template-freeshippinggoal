# Product Information

With this plugin you show your customers by means of a progress bar from which shopping cart value they will receive free shipping. This means that you can exploit the potential of higher shopping cart values ​​in your plentyShop.

## Features

<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Easy setup<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Individual and localizable messages for missing amount and success<br>
<i aria-hidden="true" class="fa fa-fw fa-check-square text-success"></i> Vouchers are taken into account in the calculation

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

### Individualization

In the **CMS » Multilingualism** menu, you can customize the texts below the progress bar. **Save** after customization and don't forget to press **Publish**.

| Key                                | Description   |
|------------------------------------|---------------|
| MessageMissing | Text if the shopping cart value is not reached, the following placeholders are available: `:amount` for the missing amount and `:currency` for the currency. |
| MessageGoal | Text when the shopping cart value is reached, i.e. as soon as the shipping is free |

Tabelle 1: Configuration options individualization


<sub><sup>Every single purchase helps with constant further development and the implementation of user requests. Thanks very much!</sup></sub>