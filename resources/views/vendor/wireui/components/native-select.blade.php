<div class="@if ($disabled) opacity-60 @endif">
    @if ($label)
        <x-dynamic-component :component="WireUi::component('label')"
            class="mb-1"
            :label="$label"
            :has-error="$errors->has($name)"
            :for="$id" />
    @endif

    <select
        {{ $attributes->class([$defaultClasses(), $errorClasses() => $errors->has($name), $colorClasses() => !$errors->has($name)])->merge([
                'class' => 'focus:outline-none focus:ring-1 focus:ring-transparent   focus:border focus:border-positive-500',
            ]) }}>
        @if ($options->isNotEmpty())
            @if ($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif

            @forelse ($options as $key => $option)
                <option value="{{ $getOptionValue($key, $option) }}"
                    @if (data_get($option, 'disabled', false)) disabled @endif>
                    {{ $getOptionLabel($option) }}
                </option>
            @empty
                <option disabled>
                    @lang('wireui::messages.empty_options')
                </option>
            @endforelse
        @else
            {{ $slot }}
        @endif
    </select>

    @if ($hint)
        <label @if ($id) for="{{ $id }}" @endif
            class="mt-2 text-sm text-secondary-500 dark:text-secondary-400">
            {{ $hint }}
        </label>
    @endif

    @if ($name)
        <x-dynamic-component :component="WireUi::component('error')"
            :name="$name" />
    @endif
</div>
