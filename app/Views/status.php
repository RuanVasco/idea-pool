<h1>Lista de Status</h1>
<div>
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ideaModal">
		Criar novo status
	</button>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Status</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($statuses as $status): ?>
			<tr>
				<td><?= htmlspecialchars($status->getId()) ?></td>
				<td><?= htmlspecialchars($status->getName()) ?></td>
				<td>
					<button class="btn-edit" data-id="<?= $status->getId() ?>">✏️ Editar</button>
					<button>Excluir</button>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="modal fade" id="ideaModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Criar novo status</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control" placeholder="Nome do status" aria-label="Nome do status">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
				<button type="button" class="btn btn-primary" id="buttonSave">Salvar</button>
			</div>
		</div>
	</div>
</div>

<script>
	$("#buttonSave").click(function() {
		const statusName = $(".modal-body input").val();
		if (statusName) {
			$.ajax({
				url: "/statuses/create",
				type: "POST",
				data: {
					name: statusName
				},
				success: function(response) {
					location.reload();
				},
				error: function() {
					alert("Erro ao comunicar com o servidor.");
				}
			});
		} else {
			alert("Por favor, insira um nome para o status.");
		}
	});

	$("#buttonEdit").click(function(self) {
		const statusId = $(this).data("id");

		if (!statusId) return;

		$.ajax({
			url: `/statuses/${statusId}`,
			type: "DELETE",
			success: function(response) {
				location.reload();
			},
			error: function() {
				alert("Erro ao comunicar com o servidor.");
			}
		});
	});
</script>