{{-- Stat Counter Component with Count-Up Animation --}}
@props([
    'value' => 0,
    'label' => 'Statistic',
    'suffix' => '',
    'prefix' => '',
    'icon' => null,
    'duration' => 2000,
    'iconColor' => 'text-za-yellow-accent',
    'valueColor' => 'text-za-green-primary'
])

<div 
    x-data="{
        count: 0,
        target: {{ $value }},
        hasStarted: false,
        
        startCounting() {
            if (this.hasStarted) return;
            this.hasStarted = true;
            
            const duration = {{ $duration }};
            const steps = 60;
            const stepValue = this.target / steps;
            const interval = duration / steps;
            
            const counter = setInterval(() => {
                this.count += stepValue;
                if (this.count >= this.target) {
                    this.count = this.target;
                    clearInterval(counter);
                }
            }, interval);
        }
    }"
    x-intersect.once="startCounting()"
    class="text-center p-6 rounded-xl bg-white shadow-lg hover:shadow-xl transition-shadow duration-300"
>
    {{-- Icon --}}
    @if($icon)
    <div class="mb-4 flex justify-center">
        <div class="w-16 h-16 rounded-full bg-za-green-light flex items-center justify-center {{ $iconColor }}">
            {!! $icon !!}
        </div>
    </div>
    @endif

    {{-- Number --}}
    <div class="mb-2">
        <span class="text-5xl font-bold {{ $valueColor }}">
            {{ $prefix }}<span x-text="Math.floor(count)">0</span>{{ $suffix }}
        </span>
    </div>

    {{-- Label --}}
    <p class="text-gray-600 font-medium text-lg">
        {{ $label }}
    </p>
</div>
