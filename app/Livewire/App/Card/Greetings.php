<?php

namespace App\Livewire\Card;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Greetings extends Component
{
    public $user;
    public $quote;
    public $quotes = [
        'In work, do what you enjoy.',
        'Let all your things have their places; let each part of your business have its time.',
        'Success usually comes to those who are too busy to be looking for it.',
        'Don’t be afraid to give up the good to go for the great.',
        'Opportunities don’t happen. You create them.',
        'Try not to become a man of success. Rather become a man of value.',
        'It is not the strongest of the species that survive, nor the most intelligent, but the one most responsive to change.',
        'Success is walking from failure to failure with no loss of enthusiasm.',
        'The road to success and the road to failure are almost exactly the same.',
        'Your time is limited, so don’t waste it living someone else’s life.',
        'The way to get started is to quit talking and begin doing.',
        'Stop chasing the money and start chasing the passion.',
        'If you are not willing to risk the usual, you will have to settle for the ordinary.',
        'Success seems to be connected with action. Successful people keep moving.',
        'The only limit to our realization of tomorrow will be our doubts of today.',
        'Don’t let yesterday take up too much of today.',
        'If you’re working on something exciting that you really care about, you don’t have to be pushed. The vision pulls you.',
        'You don’t have to be great to start, but you have to start to be great.',
        'It’s not about ideas. It’s about making ideas happen.',
        'A successful man is one who can lay a firm foundation with the bricks others have thrown at him.',
        'The secret of success is to do the common thing uncommonly well.',
        'Fall seven times and stand up eight.',
        'Success is not the key to happiness. Happiness is the key to success.',
        'The harder the conflict, the greater the triumph.',
        'There is no substitute for hard work.',
        'A dream doesn’t become reality through magic; it takes sweat, determination, and hard work.',
        'It always seems impossible until it’s done.',
        'Act as if what you do makes a difference. It does.',
        'The best way to predict the future is to create it.',
        'Do what you can with all you have, wherever you are.',
        'The only way to do great work is to love what you do.',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        // Select a random quote
        $this->quote = $this->quotes[array_rand($this->quotes)];
    }

    public function render()
    {
        return view('livewire.card.greetings');
    }
}
