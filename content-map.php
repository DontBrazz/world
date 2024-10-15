<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$invoke = new Controller();
$mysql = new MySQL();
$json = new JSONS();
$paises = $mysql->getPaisesCadastrado();
if (!isset($_SESSION['admin'])) {
    header('Location: ./index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['salvar'])) {
        $pais = $_POST['paisSelected'];
        $categoria = $_POST['categorys'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricaoPais'];
        $pixel = $_POST['pixel'];

        
            $tempName = $_FILES['urlimagem']['tmp_name'];
            if ($tempName == null) {
                $type = '';
                $base64Content = '';
                $content = '';
            } else {
                $content = file_get_contents($tempName);
                $base64Content = base64_encode($content);
                $type = $_FILES['urlimagem']['type'];
  
            }

        try {
            $json->addInformacoesPais($pais,$titulo,$categoria,$descricao,$content,$type,$pixel);
            header("Location: ./");
            exit;
        } catch (Exception $e) {
            echo 'Nao foi possivel cadastrar o pais';
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addCategoria'])) {
        $pais = $_POST['paisSelected'];
        if ($pais != null){
            $categoria = $_POST['categoria'];
            try {
                $json->addCategoriaPais($pais,$categoria);
            } catch (Exception $e) {
            }
        }
    }
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
    <title>The World - Painel</title>
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
</head>

<body>
    <?php $invoke->loadNav(); ?>




    <!-- <div class="painel-admin">
        <form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">
            <div class="register-map">
                <div class="container">    
                    <h1>CADASTRAR PAIS</h1>
                    <div class="register-body">
                        <div class="row row-cols-md-2">
                            <div class="col">
                                <div class="card">
                                    <h3>PAIS</h3>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="paisSelected">
                                    <option selected>Selecione um país</option>
                                    <?php foreach ($paises as $pais) : ?>
                                        <option value="<?php echo $pais['idPais']; ?>"><?php echo $pais['nomePais']; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <h3>Titulo</h3>
                                    <div class="mb-3">
                                        <textarea class="form-control" id="tituloPais" name="tituloPais" rows="1" placeholder="Titulo do pais"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card g2">
                                    <h3>Imagem</h3>
                                    <div class="mb-3">
                                        <textarea class="form-control" id="urlImagem" name="urlImagem" rows="1" placeholder="URL da imagem"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card g2">
                                    <h3>Descrição</h3>
                                    <div class="mb-3">
                                        <textarea class="form-control" id="descricaoPais" name="descricaoPais" rows="3" placeholder="Descricão do pais"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="salvar" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> -->


    <div class="cPainel-controller">
        <form data-name="" id="pais" name="pais-form" method="post" aria-label="Form"  enctype="multipart/form-data">
            <div class="row row-cols-md-2">

                <div class="col debug"></div>

                <div class="col">
                    <div class="content-map">
                        <div class="container">
                                <div class="content-body" style="height: 730px;">
                                    <h1><i class='bx bx-cabinet'></i><br> Anexar matéria</h1>
                                    <div class="form">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-map'></i> Páis</label>
                                            <select class="form-select form-select-sm" id="paisSelected" aria-label=".form-select-sm example" name="paisSelected">
                                                <option selected>Selecione um país</option>
                                                <?php foreach ($paises as $pais) : ?>
                                                    <option value="<?php echo $pais['idPais']; ?>"><?php echo $pais['nomePais']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-pen'></i> Titulo</label>
                                            <input type="text" class="form-control" name="titulo" id="exampleInputEmail1" placeholder="Escreva um titulo" aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <div class="row row-cols-md-2 d-flex justify-content-between">
                                                <div class="col col-md-5">
                                                    <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-menu'></i> Categoria</label>
                                                    <select id="categorys" class="form-select form-select-sm" name="categorys" aria-label=".form-select-sm example">
                   
                                                    </select>
                                                </div>
                                                <div class="col col-md-6">
                                                        <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-plus'></i> Nova categoria</label>
                                                        <input type="text" class="form-control" name="categoria" id="exampleInputEmail1" placeholder="Digite uma nova categoria" aria-describedby="emailHelp">
                                                    </div>
                                                    <div class="col col-md-1 d-flex align-items-end">
                                                    <button class="add" name="addCategoria"><i class='bx bx-plus'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 img">
                                            <div class="row row-cols-md-2 d-flex justify-content-between">
                                                <div class="col col-md-5">
                                                    <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-menu'></i> Pixel</label>
                                                    <select id="pixel" class="form-select form-select-sm" name="pixel" aria-label=".form-select-sm example">
                                                        <option value="10px">10px</option>
                                                        <option value="20px">20px</option>
                                                        <option value="30px">30px</option>
                                                        <option value="50px">50px</option>
                                                        <option value="100px">100px</option>
                                                        <option value="150px">150px</option>
                                                        <option value="190px">190px</option>
                                                        <option value="200px">200px</option>
                                                        <option value="240px">240px</option>
                                                        <option value="250px">250px</option>
                                                        <option value="290px">290px</option>
                                                        <option value="300px">300px</option>
                                                        <option value="340px">340px</option>
                                                        <option value="350px">350px</option>
                                                        <option value="380px">380px</option>
                                                        <option value="400px">400px</option>
                                                        <option value="450px">450px</option>
                                                        <option value="500px">500px</option>
                                                    </select>
                                                </div>
                                                <div class="col col-md-7">
                                                <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-image'></i> Imagem</label>
                                                <input type="file" name="urlimagem" class="form-control" id="inputGroupFile02">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label"><i class='bx bx-text'></i> Descrição</label>
                                            <textarea class="form-control desc" id="descricaoPais" name="descricaoPais" rows="2" placeholder="Descricão do pais"></textarea>

                                            <script src="https://cdn.tiny.cloud/1/tzeegs0w6e0km1cr0altlpy606l0zjiucgu8o470tnqd21hp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
                                            <script>
                                            tinymce.init({
                                                selector: '#descricaoPais',
                                                plugins: 'lists link image table code',
                                                toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  h1 h2 h3 h4 | code',
                                                menubar: false,
                                                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                                                height: 200,
                                                setup: function (editor) {
                                                editor.on('keydown', function (event) {
                                                if (event.keyCode === 13) {  // Verifica se a tecla pressionada é Enter
                                                    event.preventDefault();    // Previne o comportamento padrão
                                                    editor.execCommand('InsertLineBreak');  // Insere uma quebra de linha <br>
                                                }
                                                });
                                            }
                                            });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="button d-flex justify-content-center">
                                        <button type="submit" name="salvar" class="btn btn-primary">Adicionar</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectPais = document.getElementById('paisSelected');
        var selectCategoria = document.getElementById('categorys');
        
        selectPais.addEventListener('change', function() {
            var paisSelecionado = selectPais.value;
            
            fetch('get/loadCategory.php?id=' + paisSelecionado)
                .then(response => response.json())
                .then(data => {
                    selectCategoria.innerHTML = '';
                    var optionDefault = document.createElement('option');
                    optionDefault.textContent = 'Selecionar';
                    optionDefault.value = '';
                    selectCategoria.appendChild(optionDefault);
                    if (typeof data === 'object' && !Array.isArray(data)) {
                        for (const key in data) {
                            if (Object.prototype.hasOwnProperty.call(data, key)) {
                                if (key !== 'id') {
                                    var option = document.createElement('option');
                                    option.textContent = key;
                                    option.value = key;
                                    selectCategoria.appendChild(option);
                                }
                            }
                        }
                    } else {
                        console.error('O servidor retornou dados no formato incorreto:', data);
                    }
                })
                .catch(error => console.error('Erro ao carregar informações:', error));
        });
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.12.1/js/all.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>
</body>

</html>