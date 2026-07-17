@props(['editUrl' => '', 'deleteUrl' => ''])

<td data-label="Ações">
    <div class="cell-actions">
        @if($editUrl)
        <x-botao size="sm" :href="$editUrl">Editar</x-botao>
        @endif
        @if($deleteUrl)
        <x-botao size="sm" variant="danger-ghost" type="button" onclick="openDeleteModal('{{ $deleteUrl }}', 'Tem certeza que deseja excluir este registro? Esta ação é irreversível.')">Excluir</x-botao>
        @endif
    </div>
</td>
