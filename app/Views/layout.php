<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Ideas</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<header class="p-3 bg-dark">
		<div class="container">
			<nav>
				<ul class="nav">
					<li class="nav-item"><a class="nav-link text-white" href="/ideas">Home</a></li>
					<li class="nav-item"><a class="nav-link text-white" href="/users">Usuários</a></li>
					<li class="nav-item"><a class="nav-link text-white" href="/categories">Categorias</a></li>
					<li class="nav-item"><a class="nav-link text-white" href="/statuses">Status</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="container">
		<?php require $viewFile; ?>
	</div>
</body>

</html>
