<table class="filament-table w-full">
    <thead>
        <tr>
            <th class="px-4 py-2">Top Book</th>
            <th class="px-4 py-2">Top Author</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < max(count($books), count($authors)); $i++)
            <tr class="border-t">
                <td class="px-2 py-2">{{ $books[$i]->title ?? '-' }}</td>
                <td class="px-2 py-2">{{ $authors[$i]->name ?? '-' }}</td>
            </tr>
        @endfor
    </tbody>
</table>
