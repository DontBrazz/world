<?php
session_start();
class MySQL {
    private $host = 'localhost';
    private $dbname = 'worlds';
    private $usuario = 'root';
    private static $instance = null;
    private $senha = '';
    private $conexao;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
            $this->conexao = new PDO($dsn, $this->usuario, $this->senha);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
            exit;
        }
    }


    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new MySQL();
        }
        return self::$instance;
    }
    public function getMySQL() {
        return $this->conexao;
    }

    public function getImagemPais($idPais) {
        try {
            $stmt = $this->conexao->prepare("SELECT imagemPais FROM paises WHERE idPais = ?");
            $stmt->execute([$idPais]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['imagemPais'];            
        } catch (PDOException $e) {
        }

    }
    
    public function registerPais($pais, $imagem)
    {
        $cadastrado = "sim";
        $informacoes = "";
        try {
            $stm = $this->conexao->prepare('UPDATE paises SET imagemPais = ?, informacoes = ?, cadastrado = ? WHERE idPais = ?');
            $stm->bindParam(1, $imagem);
            $stm->bindParam(2, $informacoes);
            $stm->bindParam(3,$cadastrado);
            $stm->bindParam(4, $pais);
            $stm->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar o país' . $e->getMessage();
            return false;
        }
    }

    public function getIdRoom($chave) {
        try {
            $stm = $this->conexao->prepare('SELECT idActiviy FROM activity WHERE chave = ?');
            $stm->execute([$chave]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
    
            if ($result && isset($result['idActiviy'])) {
                return $result['idActiviy'];
            } else {
                return null; 
            }
        } catch (PDOException $e) {
            echo 'Erro ao obter o país: ' . $e->getMessage();
            return null;
        }
    }
    public function listarSalasAluno() {
        try {
            $stmt = $this->conexao->prepare('SELECT * FROM activity WHERE active = ?');
            $stmt->execute(['sim']);
            $salas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $salas;
        } catch (PDOException $e) {
            echo 'Erro ao listar as salas: ' . $e->getMessage();
            return [];
        }
    }
    public function listarSalas() {
        try {
            $stmt = $this->conexao->prepare('SELECT * FROM activity');
            $stmt->execute();
            $salas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $salas;
        } catch (PDOException $e) {
            echo 'Erro ao listar as salas: ' . $e->getMessage();
            return [];
        }
    }
    public function listarHistorico() {
        try {
            $stmt = $this->conexao->prepare('SELECT * FROM history');
            $stmt->execute();
            $salas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $salas;
        } catch (PDOException $e) {
            echo 'Erro ao listar as salas: ' . $e->getMessage();
            return [];
        }
    }

    public function getPais($idActivity) {
        try {
            $stm = $this->conexao->prepare('SELECT idPais FROM activity WHERE idActiviy = ?');
            $stm->execute([$idActivity]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
    

            if ($result && isset($result['idPais'])) {
                $idPais = $result['idPais'];

                $pais = $this->conexao->prepare('SELECT nomePais FROM paises WHERE idPais = ?');
                $pais->execute([$idPais]);
                $nome = $pais->fetch(PDO::FETCH_ASSOC);

                if ($nome && isset($nome['nomePais'])) {
                    return $nome['nomePais'];
                } else {
                    return 'País não encontrado';
                }
            } else {
                return 'ID de atividade não encontrado';
            }
        } catch (PDOException $e) {
            echo 'Erro ao obter o país: ' . $e->getMessage();
            return null;
        }
    }

    
    public function getNomePais($id) {
        try {
            $stm = $this->conexao->prepare('SELECT nomePais FROM paises WHERE idPais = ?');
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result['nomePais'];
        } catch (PDOException $e) {
            echo 'Erro ao obter o país: ' . $e->getMessage();
            return null;
        }
    }

    public function getIdPais($nome) {
        try {
            $stm = $this->conexao->prepare('SELECT idPais FROM paises WHERE nomePais = ?');
            $stm->execute([$nome]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result['idPais'];
        } catch (PDOException $e) {
            echo 'Erro ao obter o país: ' . $e->getMessage();
            return null;
        }
    }
    
    public function getProfessor($idActivy) {
        try {
            $stm = $this->conexao->prepare('SELECT professor FROM activity WHERE idActiviy = ?');
            $stm->execute([$idActivy]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo ''. $e->getMessage();
        }
    }
    public function getChave($id) {
        try {
            $stm = $this->conexao->prepare('SELECT chave FROM activity WHERE idActiviy = ?');
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
    
            if ($result && isset($result['chave'])) {
                return $result['chave'];
            } else {
                return null; 
            }
        } catch (PDOException $e) {
            echo 'Erro ao obter a chave da atividade: ' . $e->getMessage();
            return null;
        }
    }
    public function getData($idActivity) {
        try {
            $stm = $this->conexao->prepare('SELECT datas FROM activity WHERE idActiviy = ?');
            $stm->execute([$idActivity]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['datas'])) {
                $data = date('d/m/Y', strtotime($result['datas']));
                return $data;
            } else {
                return 'Data não encontrada';
            }
        } catch (PDOException $e) {
            echo 'Erro ao obter a data da atividade: ' . $e->getMessage();
            return null;
        }
    }
    
    public function changeStatus($chave, $status) {
        $value = "";
        if ($status == "sim") {
            $value = "nao";
        } else {
            $value = "sim";
        }

        try {
            $stm = $this->conexao->prepare('UPDATE activity SET active = ? WHERE chave = ?');
            $stm->bindParam(1,$value);
            $stm->bindParam(2,$chave);
            $stm->execute();
        } catch (PDOException $e) {
        }
    }
    public function generateCode() {
        $length = 7;
        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= mt_rand(0, 9);
            }
        } while ($this->codeExists($code));
        return $code;
    }
    

    public function createMath($idPais,$tempo) {
        try {
            $chave = $this->generateCode();
            $professor = "Sistema";
            $stage = "1";
            $iniciado = "Nao";
            $alunos = "";
            $perguntas = "";
            $active = "sim";
            $datas = date('Y-m-d');
            $stm = $this->conexao->prepare('INSERT INTO activity (idPais,chave,datas,professor,perguntas,tempo,alunos,iniciado,stage,active) VALUES (:idPais,:chave,:datas,:professor,:perguntas,:tempo,:alunos,:iniciado,:stage,:active)');
            $stm->bindParam(':idPais', $idPais);
            $stm->bindParam(':chave', $chave);
            $stm->bindParam(':datas',$datas);
            $stm->bindParam(':professor',$professor);
            $stm->bindParam(':perguntas',$perguntas);
            $stm->bindParam(':tempo',$tempo);
            $stm->bindParam(':alunos',$alunos);
            $stm->bindParam(':iniciado',$iniciado);
            $stm->bindParam(':stage',$stage);
            $stm->bindParam(':active',$active);
            $stm->execute();
            $idSalaCriada = $this->conexao->lastInsertId();
            if (isset($_SESSION['id'])) {
                unset($_SESSION['id']);
                $_SESSION['id'] = $idSalaCriada;
            } else {
                $_SESSION['id'] = $idSalaCriada;
            }
            header("Location: ./config-classroom.php");
            return true;
        } catch(PDOException $e) {
            echo 'erro ao criar a sala';
            return false;
        }
    }


    public function codeExists($code) {
        $query = "SELECT COUNT(*) AS count FROM activity WHERE chave = :code";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function getPaisesNaoCadastrados() {
        try {
            $stm = $this->conexao->prepare('SELECT idPais, nomePais FROM paises WHERE cadastrado = "nao"');
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Erro ao obter os países não cadastrados: ' . $e->getMessage();
            return false;
        }
    }
    public function getPaisesCadastrado() {
        try {
            $stm = $this->conexao->prepare('SELECT idPais, nomePais FROM paises WHERE cadastrado = "sim"');
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo 'Erro ao obter os países não cadastrados: ' . $e->getMessage();
            return false;
        }
    }

    public function createUser($ra,$senha,$types) {
        try {
            $stm = $this->conexao->prepare('INSERT INTO profile (ra, senha, types) VALUES (:ra, :senha, :types)');
            $stm->bindParam(':ra', $ra);
            $stm->bindParam(':senha', $senha);
            $stm->bindParam(':types', $types);
            $stm->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Erro ao cadastrar o aluno'. $e->getMessage();
            return false;
        }
    }

    public function deleteMath($id) {
        try {
            $stm = $this->conexao->prepare('DELETE FROM activity WHERE idActiviy = :id');
            $stm->bindParam(':id',$id);
            $stm->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Erro ao deletar tal informação'. $e->getMessage();
            return false;
        }
    }

    public function list($table,$variavel) {
        try {
            $stm = $this->conexao->prepare('SELECT $variavel FROM $table');
            $stm->execute();
            $nomes = $stm->fetchAll(PDO::FETCH_COLUMN);
            return $nomes;
        } catch (PDOException $e) {
            echo 'Erro ao listar essa colum'. $e->getMessage();
            return false;
        }
    }

    public function isConnection() {
        if (isset($this->conexao)) {
            return true;
        } else {
            return false;
        }
    }
    public function close() {
        $this->conexao = null;
    }
}