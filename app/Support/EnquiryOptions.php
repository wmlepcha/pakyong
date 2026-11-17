<?php

namespace App\Support;

/**
 * The fixed choices of the trip planner. Keep in step with Guard in resources/js/site.js.
 */
class EnquiryOptions
{
    public const TIERS = ['Base', 'Standard', 'Premium'];

    public const TRAVELLERS = ['Sikkim resident', 'Indian visitor', 'Foreign national'];

    public const SEASONS = ['Peak season', 'Shoulder season', 'Off-season', 'Not sure yet'];

    public const STAYS = ['Flexible, suggest for me', 'Homestays', 'Hotels', 'Resorts'];

    public const DAYS = [3, 4, 5, 6, 7, 8, 10];
}
