# AGENTS.md

## Project

Global supply chain risk monitoring dashboard. Laravel 13 + PHP 8.3 app inside `laravel-app/` subdirectory.

**All commands should be run from `laravel-app/`.**

## Quick Start

```bash
cd laravel-app
composer setup    # install, migrate, npm install, npm run build
```

## Dev Server

```bash
composer dev      # runs concurrently: php artisan serve, queue:listen, pail, npm run dev
```

## Key Commands

| Task | Command |
|---|---|
| Run all tests | `composer test` (clears config cache + phpunit) |
| Run single test | `php artisan test --filter=TestClassName` |
| Run feature suite | `php artisan test --testsuite=Feature` |
| Lint/format | `./vendor/bin/pint` (Laravel Pint) |
| Build frontend | `npm run build` |
| Full risk recalculation | `php artisan risk:monitor` |
| Seed database | `php artisan db:seed` (runs CountrySeeder) |

## Tech Stack

- **Backend**: Laravel 13, PHP 8.3, SQLite (phpunit) / MySQL (runtime)
- **Auth**: Laravel Breeze + Sanctum
- **Frontend**: Vite 8, Tailwind CSS 3, Alpine.js, Chart.js
- **DB**: `global_supply_chain` on MySQL port 8889

## Architecture

Business logic lives in `app/Services/`, not controllers. Services are injected via constructor DI.

Core services:
- `RiskScoringService` - weighted risk calculation (Weather 20%, Inflation 25%, Currency 20%, News 20%, Port 15%)
- `RiskAlertService` - generates alerts when individual indicator scores are MEDIUM or HIGH
- `SentimentService` - keyword-based sentiment analysis using positive_words/negative_words tables
- `WeatherService` - Open-Meteo API for weather data + geocoding
- `ExchangeRateService` - exchangerate-api.com for USD conversion rates
- `NewsService` - newsdata.io / GNews APIs for country news
- `WorldBankService` - World Bank API for economic indicators (inflation)
- `PortImportService` - CSV import of World Port Index data

## Gotchas

- **Debug `dd()` calls**: `app/Services/CountryService.php:22` and `app/Services/PortImportService.php:20` contain `dd()` calls that will halt execution. Remove before any sync/import operations.
- **Missing auth middleware**: Several routes in `routes/web.php` lack `auth` middleware (e.g., `ports.import`, `risk.index`, `risk.show`, `risk.analytics`, `risk-alerts`, `risk.map`, `system.health`). Be aware when modifying route protection.
- **Inconsistent .env vs .env.example**: `.env` uses MySQL (`DB_CONNECTION=mysql`, port 8889) while `.env.example` defaults to SQLite. Tests use SQLite in-memory regardless.
- **API keys required**: `EXCHANGE_RATE_API_KEY`, `NEWSDATA_API_KEY`, `GNEWS_API_KEY` must be set in `.env` for data sync to work.
- **Indonesian comments**: Service layer uses Indonesian for some comments. Preserve this convention.

## Code Style

- 4-space indent, LF line endings (`.editorconfig`)
- Use Laravel Pint for formatting: `./vendor/bin/pint`
- PSR-4 autoloading under `App\` namespace
- Controllers are thin; delegate to services
