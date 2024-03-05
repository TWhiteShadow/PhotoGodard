<?php

namespace App\Message;

use App\Entity\FooterLinks;

class UpdateVisibilityFooterLink
{
    private $footerLink;

    public function __construct(FooterLinks $footerLink)
    {
        $this->footerLink = $footerLink;
    }

    /**
     * Get the value of footerLink.
     */
    public function getFooterLink(): FooterLinks
    {
        return $this->footerLink;
    }
}
