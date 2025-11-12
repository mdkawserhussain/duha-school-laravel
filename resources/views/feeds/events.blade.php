<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Al-Maghrib International School - Events</title>
    <subtitle>Upcoming events and activities at Al-Maghrib International School</subtitle>
    <link href="{{ route('events.feed') }}" rel="self"/>
    <link href="{{ route('events.index') }}"/>
    <id>{{ route('events.feed') }}</id>
    <updated>{{ $events->isNotEmpty() ? $events->first()->updated_at->toAtomString() : now()->toAtomString() }}</updated>
    
    @foreach($events as $event)
    <entry>
        <id>{{ route('events.show', $event) }}</id>
        <title>{{ $event->title }}</title>
        <link href="{{ route('events.show', $event) }}"/>
        <updated>{{ $event->updated_at->toAtomString() }}</updated>
        <published>{{ $event->published_at->toAtomString() }}</published>
        <summary type="html">{{ $event->excerpt ?? Str::limit(strip_tags($event->description), 200) }}</summary>
        <content type="html">
            <![CDATA[
            <h2>{{ $event->title }}</h2>
            <p><strong>Date:</strong> {{ $event->event_date->format('F j, Y g:i A') }}</p>
            @if($event->location)
            <p><strong>Location:</strong> {{ $event->location }}</p>
            @endif
            @if($event->category)
            <p><strong>Category:</strong> {{ $event->category }}</p>
            @endif
            <div>{{ $event->description }}</div>
            <p><a href="{{ route('events.show', $event) }}">Read more &raquo;</a></p>
            ]]>
        </content>
        <author>
            <name>Al-Maghrib International School</name>
            <email>{{ config('contact.email.info') }}</email>
        </author>
    </entry>
    @endforeach
</feed>

