<?php
declare(strict_types=1);

return [
    [
        'title' => 'Who You Are',
        'intro' => 'Basics first. Nothing here is shared with anyone.',
        'questions' => [
            ['key' => 'adult_consent', 'label' => 'I confirm I am 18 years of age or older.', 'type' => 'confirmation'],
            ['key' => 'name', 'label' => 'What should I call you?', 'type' => 'short'],
            ['key' => 'pronouns', 'label' => 'Your pronouns', 'type' => 'short'],
            ['key' => 'age', 'label' => 'Age ain’t nothing but a number, but I want to know anyway', 'type' => 'number'],
            ['key' => 'orientation', 'label' => 'Sexual orientation, if any', 'type' => 'long', 'required' => false],
            ['key' => 'location', 'label' => 'Location', 'type' => 'long'],
            ['key' => 'timezone', 'label' => 'Time zone', 'type' => 'long'],
            ['key' => 'how_found', 'label' => 'How did you find me?', 'type' => 'short'],
            ['key' => 'contact_details', 'label' => 'What’s the best way to reach you, and when?', 'type' => 'long'],
            ['key' => 'privacy_needs', 'label' => 'Are you private about this side of your life, or open? Do you have specific privacy needs? Explain here.', 'type' => 'long'],
        ],
    ],
    [
        'title' => 'The Dynamic',
        'intro' => 'How you want this to feel.',
        'questions' => [
            ['key' => 'experience', 'label' => 'Are you new to submission, kink, findom, or experienced? Tell me your history.', 'type' => 'long'],
            [
                'key' => 'dynamic_ranking',
                'label' => 'Rank these from most to least appealing.',
                'hint' => 'Choose 1 for most appealing and 6 for least appealing. Use each number once.',
                'type' => 'rank',
                'options' => ['Praise', 'Guilt', 'Denial', 'Tasks', 'Worship', 'Roleplay'],
            ],
            ['key' => 'stay_or_go', 'label' => 'What would make you walk away? What keeps you coming back?', 'type' => 'long'],
        ],
    ],
    [
        'title' => 'Limits & Safety',
        'intro' => 'Nothing here is judged. Everything here is respected. Take your time.',
        'questions' => [
            ['key' => 'hard_limits', 'label' => 'Hard limits: what is absolutely off the table, always?', 'type' => 'long'],
            ['key' => 'soft_limits', 'label' => 'Soft limits: what are you unsure about, curious about, or willing to explore with the right person?', 'type' => 'long'],
            [
                'key' => 'communication_style',
                'label' => 'How do you want me to speak to you? Choose everything that appeals, and be honest: this is the one question you should answer with your gut, not your pride.',
                'type' => 'multi',
                'options' => ['Warmth and praise', 'Clear direction', 'Playful teasing', 'Firm correction', 'Rituals and tasks', 'Humiliation within my limits', 'Silence or distance', 'Something else'],
            ],
            ['key' => 'aftercare', 'label' => 'How do you want me to handle it if we cross a line or something goes wrong? What’s your aftercare like, if you want any at all?', 'type' => 'long', 'required' => false],
        ],
    ],
    [
        'title' => 'Tribute',
        'intro' => 'Be honest. A real number is worth more to me than a flattering one.',
        'questions' => [
            ['key' => 'monthly_budget', 'label' => 'What’s your realistic monthly tribute budget? Be honest, I’d rather have a real number than a fantasy one, and honesty here tells me more about you than the number itself.', 'type' => 'money'],
            [
                'key' => 'payment_method',
                'label' => 'Do you prefer to send by YouPay.Me, Throne, Crypto, Zelle, or another method?',
                'type' => 'multi',
                'options' => ['YouPay.Me', 'Throne', 'Crypto', 'Zelle', 'Another method'],
            ],
            [
                'key' => 'tribute_rhythm',
                'label' => 'How do you want this to work? Pick the sentence that sounds most like you:',
                'type' => 'single',
                'options' => [
                    'I want clear expectations and structured tasks.',
                    'I prefer spontaneous moments when the feeling is right.',
                    'I want a steady rhythm with room for it to evolve.',
                    'I’m still figuring out what feels right for me.',
                ],
            ],
            [
                'key' => 'arrangement',
                'label' => 'Would you like a formal arrangement, a casual send-when-you-can relationship, or something you haven’t figured out yet?',
                'type' => 'single',
                'options' => ['A formal arrangement', 'A casual, send-when-you-can relationship', 'Something I haven’t figured out yet'],
            ],
            ['key' => 'money_dynamic', 'label' => 'Some subs want to be drained. Some want to be kept. Most want a blend that shifts over time. Which draws you, and what does your ideal dynamic with money look like? Also: have you ever gone into debt or financial hardship for findom?', 'type' => 'long'],
        ],
    ],
    [
        'title' => 'Last Word',
        'intro' => 'Almost done.',
        'questions' => [
            ['key' => 'why_pick_you', 'label' => 'In one paragraph: why should I pick you?', 'type' => 'long'],
            ['key' => 'good_for_you', 'label' => 'Finish this sentence: “I want to be good for you because…”', 'type' => 'long'],
            ['key' => 'questions_for_emilia', 'label' => 'Do you have any questions for me? I promise you can ask me anything.', 'type' => 'long', 'required' => false],
        ],
    ],
];
