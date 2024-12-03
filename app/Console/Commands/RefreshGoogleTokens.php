<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GoogleCredential;
use Google_Client;
use Carbon\Carbon;

class RefreshGoogleTokens extends Command
{
    protected $signature = 'google:refresh-tokens';
    protected $description = 'Refresh expired Google OAuth tokens';

    public function handle()
    {
        $client = new Google_Client();
        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));

        $expiredTokens = GoogleCredential::where('expires_at', '<=', Carbon::now())
            ->where('refresh_token', '!=', null)
            ->get();

        foreach ($expiredTokens as $credential) {
            try {
                $client->setRefreshToken($credential->refresh_token);
                $newToken = $client->fetchAccessTokenWithRefreshToken();

                $credential->update([
                    'access_token' => $newToken['access_token'],
                    'expires_at' => Carbon::now()->addSeconds($newToken['expires_in'])
                ]);

                $this->info("Refreshed token for user {$credential->user_id}");
            } catch (\Exception $e) {
                $this->error("Failed to refresh token for user {$credential->user_id}: {$e->getMessage()}");
            }
        }
    }
}