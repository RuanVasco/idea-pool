<div class="d-flex justify-content-between align-items-center my-3">
    <h3 class="fw-semibold">Lista de Categorias</h3>

    <button type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#categoryModal"
        onclick="setModal('create')">
        Criar nova categoria
    </button>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $ct): ?>
            <tr>
                <td><?= $ct->getId() ?></td>
                <td><?= htmlspecialchars($ct->getName()) ?></td>
                <td>
                    <button class="btn btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#categoryModal"
                        onclick="setModal('edit', <?= $ct->getId() ?>, '<?= addslashes($ct->getName()) ?>')">
                        ✏️ Editar
                    </button>

                    <button class="btn btn-danger btn-delete"
                        data-id="<?= $ct->getId() ?>">
                        🗑️ Excluir
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="categoryName" class="form-control" placeholder="Nome da categoria">
                <input type="hidden" id="categoryId">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button class="btn btn-primary" id="buttonSave">Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function setModal(mode, id = null, name = '') {
        if (mode === 'create') {
            $('#modalTitle').text('Criar nova categoria');
            $('#categoryId').val('');
            $('#categoryName').val('');
        } else if (mode === 'edit') {
            $('#modalTitle').text('Editar categoria');
            $('#categoryId').val(id);
            $('#categoryName').val(name);
        }
    }

    $('#buttonSave').on('click', () => {
        const name = $('#categoryName').val().trim();
        const id = $('#categoryId').val();

        if (!name) return alert('Por favor, insira um nome.');

        const ajaxOpts = id ? {
            url: `/categories/${id}`,
            type: 'PUT',
            data: {
                name
            }
        } : {
            url: '/categories',
            type: 'POST',
            data: {
                name
            }
        };

        $.ajax(ajaxOpts)
            .done(() => location.reload())
            .fail(() => alert('Erro ao comunicar com o servidor.'));
    });

    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if (!id) return;

        if (!confirm('Confirma exclusão?')) return;

        $.ajax({
                url: `/categories/${id}`,
                type: 'DELETE'
            })
            .done(() => location.reload())
            .fail(() => alert('Erro ao comunicar com o servidor.'));
    });
</script>