@if($invoice->activities->count())
    <div class="mt-12 border-t border-gray-200 pt-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-history text-blue-500 mr-2"></i> Invoice Activity Log
        </h3>

        <div class="relative">
            <!-- Vertical line for timeline -->
            <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-gray-200"></div>

            <ul class="space-y-6 ml-10">
                @foreach($invoice->activities->sortByDesc('created_at') as $activity)
                    <li class="relative">
                        <!-- Dot -->
                        <div class="absolute -left-7 top-1.5 w-3 h-3 rounded-full
                            @if(str_contains(strtolower($activity->activity_type), 'success')) bg-green-500
                            @elseif(str_contains(strtolower($activity->activity_type), 'reject')) bg-red-500
                            @elseif(str_contains(strtolower($activity->activity_type), 'accept')) bg-blue-500
                            @elseif(str_contains(strtolower($activity->activity_type), 'email')) bg-yellow-500
                            @elseif(str_contains(strtolower($activity->activity_type), 'create')) bg-indigo-500
                            @elseif(str_contains(strtolower($activity->activity_type), 'download')) bg-purple-500
                            @else bg-gray-400 @endif"></div>

                        <!-- Content -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ ucfirst($activity->activity_type) }}
                                    </p>
                                    <p class="text-gray-700 text-sm mt-1">
                                        {{ $activity->message ?? 'No message available.' }}
                                    </p>
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap">
                                    {{ $activity->created_at->format('M d, Y h:i A') }}
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
