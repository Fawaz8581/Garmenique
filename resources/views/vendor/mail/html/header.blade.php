@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Garmenique')
GARMENIQUE
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
