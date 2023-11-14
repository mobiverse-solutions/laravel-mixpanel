<?php

namespace Mobiverse\LaravelMixpanel\Listeners;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Mobiverse\LaravelMixpanel\Events\MixpanelEvent;

/**
 * Handle the TariffPlanUpdated event.
 */
class MixpanelEventListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(MixpanelEvent $event): void
    {
        $user = $event->user;

        if ($user && config("laravel-mixpanel.enable-default-tracking")) {
            $profileData = $this->getProfileData($user);
            $profileData = array_merge($profileData, $event->profileData);

            app('mixpanel')->identify($user->getKey());
            app('mixpanel')->people->set($user->getKey(), $profileData, request()->ip());

            if ($event->charge !== 0) {
                app('mixpanel')->people->trackCharge($user->id, $event->charge);
            }

            foreach ($event->trackingData as $eventName => $data) {
                app('mixpanel')->track($eventName, $data);
            }
        }

    }

    private function getProfileData($user): array
    {
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        if ($user->name) {
            $nameParts = explode(' ', $user->name);
            array_filter($nameParts);
            $lastName = array_pop($nameParts);
            $firstName = implode(' ', $nameParts);
        }

        $data = [
            '$first_name' => $firstName,
            '$last_name' => $lastName,
            '$name' => $user->name,
            '$email' => $user->email,
            '$created' => ($user->created_at
                ? (new Carbon())
                    ->parse($user->created_at)
                    ->format('Y-m-d\Th:i:s')
                : null),
        ];
        array_filter($data);

        return $data;
    }
}
