<div class="bg-white overflow-hidden shadow rounded-lg">
  <div class="px-4 py-5 sm:p-6">
    <div class="flex items-center">
      <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
      </div>
      <div class="ml-5 w-0 flex-1">
        <dl>
          <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
            Unique Sessions
          </dt>
          <dd class="flex items-baseline">
            <div class="text-2xl leading-8 font-semibold text-gray-900">
              {{ $period }}
            </div>
            @if ($diff > 0)
            <div class="ml-2 flex items-baseline text-sm leading-5 font-semibold text-green-600" title="Changed from {{ $compare }}">
              <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
              <span class="sr-only">
                Increased by
              </span>
              {{ number_format($diff, 0) }}%
            </div>
            @elseif ($diff < 0)
            <div class="ml-2 flex items-baseline text-sm leading-5 font-semibold text-red-600" title="Changed from {{ $compare }}">
              <svg class="self-center flex-shrink-0 h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
              <span class="sr-only">
                Decreased by
              </span>
              {{ number_format($diff, 0) }}%
            </div>
            @else
            <div class="ml-2 flex items-baseline text-sm leading-5 font-semibold text-blue-600" title="Same as previous">
              <svg class="self-center flex-shrink-0 h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </div>
            @endif
          </dd>
        </dl>
      </div>
    </div>
  </div>
</div>