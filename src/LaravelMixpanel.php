<?php

namespace Mobiverse\LaravelMixpanel;

use Illuminate\Http\Request;
use Mixpanel;
use hisorange\BrowserDetect\Facade as Browser;

/**
 * Class LaravelMixpanel
 */
class LaravelMixpanel extends Mixpanel
{
    private $defaults;

    private Request $request;

    public function __construct(Request $request, array $options = [])
    {
        $this->defaults = [
            'consumer' => config('laravel-mixpanel.consumer', 'socket'),
            'connect_timeout' => config('laravel-mixpanel.connect-timeout', 2),
            'timeout' => config('laravel-mixpanel.timeout', 2),
        ];

        if (config('laravel-mixpanel.host')) {
            $this->defaults["host"] = config('laravel-mixpanel.host');
        }

        $this->request = $request;


        parent::__construct(
            config('laravel-mixpanel.token'),
            array_merge($this->defaults, $options)
        );
    }

    protected function getData(): array
    {
        $browserVersion = trim(str_replace('unknown', '', Browser::browserName() . ' ' . Browser::browserVersion()));
        $osVersion = trim(str_replace('unknown', '', Browser::platformName() . ' ' . Browser::platformVersion()));
        $hardwareVersion = trim(str_replace('unknown', '', Browser::deviceModel()));

        $data = [
            'Url' => $this->request->getUri(),
            'Operating System' => $osVersion,
            'Hardware' => $hardwareVersion,
            '$browser' => $browserVersion,
            'Referrer' => $this->request->header('referer'),
            '$referring_domain' => ($this->request->header('referer')
                ? parse_url($this->request->header('referer'))['host']
                : null),
            'ip' => $this->request->ip(),
        ];

        if ((!array_key_exists('$browser', $data)) && Browser::isBot()) {
            $data['$browser'] = 'Robot';
        }

        return array_filter($data);
    }

    public function track($event, $properties = [])
    {
        $properties = array_filter($properties);
        $data = $properties + $this->getData();

        if ($callbackClass = config("laravel-mixpanel.data_callback_class")) {
            $data = (new $callbackClass())->process($data);
            $data = array_filter($data);
        }

        parent::track($event, $data);
    }
}
