<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking\Booking;
use App\Models\Client\Client;
use App\Models\Client\ClientMessage;
use App\Models\Content\PortfolioItem;

class HomeController
{
    public function index()
    {
        $bookingsCount = Booking::count();
        $clientsCount = Client::count();
        $portfolioCount = PortfolioItem::count();
        $unconfirmedBookingsCount = Booking::whereIn('status', ['unconfirmed', 'new'])->count();
        $unreadMessagesCount = ClientMessage::whereNull('admin_read_at')->count();
        $recentBookings = Booking::with(['client', 'eventLocation'])
            ->latest('created_at')
            ->take(7)
            ->get();

        return view('home', compact(
            'bookingsCount',
            'clientsCount',
            'portfolioCount',
            'unconfirmedBookingsCount',
            'unreadMessagesCount',
            'recentBookings'
        ));
    }
}
