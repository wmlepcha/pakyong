<?php

return [
    'brand' => 'The Himalio Travels',
    // Registered business (from the Udyam certificate).
    'legal_name' => 'Himalio Edge Enterprises',
    'udyam' => 'UDYAM-SK-05-0002972',
    'email' => 'niteshchettri388@gmail.com',
    'address' => ['Bering, Kerabari', 'Pakyong, Sikkim 737106'],
    'phone' => '+91 74781 27403',
    'nav' => [
        'Destinations' => 'destinations',
        'Travel Guide' => 'guide',
        'Blog' => 'blog',
        'FAQ' => 'faq',
        'Contact' => 'contact',
    ],
    'slides' => [
        ['all-sikkim.webp', 'Sikkim Himalayas', 'The land of Kanchenjunga'],
        ['north.webp', 'Yumthang Valley', 'North Sikkim · 11,800 ft'],
        ['east.webp', 'Gangtok & Tsomgo Lake', 'East Sikkim · 12,400 ft'],
        ['west.webp', 'Pelling', 'West Sikkim · Views of Kanchenjunga'],
        ['south.webp', 'Ravangla & Namchi', 'South Sikkim · Tea gardens & Buddha Park'],
    ],
    'destinations' => [
        ['East Sikkim', 'Gangtok, Tsomgo Lake, Nathula', 'east.webp', '₹12,999'],
        ['North Sikkim', 'Lachung, Yumthang, Gurudongmar', 'north.webp', '₹18,999'],
        ['West Sikkim', 'Pelling, Khecheopalri, Rabdentse', 'west.webp', '₹14,999'],
        ['South Sikkim', 'Namchi, Ravangla, Temi Tea Garden', 'south.webp', '₹11,999'],
        // Draft: image is a stand-in, prices not set yet (null shows no price).
        ['Darjeeling', 'Tiger Hill, tea gardens, toy train', 'all-sikkim.webp', null],
        ['Kalimpong', 'Deolo Hill, monasteries, nurseries', 'all-sikkim.webp', null],
    ],
    'why' => [
        ['Local experts', 'Born-and-raised Sikkim drivers and guides who know every road and monastery.'],
        ['Permits handled', 'We arrange Protected Area Permits for North Sikkim and Nathula.'],
        ['Custom itineraries', 'Family, honeymoon or group trips planned around your dates and budget.'],
        ['24/7 support', 'A real person on WhatsApp from the day you book to the day you return.'],
    ],
    // Placeholder copy: replace packages, prices and reviews with real ones.
    'packages' => [
        ['Gangtok & Pelling Classic', '6N / 7D', 'west.webp', '₹16,999', ['Gangtok city & Tsomgo Lake', 'Pelling sky walk', 'Pemayangtse Monastery']],
        ['North Sikkim Explorer', '5N / 6D', 'north.webp', '₹21,999', ['Lachung & Yumthang Valley', 'Gurudongmar Lake', 'Permits included']],
        ['Sikkim Grand Circuit', '8N / 9D', 'all-sikkim.webp', '₹29,999', ['East, West, South & North', 'Ravangla Buddha Park', 'Private cab throughout']],
        ['South Sikkim Retreat', '3N / 4D', 'south.webp', '₹11,999', ['Ravangla & Namchi', 'Temi Tea Garden', 'Buddha Park & Char Dham']],
        ['Offbeat West Sikkim', '5N / 6D', 'west.webp', '₹15,999', ['Yuksom & Dzongri trail', 'Khecheopalri Lake', 'Village homestays']],
    ],
    'experiences' => [
        ['Monastery trails', 'Rumtek, Pemayangtse and Tashiding, at prayer time.', 'west.webp'],
        ['Trekking', 'Dzongri, Goecha La and gentle village walks.', 'north.webp'],
        ['River rafting', 'Teesta and Rangit rapids, grade II to IV.', 'south.webp'],
        ['Cable car rides', 'Gangtok ropeway above the city rooftops.', 'east.webp'],
        ['Tea gardens', 'Temi estate, the only tea garden in Sikkim.', 'south.webp'],
        ['Yak safaris', 'Ride a yak at Tsomgo Lake and Nathula.', 'all-sikkim.webp'],
    ],
    'seasons' => [
        ['March to May', 'Spring', 'Rhododendrons in full bloom, clear skies.', 'bg-[#f3e0d9]'],
        ['June to September', 'Monsoon', 'Lush valleys, waterfalls, fewer crowds.', 'bg-[#d8e5c9]'],
        ['October to November', 'Autumn', 'Crystal views of Kanchenjunga.', 'bg-[#f1dfb5]'],
        ['December to February', 'Winter', 'Snow in Lachung and Yumthang.', 'bg-[#d5e3ea]'],
    ],
    'steps' => [
        ['Tell us your plan', 'Share dates, group size and interests through the form or WhatsApp.'],
        ['Get a custom itinerary', 'We send a day-by-day plan with a transparent price within a day.'],
        ['Pack and go', 'We handle cabs, stays and permits. You enjoy the mountains.'],
    ],
    'reviews' => [
        ['Priya S.', 'Kolkata', 'Our driver knew every viewpoint and never rushed us. Gurudongmar at sunrise was unforgettable.', 'North Sikkim Explorer'],
        ['Rahul & Meera', 'Delhi', 'Honeymoon in Pelling, perfectly planned. Hotels, food and timing were all spot on.', 'Gangtok & Pelling Classic'],
        ['The Thapa family', 'Siliguri', 'Travelled with two kids and grandparents. Zero stress, constant WhatsApp support.', 'Sikkim Grand Circuit'],
    ],
];
