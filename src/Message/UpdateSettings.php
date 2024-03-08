<?php

namespace App\Message;

use App\Entity\Settings;

final class UpdateSettings
{
    private $setting;
    private $data;

    public function __construct(Settings $setting, ?array $data = null)
    {
        $this->setting = $setting;
        $this->data = $data;
    }

    public function getSetting(): Settings
    {
        return $this->setting;
    }

    /**
     * Get the value of data.
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}
