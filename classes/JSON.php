<?php
require_once("mysql/MySQLController.php");
$mysql = new MySQL();
class JSONS {
    public function getPergunta($param, $id) { 
        global $mysql;
        try {
          $stm = $mysql->getMySQL()->prepare('SELECT perguntas FROM activity WHERE idActiviy = ?');    
          $stm->execute([$id]);
          $result = $stm->fetch(PDO::FETCH_ASSOC);
          $perguntas = json_decode($result['perguntas'], true);
          return $perguntas[$param]['question'];
        } catch (PDOException $e) {
            echo 'Erro ao receber as informações'. $e->getMessage();
        }
    }
    public function getResposta($param,$repost, $id) {
        global $mysql;
        try {
          $stm = $mysql->getMySQL()->prepare('SELECT perguntas FROM activity WHERE idActiviy = ?');    
          $stm->execute([$id]);
          $result = $stm->fetch(PDO::FETCH_ASSOC);
          $perguntas = json_decode($result['perguntas'], true);
          return $perguntas[$param][$repost];
        } catch (PDOException $e) {
            echo 'Erro ao receber as informações'. $e->getMessage();
        }
    }
    public function listQuestions($id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT perguntas FROM activity WHERE idActiviy = ?');
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
    
            if ($result && isset($result['perguntas']) && !empty($result['perguntas'])) {
                $alunos = json_decode($result['perguntas'], true);
                return $alunos;
            } else {
                return []; // ou outra ação adequada se não houver perguntas definidas
            }
        } catch (PDOException $e) {
            echo 'Erro ao listar as perguntas: ' . $e->getMessage();
        }
    }
    public function getRespostaCorreta($param, $id) {
        global $mysql;
        try {
          $stm = $mysql->getMySQL()->prepare('SELECT perguntas FROM activity WHERE idActiviy = ?');    
          $stm->execute([$id]);
          $result = $stm->fetch(PDO::FETCH_ASSOC);
          $perguntas = json_decode($result['perguntas'], true);
          return $perguntas[$param]['respostaCorreta']['id'];
        } catch (PDOException $e) {
            echo 'Erro ao receber as informações'. $e->getMessage();
        }
    }
    public function getAlunos($idActivy) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT alunos FROM activity WHERE idActiviy = ?');
            $stm->execute([$idActivy]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            
            // Verifica se encontrou o registro
            if ($result) {
                $alunos = json_decode($result['alunos'], true);
                return $alunos;
            } else {
                echo 'Não foi possível encontrar a atividade com o ID ' . $idActivy;
                return null;
            }
        } catch (PDOException $e) {
            echo 'Erro ao buscar os alunos da atividade: ' . $e->getMessage();
            return null;
        }
    }
    public function getAlunosHistory($id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT alunos FROM history WHERE idHistory = ?');
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            
            // Verifica se encontrou o registro
            if ($result) {
                $alunos = json_decode($result['alunos'], true);
                return $alunos;
            } else {
                echo 'Não foi possível encontrar a atividade com o ID ' . $id;
                return null;
            }
        } catch (PDOException $e) {
            echo 'Erro ao buscar os alunos da atividade: ' . $e->getMessage();
            return null;
        }
    }
    
    public function addAluno($name, $points, $id,$chave) {
        global $mysql;
        try {
            // Verifica se o aluno já existe
            $stm_check = $mysql->getMySQL()->prepare('SELECT alunos FROM activity WHERE idActiviy = ?');
            $stm_check->execute([$id]);
            $result = $stm_check->fetch(PDO::FETCH_ASSOC);
    
            if (!$result || !isset($result['alunos'])) {
                $alunos = [];
            } else {
                // Decodifica o JSON para array
                if ($result['alunos'] != null) {
                $alunos = json_decode($result['alunos'], true);
    
                // Verifica se a decodificação foi bem-sucedida
                if ($alunos === null) {
                    echo 'Erro ao decodificar a lista de alunos para a atividade com ID ' . $id;
                    return;
                }
            } else {
                $alunos = [];
            }
            }

            $aluno_existente = false;
            foreach ($alunos as $aluno) {
                if ($aluno['name'] == $name) {
                    $aluno_existente = true;
                    break;
                }
            }
    
            if ($aluno_existente) {
                echo 'O aluno ' . $name . ' já está na lista.';
                return;
            }
    
            $informacoes = [
                'name' => $name,
                'points' => $points,
                'perguntas' => [
                    '1' => '',
                    '2' => '',
                    '3' => '',
                    '4' => '',
                    '5' => '',
                ],
                'acertos' => '0'
            ];
            $alunos[] = $informacoes;
            $alunos_json = json_encode($alunos);
    
            // Atualiza a lista de alunos na atividade
            $stm_update = $mysql->getMySQL()->prepare('UPDATE activity SET alunos = ? WHERE idActiviy = ?');
            $stm_update->bindParam(1, $alunos_json);
            $stm_update->bindParam(2, $id);
            $stm_update->execute();
            $_SESSION['nome'] = $name;
            $_SESSION['key'] = $chave;
            
        } catch (PDOException $e) {
            echo 'Erro ao adicionar o aluno ao json: ' . $e->getMessage();
        }
    }
    
    public function removerAluno($name, $id) {
        global $mysql;
        try {
            $stm_check = $mysql->getMySQL()->prepare('SELECT alunos FROM activity WHERE idActiviy = ?');
            $stm_check->execute([$id]);
            $result = $stm_check->fetch(PDO::FETCH_ASSOC);
            if (!$result || !isset($result['alunos'])) {
                //echo 'Não há alunos registrados para a atividade com o ID ' . $id;
                return;
            }
            $alunos = json_decode($result['alunos'], true);
            if ($alunos === null) {
                //echo 'Erro ao decodificar a lista de alunos para a atividade com ID ' . $id;
                return;
            }
            $alunoEncontrado = false;
            foreach ($alunos as $indice => $aluno) {
                if ($aluno['name'] == $name) {
                    unset($alunos[$indice]);
                    $alunoEncontrado = true;
                    break;
                }
            }
            if (!$alunoEncontrado) {
                return;
            }
            $alunos_json = json_encode(array_values($alunos));
            $stm_update = $mysql->getMySQL()->prepare('UPDATE activity SET alunos = ? WHERE idActiviy = ?');
            $stm_update->bindParam(1, $alunos_json);
            $stm_update->bindParam(2, $id);
            $stm_update->execute();
    
        } catch (PDOException $e) {
            echo 'Erro ao remover o aluno do JSON: ' . $e->getMessage();
        }
    }
    

    public function todosIndicesOcupados($id) {
        global $mysql;
        
        try {
            // Busca as perguntas do banco de dados
            $stm = $mysql->getMySQL()->prepare('SELECT perguntas FROM activity WHERE idActiviy = ?');    
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            if (!$result || empty($result['perguntas'])) {
                return false;
            }
            $alunos = json_decode($result['perguntas'], true);
            $maxIndex = 5;
            for ($i = 1; $i <= $maxIndex; $i++) {
                if (!isset($alunos[$i])) {
                    return false;
                }
            }
            
            return true;
        } catch (PDOException $e) {
            echo 'Erro ao verificar índices ocupados: ' . $e->getMessage();
            return false;
        }
    }
    public function addQuestion($name,$resposta1,$resposta2,$resposta3,$respostaCorreta, $id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT perguntas FROM activity WHERE idActiviy = ?');    
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['perguntas'])) {
                $alunos = json_decode($result['perguntas'], true);
            } else {
                $alunos = [];
            }
    
            $maxIndex = 5;
            $todosOcupados = true;
            for ($i = 1; $i <= $maxIndex; $i++) {
                if (!isset($alunos[$i])) {
                    $todosOcupados = false;
                    break;
                }
            }

            if ($todosOcupados) {
                echo 'Você já atingiu o limite máximo de 5 perguntas para esta atividade.';
                return;
            }

            $nextIndex = 1;
            while (isset($alunos[$nextIndex])) {
                $nextIndex++;
            }
            $question = [
                'id' => $nextIndex,
                'question' => $name,
                'resposta1' => ['id' => '1', 'reposta' => ''.$resposta1],
                'resposta2' => ['id' => '2', 'reposta' => ''.$resposta2],
                'resposta3' => ['id' => '3', 'reposta' => ''.$resposta3],
                'respostaCorreta' => ['id' => '4', 'reposta' => ''.$respostaCorreta],
            ];
            $alunos[$nextIndex] = $question;    
            $alunos_json = json_encode($alunos);
            $stm2 = $mysql->getMySQL()->prepare('UPDATE activity SET perguntas = ? WHERE idActiviy = ?');
            $stm2->bindParam(1, $alunos_json);
            $stm2->bindParam(2, $id);
            $stm2->execute();
        } catch (PDOException $e) {
            echo 'Erro ao adicionar a pergunta ao JSON: ' . $e->getMessage();
        }
    }

    public function deleteQuestion($idPergunta, $id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT perguntas FROM activity WHERE idActiviy = ?');    
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            
            if (!$result || empty($result['perguntas'])) {
                echo 'Nenhuma pergunta encontrada para esta chave.';
                return;
            }
    
            $alunos = json_decode($result['perguntas'], true);
            if (!isset($alunos[$idPergunta])) {
                echo 'Pergunta não encontrada.';
                return;
            }
    
            unset($alunos[$idPergunta]);
            $alunos_json = json_encode($alunos);
            $stm2 = $mysql->getMySQL()->prepare('UPDATE activity SET perguntas = ? WHERE idActiviy = ?');
            $stm2->bindParam(1, $alunos_json);
            $stm2->bindParam(2, $id);
            $stm2->execute();
    
        } catch (PDOException $e) {
            echo 'Erro ao excluir a pergunta do JSON: ' . $e->getMessage();
        }
    }
    public function setStageMath($id,$stage) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('UPDATE activity set stage = ? where idActiviy = ?');
            $stm->bindParam(1,$stage);
            $stm->bindParam(2,$id);
            $stm->execute();
            return 'sucess';
        } catch (PDOException $e) {
            echo 'Nao foi possivel iniciar a sala.'. $e->getMessage();
        }
    }
    
    public function getStage($id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT stage from activity where idActiviy = ?');
            $stm->bindParam(1,$id);
            $stm->execute();

            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result['stage'];
        } catch (PDOException $e) {
            echo 'Nao foi possivel iniciar a sala.'. $e->getMessage();
        }
    }

    public function setIniciado($id,$stage) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('UPDATE activity set iniciado = ? where idActiviy = ?');
            $stm->bindParam(1,$stage);
            $stm->bindParam(2,$id);
            $stm->execute();
        } catch (PDOException $e) {
            echo 'Nao foi possivel iniciar a sala.'. $e->getMessage();
        }
    }
    public function resetAluno($id) {
        global $mysql;
        $aluno = [];
        $alunos = json_encode($aluno);
        try {
            $stm = $mysql->getMySQL()->prepare('UPDATE activity set alunos = ? where idActiviy = ?');
            $stm->bindParam(1,$alunos);
            $stm->bindParam(2,$id);
            $stm->execute();
        } catch (PDOException $e) {
            echo 'Nao foi possivel iniciar a sala.'. $e->getMessage();
        }
    }
    
    public function getIniciado($id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT iniciado from activity where idActiviy = ?');
            $stm->bindParam(1,$id);
            $stm->execute();

            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result['iniciado'];
        } catch (PDOException $e) {
            echo 'Nao foi possivel iniciar a sala.'. $e->getMessage();
        }
    }
    public function getTempo($id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT tempo from activity where idActiviy = ?');
            $stm->bindParam(1,$id);
            $stm->execute();

            $result = $stm->fetch(PDO::FETCH_ASSOC);
            return $result['tempo'];
        } catch (PDOException $e) {
            echo 'Nao foi possivel iniciar a sala.'. $e->getMessage();
        }
    }


    public function voteQuestion($name,$param,$resposta,$id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT alunos FROM activity WHERE idActiviy = ?');    
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            $alunos = json_decode($result['alunos'], true);
            if (array_key_exists($name, $alunos)) {
                $alunos[$name]['perguntas'][$param] = $resposta;
                $alunos_json = json_encode($alunos);
                $stm2 = $mysql->getMySQL()->prepare('UPDATE activity SET alunos = ? WHERE idActiviy = ?');
                $stm2->bindValue(1, $alunos_json);
                $stm2->bindValue(2, $id);
                $stm2->execute();
            }
        } catch (PDOException $e) {
            echo 'Erro ao adicionar o aluno ao json'. $e->getMessage();
        }
    }
    public function checkQuestion($name,$param,$id) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT alunos FROM activity WHERE idActiviy = ?');    
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            $alunos = json_decode($result['alunos'], true);
            if (array_key_exists($name, $alunos)) {
                if ($alunos[$name]['perguntas'][$param] == $this->getRespostaCorreta($param,$id)) {
                    $alunos[$name]['perguntas']['acertos'] += 1;
                    $alunos_json = json_encode($alunos);
                    $stm2 = $mysql->getMySQL()->prepare('UPDATE activity SET alunos = ? WHERE chave = ?');
                    $stm2->bindValue(1, $alunos_json);
                    $stm2->bindValue(2, $id);
                    $stm2->execute();
                }
            }
        } catch (PDOException $e) {
            echo 'Erro ao adicionar o aluno ao json'. $e->getMessage();
        }
    }

    public function checkQuestionI($resposta,$param,$id) {
        if ($resposta == $this->getRespostaCorreta($param,$id)) {
            return true;
        } else {
            return false;
        }
    }
    public function getPoints($name, $id) {
        global $mysql;
    
        try {

            $stm = $mysql->getMySQL()->prepare('SELECT alunos FROM activity WHERE idActiviy = ?');
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
    

            $alunos = json_decode($result['alunos'], true);

            foreach ($alunos as $aluno) {
                if ($aluno['name'] === $name) {

                    return $aluno['points'];
                }
            }

            return 'Aluno não encontrado';
    
        } catch (PDOException $e) {

            return 'Erro ao buscar os pontos do aluno: ' . $e->getMessage();
        }
    }
    
    public function updatePoints($name, $id,$time,$resultado) {
        global $mysql;

        $points = 500;
        if ($resultado) {
            if ($time < 10) {
                $points *= 3.5;
            } else if ($time < 15) {
                $points *= 2.8;
            } else if ($time < 20) {
                $points *= 2.3;
            } else if ($time < 25) {
                $points *= 1.8;
            }
        } else {
            if ($time == -5) {
                $points -= 1500;
            } else {
                $points -= 1000;
            }
        }
        
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT alunos FROM activity WHERE idActiviy = ?');
            $stm->execute([$id]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);

            $alunos = json_decode($result['alunos'], true);

            $alunoEncontrado = false;
 
            foreach ($alunos as &$aluno) {
                if ($aluno['name'] === $name) {
                    $aluno['points'] += $points;
                    $alunoEncontrado = true;
                    break;
                }
            }
        
            if ($alunoEncontrado) {
                $alunos_json = json_encode($alunos);
        
                $stm2 = $mysql->getMySQL()->prepare('UPDATE activity SET alunos = ? WHERE idActiviy = ?');
                $stm2->bindValue(1, $alunos_json);
                $stm2->bindValue(2, $id);
                $stm2->execute();
            } else {
                echo 'Aluno não encontrado';
            }
        } catch (PDOException $e) {
            echo 'Erro ao atualizar os pontos do aluno no JSON: ' . $e->getMessage();
        }
    }

    public function addInformacoesPais($idPais,$titulo,$categoria,$descricao,$imagem,$imagemtype,$pixel) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT informacoes FROM paises WHERE idPais = ?');
            $stm->execute([$idPais]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            $paises = json_decode($result['informacoes'], true);
            $nomePais = $mysql->getNomePais($idPais);
            // Ensure that $paises is an array
  
    // Ensure that $paises is an array
    if (!is_array($paises)) {
        $paises = [];
    }

    // Initialize country data if it does not exist
    if (!isset($paises[$nomePais])) {
        $paises[$nomePais] = [
            'id' => $idPais,
        ];
    }

    // Initialize category with an empty array if it does not exist
    if (!isset($paises[$nomePais][$categoria])) {
        $paises[$nomePais][$categoria] = []; // Create an array to hold multiple entries
    }

    // Create the new information object
    $novaInformacao = [
        'titulo' => $titulo,
        'descricao' => $descricao,
        'imagemtype' => $imagemtype,
        'pixel' => $pixel,
        'imagem64' => $imagem
    ];

    // Ensure that $paises[$nomePais][$categoria] is an array
    if (is_array($paises[$nomePais][$categoria])) {
        $exists = false;
        foreach ($paises[$nomePais][$categoria] as $item) {
            if ($item['titulo'] === $novaInformacao['titulo'] &&
                $item['descricao'] === $novaInformacao['descricao']) {
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            $paises[$nomePais][$categoria][] = $novaInformacao;
        }
    } else {
        $paises[$nomePais][$categoria] = [$novaInformacao];
    }

    $jsonAtualizado = json_encode($paises, JSON_UNESCAPED_UNICODE);

            $stm = $mysql->getMySQL()->prepare('UPDATE paises SET informacoes = ? WHERE idPais = ?');
            $stm->execute([$jsonAtualizado, $idPais]);
    
        } catch (PDOException $e) {
            echo 'Erro ao adicionar informações';
        }

    }
    public function getInformacoes($idPais, $categoria) {
        global $mysql;
        try {
           
            $stm = $mysql->getMySQL()->prepare('SELECT informacoes FROM paises WHERE idPais = ?');
            $stm->execute([$idPais]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            $nomePais = $mysql->getNomePais($idPais);
            $paises = json_decode($result['informacoes'], true);
            
  
            if (isset($paises[$nomePais]) && isset($paises[$nomePais][$categoria])) {
                // Exibe os títulos e descrições alternadamente
                $trs = $paises[$nomePais][$categoria];
                $totalItens = count($trs);
                
                for ($i = 0; $i < $totalItens; $i++) {
                    if (isset($trs[$i]['titulo'])) {
                        echo '<strong>Título:</strong> ' . $trs[$i]['titulo'] . '<br>';
                    }
                    if (isset($trs[$i]['descricao'])) {
                        echo '<strong>Descrição:</strong> ' . $trs[$i]['descricao'] . '<br>';
                    }
                }
            } else {
                echo 'País ou categoria não encontrados.';
            }
        } catch (PDOException $e) {
            echo 'Erro ao buscar informações do país: ' . $e->getMessage();
        }
    } 

    public function criarPaisJson($idPais) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT informacoes FROM paises WHERE idPais = ?');
            $stm->execute([$idPais]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            $paises = json_decode($result['informacoes'], true);
            $nomePais = $mysql->getNomePais($idPais);
    

            if (!isset($paises[$nomePais])) {
                $paises[$nomePais] = [
                    'id' => $idPais,
                ];
            }

            $jsonAtualizado = json_encode($paises);
            $stm = $mysql->getMySQL()->prepare('UPDATE paises SET informacoes = ? WHERE idPais = ?');
            $stm->execute([$jsonAtualizado, $idPais]);
    
        } catch (PDOException $e) {
            echo 'Erro ao adicionar categoria';
        }
    }

    public function addCategoriaPais($idPais, $categoria) {
        global $mysql;
        try {
            $stm = $mysql->getMySQL()->prepare('SELECT informacoes FROM paises WHERE idPais = ?');
            $stm->execute([$idPais]);
            $result = $stm->fetch(PDO::FETCH_ASSOC);
            $informacoes = $result['informacoes'] ?? '{}'; // Default to empty JSON object if null
            $paises = json_decode($informacoes, true);
    
            // Get the country name
            $nomePais = $mysql->getNomePais($idPais);
    
            // Ensure that $paises is an array
            if (!is_array($paises)) {
                $paises = [];
            }
    
            // Initialize country data if it does not exist
            if (!isset($paises[$nomePais])) {
                $paises[$nomePais] = [
                    'id' => $idPais,
                ];
            }
    
            // Ensure the category is added to the country data
            if (!isset($paises[$nomePais][$categoria])) {
                $paises[$nomePais][$categoria] = new stdClass();;
            }
            

            $jsonAtualizado = json_encode($paises);
            $stm = $mysql->getMySQL()->prepare('UPDATE paises SET informacoes = ? WHERE idPais = ?');
            $stm->execute([$jsonAtualizado, $idPais]);
    
        } catch (PDOException $e) {
            echo 'Erro ao adicionar categoria';
        }
    }

    public function getCategorias($idPais) {
        global $mysql;
    
        try {
            $stmt = $mysql->getMySQL()->prepare('SELECT informacoes FROM paises WHERE idPais = ?');
            $stmt->execute([$idPais]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $paises = json_decode($result['informacoes'], true);
                $nomePais = $mysql->getNomePais($idPais);
                return $paises[$nomePais];
        } catch (PDOException $e) {
            echo 'Erro ao buscar categorias: ' . $e->getMessage();
            return [];
        }
    }
    

}

?>