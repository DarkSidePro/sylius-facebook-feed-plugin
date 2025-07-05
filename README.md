# Sylius Facebook Feed Plugin

Plugin do Sylius 2.x generujący feed produktowy w formacie XML zgodnym z wymaganiami Facebook Catalog.

## Wymagania
- PHP 8.2+
- Sylius 2.x

## Instalacja

1. Zainstaluj plugin przez Composer:

```bash
composer require darksidepro/sylius-facebook-feed-plugin
```

2. Dodaj plugin do pliku `config/bundles.php`:

```php
return [
    // ...
    DarkSidePro\FacebookFeed\FacebookFeedPlugin::class => ['all' => true],
];
```

3. Załaduj routing w pliku `config/routes.yaml`:

```yaml
facebook_feed:
    resource: "@FacebookFeedPlugin/Resources/routes/facebook_feed.yaml"
```

4. (Opcjonalnie) Skonfiguruj serwisy w `config/services.yaml` jeśli chcesz nadpisać domyślne zachowanie.

## Użycie

- Feed produktowy dostępny jest pod adresem:
  
  `https://twoja-domena/facebook-feed.xml`

- Możesz wygenerować feed do pliku przez CLI:

```bash
php bin/console app:facebook-feed:generate /ścieżka/do/feed.xml
```

## Testy

Uruchom testy jednostkowe:

```bash
vendor/bin/phpunit
```

## Rozszerzanie

Możesz nadpisać:
- Fabrykę `ProductFeedItemFactory` (np. aby dodać własne pola)
- Eksporter XML (`XmlFacebookFeedExporter`)
- Generator feeda (`ProductFeedGenerator`)

## Licencja

MIT
