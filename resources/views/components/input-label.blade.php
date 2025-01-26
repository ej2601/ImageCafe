@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-white dark:text-white mb-1 transition ease-in-out duration-150']) }}>
    {{ $value ?? $slot }}
</label>
