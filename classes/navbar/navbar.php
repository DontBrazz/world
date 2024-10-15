
<?php
require_once("classes/Controller.php");
require_once("classes/mysql/MySQLController.php");
require_once("classes/JSON.php");
$mysql = new MySQL();
$controller = new Controller();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logar'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        
        $user = "Escola_Admin";
        $pass =  "marcelino2233";

        if ($usuario == $user && $senha == $pass) {
            $_SESSION["admin"] = $usuario;
        }

    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['deslogar'])) {
        unset($_SESSION['admin']);
        header("Location: ".$_SERVER['PHP_SELF']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pagina']) || isset($_GET['pagina'])) {
        // Obtém o valor da página do POST
        $pagina = $_POST['pagina'];
        if ($pagina == 'index' || $pagina2 == 'index') {
            if ($mysql->isConnection() != null) {
                $mysql->close();
            }
            include('index.php');
            exit;
        } elseif ($pagina == 'atividades') {
            include('atividades.php');
        } else {
            echo 'Página não encontrada.';
        }
    } 
}

?>
<div class="sidebar close">
        <div class="logo-details">
            <!-- <span class="logo_name">The World</span> -->
            <a class="logo_name" href="#"><span class="letter-1">T</span><span
                                class="letter-2">h</span><span class="letter-3">e</span><span
                                class="letter-4"> W</span><span class="letter-5">o</span><span
                                class="letter-6">r</span><span class="letter-7">l</span><span
                                class="letter-8">d</span></a>
        </div>
        <ul class="nav-links">
            <li class="h">
                <a href="index.php">
                    <i class='selected bx bx-world'></i>
                    <span class="link_name">Mundo</span>
                </a>
                <li class="h">
                    <a href="activity.php">
                        <i class='bx bx-news'></i>
                        <span class="link_name">Atividades</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="activity.php">Atividades</a></li>
                    </ul>
                </li>
            <li class="h">
                <a href="classroom-log.php">
                    <i class='bx bx-key'></i>
                    <span class="link_name">Histórico</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="log.php">Histórico</a></li>
                </ul>
            </li>
            <!-- <button class="bttn" data-bs-toggle="modal" data-bs-target="#register">Cadastrar</button>
            <button class="bttn" data-bs-toggle="modal" data-bs-target="#login">login</button> -->
            <?php 
            
            if (isset($_SESSION['admin'])) {
                echo '<li id="teste" class="h">
                <div class="iocn-link">
                    <a href="#">
                        <i class="bx bx-code"></i>
                        <span class="link_name">cPainel</span>
                    </a>
                    <i class="bx bxs-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Admin</a></li>
                    <li><a href="register-map.php">Cadastrar</a></li>
                    <li><a href="content-map.php">Matéria</a></li>
                    <li><a href="key-classroom.php">Criar sala</a></li>
                    <li><a href="list-classroom.php">Lista sala</a></li>
                </ul>
            </li>';
            }

            ?>
            
            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        <img src="https://as2.ftcdn.net/v2/jpg/03/49/49/79/1000_F_349497933_Ly4im8BDmHLaLzgyKg2f2yZOvJjBtlw5.jpg"
                            alt="profileImg">
                    </div>
                    <div class="name-job">
                    <div class="profile_name"><?php echo $controller->getUser();?></div>
                        <div class="job"><?php echo $controller->getStats();?></div>
                    </div>
                    <?php
                    if (isset($_SESSION['admin'])) {
                        echo '<form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">';
                        echo '<button type="submit" name="deslogar"><i class="bx bx-door-open""></i></button>';
                        echo '</form>';
                    } else {
                        echo '<button><i class="bx bx-door-open" data-bs-toggle="modal" data-bs-target="#login"></i></button>';
                    }
                    ?>
                </div>
                <!-- <div class="profile-details">
                    <div class="profile-content">
                        <img src="https://cdn.discordapp.com/avatars/639209589753118750/10de8f1a1219893389240dcf618432b6.png"
                            alt="profileImg">
                    </div>
                    <div class="name-job">
                        <div class="profile_name">ReFlexoo</div>
                        <div class="job">Administrador</div>
                    </div>
                    <i class='bx bx-log-out'></i>
                </div> -->
            </li>
        </ul>
    </div>
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <h1 class="modal-title text-center">Entrar</h1>
                        
                        <div class="modal-body d-flex justify-content-center">
                            <form data-name="" id="pais" name="pais-form" method="post" aria-label="Form">
                                <div class="mb-3" style="width: 45vh;">
                                    <label for="recipient-email" class="col-form-label">Usuario</label>
                                    <input type="text" name="usuario" class="form-control" id="recipient-email">
                                </div>
                                <div class="mb-3" style="width: 45vh;">
                                    <label for="recipient-password" class="col-form-label">Senha</label>
                                    <input type="password" name="senha" class="form-control" id="recipient-password">
                                </div>
                                <div class="modal-footer justify-content-around m1">
                            <button type="submit" name="logar" class="btn">Logar</button>
 
                        </div>
                            </form>
                        </div>

                    </div>
        </div>
    </div>
    <script src="../js/controller.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let navLinks = document.querySelectorAll('.nav-links .h > a');
        let currentUrl = window.location.href;

        navLinks.forEach(link => {
            if (currentUrl === "http://localhost/project/register-map.php" || currentUrl === "http://localhost/project/content-map.php" || currentUrl === "http://localhost/project/key-classroom.php") {
                console.log('teste');
                document.getElementById('teste').classList.add('h-selected');
            } else {
                if (link.href === currentUrl) {
                link.parentElement.classList.add('h-selected');
            }
            }
         
        });
    });
        </script>
    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        console.log(sidebarBtn);
        document.addEventListener('DOMContentLoaded', function() {
            sidebar.classList.toggle("close");
        })
  
    </script>
    <script>
    function requestPage(name) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "request.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
        xhr.setRequestHeader("X-CSRF-Token", name);

        xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("teste");
        }
        };
        xhr.send();
    }

    </script>
    <script>
        function changePage(page) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'navbar.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('pagina=' + encodeURIComponent(page));
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            document.open();
            document.write(xhr.responseText);
            document.close();
            console.log('pagina trocada');
        } else {
            console.error('Erro na solicitação:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error('Erro na solicitação.');
    };
    xhr.send();
}
    </script>