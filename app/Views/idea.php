<h1>Lista de Idéias</h1>
<div>
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ideaModal">
		Criar Nova Idéia
	</button>
</div>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Título</th>
			<th>Descrição</th>
			<th>Autor</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($ideas as $idea): ?>
			<tr>
				<td><?= htmlspecialchars($idea['id']) ?></td>
				<td><?= htmlspecialchars($idea['title']) ?></td>
				<td><?= htmlspecialchars($idea['description']) ?></td>
				<td><?= htmlspecialchars($idea['author']) ?></td>
				<td><a href="/ideas/<?= $idea['id'] ?>">Ver Detalhes</a></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="modal fade" id="ideaModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5">Criar nova idéia</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control" placeholder="Título da Idéia" aria-label="Título da Idéia">
				<input type="text" class="form-control mt-2" placeholder="Descrição da Idéia" aria-label="Descrição da Idéia">
				<select>
					<option value="" disabled selected>Selecione uma Categoria</option>
					<?php foreach ($categories as $category): ?>
						<option value="<?= htmlspecialchars($category->getId()) ?>"><?= htmlspecialchars($category->getName()) ?></option>
					<?php endforeach; ?>
				</select>
				<select>
					<option value="" disabled selected>Selecione um Status</option>
					<?php foreach ($statuses as $status): ?>
						<option value="<?= htmlspecialchars($status->getId()) ?>"><?= htmlspecialchars($status->getName()) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
				<button type="button" class="btn btn-primary">Salvar</button>
			</div>
		</div>
	</div>
</div>