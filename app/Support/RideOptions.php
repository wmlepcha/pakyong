<?php

namespace App\Support;

/**
 * The fixed choices of the Book a ride form. Keep in step with Guard in resources/js/site.js.
 */
class RideOptions
{
    public const DISTRICTS = ['Gangtok', 'Pakyong', 'Mangan', 'Namchi', 'Gyalshing', 'Soreng', 'Darjeeling', 'Kalimpong', 'Siliguri', 'Other'];

    public const CARS = ['4 seater', '7 seater'];
}
