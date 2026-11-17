<?php

/*
 * Travel Guide content. Distances, timings and altitudes are approximate;
 * verify against current local conditions before publishing.
 */
return [
    'intro' => 'Sikkim packs Himalayan peaks, gurgling streams, rich culture, monasteries, flora and fauna into one small state. This guide covers what to know before you book: when to go, how to get here, where to stay, what each region offers and how to stay safe at altitude.',

    'facts' => [
        ['Capital', 'Gangtok'],
        ['Highest peak', 'Kanchenjunga, 8,586 m'],
        ['Languages', 'Nepali, Bhutia, Lepcha, Hindi, English'],
        ['Time zone', 'Indian Standard Time'],
        ['Nearest airports', 'Bagdogra and Pakyong'],
        ['Nearest railhead', 'New Jalpaiguri (NJP)'],
        ['Altitude range', '~300 m to 5,400 m on tourist routes'],
        ['Best months', 'March–May and October–November'],
    ],

    'overview' => [
        'Sikkim is one of India\'s smallest states, but it rises from subtropical river valleys to snow peaks above 8,000 metres. That range is why a single trip can include rhododendron forests, tea gardens, alpine lakes and 17th-century monasteries.',
        'The state is traditionally divided into four regions: East (Gangtok, Tsomgo Lake, Nathula), North (Lachung, Lachen, Yumthang, Gurudongmar), West (Pelling, Yuksom, Khecheopalri) and South (Namchi, Ravangla, Temi). Most first trips combine two or three of them. Distances look short on a map, but mountain roads are slow, so plan on roughly 30 to 40 km per hour.',
        'Sikkim is a Buddhist-majority state with Lepcha, Bhutia and Nepali communities, and a large Hindu population. Expect prayer flags on every ridge, monasteries within a short drive of almost every town, and a calm pace that rewards slow travel.',
    ],

    'seasons' => [
        ['March – May', 'Spring', 'Pleasant days in Gangtok and Pelling, and rhododendrons in bloom around Yumthang and Lachung, especially in April and May. Clear mornings, and roads to the north are usually open. This is a peak season, so book early.', 'Peak season', [2, 3, 4]],
        ['June – September', 'Monsoon', 'Heavy rain, waterfalls at full flow and lush green valleys. Landslides can close the Siliguri–Gangtok highway and the North Sikkim roads for hours or days, so keep your plans flexible. Hotels are cheaper and the crowds are thin.', 'Low season', [5, 6, 7, 8]],
        ['October – November', 'Autumn', 'The clearest skies of the year and the best views of Kanchenjunga from Pelling and Gangtok. Days are comfortable and nights get cold at altitude. This is the other peak season.', 'Peak season', [9, 10]],
        ['December – February', 'Winter', 'Cold, with snow at Lachung, Yumthang, Tsomgo Lake and Nathula. Gangtok and Pelling are cool and clear. Some high roads close after snowfall, and Gurudongmar Lake may be frozen or inaccessible on some days.', 'Cold, snow up north', [11, 0, 1]],
    ],
    // Month quality for the calendar, Jan to Dec: peak, good, wet, cold.
    'calendar' => ['cold', 'cold', 'good', 'peak', 'peak', 'wet', 'wet', 'wet', 'wet', 'peak', 'peak', 'cold'],
    'seasons_note' => 'Dates are approximate and conditions change from year to year. We check road and weather status before every departure.',

    'getting_there' => [
        ['By air: Bagdogra (IXB)', 'The main gateway, near Siliguri in West Bengal, about 125 km from Gangtok. The drive takes roughly 4 to 5 hours depending on traffic and roadworks. Bagdogra is connected to major Indian cities.', '~125 km · 4–5 h'],
        ['By air: Pakyong (PYG)', 'Sikkim\'s own airport, around 30 km from Gangtok. Flights are limited and weather dependent, so check the current schedule and keep a buffer day if you have a connecting flight.', '~30 km · about 1 h'],
        ['By rail: New Jalpaiguri (NJP)', 'Sikkim has no railway station of its own. NJP and Siliguri Junction are the usual railheads, about 4 to 5 hours by road from Gangtok.', '~4–5 h by road'],
        ['By road', 'The Siliguri–Gangtok route runs along the Teesta river via Rangpo, the state\'s entry check post. You can also enter from Darjeeling and Kalimpong. We arrange pick-ups at Bagdogra, NJP, Siliguri or Pakyong.', 'Via NH10 and Rangpo'],
    ],

    'getting_around' => [
        'Within Sikkim, travel is by road. Shared jeeps connect the main towns cheaply but run on fixed schedules. For sightseeing, a private cab with a local driver is the practical choice, and for the north and the high-altitude routes it is effectively required.',
        'Approximate drive times from Gangtok: Tsomgo Lake 1.5–2 hours, Nathula 2.5–3 hours, Ravangla about 3 hours, Namchi about 3 hours, Pelling 5–6 hours, Lachung 5–6 hours. Allow extra time in the monsoon.',
        'Drivers avoid mountain roads after dark. Start days early, particularly for Gurudongmar Lake, which usually means leaving Lachen before dawn.',
    ],

    // Hours are the upper end of the usual range, for the bar chart.
    'drive' => [
        ['Tsomgo Lake', '1.5–2 h', 2], ['Nathula', '2.5–3 h', 3], ['Ravangla', '~3 h', 3], ['Namchi', '~3 h', 3],
        ['Pelling', '5–6 h', 6], ['Lachung', '5–6 h', 6],
    ],

    'regions' => [
        [
            'name' => 'East Sikkim', 'high' => 'Nathula, 14,140 ft', 'base' => 'Gangtok', 'days' => '3 to 4 days', 'img' => 'east.webp',
            'about' => 'The capital and the easiest base. Gangtok has the widest choice of hotels, restaurants and cabs, and day trips reach the high passes on the Tibet border.',
            'highlights' => ['MG Marg, the pedestrian promenade, for an evening walk', 'Rumtek Monastery, seat of the Karmapa tradition', 'Enchey Monastery, Tashi Viewpoint and Ganesh Tok', 'Hanuman Tok and the Gangtok ropeway', 'Tsomgo (Changu) Lake at about 12,400 ft, with yak rides nearby', 'Baba Mandir and Nathula Pass at about 14,140 ft (permit needed, and Nathula is closed on some days of the week)'],
        ],
        [
            'name' => 'North Sikkim', 'high' => 'Gurudongmar, 17,800 ft', 'base' => 'Lachung and Lachen', 'days' => '3 to 4 days', 'img' => 'north.webp',
            'about' => 'The wild, high-altitude side of Sikkim: river gorges, waterfalls, alpine valleys and Sikkim\'s most famous lake. Facilities are simple and the weather can change quickly, so book with a team that knows the roads.',
            'highlights' => ['Seven Sisters and Naga waterfalls on the way up', 'Lachung village and its monastery', 'Yumthang Valley at about 11,800 ft, known for rhododendrons in spring', 'Yumesamdong (Zero Point) at about 15,300 ft, weather permitting', 'Gurudongmar Lake at about 17,800 ft, one of the highest lakes in the world', 'Thangu and Chopta Valley, high meadows near the Tibet plateau'],
        ],
        [
            'name' => 'West Sikkim', 'high' => 'Dzongri trek, ~13,000 ft', 'base' => 'Pelling', 'days' => '3 days', 'img' => 'west.webp',
            'about' => 'The closest views of Kanchenjunga, along with the oldest monasteries and Sikkim\'s first capital. It suits families, honeymooners and anyone who wants slower days.',
            'highlights' => ['Pemayangtse Monastery, one of the oldest in the state', 'Rabdentse ruins, the second capital of the Chogyal kings', 'Rimbi Waterfall and the Pelling Skywalk', 'Khecheopalri Lake, a sacred lake surrounded by forest', 'Yuksom, the first capital, and the start of the Dzongri trek', 'Tashiding Monastery on its hilltop'],
        ],
        [
            'name' => 'South Sikkim', 'high' => 'Ravangla, ~7,000 ft', 'base' => 'Ravangla and Namchi', 'days' => '2 days', 'img' => 'south.webp',
            'about' => 'Gentler, greener and closer to the plains, which makes it a good first or last stop. Its tea gardens and large statues are easy to reach by road.',
            'highlights' => ['Buddha Park at Ravangla, with its giant seated Buddha', 'Temi Tea Garden, Sikkim\'s only tea estate', 'Maenam Hill for sunrise walks', 'Samdruptse and the Char Dham pilgrim complex at Namchi', 'Village homestays with local food'],
        ],
    ],

    'itineraries' => [
        [
            'name' => 'Gangtok & Pelling Classic', 'length' => '6 nights / 7 days', 'summary' => 'A relaxed first trip: city, lakes, monasteries and Kanchenjunga views.',
            'days' => [
                'Arrive at Bagdogra or NJP and drive to Gangtok. Evening on MG Marg.',
                'Gangtok sightseeing: Enchey Monastery, Tashi Viewpoint, Ganesh Tok, Hanuman Tok and the ropeway.',
                'Tsomgo Lake and Baba Mandir (Nathula as permits and weather allow).',
                'Drive to Pelling via Ravangla and Temi Tea Garden, with a stop at Buddha Park.',
                'Pelling: Pemayangtse Monastery, Rabdentse ruins, Rimbi Waterfall and the Skywalk.',
                'Khecheopalri Lake and a slow afternoon in Pelling.',
                'Drive to Bagdogra or NJP for your onward journey.',
            ],
        ],
        [
            'name' => 'North Sikkim Explorer', 'length' => '5 nights / 6 days', 'summary' => 'Lachung, Yumthang and Gurudongmar for travellers who want the high country.',
            'days' => [
                'Arrive and drive to Gangtok. Rest and acclimatise.',
                'Gangtok to Lachung, stopping at waterfalls along the way.',
                'Yumthang Valley in the morning, Zero Point if weather permits, then drive to Lachen.',
                'Leave before dawn for Gurudongmar Lake, then return towards Gangtok (a long day).',
                'Free day in Gangtok for rest, shopping or Rumtek Monastery.',
                'Drive to Bagdogra or NJP for your onward journey.',
            ],
        ],
        [
            'name' => 'Sikkim Grand Circuit', 'length' => '8 nights / 9 days', 'unit' => 'Stop', 'summary' => 'All four regions in one trip.',
            'days' => [
                'Gangtok (2 nights): city sights, Tsomgo Lake and Nathula.',
                'Lachung (1 night): Yumthang Valley.',
                'Lachen (1 night): Gurudongmar Lake.',
                'Gangtok (1 night): rest day and Rumtek.',
                'Pelling (2 nights): monasteries, Rabdentse, Khecheopalri and Kanchenjunga views.',
                'Ravangla (1 night): Buddha Park and Temi Tea Garden, then departure the next morning.',
            ],
        ],
    ],
    'itineraries_note' => 'These are samples. Every trip is built around your dates, pace and budget, so tell us what you want to see and we will adjust the route.',

    'altitudes' => [
        ['Siliguri / Bagdogra', '~120 m', 120],
        ['Namchi', '~1,675 m (5,500 ft)', 1675],
        ['Gangtok', '~1,650 m (5,400 ft)', 1650],
        ['Pelling', '~2,080 m (6,800 ft)', 2080],
        ['Ravangla', '~2,130 m (7,000 ft)', 2130],
        ['Lachen', '~2,750 m (9,000 ft)', 2750],
        ['Lachung', '~2,900 m (9,600 ft)', 2900],
        ['Yumthang Valley', '~3,600 m (11,800 ft)', 3600],
        ['Tsomgo Lake', '~3,780 m (12,400 ft)', 3780],
        ['Nathula Pass', '~4,310 m (14,140 ft)', 4310],
        ['Gurudongmar Lake', '~5,430 m (17,800 ft)', 5430],
    ],
    'health' => [
        'Altitude sickness can affect anyone, regardless of fitness. Symptoms include headache, nausea, dizziness and unusual tiredness.',
        'Gain height gradually. Spend a night in Gangtok before heading to Lachung, and avoid rushing straight to Gurudongmar.',
        'Drink plenty of water, eat light, and skip alcohol and smoking at high altitude.',
        'If symptoms get worse, descend. Tell your driver or guide early, and do not wait for a bad night.',
        'Travellers with heart or lung conditions, young children and older travellers should check with their doctor before North Sikkim. Carry your regular medicines and a basic first-aid kit.',
        'Keep your travel plan flexible: weather, not the itinerary, decides when the high passes can be visited.',
    ],

    'packing_always' => ['Photo ID (original and photocopies)', 'Passport-size photographs for permits', 'Comfortable walking shoes with grip', 'Sunscreen, sunglasses and a hat', 'Power bank and a reusable water bottle', 'Regular medicines and a small first-aid kit'],
    'packing' => [
        ['Spring and autumn', ['Layers: a light jacket and a fleece', 'A warm jacket for North Sikkim nights', 'A light rain shell']],
        ['Monsoon', ['A good raincoat or poncho', 'Quick-dry clothing and spare socks', 'Waterproof cover for bags and electronics']],
        ['Winter and high altitude', ['Thermal innerwear and woollens', 'Insulated jacket, gloves, cap and scarf', 'Waterproof, warm boots']],
    ],

    'food' => [
        ['Momos and thukpa', 'Steamed dumplings and noodle soup, found everywhere from street stalls to hotels.'],
        ['Gundruk and sinki soup', 'Fermented leafy-green soup, a traditional Sikkimese staple.'],
        ['Sel roti', 'A ring-shaped rice bread, usually eaten at festivals and tea time.'],
        ['Phagshapa', 'Pork strips stewed with radish and chillies.'],
        ['Chhurpi', 'A hard local cheese made from yak or cow milk.'],
        ['Temi tea and tongba', 'Sikkim\'s own tea, and a warm millet drink sipped through a bamboo straw.'],
    ],
    // Food photos from Wikimedia Commons: [dish, author, licence, licence URL, source page].
    'food_credits' => [
        'momos-and-thukpa' => ['Momos', 'SristiAwasthi21', 'CC0', 'http://creativecommons.org/publicdomain/zero/1.0/deed.en', 'https://commons.wikimedia.org/wiki/File:Steam_Momo_%E2%80%93_Traditional_Nepalese_Dumpling.jpg'],
        'gundruk-and-sinki-soup' => ['Gundruk soup', 'Ser Amantio di Nicolao', 'CC BY-SA 4.0', 'https://creativecommons.org/licenses/by-sa/4.0', 'https://commons.wikimedia.org/wiki/File:Gundruk_soup_at_Nepal_House_in_Baltimore.jpg'],
        'sel-roti' => ['Sel roti', 'Physics Ramesh', 'CC BY-SA 4.0', 'https://creativecommons.org/licenses/by-sa/4.0', 'https://commons.wikimedia.org/wiki/File:Sel_roti123.jpg'],
        'chhurpi' => ['Chhurpi', 'Krish Dulal', 'CC BY-SA 3.0', 'https://creativecommons.org/licenses/by-sa/3.0', 'https://commons.wikimedia.org/wiki/File:Chhurpi_Nep.jpg'],
        'temi-tea-and-tongba' => ['Tongba', 'Bhattaraibinod3', 'CC BY-SA 4.0', 'https://creativecommons.org/licenses/by-sa/4.0', 'https://commons.wikimedia.org/wiki/File:Nepali_Tongba_-_Nepalese_fermented_millet_beer.JPG'],
    ],

    'food_note' => 'Vegetarian food is easy to find, and we can arrange meals to suit dietary needs.',

    'culture' => [
        ['Monasteries', 'Remove your shoes before entering, dress modestly, speak softly, and ask before photographing inside. Walk clockwise around prayer wheels and stupas.'],
        ['Festivals', 'Losar (Tibetan New Year, around February or March), Saga Dawa (around May or June), Pang Lhabsol (around August or September) and Losoong (around December) are the major ones. Dates follow the lunar calendar and change each year.'],
        ['People', 'Greet with a smile or a folded-hands "namaste". Ask before taking portraits, and be sensitive around villages and homes.'],
    ],

    'money' => [
        ['Cash and ATMs', 'ATMs are available in Gangtok, Pelling, Namchi and Ravangla. They are scarce or absent in Lachung, Lachen and other remote areas, so carry enough cash before heading north.'],
        ['Mobile network', 'Coverage is good in the main towns and patchy elsewhere. Expect little or no signal in much of North Sikkim and at high passes. Tell family you may be out of touch for a day or two.'],
        ['Wi-Fi', 'Most hotels in towns offer Wi-Fi, but speeds can be slow and it may drop in bad weather.'],
    ],

    'coverage' => [
        ['Gangtok', 'Plenty', 'Good'],
        ['Pelling, Ravangla, Namchi', 'Available', 'Good in town'],
        ['Lachung and Lachen', 'Scarce or none', 'Patchy'],
        ['Yumthang, Gurudongmar and high passes', 'None', 'Little or none'],
    ],

    'responsible' => [
        'Carry your waste back to the hotel and avoid single-use plastic.',
        'Stay on marked paths, and do not pick flowers or disturb wildlife.',
        'Khecheopalri and Gurudongmar are sacred lakes. Keep a respectful distance and do not swim or wash in them.',
        'Photography near military and border areas, including Nathula, may be restricted. Follow the guidance of your driver and the signs. Ask before flying a drone anywhere.',
        'Choose locally owned homestays where you can. It keeps the money in the village.',
    ],
];
