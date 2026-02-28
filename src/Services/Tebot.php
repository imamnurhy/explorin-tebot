<?php

namespace Explorin\Tebot\Services;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Tebot - A class for sending alert messages via HTTP to a Tebot service.
 *
 * This class provides a simple way to send alert messages to a Tebot service using HTTP POST requests.
 *
 * Example usage:
 *
 * Tebot::alert('Hai')->status(200);
 *
 * @package App\Services\Tebot
 */
class Tebot
{
    /* ========================
     | State
     |========================*/

    private string $channelConfig = 'default';
    private int $status = Response::HTTP_OK;
    private string $title = 'Alert';
    private ?string $message = null;
    private array $detail = [];

    private ?string $customKey = null;
    private ?string $customUrl = null;
    private ?string $customName = null;

    /* ========================
     | Static Entry
     |========================*/

    public static function alert(string $message, array $detail = []): self
    {
        $instance = new self();
        $instance->title = '📢';
        $instance->message = $message;
        $instance->detail = $detail;
        return $instance;
    }

    public static function info(string $message): self
    {
        $instance = new self();
        $instance->title = '📢';
        $instance->message = $message;
        return $instance;
    }

    public static function warning(string $message, array $detail = []): self
    {
        $instance = new self();
        $instance->title = '⚠️';
        $instance->message = $message;
        $instance->detail = $detail;
        return $instance;
    }

    public static function error(string $message, array $detail = []): self
    {
        $instance = new self();
        $instance->title = '🚫';
        $instance->message = $message;
        $instance->detail = $detail;
        return $instance;
    }

    /* ========================
     | Builder
     |========================*/

    public function channel(string $channel): self
    {
        $this->channelConfig = $channel;
        return $this;
    }

    public function status(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function withKey(string $key): self
    {
        $this->customKey = $key;
        return $this;
    }

    public function withUrl(string $url): self
    {
        $this->customUrl = $url;
        return $this;
    }

    public function withName(string $name): self
    {
        $this->customName = $name;
        return $this;
    }

    /**
     * Override semua config sekaligus (untuk DB multi-admin)
     */
    public function using(string $url, string $key, ?string $name = null): self
    {
        $this->customUrl = $url;
        $this->customKey = $key;
        $this->customName = $name;
        return $this;
    }

    /* ========================
     | Public Action
     |========================*/

    public function send(): bool
    {
        return $this->dispatch();
    }

    /* ========================
     | Internal Dispatcher
     |========================*/

    private function dispatch(): bool
    {
        $this->validate();

        $config = config("tebot.{$this->channelConfig}");

        $url  = $this->customUrl  ?? $config['url']  ?? null;
        $key  = $this->customKey  ?? $config['key']  ?? null;
        $name = $this->customName ?? $config['name'] ?? '';

        if (empty($url) || empty($key)) {
            throw new \InvalidArgumentException(
                "Tebot URL or Key not configured"
            );
        }

        $payload = [
            'code'     => $this->status,
            'message'  => $this->message,
            'datetime' => Carbon::now()->toDateTimeString(),
            'title'    => $this->title . ' ' . $name,
        ];

        if (!empty($this->detail)) {
            $payload['detail'] = json_encode($this->detail);
        }

        /**
         * Atomic Anti-Spam (race-condition safe)
         */
        $spamKey = 'tebot_spam_' . md5(
            $this->channelConfig .
                $this->status .
                $this->message .
                json_encode($this->detail)
        );

        // Set cache untuk mencegah spam yang sama dalam 60 detik
        if (!cache()->add($spamKey, true, now()->addSeconds(60))) {
            return false;
        }

        try { // Kirim request ke Tebot
            $response = Http::timeout(5)
                ->withHeaders(['x-api-key' => $key])
                ->post(rtrim($url, '/') . '/api/message', $payload);

            if (!$response->successful()) {

                Log::channel('tebot')->warning('Tebot HTTP Failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                throw new \RuntimeException(
                    'Tebot HTTP Failed: ' . $response->body(),
                    $response->status()
                );
            }

            Log::channel('tebot')->info('Tebot sent', [
                'channel' => $this->channelConfig,
                'code'    => $this->status,
            ]);

            return true;
        } catch (\Throwable $e) {

            Log::channel('tebot')->error('Tebot Exception', [
                'error' => $e->getMessage()
            ]);

            throw $e; // penting supaya queue bisa retry
        }
    }

    /* ========================
     | Validation
     |========================*/

    private function validate(): void
    {
        if (empty($this->message)) {
            throw new \InvalidArgumentException('Tebot message is required');
        }
    }
}
