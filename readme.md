# Analytics

Analytics is a simple website analytic package for Laravel giving you just enough data to be practical without any of the data-sharing, third party crazyness you get with hosted web analytic tools.

This plugin is being actively developed on stream by [https://www.twitch.tv/jakeydev](https://www.twitch.tv/jakeydev).

## Installation

System built on Laravel 8. Not tested on anything under version 8.

`$ composer require jakeydevs/analytics`

Once installed, run migrations to allow the system to record pageviews!

## Record Pageviews

### Recorded Pageviews

To record pageviews, you'll need to add a specific middleware to your routes. This middleware, when ran, will save each pageview to the system. The middleware is named `pageview`.

**To save on all pageviews to your system** set the middleware to run when the web routes are ran. The best way to do this is by setting the middleware on the RouteServiceProvider

`app\Providers\RouteServiceProvider.php`

```php
Route::middleware(['web', 'pageview'])
  ->namespace($this->namespace)
  ->group(base_path('routes/web.php'));
```

### Provided methods

#### Dates

Dates should be passed to the analytics model in as a `Period`. Examples are:

```php
Period::days(7) //-- Gets the last 7 days
Period::days(0) //-- Gets today
Period::create(now(), now()->subMinutes(10)) //-- Gets last 10 minutes
```

You can also get a set of dates to compare to your period - useful for providing context to results - by using the compare method. Examples are

```php
$period = Period::days(7);
$compare = Period::compare($period); //-- Gets the 7 days before that

$period = Period::days(0);
$compare = Period::compare($period); //-- Gets yesterdays data
```

#### Analytic Methods

You can use these methods to get pageviews, unique sessions, the bounce rate or the average duration of time for a session (in seconds):

```php
Jakeydevs\Analytics\Analytics::getPageviews(Period $period): int
Jakeydevs\Analytics\Analytics::getUnique(Period $period): int
Jakeydevs\Analytics\Analytics::getBounceRate(Period $period): float
Jakeydevs\Analytics\Analytics::getDuration(Period $period): int
```

You can also get aggregated information for any of the parsed data gathered (browser, os, device, location, paths).

```php
Jakeydevs\Analytics\Analytics::getDataAggregate(Period $period, string $column): array
```

The data returned is an array with the column and sessions ordered high to low.

### View Components

The system comes with several [view components](https://laravel.com/docs/8.x/blade#components) out the box for working with the data. They are based on [Tailwind](https://tailwindcss.com/) and the design can be found below.

![1](https://jakey.ams3.cdn.digitaloceanspaces.com/site/5DRtueBtmY9JqhQvtHvlsAtLvpT5aQGmGDkERRcX.png)

You can use these with the tags:

```php
@php
$p = Period::days(7);
@endphp

<!-- Blade file -->
<x-analytics-uniques :p="$p"/>
<x-analytics-views :p="$p"/>
<x-analytics-bounce :p="$p"/>
<x-analytics-duration :p="$p"/>
```

## FAQ

**Is this GDPR comliant?**
I think so? I am not a lawyer - and if you are not either, you should totally talk to one if you are worried about GDPR.

**Does this work on SPAs**
At the moment no as it only records a pageview on a page request.

## Contributing

Contributions are welcome - please send a pull request. When the project matures we'll add more detailed contribution guidelines!

This repo is available as part of [Hacktoberfest 2020](https://hacktoberfest.digitalocean.com/) and is perfect for first timers! If you need help, please join me on streams on Tuesdays and Fridays between 1pm and 4pm (GMT)!

## Features

Please feel free to add pull requests for any of the below crossed - or ask for new features in the issues.

✅ Record a pageview (Middleware)
✅ Get data from system
✅ Parsing configuration
❌ Record a pageview (manually - useful for SPA)
❌ View components for basic analytics
❌ Tests
❌ How to add own data parsers
❌ Example dashboard

## License

MIT
