@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-purple-600 dark:text-purple-400 bg-white dark:bg-gray-800 border border-purple-500 rounded-lg p-4 shadow-lg transition-all duration-300 hover:shadow-xl']) }}>
        {{ $status }}
    </div>
@endif
