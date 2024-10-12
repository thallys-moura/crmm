@props([
    'customAttributes' => [],
    'entity'           => null,
    'allowEdit'        => false,
    'url'              => null,
])

@php
    $ignoredAttributes = ['lead_source_id', 'lead_type_id'];
@endphp
<div class="flex flex-col gap-1">
    @foreach ($customAttributes as $attribute)

        @if (!in_array($attribute->code, $ignoredAttributes))  <!-- Verifica se o código do atributo não está na lista -->
            @if (view()->exists($typeView = 'admin::components.attributes.view.' . $attribute->type))
                <div class="grid grid-cols-[1fr_2fr] items-center gap-1">
                    <div class="label dark:text-white">{{ $attribute->name }}</div>

                    <div class="font-medium dark:text-white">
                        @include ($typeView, [
                            'attribute' => $attribute,
                            'value'     => isset($entity) ? $entity[$attribute->code] : null,
                            'allowEdit' => $allowEdit,
                            'url'       => $url,
                        ])
                    </div>
                </div>
            @endif
        @endif
    @endforeach
</div>