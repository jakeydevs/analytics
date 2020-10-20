# Analytics

Analytics is a simple website analytic package for Laravel giving you just enough data to be practical without any of the data-sharing, third party crazyness you get with hosted web analytic tools.

This plugin is being actively developed on stream by [https://www.twitch.tv/jakeydev](https://www.twitch.tv/jakeydev) and is not quite ready for real world usage yet.

## Installation

System built on Laravel 8. Not tested on anything under version 8.

`$ composer require jakeydevs/analytics`

Once installed, run migrations to allow the system to record pageviews!

## Record Pageviews

To record pageviews, you'll need to add a specific middleware to your routes. This middleware, when ran, will save each pageview to the system. The middleware is named `pageview`.

**To save on all pageviews to your system** set the middleware to run when the web routes are ran. The best way to do this is by setting the middleware on the RouteServiceProvider

`app\Providers\RouteServiceProvider.php`

```javascript
Route::middleware(['web', 'pageview'])
  ->namespace($this->namespace)
  ->group(base_path('routes/web.php'));
```

## FAQ

**Is this GDPR comliant?**
I think so? I am not a lawyer - and if you are not either, you should totally talk to one if you are worried about GDPR.

**Does this work on SPAs**
At the moment no as it only records a pageview on a page request.

## Contributing

Contributions are welcome - please send a pull request. When the project matures we'll add more detailed contribution guidelines!

This repo is available as part of [Hacktoberfest 2020](https://hacktoberfest.digitalocean.com/) and is perfect for first timers! If you need help, please join me on streams on Tuesdays and Fridays between 1pm and 4pm (GMT)!

## License

MIT
