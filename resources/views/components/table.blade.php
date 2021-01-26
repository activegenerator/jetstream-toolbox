<table {{ $attributes->merge(['class' => 'rounded-lg table-auto border-collapse w-full whitespace-no-wrap bg-white relative']) }}>
    <thead class="bg-gray-50">
        <tr class="text-left">
            {{ $head }}
        </tr>
    </thead>
    <tbody>
        {{ $body }}
    </tbody>
</table>
