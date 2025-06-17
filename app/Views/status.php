<div class="d-flex justify-content-between align-items-center my-3">
	<h3 class="fw-semibold">Lista de Status</h3>

	<button type="button"
		class="btn btn-primary"
		data-bs-toggle="modal"
		data-bs-target="#statusModal"
		onclick="setModal('create')">
		Criar novo status
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
		<?php foreach ($statuses as $st): ?>
			<tr>
				<td><?= $st->getId() ?></td>
				<td><?= htmlspecialchars($st->getName()) ?></td>
				<td>
					<button class="btn btn-warning"
						data-bs-toggle="modal"
						data-bs-target="#statusModal"
						onclick="setModal('edit', <?= $st->getId() ?>, '<?= addslashes($st->getName()) ?>')">
						✏️ Editar
					</button>

					<button class="btn btn-danger btn-delete"
						data-id="<?= $st->getId() ?>">
						🗑️ Excluir
					</button>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="modalTitle"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<input type="text" id="statusName" class="form-control" placeholder="Nome do status">
				<input type="hidden" id="statusId">
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
			$('#modalTitle').text('Criar novo status');
			$('#statusId').val('');
			$('#statusName').val('');
		} else if (mode === 'edit') {
			$('#modalTitle').text('Editar status');
			$('#statusId').val(id);
			$('#statusName').val(name);
		}
	}

	$('#buttonSave').on('click', () => {
		const name = $('#statusName').val().trim();
		const id = $('#statusId').val();

		if (!name) return alert('Por favor, insira um nome.');

		const ajaxOpts = id ? {
			url: `/statuses/${id}`,
			type: 'PUT',
			data: {
				name
			}
		} : {
			url: '/statuses',
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
				url: `/statuses/${id}`,
				type: 'DELETE'
			})
			.done(() => location.reload())
			.fail(() => alert('Erro ao comunicar com o servidor.'));
	});
</script>