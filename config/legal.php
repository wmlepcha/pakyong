<?php

/*
 * Legal documents, drafted for a Sikkim tour operator under Indian law.
 * This is a starting draft, not legal advice: have a lawyer review it, and set the
 * cancellation schedule and business details to match how you actually operate.
 * Tokens :brand and :phone are replaced from config/site.php.
 * A block is a paragraph (string), ['list' => [...]] or ['table' => [headers, rows]].
 */
return [
    'updated' => '13 November 2026',

    'terms' => [
        'title' => 'Terms and conditions',
        'intro' => 'These terms apply when you use this website or book a trip with :brand. Please read them before you pay. If anything is unclear, ask us on WhatsApp at :phone before you book.',
        'summary' => [
            'Your quote and written confirmation list exactly what your trip includes.',
            'A booking is confirmed only after we receive the advance payment.',
            'Permits and registration depend on government approval, and you must give us correct documents on time.',
            'Mountain weather and roads change plans. We will offer the best alternative we can.',
            'Cancellation charges depend on how close to departure you cancel.',
        ],
        'sections' => [
            ['About these terms', [
                'These terms are an agreement between you and :brand, a tour operator based in Gangtok, Sikkim ("we", "us"). By sending an enquiry, paying an advance or travelling with us, you accept these terms.',
                'If you book for a group, you confirm you are authorised to accept these terms for everyone in it, and you will make sure they read them.',
            ]],
            ['Our role', [
                'We design and organise tours in Sikkim. We arrange services such as accommodation, local transport, guides, permits and activities. Most of these are provided by independent third parties, including hotels, drivers, homestay hosts and activity operators.',
                'We choose these providers with care, but they run their own businesses. Their own terms apply to their services, and we act as your organiser and agent in booking them.',
            ]],
            ['Enquiries, quotes and itineraries', [
                'A quote is based on the dates, group size and services you ask for. It is valid for the period stated on it, and prices can change after that because of hotel rates, fuel, taxes or permit fees.',
                'Itineraries on our website and in sample plans are only a guide. Your confirmed itinerary is the one we send in writing after booking.',
                'Drive times, distances and altitudes shown on this website are approximate.',
            ]],
            ['Booking and payment', [
                'Your booking is confirmed when we receive the advance payment stated in your quote and send you written confirmation. The balance is due before the trip starts, by the date stated in your confirmation.',
                'If the balance is not received on time, we may treat the booking as cancelled and the cancellation charges below will apply.',
                'We accept the payment methods listed in your quote. Please pay only to the account details we send you from our official number, and confirm them with us if you are unsure.',
            ]],
            ['What is included and excluded', [
                'Only what is listed in your quote or confirmation is included. Typically a package covers accommodation, a private vehicle with a driver, permit assistance and the sightseeing in your itinerary.',
                ['list' => [
                    'Usually excluded: flights and train tickets, meals not listed, entry fees, camera fees, tips, personal expenses, laundry, insurance and anything not named in your quote.',
                    'Optional activities such as rafting, trekking, cable car rides or yak rides are included only if your quote says so.',
                ]],
            ]],
            ['Permits, ID and entry rules', [
                'Many places in Sikkim, including Nathula Pass, Gurudongmar Lake and Yumthang Zero Point, need permits. We apply for permits on your behalf, but we do not issue them. Approval is decided by the authorities and is never guaranteed.',
                ['list' => [
                    'Indian nationals need no permit for general, unrestricted areas. An Inner Line Permit is needed for protected places in the north and east.',
                    'Foreign nationals must register through the FRRO portal at least 15 days before travel, and may need further permits for restricted areas.',
                    'You must carry a valid government photo ID in original, and give us accurate copies and passport-size photographs by the date we ask for.',
                ]],
                'If a permit is delayed or refused because of incorrect, late or missing documents, or because of a government decision, we are not responsible for the loss of the affected services, and any costs already paid to third parties are not refundable.',
            ]],
            ['Cancellations and refunds', [
                'You can cancel at any time by telling us in writing, including by WhatsApp. The date we receive your message is the cancellation date. Unless your quote states a different schedule, these charges apply as a share of the total trip cost:',
                ['table' => [['Cancellation before departure', 'Amount we keep'], [
                    ['30 days or more', '10%'],
                    ['15 to 29 days', '25%'],
                    ['7 to 14 days', '50%'],
                    ['Less than 7 days, or no-show', '100%'],
                ]]],
                'Costs we have already paid or committed to hotels, transporters, permit fees and similar providers are not refundable, even if they exceed these percentages. If a provider refunds us, we pass it on to you.',
                'Refunds are made to the original payment method, normally within 15 working days after we confirm the amount. Unused services once the trip has started, such as a night you skip or a day you leave early, are not refundable.',
            ]],
            ['Changes to your trip', [
                'If you want to change dates, destinations or group size, tell us as early as possible. We will try to accommodate you, but changes depend on availability and may cost more. A change that reduces the trip is treated as a partial cancellation.',
                'We may change your itinerary, hotels or vehicle for operational reasons, such as a closed road, a failed permit or an unavailable property. We will offer an alternative of similar standard. If the change is significant and you do not accept the alternative, you may cancel and we will refund what we can recover.',
            ]],
            ['Weather, road conditions and force majeure', [
                'Sikkim is mountainous. Landslides, snow, heavy rain, road closures, permit changes and government orders can delay, shorten or cancel parts of a trip, especially in North Sikkim and at high passes. Gurudongmar Lake, Nathula and Yumthang may be closed or inaccessible on any day.',
                'We will do our best to rearrange your plans, but we are not liable for losses caused by events beyond our reasonable control, such as natural disasters, strikes, curfews, epidemics, accidents on the road, closed borders or acts of government. Extra costs caused by these events, such as additional nights or alternative transport, are paid by you unless your quote says otherwise.',
                'Drivers do not drive mountain roads after dark. We may change timings or routes for your safety.',
            ]],
            ['Health, altitude and safety', [
                'Parts of this trip are at high altitude: Tsomgo Lake is about 12,400 ft, Nathula about 14,140 ft and Gurudongmar about 17,800 ft. Altitude sickness can affect anyone.',
                ['list' => [
                    'Tell us in advance about any medical condition, pregnancy, mobility limits or allergy, and consult your doctor if you have a heart or lung condition.',
                    'Follow the advice of your driver and guide. They may change the plan, or ask you to descend, if someone is unwell.',
                    'Activities such as trekking and river rafting carry real risk. You take part at your own risk, and you must follow safety instructions.',
                    'We strongly recommend travel insurance that covers medical care, evacuation and trip interruption. We do not provide insurance.',
                ]],
            ]],
            ['Your responsibilities and conduct', [
                ['list' => [
                    'Give us accurate information, and carry your ID and permits at all times.',
                    'Respect local people, monasteries and sacred sites. Follow dress codes and photography rules, and do not use drones without permission.',
                    'Look after the environment: avoid single-use plastic, take your litter back, and do not swim in or wash in sacred lakes.',
                    'Do not behave in a way that endangers others, or break the law, while on a trip.',
                ]],
                'We may end services to anyone whose behaviour is unsafe, unlawful or disrespectful. In that case no refund is due and you are responsible for your own onward travel.',
            ]],
            ['Hotels, vehicles and third-party services', [
                'Hotels and homestays may substitute a similar room, and facilities such as hot water, heating, electricity and internet can be limited in remote areas. Check-in and check-out times follow each property.',
                'Vehicles are provided by local operators. We may substitute a similar vehicle. Seat numbers, luggage space and the route are decided by the driver for safety.',
                'Services bought outside our quote, such as extra activities you arrange directly with a provider, are between you and that provider.',
            ]],
            ['Our liability', [
                'We will use reasonable care and skill in arranging your trip. We are responsible for what we promise to provide, but not for the acts or failures of independent third parties, including hotels, drivers and activity operators, except where the law says we are.',
                'Subject to the law, our total liability to you for any claim about a service is limited to the amount you paid us for that service. We are not liable for indirect losses, loss of enjoyment, loss or damage to personal belongings, or delays caused by events listed above. Nothing in these terms limits liability that cannot be limited under Indian law.',
                'Keep valuables with you, and keep copies of your documents.',
            ]],
            ['Complaints', [
                'If something is wrong during your trip, tell your driver or us at once, so we can try to fix it there and then. If it is not resolved, send us your complaint in writing within 15 days after the trip ends, with the details. We will respond within a reasonable time and try to settle it fairly.',
            ]],
            ['Using this website', [
                'This website is for general information and trip enquiries. We try to keep it accurate, but prices, availability, permits, distances and rules can change, so please confirm details with us before you rely on them.',
                'The website content, design and text belong to us or our licensors. Some photographs are used under free licences and credited on the page where they appear. You may not copy or reuse our content for commercial purposes without our written permission.',
                'The website may link to other websites, such as the FRRO portal. We do not control them and are not responsible for their content.',
            ]],
            ['Governing law and disputes', [
                'These terms are governed by the laws of India. We will first try to resolve any dispute through discussion. If that fails, the courts at Gangtok, Sikkim have jurisdiction.',
            ]],
            ['Changes and contact', [
                'We may update these terms from time to time. The version on this page on the date you book applies to your booking.',
                'Questions? Call or message us on WhatsApp at :phone.',
            ]],
        ],
    ],

    'privacy' => [
        'title' => 'Privacy policy',
        'intro' => 'This policy explains what personal information :brand collects when you use this website or book a trip, why we need it, who sees it and what choices you have. We keep it to what is needed to plan and run your trip.',
        'summary' => [
            'We collect only what we need to answer you, plan your trip and arrange permits and stays.',
            'The forms on this website do not store your message. They open WhatsApp with your text ready to send.',
            'We do not sell your information.',
            'You can ask us to correct or delete your information, or to stop contacting you, at any time.',
        ],
        'sections' => [
            ['Who we are', [
                ':brand is a tour operator based in Gangtok, Sikkim. We decide why and how your personal information is used for your enquiry or booking. You can reach us at :phone.',
            ]],
            ['What we collect', [
                ['list' => [
                    'Contact details: your name, phone or WhatsApp number, and the message you send us.',
                    'Trip details: destinations, travel dates, number of travellers, preferences and special requests.',
                    'Identity documents: copies of ID or passport, passport-size photographs, and for foreign nationals visa and FRRO details, needed to apply for permits and register your stay.',
                    'Health and dietary information, only if you choose to share it so that we can plan safely and suit your needs.',
                    'Payment details: we record that a payment was made and its reference. We do not store card numbers.',
                    'Technical data: your browser, device type and pages visited, as collected by the services described below.',
                ]],
            ]],
            ['How information reaches us', [
                'When you use the enquiry form, the contact form or the "Plan my trip" form on this website, nothing is saved on our website. The form opens WhatsApp with your message ready to send, and the information is shared with us only when you send it.',
                'Once you message us, WhatsApp handles it under its own terms and privacy policy. We receive the number and message you send us. We may also collect information when you call us, email us or send documents.',
            ]],
            ['Why we use it', [
                ['list' => [
                    'To reply to your enquiry and prepare quotes and itineraries.',
                    'To book hotels, vehicles and activities, and to apply for permits and registrations.',
                    'To take payments, issue confirmations and handle changes, cancellations and refunds.',
                    'To look after you during your trip and in an emergency.',
                    'To meet legal duties, such as accounting, tax and government registration.',
                    'To improve our website and services. We contact you with offers only if you ask us to, and you can stop at any time.',
                ]],
                'We use your information because you give us your consent by contacting us, because we need it to carry out the trip you asked for, or because the law requires it.',
            ]],
            ['Who we share it with', [
                'We share only what each party needs, and only to deliver your trip:',
                ['list' => [
                    'Hotels, homestays, drivers, guides and activity operators.',
                    'Government authorities that issue permits and registrations, including Sikkim tourism and immigration authorities and the FRRO.',
                    'Payment and banking providers.',
                    'Technology services that help us run the website and messaging.',
                    'Advisers, auditors or authorities when the law requires it.',
                ]],
                'We do not sell or rent your personal information.',
            ]],
            ['Third-party services on this website', [
                'To work, this website loads some resources from other companies. They may see your IP address and device details when your browser requests them, and they have their own privacy policies:',
                ['list' => [
                    'Google Fonts, for the headline typeface.',
                    'jsDelivr, a content delivery network that serves a script we use for the interactive parts of the pages.',
                    'Google Maps, on the Contact page, which can set cookies and collect usage data when the map loads.',
                    'WhatsApp, when you tap a WhatsApp or "Send" button.',
                ]],
                'This website does not use advertising or tracking cookies of its own. If we add analytics later, we will update this policy.',
            ]],
            ['How long we keep it', [
                'We keep your information only as long as we need it for the purposes above. Identity documents are kept only for the time needed to arrange your permits and trip, and are then securely deleted unless the law requires us to keep them. Booking and payment records are kept for the period required for accounting and tax.',
                'Old enquiries that did not become bookings are deleted after a reasonable time.',
            ]],
            ['Keeping it safe', [
                'We limit who can see your information, protect our devices and accounts, and ask the businesses we work with to handle it carefully. No online system is completely secure, and we cannot guarantee absolute security. Please do not send us card numbers, passwords or sensitive details you do not need to share.',
                'If we learn of a data breach that affects you, we will tell you and the authorities as the law requires.',
            ]],
            ['Your rights and choices', [
                'Subject to the law, you can ask us to:',
                ['list' => [
                    'tell you what personal information we hold about you,',
                    'correct anything that is wrong or out of date,',
                    'delete your information, once we no longer need it for your trip or for legal reasons,',
                    'stop using your information, or withdraw a consent you gave us,',
                    'stop sending you messages or offers.',
                ]],
                'Message us at :phone with your request and we will respond within a reasonable time. If you are not satisfied with our answer, you can complain to the Data Protection Board of India or another authority with jurisdiction.',
            ]],
            ['Children', [
                'Trips for people under 18 must be booked by a parent or guardian. We collect a child\'s information only from the parent or guardian, and only to plan the trip. We do not track or profile children or send them marketing.',
            ]],
            ['Transfers outside India', [
                'Some services mentioned above, such as WhatsApp, Google and our content networks, may process information on servers outside India. We use them only for the purposes in this policy.',
            ]],
            ['Changes and contact', [
                'We may update this policy. The date at the top shows when it last changed, and we will make the update visible on this page.',
                'Questions or requests about your information? Call or message us on WhatsApp at :phone.',
            ]],
        ],
    ],
];
