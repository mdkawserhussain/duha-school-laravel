<!-- Stats Section -->
<section class="relative overflow-hidden py-20" style="background-color: #f7f8fb;">
    <div class="absolute inset-0" style="background-image:url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;200&quot; height=&quot;200&quot; viewBox=&quot;0 0 200 200&quot;><g fill=&quot;none&quot; fill-rule=&quot;evenodd&quot; opacity=&quot;.12&quot;><circle stroke=&quot;%230C1B3D&quot; stroke-width=&quot;0.4&quot; cx=&quot;100&quot; cy=&quot;100&quot; r=&quot;96&quot;/><circle stroke=&quot;%236EC1F5&quot; stroke-width=&quot;0.4&quot; cx=&quot;100&quot; cy=&quot;100&quot; r=&quot;70&quot;/></g></svg>');"></div>
    <div class="container relative z-10 mx-auto px-6 lg:px-12">
        <div class="mb-14 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.4em]" style="color: #636c93;">Impact</p>
            <h2 class="mt-4 text-3xl font-bold md:text-4xl" style="color: #0C1B3D;">Our School in Numbers</h2>
            <p class="mt-4 text-lg max-w-2xl mx-auto" style="color: #343b57;">A snapshot of growth across our Cambridge and Islamic streams.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['label' => 'Students', 'value' => '1200+', 'copy' => 'Across Early Years to A-Level', 'icon' => 'M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z'],
                    ['label' => 'Teachers', 'value' => '85', 'copy' => 'Certified international faculty', 'icon' => 'M5 13l4 4L19 7'],
                    ['label' => 'Years', 'value' => '15+', 'copy' => 'Established excellence', 'icon' => 'M9 12l2 2 4-4'],
                    ['label' => 'Success Rate', 'value' => '98%', 'copy' => 'IGCSE & A-Level results', 'icon' => 'M5 13l4 4L19 7'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="group rounded-3xl border bg-white p-8 shadow-card transition hover:-translate-y-1" style="border-color: rgba(226, 232, 240, 0.8);">
                    <div class="mb-6 inline-flex rounded-2xl p-3" style="background-color: rgba(12, 27, 61, 0.1); color: #0C1B3D;">
                        <svg class="h-6 w-6 md:h-7 md:w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24" height="24">
                            <path d="{{ $stat['icon'] }}" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div class="text-4xl font-bold" style="color: #0C1B3D;">{{ $stat['value'] }}</div>
                    <div class="mt-2 text-sm font-semibold uppercase tracking-widest" style="color: #636c93;">{{ $stat['label'] }}</div>
                    <p class="mt-4" style="color: #343b57;">{{ $stat['copy'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-16 grid gap-6 rounded-3xl p-10 text-white md:grid-cols-2" style="background-color: #0C1B3D;">
            <div>
                <p class="text-sm uppercase tracking-[0.4em]" style="color: rgba(255, 255, 255, 0.9);">Admissions</p>
                <h3 class="mt-3 text-3xl font-bold text-white">Join a community grounded in faith and excellence.</h3>
            </div>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-end">
                <a href="#visit" class="rounded-xl border px-6 py-3 text-center font-semibold text-white transition-all hover:bg-white/10" style="border-color: rgba(255, 255, 255, 0.3);">Schedule a Visit</a>
                <a href="#contact" class="rounded-xl px-6 py-3 text-center font-semibold transition-all" style="background-color: #F4C430; color: #0C1B3D;" onmouseover="this.style.backgroundColor='#ffdc5c'" onmouseout="this.style.backgroundColor='#F4C430'">Talk to Admissions</a>
            </div>
        </div>
    </div>
</section>