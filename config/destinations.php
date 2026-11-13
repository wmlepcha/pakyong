<?php

/*
 * Destination detail pages. Keys are the slug of the destination name.
 * Temperatures, distances, drive times and altitudes are approximate: confirm before publishing.
 *
 * calendar: Jan to Dec, one of peak | good | wet | cold
 * seasons : [name, months, typical temperature, one-line mood, longer text, what to wear[]]
 * places  : [name, type, description, how far or how high]
 * getting : [route, detail, time tag]
 */
return [
    'east-sikkim' => [
        'name' => 'East Sikkim', 'short' => 'East', 'img' => 'east.jpeg', 'base' => 'Gangtok', 'days' => '3 to 4 days',
        'high' => 'Nathula, 14,140 ft', 'elev' => 'Gangtok sits at about 5,400 ft',
        'tagline' => 'The capital, a high-altitude lake and the Tibet border pass.',
        'good_for' => ['First-time visitors', 'Families', 'Monasteries', 'Short trips'],
        'about' => [
            'East Sikkim is where most trips begin. Gangtok has the widest choice of hotels, restaurants and cabs, and from it you can reach Tsomgo Lake and Nathula Pass in a day.',
            'The city itself is steep, clean and walkable around MG Marg. Beyond it, the road climbs through pine and rhododendron forest to cold, open country on the old trade route to Tibet.',
        ],
        'calendar' => ['cold', 'cold', 'good', 'peak', 'peak', 'wet', 'wet', 'wet', 'wet', 'peak', 'peak', 'cold'],
        'seasons' => [
            ['Spring', 'March – May', '12–24°C', 'Mild days, flowers in the forest', 'Gangtok is pleasant and the forests around Tsomgo and Kyongnosla bloom with rhododendrons, mostly in April and May. Tsomgo and Nathula stay cold, and late snow is possible in March. This is one of the two best seasons.', ['Light layers and a fleece', 'A windproof jacket for Tsomgo and Nathula', 'Comfortable walking shoes', 'Sunglasses and sunscreen']],
            ['Monsoon', 'June – September', '17–25°C', 'Green, wet and quiet', 'Heavy rain and low cloud often hide the views. Landslides can slow or close the highway and the road to Tsomgo. Waterfalls are at their best and hotels are cheaper, so keep your plans flexible.', ['A good raincoat or poncho', 'Quick-dry clothes and spare socks', 'Waterproof shoes with grip', 'Waterproof cover for bags and phones']],
            ['Autumn', 'October – November', '10–22°C', 'Clearest skies of the year', 'The best time for Kanchenjunga views from Tashi Viewpoint and the city. Days are comfortable, mornings and evenings turn cold, and Tsomgo can drop close to freezing at night.', ['A fleece plus a light down jacket', 'Scarf and cap for early mornings', 'Closed shoes with grip', 'Sunglasses']],
            ['Winter', 'December – February', '4–14°C', 'Cold, with snow at the passes', 'Gangtok is cool and clear. Tsomgo Lake freezes and Nathula is usually under snow and well below zero. Roads to the passes can close after snowfall, so we check conditions before each trip.', ['Thermal innerwear', 'A heavy down or insulated jacket', 'Gloves, cap and scarf', 'Waterproof, warm boots for snow']],
        ],
        'pack_always' => ['Photo ID (original and copies) for permits', 'Passport-size photographs', 'Sunscreen, sunglasses and a hat', 'Power bank and a reusable water bottle', 'Regular medicines and a small first-aid kit'],
        'places' => [
            ['MG Marg', 'Promenade', 'Gangtok\'s pedestrian-only main street, best for an evening walk, food and shopping.', 'In Gangtok'],
            ['Rumtek Monastery', 'Monastery', 'A large monastery and the seat of the Karmapa lineage in Sikkim, with a wide courtyard and a golden stupa.', 'About 1 hour from Gangtok'],
            ['Enchey Monastery', 'Monastery', 'A small, calm monastery above the city, known for its mask dances at festival time.', '10 minutes from MG Marg'],
            ['Tashi Viewpoint', 'Viewpoint', 'Sunrise views of Kanchenjunga and the Himalayan range on clear mornings.', 'About 8 km from Gangtok'],
            ['Ganesh Tok and Hanuman Tok', 'Temples', 'Two hilltop temples with wide views over the city and the valley.', 'Short drives from the city'],
            ['Gangtok Ropeway', 'Experience', 'A cable car ride above the city rooftops, good for an easy first look at the valley.', 'In Gangtok'],
            ['Do Drul Chorten', 'Stupa', 'A large white stupa ringed by 108 prayer wheels, built in 1945 and a calm stop in the middle of the city.', 'In Gangtok'],
            ['Tsomgo (Changu) Lake', 'Lake', 'A glacial lake at about 12,400 ft that freezes in winter. The road passes Kyongnosla Alpine Sanctuary, and yak rides are offered nearby.', 'About 1.5 to 2 hours'],
            ['Baba Mandir and Nathula Pass', 'Border pass', 'A memorial temple and the India–China border pass at about 14,140 ft. Permit needed, open on selected days.', 'About 2.5 to 3 hours'],
        ],
        'getting' => [
            ['From Bagdogra airport', 'About 125 km by road to Gangtok, depending on traffic and roadworks.', '4–5 hours'],
            ['From New Jalpaiguri (NJP) station', 'The usual railhead for Sikkim, with pick-ups arranged by us.', '4–5 hours'],
            ['From Pakyong airport', 'Sikkim\'s own airport, with limited flights that depend on weather.', 'About 1 hour'],
            ['Around East Sikkim', 'Tsomgo Lake takes 1.5 to 2 hours from Gangtok, Nathula 2.5 to 3 hours and Rumtek about 1 hour.', 'Day trips'],
        ],
        'permits' => 'Tsomgo Lake and Nathula Pass need permits, which we arrange through registered channels. Share your photo ID copies in advance. Nathula is usually open on selected days of the week and can close in bad weather.',
        'stay' => 'Gangtok has the widest choice, from budget hotels to boutique stays near MG Marg and quieter homestays on the ridge. Book early in April, May, October and November.',
        'itinerary' => [
            'Arrive in Gangtok and settle in. Evening walk on MG Marg.',
            'City day: Enchey Monastery, Tashi Viewpoint, Ganesh Tok, Hanuman Tok and the ropeway.',
            'Tsomgo Lake and Baba Mandir. Nathula if it is open and the weather allows.',
            'Rumtek Monastery in the morning, then depart.',
        ],
        'tips' => [
            'Start early for Tsomgo and Nathula: clouds often roll in by midday.',
            'Gangtok is steep. Wear comfortable shoes with grip.',
            'Nathula is at about 14,140 ft. Move slowly, drink water and do not rush.',
            'Photography is restricted near the border. Follow the guidance of your driver and the signs.',
        ],
        'faqs' => [
            ['Is Nathula always open?', 'No. It is open on selected days of the week and can close in bad weather or after snowfall. We check before your trip and offer an alternative if it is shut.'],
            ['How many days do I need for East Sikkim?', 'Three to four days is comfortable: one for Gangtok, one for Tsomgo and Nathula, and a day for Rumtek or a slower pace.'],
            ['Will I see snow?', 'Often, from December to March at Tsomgo and Nathula. Gangtok itself rarely gets snow.'],
        ],
    ],

    'north-sikkim' => [
        'name' => 'North Sikkim', 'short' => 'North', 'img' => 'north.jpeg', 'base' => 'Lachung and Lachen', 'days' => '3 to 4 days',
        'high' => 'Gurudongmar, 17,800 ft', 'elev' => 'Lachung sits at about 9,600 ft',
        'tagline' => 'River gorges, rhododendron valleys and one of the highest lakes on earth.',
        'good_for' => ['Adventure', 'Photography', 'Mountain scenery', 'Slow travel'],
        'about' => [
            'North Sikkim is the wild, high-altitude side of the state: deep river gorges, waterfalls, alpine valleys and Gurudongmar Lake near the Tibet border. Facilities are simple, the weather can change quickly and permits are required.',
            'Most trips use Lachung for Yumthang Valley and Zero Point, and Lachen as the base for Gurudongmar. We plan it with a night at each so your body can adjust to the height.',
        ],
        'calendar' => ['cold', 'cold', 'good', 'peak', 'peak', 'wet', 'wet', 'wet', 'good', 'peak', 'good', 'cold'],
        'seasons' => [
            ['Spring', 'March – May', '3–15°C', 'Rhododendrons in bloom', 'Yumthang Valley flowers in April and May, and the roads are mostly open. Lachung is cold, Zero Point still has snow, and Gurudongmar is freezing in the mornings. This is peak season, so book early.', ['Down jacket and thermals', 'Gloves, warm cap and scarf', 'Windproof outer layer', 'Sturdy shoes with grip']],
            ['Monsoon', 'June – September', '8–18°C', 'Lush, with road delays', 'Valleys turn green and waterfalls are at full flow, but landslides can close roads for hours or days. Cloud often hides the views. Keep your plans flexible and allow spare days.', ['Raincoat or poncho', 'Warm layers, evenings are cold', 'Waterproof boots', 'Quick-dry clothes']],
            ['Autumn', 'October – November', '2–14°C', 'Crisp air and the clearest skies', 'The best weather for Gurudongmar and the high valleys. Days are bright, nights are very cold, and the first snow can arrive late in November.', ['Heavy down jacket', 'Thermal innerwear', 'Gloves, cap and scarf', 'Sunglasses and sunscreen']],
            ['Winter', 'December – February', '−8 to 6°C', 'Snow and closed roads', 'Heavy snow covers Lachung and Yumthang. Roads and Gurudongmar are often closed, so it suits travellers who love snow and accept that plans can change at the last minute.', ['Heavy insulated jacket', 'Two layers of thermals', 'Snow boots, gloves and balaclava', 'Hand and foot warmers']],
        ],
        'pack_always' => ['Photo ID (original and copies) for permits', 'Passport-size photographs', 'Cash, as ATMs are scarce or absent', 'Sunscreen, sunglasses and lip balm', 'Water bottle, snacks and regular medicines'],
        'places' => [
            ['Seven Sisters and Naga waterfalls', 'Waterfall', 'Roadside waterfalls on the drive north, good places to stop and stretch.', 'On the way to Lachung'],
            ['Chungthang', 'Confluence', 'Where the Lachen and Lachung rivers meet to form the Teesta, and where the road splits.', 'Halfway to the north'],
            ['Lachung village and monastery', 'Village', 'A mountain village with a small monastery and a good base for Yumthang.', 'About 5 to 6 hours from Gangtok'],
            ['Yumthang Valley', 'Valley', 'A wide valley at about 11,800 ft, known for rhododendrons in spring and hot springs nearby.', 'About 1.5 hours from Lachung'],
            ['Yumesamdong (Zero Point)', 'High point', 'A snow-covered high plateau at about 15,300 ft, weather and road permitting.', 'Beyond Yumthang'],
            ['Lachen village', 'Village', 'A quiet Bhutia village and the usual overnight stop before Gurudongmar.', 'About 2 to 3 hours from Lachung'],
            ['Thangu and Chopta Valley', 'Meadow', 'High meadows close to the Tibet plateau, with sweeping views.', 'On the road to Gurudongmar'],
            ['Gurudongmar Lake', 'Lake', 'One of the highest lakes in the world, at about 17,800 ft, sacred to Buddhists and Sikhs.', 'Several hours from Lachen'],
        ],
        'getting' => [
            ['Gangtok to Lachung', 'About 120 km on a winding mountain road, with waterfall stops along the way.', '5–6 hours'],
            ['Gangtok to Lachen', 'About the same distance, via Mangan and Chungthang.', '5–6 hours'],
            ['Lachung to Lachen', 'Back down to Chungthang and up the other valley.', '2–3 hours'],
            ['Lachen to Gurudongmar', 'A rough road that starts before dawn, so you reach the lake in clear light.', 'Several hours each way'],
        ],
        'permits' => 'Lachung, Lachen, Yumthang, Zero Point and Gurudongmar need permits, which we arrange. Tourist vehicles for the north are local and arranged through us. Foreign nationals face extra rules, so tell us your nationality early.',
        'stay' => 'Expect simple hotels, lodges and homestays in Lachung and Lachen. Hot water, heating and electricity can be limited, and rooms fill quickly in spring and autumn. We book ahead for you.',
        'itinerary' => [
            'Arrive in Gangtok and rest to start adjusting to the height.',
            'Drive to Lachung via the waterfalls and Chungthang.',
            'Yumthang Valley in the morning, Zero Point if the weather allows, then drive to Lachen.',
            'Leave before dawn for Gurudongmar Lake, then return down to Gangtok on a long day.',
        ],
        'tips' => [
            'Spend a night in Gangtok before heading north, and go up gradually.',
            'Carry warm layers even in summer, and cash for the whole trip.',
            'Mobile signal is patchy and often absent, so tell family you may be out of touch.',
            'Drivers do not drive at night. Early starts are part of the plan.',
        ],
        'faqs' => [
            ['Can I visit Gurudongmar in winter?', 'Often not. The lake can be frozen and the road may close after snowfall. We check conditions and keep a flexible plan.'],
            ['Is North Sikkim suitable for children and older travellers?', 'It can be, with a slower route and extra nights to adjust. Check with a doctor first if there is a heart or lung condition.'],
            ['Will I have a mobile network?', 'Rarely. Coverage is patchy in Lachung and Lachen and usually absent at the high points.'],
        ],
    ],

    'west-sikkim' => [
        'name' => 'West Sikkim', 'short' => 'West', 'img' => 'west.jpeg', 'base' => 'Pelling', 'days' => '3 days',
        'high' => 'Dzongri trek, about 13,000 ft', 'elev' => 'Pelling sits at about 6,800 ft',
        'tagline' => 'The closest views of Kanchenjunga, old monasteries and a first capital.',
        'good_for' => ['Honeymoons', 'Families', 'Monasteries', 'Trekking'],
        'about' => [
            'West Sikkim has the nearest views of Kanchenjunga from Pelling, along with some of the oldest monasteries in the state and the first capital at Yuksom. It suits slower days.',
            'Roads are quieter than in the east, and the area is the gateway for the Dzongri and Goecha La treks in Kanchenjunga National Park.',
        ],
        'calendar' => ['cold', 'cold', 'good', 'peak', 'peak', 'wet', 'wet', 'wet', 'wet', 'peak', 'peak', 'cold'],
        'seasons' => [
            ['Spring', 'March – May', '9–21°C', 'Clear mornings and flowers', 'Comfortable days and good morning views of the mountains. Rhododendrons bloom on the higher trails in April and May. Book view rooms early for this peak season.', ['Light layers and a fleece', 'A warm jacket for evenings', 'Comfortable walking shoes', 'Sunscreen and sunglasses']],
            ['Monsoon', 'June – September', '15–22°C', 'Misty and wet', 'Heavy rain and cloud often hide Kanchenjunga. The area is lush and quiet, but landslides can affect the road, so keep your plans flexible.', ['Raincoat or poncho', 'Waterproof shoes', 'Quick-dry clothes', 'Leech socks if you plan to trek']],
            ['Autumn', 'October – November', '8–19°C', 'The best Kanchenjunga views', 'The clearest season, with bright mornings and sharp views of the whole range. Evenings are cold, so pack warm layers.', ['Fleece and a light down jacket', 'Scarf and cap', 'Closed shoes with grip', 'Sunglasses']],
            ['Winter', 'December – February', '2–12°C', 'Cold and clear', 'Cold nights and clear days with good mountain views. Higher trails are under snow. It is quiet and suits travellers who are comfortable with cold.', ['Thermal innerwear', 'Warm insulated jacket', 'Gloves, cap and scarf', 'Warm, waterproof boots']],
        ],
        'pack_always' => ['Photo ID (original and copies)', 'Passport-size photographs', 'Sunscreen and sunglasses', 'Camera or phone with spare power', 'Regular medicines and a small first-aid kit'],
        'places' => [
            ['Pemayangtse Monastery', 'Monastery', 'One of the oldest and most important monasteries in Sikkim, with a hilltop setting and fine painted walls.', 'Near Pelling'],
            ['Rabdentse Ruins', 'Heritage', 'The ruins of Sikkim\'s second capital, with a short forest walk and mountain views.', 'Near Pelling'],
            ['Rimbi Waterfall', 'Waterfall', 'A forest waterfall on the Rimbi river near Pelling, a cool and shady stop away from the viewpoints.', 'Near Pelling'],
            ['Pelling Skywalk and Chenrezig statue', 'Viewpoint', 'A glass walkway and a large statue overlooking the valley, good for early light.', 'In Pelling'],
            ['Khecheopalri Lake', 'Sacred lake', 'A quiet forest lake sacred to Buddhists and Hindus. Keep a respectful distance and do not swim.', 'About 1.5 hours from Pelling'],
            ['Yuksom', 'First capital', 'Where Sikkim\'s first king was crowned, with an old coronation throne and Dubdi Monastery.', 'About 1.5 to 2 hours from Pelling'],
            ['Tashiding Monastery', 'Monastery', 'A hilltop monastery among rhododendron and prayer flags, with views over two rivers.', 'On the Yuksom side'],
            ['Dzongri trek', 'Trek', 'A multi-day trek from Yuksom to around 13,000 ft in Kanchenjunga National Park, best in spring and autumn.', 'Starts at Yuksom'],
        ],
        'getting' => [
            ['From Gangtok', 'About 115 km by road, often combined with a stop at Ravangla and Temi.', '5–6 hours'],
            ['From Bagdogra or NJP', 'By road via Jorethang, a long day if you are connecting from a flight or train.', '5–6 hours'],
            ['Around Pelling', 'Khecheopalri Lake is about 1.5 hours from Pelling and Yuksom about 1.5 to 2 hours.', 'Day trips'],
        ],
        'permits' => 'Most of West Sikkim needs no special permit for Indian travellers. Treks into Kanchenjunga National Park, such as Dzongri and Goecha La, need separate trekking permits and registered guides, which we arrange.',
        'stay' => 'Pelling has hotels with mountain-view rooms, and village homestays near Darap, Yuksom and Khecheopalri give a quieter experience. Ask for a Kanchenjunga-facing room.',
        'itinerary' => [
            'Drive from Gangtok to Pelling, stopping at Ravangla and Temi Tea Garden.',
            'Pemayangtse Monastery, Rabdentse ruins and Rimbi Waterfall, then the Skywalk.',
            'Khecheopalri Lake, a slow afternoon in Pelling, then depart.',
        ],
        'tips' => [
            'Book a view-facing room, and look out of the window at sunrise.',
            'Clouds often cover the peaks by 9 a.m., so go early.',
            'Treks need guides and permits. Do not attempt them alone.',
            'Carry a rain layer from June to September.',
        ],
        'faqs' => [
            ['Where do you see Kanchenjunga best?', 'From Pelling and from the viewpoints near Gangtok, most reliably between October and November, in the early morning.'],
            ['Is the Dzongri trek suitable for beginners?', 'It is moderate and lasts several days at altitude. It suits fit beginners with a guide, in spring or autumn.'],
            ['How long should I stay in West Sikkim?', 'Three days works well. Add two more if you want to visit Yuksom and Tashiding or start a trek.'],
        ],
    ],

    'south-sikkim' => [
        'name' => 'South Sikkim', 'short' => 'South', 'img' => 'south.jpeg', 'base' => 'Ravangla and Namchi', 'days' => '2 days',
        'high' => 'Ravangla, about 7,000 ft', 'elev' => 'Ravangla sits at about 7,000 ft',
        'tagline' => 'Tea gardens, giant statues and the gentlest side of Sikkim.',
        'good_for' => ['Easy trips', 'Families', 'Elders', 'Tea and nature'],
        'about' => [
            'South Sikkim is greener, warmer and closer to the plains. It has Sikkim\'s only tea estate, large statues and pleasant hill towns, which makes it a good first or last stop.',
            'The roads are easier than in the north, and the altitude is lower, so it also suits older travellers and young children.',
        ],
        'calendar' => ['cold', 'cold', 'good', 'peak', 'peak', 'wet', 'wet', 'wet', 'wet', 'peak', 'peak', 'good'],
        'seasons' => [
            ['Spring', 'March – May', '12–24°C', 'Warm days, flowering hills', 'Comfortable weather and clear mornings. Good for walks around Ravangla. Mild enough for most travellers.', ['Light clothes and a fleece', 'Comfortable walking shoes', 'Sunhat and sunscreen', 'A light rain layer']],
            ['Monsoon', 'June – September', '17–25°C', 'Very green, very wet', 'Heavy rain and mist, with lush tea gardens. Some roads can be affected by landslides. Quiet and cheaper if you do not mind the rain.', ['Raincoat or poncho', 'Waterproof shoes', 'Quick-dry clothes', 'Insect repellent']],
            ['Autumn', 'October – November', '10–22°C', 'Crisp, bright and clear', 'Clear skies and good views of the snow peaks from Ravangla. Evenings are cool.', ['Light jacket or fleece', 'Scarf for evenings', 'Closed shoes', 'Sunglasses']],
            ['Winter', 'December – February', '5–16°C', 'Mild and cool', 'The mildest winter in Sikkim. Mornings and nights are cold, but days are pleasant and clear.', ['Warm jacket and woollens', 'Cap and gloves for mornings', 'Closed shoes', 'Thermal innerwear for early starts']],
        ],
        'pack_always' => ['Photo ID (original and copies)', 'Sunscreen and sunglasses', 'Comfortable walking shoes', 'Reusable water bottle', 'Regular medicines and a small first-aid kit'],
        'places' => [
            ['Buddha Park (Tathagata Tsal)', 'Landmark', 'A large seated Buddha surrounded by gardens, with wide views over the hills.', 'At Ravangla'],
            ['Ralong Monastery', 'Monastery', 'A colourful monastery set on a quiet hillside near Ravangla.', 'Near Ravangla'],
            ['Namchi Monastery', 'Monastery', 'A quiet Buddhist monastery above Namchi town, a peaceful stop away from the larger statues.', 'At Namchi'],
            ['Temi Tea Garden', 'Tea estate', 'Sikkim\'s only tea estate, with terraced slopes and fresh tea to buy and taste.', 'Between Ravangla and Namchi'],
            ['Samdruptse', 'Statue', 'A very large statue of Guru Padmasambhava on a hill above Namchi.', 'At Namchi'],
            ['Char Dham (Siddheshwar Dham)', 'Pilgrim complex', 'A pilgrimage complex with replicas of four Hindu shrines and a tall Shiva statue.', 'At Namchi'],
        ],
        'getting' => [
            ['From Gangtok to Ravangla', 'About 65 km, usually combined with Temi Tea Garden on the way.', 'About 3 hours'],
            ['From Gangtok to Namchi', 'About 78 km on a good road via Singtam.', 'About 3 hours'],
            ['From Bagdogra or NJP', 'By road via Jorethang, the shortest route into the state.', '3–4 hours'],
        ],
        'permits' => 'South Sikkim generally needs no special permit for Indian travellers. Some sites charge small entry fees. Foreign nationals should check registration rules with us in advance.',
        'stay' => 'Ravangla has hotels and homestays with mountain views, and Namchi and Temi offer quieter options. It works well as an overnight on the way between Gangtok and Pelling.',
        'itinerary' => [
            'Drive from Gangtok via Temi Tea Garden to Ravangla. Buddha Park in the afternoon.',
            'Ralong Monastery in the morning, then Namchi for its monastery, Samdruptse and Char Dham.',
        ],
        'tips' => [
            'Pair South Sikkim with Pelling or Gangtok, as it works best on the way.',
            'Buy tea at Temi, as it is cheaper and fresher there.',
            'Mornings are clearest, so plan viewpoints before 10 a.m.',
            'Carry a light rain layer in any season.',
        ],
        'faqs' => [
            ['Is South Sikkim worth including?', 'Yes, especially as a gentle stop between Gangtok and Pelling. It adds tea, views and an easier day.'],
            ['Is it suitable for older travellers?', 'Yes. The roads are gentler and the altitude is lower than in the north and east.'],
            ['How many days do I need?', 'One to two days is enough, or one night at Ravangla on the way to Pelling.'],
        ],
    ],
];
