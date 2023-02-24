# Release Notes for "No shipping costs for values over"

## v1.0.5 (2023-02-24)

### Fixed
- Fix retrieval of no shipping costs in table of shipping charges if option "From an item value of ..." was set

## v1.0.4 (2023-02-17)

### Added
- New setting **Get free shipping limit from postage table** in the plugin configuration. Activate this if you use several shipping profiles with different flat rates for free shipping from the value of the goods

## v1.0.3 (2023-02-01)

### Added
- The appearance of the progress bar can now be customized: CSS class(es) for missing and success (determines the background color of the progress bar) and, if necessary, striped progress bar

## v1.0.2 (2023-01-24)

### Fixed
- A duplicate class attribute in HTML markup combined with Server-Side Rendering (SSR) caused the deployment process to fail

## v1.0.1 (2023-01-09)

### Added
- You now have the option of excluding individual shipping countries from free shipping via the plugin configuration and thus hiding the progress bar

### Changed
- The messages of the progress bar have been moved to the **CMS » Multilingualism** menu so that they can be translated. Furthermore, you can now use emojis or HTML code there

### Fixed
- Coupons are correctly reflected in the progress bar

### TODO
- Customize the translations for the **Individualization** section of the FreeShippingGoal plugin in the **CMS » Multilingualism** menu

## v1.0.0 (2022-10-18)

### Added
- Initial release
