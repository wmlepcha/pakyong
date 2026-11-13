<?php

/*
 * FAQ content. 'home' => true shows the question on the home page.
 * Payment, inclusion and cancellation answers are placeholders: replace with your real policy.
 */
return [
    'categories' => ['Permits and entry', 'Planning your trip', 'Booking and payment', 'On the trip'],

    'items' => [
        // Permits and entry
        ['cat' => 'Permits and entry', 'home' => true, 'q' => 'Do I need a permit to visit Sikkim?', 'a' => 'Indian citizens need no permit for the general, unrestricted parts of the state. Restricted places, such as Nathula and Gurudongmar, need permits, which we arrange. Foreign nationals need to register through the FRRO portal at least 15 days in advance.'],
        ['cat' => 'Permits and entry', 'q' => 'Which places need a permit?', 'a' => 'Protected and restricted places in the north and east, including Nathula Pass, Gurudongmar Lake and Yumthang Zero Point, need permits. The list can change, so we confirm the current requirements for your route before you travel.'],
        ['cat' => 'Permits and entry', 'q' => 'What documents should I carry?', 'a' => 'A government-issued photo ID, original and photocopies, plus a few passport-size photographs. Share copies of your ID with us before the trip so the permits are ready when you arrive.'],
        ['cat' => 'Permits and entry', 'q' => 'How do foreign nationals register?', 'a' => 'Foreign nationals are required to register through the FRRO portal at least 15 days in advance.', 'link' => ['Open the FRRO portal', 'https://indianfrro.gov.in/efrro/']],
        ['cat' => 'Permits and entry', 'q' => 'Can permits be arranged at the last minute?', 'a' => 'Please do not count on it. Share your documents as early as you can, and we will tell you the lead time for your route and dates.'],

        // Planning
        ['cat' => 'Planning your trip', 'home' => true, 'q' => 'How many days should I plan?', 'a' => 'Gangtok plus Pelling works well in 6 to 7 days. Adding North Sikkim makes it 8 to 9 days. If you only have 4 or 5 days, choose one or two regions rather than rushing through all of them.'],
        ['cat' => 'Planning your trip', 'q' => 'When is the best time to visit?', 'a' => 'March to May for rhododendrons and pleasant weather, and October to November for the clearest mountain views. Winter brings snow in the north, and the monsoon brings the risk of landslides.', 'link' => ['Read the travel guide', '/travel-guide#best-time']],
        ['cat' => 'Planning your trip', 'home' => true, 'q' => 'Can you customise the itinerary?', 'a' => 'Yes. Every trip is built around your dates, pace and budget. Tell us what you want to see, how many people are travelling and how you like to travel, and we will plan the route.'],
        ['cat' => 'Planning your trip', 'q' => 'Is North Sikkim open in winter and the monsoon?', 'a' => 'Often, but not always. Snow in winter and landslides in the monsoon can close roads for hours or days, and Gurudongmar Lake may be frozen. We check conditions before every departure and keep a flexible plan.'],
        ['cat' => 'Planning your trip', 'q' => 'Is Sikkim suitable for families, older travellers and solo travellers?', 'a' => 'Yes, with sensible planning. Sikkim is generally calm and welcoming. For young children and older travellers, we suggest a slower route and extra acclimatisation before going high, and we are happy to plan that with you.'],
        ['cat' => 'Planning your trip', 'q' => 'Do you arrange pick-ups from Bagdogra, NJP and Pakyong?', 'a' => 'Yes. We arrange pick-ups and drops at Bagdogra airport, New Jalpaiguri station, Siliguri and Pakyong airport. Share your arrival time and we will match it.'],

        // Booking
        ['cat' => 'Booking and payment', 'home' => true, 'q' => 'How do I pay?', 'a' => 'A small advance confirms your booking, and the balance is paid before the trip starts. We will share the payment details with your final quote.'],
        ['cat' => 'Booking and payment', 'q' => 'What is included in a package?', 'a' => 'Typically accommodation, a private cab with a driver, permit assistance and the sightseeing in your itinerary. Flights, personal expenses and entry fees are usually extra. Each quote lists exactly what is and is not included.'],
        ['cat' => 'Booking and payment', 'q' => 'What is your cancellation policy?', 'a' => 'Terms depend on how close to departure you cancel, and on the hotels and permits already booked. We share the cancellation terms with your quote, before you pay anything.'],
        ['cat' => 'Booking and payment', 'q' => 'How soon will I get a quote?', 'a' => 'Usually within a day of your enquiry. Send your dates and group size through the form or on WhatsApp.'],

        // On the trip
        ['cat' => 'On the trip', 'q' => 'Will I get altitude sickness?', 'a' => 'It can affect anyone at high altitude. Go up gradually, drink plenty of water, skip alcohol, and descend if symptoms get worse. Check with a doctor first if you have a heart or lung condition.', 'link' => ['Read the altitude guide', '/travel-guide#altitude']],
        ['cat' => 'On the trip', 'q' => 'Will I have mobile network and ATMs?', 'a' => 'Good in Gangtok and the main towns. Patchy in Lachung and Lachen, and little or none at the high passes. ATMs are scarce in the north, so carry enough cash before you go.'],
        ['cat' => 'On the trip', 'q' => 'What should I pack?', 'a' => 'Layers, comfortable shoes with grip, sun protection, and warm clothing for North Sikkim even in summer. Our travel guide has a tickable packing list for each season.', 'link' => ['See the packing list', '/travel-guide#packing']],
        ['cat' => 'On the trip', 'q' => 'Can you cater for vegetarian or other dietary needs?', 'a' => 'Vegetarian food is easy to find. Tell us about any dietary needs in advance and we will arrange meals as far as possible.'],
        ['cat' => 'On the trip', 'q' => 'Can I drive myself?', 'a' => 'Most visitors travel with a local driver, because the mountain roads are demanding. For North Sikkim, using a local driver and vehicle is the practical option. Our packages include a private cab and driver.'],
    ],
];
