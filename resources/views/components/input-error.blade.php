@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1 mt-2 p-3 bg-red-50 dark:bg-red-900 border border-red-600 rounded-md']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center">
                <!-- Optional icon for errors -->
                <svg class="w-4 h-4 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 1a1 1 0 01.707.293l8 8a1 1 0 010 1.414l-8 8A1 1 0 0110 18V2a1 1 0 01.293-.707L10 1zm0 2v14a1 1 0 00.293-.707l8-8-8-8A1 1 0 0010 3z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
