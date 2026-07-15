@props(['editUrl' => '', 'deleteUrl' => ''])

<td data-label="Ações">
    <div class="cell-actions">
        @if($editUrl)
        <x-botao size="sm" :href="$editUrl">Editar</x-botao>
        @endif
        @if($deleteUrl)
        <form action="{{ $deleteUrl }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmar exclusão?')">
            @csrf
            @method('DELETE')
            <x-botao size="sm" variant="danger-ghost" type="submit">Excluir</x-botao>
        </form>
        @endif
    </div>
</td>
