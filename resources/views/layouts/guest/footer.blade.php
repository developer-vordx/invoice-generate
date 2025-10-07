<footer class="text-center mt-6 text-sm text-gray-600">
    <p>
        &copy;
        @php
            $startYear = 2025; // Change this to your app's launch year
            $currentYear = date('Y');
        @endphp

        {{ $startYear == $currentYear ? $currentYear : $startYear . '–' . $currentYear }}
        {{ config('app.name', 'ReconX') }}. All rights reserved.
    </p>
</footer>

