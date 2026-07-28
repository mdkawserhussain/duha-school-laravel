<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    @php
        $siteName = \App\Helpers\SiteHelper::getSiteName();
    @endphp
    <title>{{ $siteName }} - Events</title>
    <subtitle>Upcoming events and activities at {{ $siteName }}</subtitle>
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
        <summary type="html">{{ $event->excerpt ?? Str::limit(strip_tags($event->content ?? $event->description), 200) }}</summary>
        <content type="html">
            <![CDATA[
            <h2>{{ $event->title }}</h2>
            @php $start = $event->start_at ?? $event->event_date; @endphp
            <p><strong>Date:</strong> {{ $start ? $start->format('F j, Y g:i A') : '' }}</p>
            @if($event->location)
            <p><strong>Location:</strong> {{ $event->location }}</p>
            @endif
            @if($event->category)
            <p><strong>Category:</strong> {{ $event->category }}</p>
            @endif
            <div>{{ $event->content ?? $event->description }}</div>
            <p><a href="{{ route('events.show', $event) }}">Read more &raquo;</a></p>
            ]]>
        </content>
        <author>
            <name>{{ $siteName }}</name>
            <email>{{ config('contact.email.info') }}</email>
        </author>
    </entry>
    @endforeach
</feed>

