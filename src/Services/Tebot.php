<?php

namespace Explorin\Tebot\Services;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

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
    private $channelConfig = 'default';
    private $status = Response::HTTP_OK;
    private $title = 'Alert';
    private $message;
    private $detail;

    /**
     * Destructor to send the alert message automatically when the Tebot object is destroyed.
     */
    public function __destruct()
    {
        $this->send();
    }

    /**
     * Set the alert message and return the Tebot instance.
     *
     * @param  string  $message  The message to be sent as an alert.
     * @param  array  $detail  The detail to be sent as an alert.
     * @return self
     */
    public static function alert(string $message, array $detail = []): self
    {
        $instance = new self();
        $instance->title = '📢';
        $instance->message = $message;
        $instance->detail = $detail;
        return $instance;
    }

    /**
     * Set the info message and return the Tebot instance.
     *
     * @param  string  $message  The message to be sent as an alert.
     * @return self
     */
    public static function info(string $message): self
    {
        $instance = new self();
        $instance->title = '📢';
        $instance->message = $message;
        return $instance;
    }

    /**
     * Set the warning message and return the Tebot instance.
     *
     * @param  string  $message  The message to be sent as an alert.
     * @return self
     */
    public static function warning(string $message, array $detail = []): self
    {
        $instance = new self();
        $instance->title = '⚠️';
        $instance->message = $message;
        $instance->detail = $detail;
        return $instance;
    }

    /**
     * Set the error message and return the Tebot instance.
     *
     * @param  string  $message  The message to be sent as an alert.
     * @param  array  $detail  The detail to be sent as an alert.
     * @return self
     */
    public static function error(string $message, array $detail = []): self
    {
        $instance = new self();
        $instance->title = '🚫';
        $instance->message = $message;
        $instance->detail = $detail;
        return $instance;
    }

    /**
     * Set the channel configuration for the Tebot instance and return the instance.
     * @param  string  $channel  The name of the channel for which the configuration should be set.
     * @return self
     */
    public function channel(string $channel): self
    {
        $this->channelConfig = $channel;
        return $this;
    }

    /**
     * Set the status code for the alert message and return the Tebot instance.
     *
     * @param  int  $status  The HTTP status code to be included in the alert.
     * @return self
     */
    public function status(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Send the alert message with the specified status to the Tebot service.
     *
     * @return void
     */
    private function send(): void
    {
        $data = [
            'code'     => $this->status,
            'message'  => $this->message,
            'datetime' => Carbon::now()->toDateTimeString(),
        ];

        $config = config("tebot.$this->channelConfig");

        $data['title'] = $this->title . ' ' . $config['name'];

        if (!empty($this->detail)) $data['detail'] = json_encode($this->detail);

        Http::withHeaders(['x-api-key' => $config['key']])->post($config['url'] . '/api/message', $data);
    }

    /**
     * Send the alert message with the specified status to the Tebot service Now
     *
     * @return void
     */
    public function sendNow(): void
    {
        $this->send();
    }
}
