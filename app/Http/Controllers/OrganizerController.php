<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        $events = Event::where('organizer_id', auth()->id())->paginate(10);

        return view('organizer.dashboard', compact('events'));
    }
}
