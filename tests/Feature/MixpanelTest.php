<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Mobiverse\LaravelMixpanel\Events\MixpanelEvent;
use Mobiverse\LaravelMixpanel\Listeners\MixpanelEventListener;
use Mobiverse\LaravelMixpanel\Tests\Fixtures\App\Models\User;

it(
    'can identify',
    function () {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')
            ->with('name')
            ->andReturn('George');
        $user->shouldReceive('getAttribute')
            ->with('first_name')
            ->andReturn(null);
        $user->shouldReceive('getAttribute')
            ->with('last_name')
            ->andReturn(null);
        $user->shouldReceive('getAttribute')
            ->with('email')
            ->andReturn('testuser@example.com');
        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(1);
        $user->shouldReceive('getAttribute')
            ->with('created_at')
            ->andReturn(now()->toDateTimeString());
        $user->shouldReceive('getKey')
            ->andReturn(1);

        $mpel = new MixpanelEventListener();
        $mpel->handle(new MixpanelEvent($user, ['User: Registered' => []]));
    }
)->expectNotToPerformAssertions();
