<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 22.01.2020
 */

namespace Appus\Admin\Messages;

use Illuminate\Contracts\Session\Session;

class Message
{

    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $text
     * @param string $type
     * @return bool
     */
    public function send(string $text, string $type): bool
    {
        $this->session->start();
        $notifications = $this->getMessages();
        $notifications[] = [
            'text' => $text,
            'type' => $type,
        ];
        $this->session->put('notifications', json_encode($notifications));
        return true;
    }

    /**
     * @param string $text
     * @return bool
     */
    public function success(string $text): bool
    {
        return $this->send($text, 'success');
    }

    /**
     * @param string $text
     * @return bool
     */
    public function error(string $text): bool
    {
        return $this->send($text, 'danger');
    }

    /**
     * @param string $text
     * @return bool
     */
    public function info(string $text): bool
    {
        return $this->send($text, 'info');
    }

    /**
     * @param string $text
     * @return bool
     */
    public function warning(string $text): bool
    {
        return $this->send($text, 'warning');
    }

    /**
     * @param bool $isJson
     * @return array|mixed
     */
    public function getMessages(bool $isJson = false)
    {
        $notifications = $this->session->pull('notifications') ?? null;
        if (!empty($notifications) && !$isJson) {
            $notifications = json_decode($notifications, true);
        }
        return $notifications;
    }

}
