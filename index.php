<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();

$paises = $mysql->getPaisesCadastrado();
$nome = null;
foreach ($paises as $pais) {
    $nome[] = $pais['nomePais'];

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<script src="https://unpkg.com/topojson@3"></script>

	<link rel="stylesheet" href="bootstrap.min.css">
	<title>The World - Mundo</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-rR6z4u7ezt6ureuF5F73BzLcHekVJf5Y2n1BSUoBPK8Dq1T7n3U5tJYh3PQgXtB8" crossorigin="anonymous">
	<link rel="stylesheet" href="classes/template/config.css">
	<link rel="stylesheet" href="classes/template/login.css">
	<link rel="stylesheet" href="classes/template/dashboard.css">
	<link rel="stylesheet" href="classes/template/custom.css">
	<link rel="stylesheet" href="classes/template/global.css">
	<link rel="stylesheet" href="classes/template/animation.css">
	<link rel="stylesheet" href="classes/template/global.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Righteous&family=Roboto:wght@400;500;900&display=swap" rel="stylesheet">
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
	<?php $invoke->loadNav(); ?>







	<!-- Modal -->
	<div class="study-modal modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="title"></h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<img id="imagem" src="" alt="Imagem do País" style="width: 500px; display:block; margin:auto;">
				<div class="card text-center">
			
					<div class="modal-body">
						<div class="card-header">
						</div>
						<div class="card-body" style="width: 100%; height: 30rem; overflow-y: scroll;">
						</div>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>




	<!-- <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<h1 class="modal-title text-center">Entrar</h1>
				<div class="modal-body d-flex justify-content-center">
					<form>
						<div class="mb-3" style="width: 45vh;">
							<label for="recipient-email" class="col-form-label">Email</label>
							<input type="text" class="form-control" id="recipient-email">
						</div>
						<div class="mb-3" style="width: 45vh;">
							<label for="recipient-password" class="col-form-label">Senha</label>
							<input type="text" class="form-control" id="recipient-password">
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
							<label class="form-check-label" for="flexCheckDefault">
								Me lembrar
							</label>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-around m1">
					<button type="button" class="btn">Logar</button>
					<a href="">Esqueceu a senha?</a>
				</div>
				<div class="modal-footer  justify-content-center m2">
					<div class="modal-detals"></div>
					<h6>Logar com</h6>
					<div class="modal-detals"></div>
				</div>
				<div class="modal-footer justify-content-center m3">
					<button type="button" class="btn b1">Google</button>
					<button type="button" class="btn b2">Facebook</button>
					<button type="button" class="btn b3">Github</button>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<h1 class="modal-title text-center">Cadastro</h1>
				<div class="modal-body d-flex justify-content-center">
					<form>
						<div class="mb-3" style="width: 45vh;">
							<label for="recipient-email" class="col-form-label">Email</label>
							<input type="text" class="form-control" placeholder="seuemail@gmail.com" id="recipient-email" required>
						</div>
						<div class="mb-3" style="width: 45vh;">
							<label for="recipient-name" class="col-form-label">Usuário</label>
							<input type="text" class="form-control" placeholder="Nome123" id="recipient-name" required>
						</div>
						<div class="mb-3" style="width: 45vh;">
							<label for="telefone" class="col-form-label">Telefone</label>
							<input type="tel" name="telefone" pattern="[0-9]{2} [0-9]{4,5}-[0-9]{4}" class="form-control" placeholder="(00)00000-0000" id="recipient-tel" required>
						</div>
						<div class="mb-3" style="width: 45vh;">
							<label for="senha" class="col-form-label">Digite uma senha</label>
							<input type="password" name="senha" minlength="8" maxlength="20" class="form-control" placeholder="Senha" id="senha" required>
						</div>
						<div class="mb-3" style="width: 45vh;">
							<label for="senha" class="col-form-label">Repita novamente a senha</label>
							<input type="password" name="senha" minlength="8" maxlength="20" class="form-control" placeholder="Senha" id="senha" required>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
							<label class="form-check-label" for="flexCheckDefault">
								Me lembrar
							</label>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-center m1">
					<button type="button" class="btn">Cadastrar</button>
				</div>
			</div>
		</div>
	</div> -->

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
	<script src="js/bootstrap/bootstrap.js"></script>
</body>

<script>



	
	const nomesSA = [];
      fetch(`get/getNomes.php`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro');
            }
            return response.json();
        })
        .then(data => {
	        data.forEach(teste => {
                nomesSA.push(teste);
            })      
       })
        .catch(error => {
            console.error('Erro ao carregar os nomes dos paises:', error);
        });

	function reload() {
		setTimeout(function()  {
			if (!d3.select('svg').empty()) {
				d3.select('svg').remove();
				carregarWorld();
			} else {
			carregarWorld();
			}
		},100);
	}
	document.addEventListener('DOMContentLoaded', function() {
		reload();
	})

				 
	function carregarWorld() {
		const width = 500;
		const height = 500;
		const svg = d3.select('body')
			.append('div')
			.attr('id', 'world')
			.append('svg')
			.attr('width', width)
			.style('transform', 'translateY(30%)')
			.attr('height', height);

		const projection = d3.geoOrthographic()
			.scale(width / 2)
			.translate([width / 2, height / 2])
			.precision(0.6);

		const path = d3.geoPath().projection(projection);

		const zoom = d3.zoom()
			.scaleExtent([1, 8])
			.on('zoom', zoomed);

		svg.call(zoom);

		d3.json('json/countries-50m.json')
			.then(data => {
				const countryNames = data.objects.countries.geometries.map(country => country.properties.name);
				console.log(countryNames);
				const countries = topojson.feature(data, data.objects.countries).features;

				svg.selectAll('path')
					.data(countries)
					.enter()
					.append('path')
					.attr('d', path)
					.classed('gelo', function(d) {
						//Adiciona a class em especifico para o Antarctica!
						//&& names.includes('Antarctica')
						return d.properties.name === "Antarctica" && nomesSA.includes('Antarctica') ? true : false;
					})
					.classed('unlocked', function(d) {
						//Adiciona a class em especifico para os paises liberados pelo sistema!
						//names.includes(d.properties.name) && 
						return nomesSA.includes(d.properties.name) && d.properties.name !== 'Antarctica' ? true : false;
					})
					.on('mouseover', mouseover)
					.on('mouseout', mouseout)
					.on('click', function(event, d) {
						clicked(event, d, data);
					});

				//Partes dos textos dos paises!
				const paises = svg.selectAll('.country-label')
					.data(countries)
					.enter()
					.append('text')
					.attr('class', 'country-label')
					.text(d => {
						const countryInfo = data.objects.countries.geometries.find(c => c.id === d.id);
						return countryInfo ? countryInfo.properties.name : '';
					})
					.attr('dy', '0.35em')
					.style('text-anchor', 'middle')
					.style('alignment-baseline', 'middle')
					.style('font-size', '9px')
					.style('fill', 'black')
					.attr('opacity', 1);

				//Evento de recarregar os nomes!
				function updatePaises() {
					svg.selectAll('.country-label')
						.attr('transform', d => {
							const [lon, lat] = d3.geoCentroid(d);
							const [x, y] = projection([lon, lat]);
							return `translate(${x},${y})`;
						});
					paises.attr('opacity', d => isCountryVisible(d) ? 1 : 0);
					paises.style('display', 'flex');

				}



				function isCountryVisible(d) {
					const [lon, lat] = d3.geoCentroid(d);
					const [x, y] = projection([lon, lat]);
					const [inverseLon, inverseLat] = projection.invert([x, y]);
					return d3.geoContains(d, [inverseLon, inverseLat]);
				}

				svg.on('mousemove', throttle(updatePaises, 100));

				function throttle(func, interval) {
					let lastCallTime = 0;

					return function() {
						const now = Date.now();

						if (now - lastCallTime >= interval) {
							func.apply(this, arguments);
							lastCallTime = now;
						}
					};
				}
			});

		//Bloqueia o click do botao direito!
		document.addEventListener("contextmenu", function(e) {
			e.preventDefault();
		});

		//Sistema de zoom do mapa!
		function zoomed() {
			svg.selectAll('.country-label').attr('opacity', 0).style('display', 'none');
			const transform = d3.event.transform;
			const event = d3.event.sourceEvent;
			if (transform) {
				if (event.type === 'wheel') {
					projection.scale(transform.k * (width / 2 - 10)); // Ajustando a escala
				} else {
					const sensitivity = 0.40;
					const rotationScale = sensitivity / transform.k;
					projection.rotate([transform.x * rotationScale % 360, -transform.y * rotationScale]);

				}
				svg.selectAll('path').attr('d', path);
			}
		}

		function mouseover(event, d) {
			d3.select(this).attr('fill', '#1565C0');
		}

		function mouseout(event, d) {
			d3.select(this).attr('fill', '#2196F4');
		}


		function clicked(event, d, jsonData) {
			const index = d;
			const countryInfo = jsonData.objects.countries.geometries[index];
			const countryName = countryInfo ? countryInfo.properties.name : null;
			open(countryName);
        }

		function open(name) {
			fetch('get/getWorld.php?nomePais=' + name)
			.then(response => response.json())
			.then(data => {
				const modalTitle = document.getElementById('title');
				modalTitle.innerHTML = `<strong>País:</strong> ${name}`;

				const imagem = document.getElementById("imagem");
				imagem.src = data.imagem;

				const cardBody = document.querySelector('.card-body');
				cardBody.innerHTML = ''; // Limpa o conteúdo existente

				if (typeof data.categoria === 'object' && !Array.isArray(data.categoria)) {
					let ulElements = document.querySelector('.nav-tabs');
					if (ulElements) {
						ulElements.remove(); // Remove a lista de categorias existente, se houver
					}

					const ulElement = document.createElement('ul');
					ulElement.classList.add('nav', 'nav-tabs', 'card-header-tabs');
					let active = false;
					for (const key in data.categoria) {
						if (Object.prototype.hasOwnProperty.call(data.categoria, key)) {
							if (key !== 'id') {
								
								const liElement = document.createElement('li');
								liElement.classList.add('nav-item');

								const aElement = document.createElement('a');
								aElement.classList.add('nav-link');
								aElement.setAttribute('href', '#');
								aElement.textContent = key;
								if (!active) {
									const categoriaSelecionada = key;
									const informacoesDaCategoria = data.categoria[key];
									let infor = document.querySelectorAll('.info-div');
									infor.forEach(element => {
										element.remove();
									});
									for (const prop in informacoesDaCategoria) {
										if (Object.prototype.hasOwnProperty.call(informacoesDaCategoria, prop)) {

											const info = informacoesDaCategoria[prop];
											const infoDiv = document.createElement('div');
											infoDiv.classList.add('info-div');
											
											const title = document.createElement('h5');
											title.classList.add('card-title');
											title.textContent = info.titulo || ''; // Verifica se há título
											const text = document.createElement('p');
											text.classList.add('card-text');
											text.innerHTML = info.descricao || ''; 
											if (!info.imagem64 == "") {
												const img = document.createElement('img');
												img.src = 'data:' + info.imagemtype + ';base64,'+ info.imagem64;
												img.style.width = info.pixel;
												img.style.display = "block";
												img.style.margin = "auto";			
												infoDiv.appendChild(img);
											}
											infoDiv.appendChild(title);
											infoDiv.appendChild(text);
											cardBody.appendChild(infoDiv);
										}
									}
									active = true;
								}
								// Cria uma função de evento que não será duplicada
								const clickHandler = function(event) {
									event.preventDefault(); // Previne o comportamento padrão do link
									const categoriaSelecionada = key;
									const informacoesDaCategoria = data.categoria[key];
									let infor = document.querySelectorAll('.info-div');
									infor.forEach(element => {
										element.remove();
									});
									for (const prop in informacoesDaCategoria) {
										if (Object.prototype.hasOwnProperty.call(informacoesDaCategoria, prop)) {

											const info = informacoesDaCategoria[prop];
											const infoDiv = document.createElement('div');
											infoDiv.classList.add('info-div');
											
											const title = document.createElement('h5');
											title.classList.add('card-title');
											title.textContent = info.titulo || ''; // Verifica se há título
											const text = document.createElement('p');
											text.classList.add('card-text');
											text.innerHTML = info.descricao || ''; // Verifica se há descrição
											if (!info.imagem64 == "") {
												const img = document.createElement('img');
												img.src = 'data:' + info.imagemtype + ';base64,'+ info.imagem64;
												img.style.width = info.pixel;
												img.style.display = "block";
												img.style.margin = "auto";			
												infoDiv.appendChild(img);
											}

											infoDiv.appendChild(title);
											infoDiv.appendChild(text);
											cardBody.appendChild(infoDiv);
										}
									}
								};

								aElement.addEventListener('click', clickHandler);
								liElement.appendChild(aElement);
								ulElement.appendChild(liElement);
							}
						}
					}

					const cardHeader = document.querySelector('.card-header');
					cardHeader.appendChild(ulElement);
				}

				const modal = new bootstrap.Modal(document.getElementById('exampleModal'), {
					keyboard: false
				});
				modal.show();
			})
			.catch(error => {
			});

		}
		
		
		
	}
</script>

</html>