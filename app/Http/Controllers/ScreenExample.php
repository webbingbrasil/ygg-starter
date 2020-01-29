<?php


namespace App\Http\Controllers;


use Ygg\Screens\Layout;
use Ygg\Screens\Screen;

class ScreenExample extends Screen
{
    /**
     * Display header name
     *
     * @var string
     */
    public $name = 'Idea Screen';

    /**
     * Display header description
     *
     * @var string
     */
    public $description = 'Idea Screen';

    /**
     * @inheritDoc
     */
    public function query(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function layout(): array
    {
        return [
            Layout::columns([
                'left' => [],
                'right' => [],
            ])
        ];
    }
}
